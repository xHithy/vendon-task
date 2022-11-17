<?php
    class Tests extends Controller {
        public function __construct() {
            // Load Test model
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
            if(!fetchTestProgress()) {
                redirect("landing");
            }

            // If the final question has been answered, redirect to result page
            if($_SESSION["question_nr"] > $_SESSION["question_total_count"]) {
                $_SESSION["test_finished"] = true;
                $this->testModel->finishTest();
                redirect("result");
            }

            $question = $_SESSION["question_list"][$_SESSION["question_nr"]];
            $options = $this->testModel->getAnswers($question->id);

            $data = [
                "question_nr" => $_SESSION["question_nr"],
                "question_count" => $_SESSION["question_total_count"],
                "question" => $question,
                "options" => $options,
            ];
            $this->view("tests/test", $data);
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
                    $data = [
                        "username" => $_SESSION["username"],
                        "correct_questions" => $this->testModel->getCorrectAnswerCount($_SESSION["attempt_id"]),
                        "total_questions" => $_SESSION["question_total_count"] + 1,
                    ];
                    $this->testModel->removeTestSession();
                    $this->view("tests/result", $data);
                } else {
                    redirect("landing");
                }
            } else {
                redirect("landing");
            }
        }



        public function startTest() {
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $userID = $this->testModel->fetchUser($_POST["user"]);
                $activeTest = $_POST["selectedTest"];
                $username = $_POST["user"];
                $data = [
                    "test_active" => true,
                    "test_finished" => false,
                    "user_id" => $userID,
                    "username" => $username,
                    "test_id" => $activeTest,
                    "attempt_id" => $this->testModel->getUserTestStatus($userID, $activeTest),
                    "question_list" => $this->testModel->getQuestions($activeTest),
                    "question_nr" => 0,
                    "question_total_count" => $this->testModel->getQuestionCount($activeTest)
                ];
                $this->createTestSession($data);
                redirect("test");
            }
        }



        public function createTestSession($data) {
            /* 
            *  Initialize a session for the current active test, 
            *  This is so it's easier to follow users steps during the test
            *  This also enables the user to leave during the test, and come back to the test where they left off
            */
            $_SESSION["test_active"] = $data["test_active"];
            $_SESSION["test_id"] = $data["test_id"];
            $_SESSION["username"] = $data["username"];
            $_SESSION["user_id"] = $data["user_id"];
            $_SESSION["test_finished"] = $data["test_finished"];
            $_SESSION["attempt_id"] = $data["attempt_id"];
            $_SESSION["question_list"] = $data["question_list"];
            $_SESSION["question_nr"] = $data["question_nr"];
            $_SESSION["question_total_count"] = $data["question_total_count"]-1; // I subtract 1 here, because it's easier to work with arrays when the index is 0 instead of 1. When I gather all the information at the end of a test, I add it back!
        }



        // This function ONLY gets called via AJAX
        public function registerAnswer() {
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $this->testModel->submitAnswer($_POST["answerID"], $_POST["questionID"]);
            }
        }
    }