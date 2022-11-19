<?php
    class Tests extends Controller {
        public function __construct() {
            // Load the Test model
            $this->testModel = $this->model("Test");
        }



        // Landing view
        public function index() {
            // If the session has a test in progress, redirect user to the unfinished test on the question they left on
            if(fetchTestProgress()) {
                redirect("test");
            } else {
                // When the landing page gets loaded fetch all tests
                $tests = $this->testModel->getTests();
                $data = [
                    "tests" => $tests,
                ];
                $this->view("tests/landing", $data);
            }
        }



        // Test view
        public function test() {
            // Check if this is a refresh from an active test
            if(isset($_SESSION["test_active"])) {
                $userID = $_SESSION["user_id"];
                $activeTest = $this->testModel->getTestIdByAttemptId($_SESSION["attempt_id"]);
                $totalQuestionCount = $this->testModel->getQuestionCount($activeTest);
                $questionList = $this->testModel->getQuestions($activeTest);
                $testStatus = $this->testModel->getUserTestStatus($userID, $activeTest);

                // If the final question has been answered, redirect to result page
                if($testStatus["question_nr"] >= $totalQuestionCount) {
                    $this->testModel->finishTest();
                    redirect("result");
                }
    
                $question = $questionList[$testStatus["question_nr"]];
                $options = $this->testModel->getAnswers($question->id);
    
                $data = [
                    "question_nr" => $testStatus["question_nr"],
                    "question_count" => $totalQuestionCount-1,
                    "question" => $question,
                    "options" => $options,
                ];
                $this->view("tests/test", $data);
            } else {
                // Check if the test has been initialized, if not initialize one
                if($_SERVER['REQUEST_METHOD'] == "POST") {
                    $userID = $this->testModel->fetchUserByName($_POST["user"]);
                    $activeTest = $_POST["selectedTest"];
                    $testStatus = $this->testModel->getUserTestStatus($userID, $activeTest);
                    $data = [
                        "test_active" => true,
                        "test_finished" => false,
                        "user_id" => $userID,
                        "attempt_id" => $testStatus["attempt_id"],
                    ];
                    $this->testModel->createTestSession($data);
                    redirect("test");
                }

                /*
                * If there isn't a test active, and there is no post request from the server indicating a test setup
                * Then redirect to the landing page to prevent unwanted bugs
                */
                if(!fetchTestProgress()) {
                    redirect("landing");
                }
            }
        }


        // Result view
        public function result() {
            /*
            * Some error handling measurments:
            * A user isn't allowed to URL himself to the results page
            * without actually finishing a test
            */
            if(isset($_SESSION["test_finished"])) {
                if($_SESSION["test_finished"] == true) {
                    $testID = $this->testModel->getTestIdByAttemptId($_SESSION["attempt_id"]);
                    $username = $this->testModel->fetchUserById($_SESSION["user_id"]);
                    $correctQuestions = $this->testModel->getCorrectAnswerCount($_SESSION["attempt_id"]);
                    $totalQuestions = $this->testModel->getQuestionCount($testID);
                    $data = [
                        "username" => $username,
                        "correct_questions" => $correctQuestions,
                        "total_questions" => $totalQuestions,
                    ];
                    
                    /*
                    * Removing the test-session when the test is finished, 
                    * removes the users ability to return to the test view and cause unwanted errors
                    */
                    $this->testModel->removeTestSession();
                    $this->view("tests/result", $data);
                } else {
                    redirect("landing");
                }
            } else {
                redirect("landing");
            }
        }



        // This function ONLY gets called via AJAX
        public function registerAnswer() {
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $this->testModel->submitAnswer($_POST["answerID"], $_POST["questionID"]);
            } else {
                // Safety measurement: If the request to this function hasn't been sent by the server, redirect to the landing page
                redirect("landing");
            }
        }
    }