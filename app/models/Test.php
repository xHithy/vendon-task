<?php
    class Test {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function getTests() {
            $this->db->query("SELECT * FROM tests");
            $this->db->execute();
            return $this->db->resultSet();
        }

        public function getUserTestStatus($userID, $testID) {
            $this->db->query("SELECT finished, id FROM attempts WHERE user_id=:user_id AND test_id=:test_id");
            $this->db->bind(":user_id", $userID);
            $this->db->bind(":test_id", $testID);
            $this->db->execute();

            if($this->db->rowCount() > 0) {
                /*
                * If there are previous attempts registered, find the one that isn't finished
                * If all previous attempts are finished then create a new attempt
                */ 

                $found = false;
                $attempts = $this->db->resultSet();
                foreach($attempts as $attempt) {
                    if($attempt->finished == false) {
                        $found = true;
                        /*
                        * If an unfinished attempt is found fetch the test ID:
                        * Find the questions that have not been answered in the attempt
                        * and make the user start on the question they left on
                        */

                        $attemptID = $attempt->id;

                        /*
                        * This query will get the questions answered in the current attempt.
                        * Then with a simple subtraction from the total_quiz_questions with the answered question count fetched from the query
                        * it will return the remaining number of questions that haven't been answered
                        */
                        $this->db->query("SELECT * FROM answered_questions WHERE attempt_id=:attempt_id AND user_id=:user_id");
                        $this->db->bind(":attempt_id", $attemptID);
                        $this->db->bind(":user_id", $userID);
                        $this->db->execute();
                        $questionsAnswered = $this->db->rowCount();

                        return [
                            "attempt_id" => $attemptID,
                            "question_nr" => $questionsAnswered,
                        ];
                    }
                }

                if(!$found) {
                    // Create a new attempt if no attempts that are marked as unfinished are found
                    $this->db->query("INSERT INTO attempts (user_id, test_id, finished) VALUES (:user_id, :test_id, :finished)");
                    $this->db->bind(":user_id", $userID);
                    $this->db->bind(":test_id", $testID);
                    $this->db->bind(":finished", false);
                    $this->db->execute();

                    // Return 1, because it's a new test, therefore it's the first question
                    return [
                        "attempt_id" => $this->db->lastID(),
                        "question_nr" => 0,
                    ];
                }
            } else {
                // If a previous attempt was never found then create a new attempt
                $this->db->query("INSERT INTO attempts (user_id, test_id, finished) VALUES (:user_id, :test_id, :finished)");
                $this->db->bind(":user_id", $userID);
                $this->db->bind(":test_id", $testID);
                $this->db->bind(":finished", false);
                $this->db->execute();

                // Return 1, because it's a new test, therefore it's the first question
                return [
                    "attempt_id" => $this->db->lastID(),
                    "question_nr" => 0,
                ];
            }
        }

        public function fetchUserByName($username) {
            $this->db->query("SELECT id FROM users WHERE username=:username");
            $this->db->bind(":username", $username);
            $this->db->execute();

            /*
            * If the user exists, fetch the users ID
            * If the user doesn't exist, create the user and fetch the last ID
            */
            if($this->db->rowCount() > 0) {
                return $this->db->resultSet()[0]->id;
            } else {
                $this->db->query("INSERT INTO users (username) VALUES (:username)");
                $this->db->bind(":username", $username);
                $this->db->execute();
                return $this->db->lastID();
            }
        }

        public function fetchUserById($id) {
            $this->db->query("SELECT * FROM users WHERE id=:id LIMIT 1");
            $this->db->bind(":id", $id);
            $this->db->execute();
            if($this->db->rowCount() > 0) {
                return $this->db->single()->username;
            } else {
                die("Fatal error: Provided user doesn't exist!");
            }
        }

        public function getQuestionCount($testID) {
            $this->db->query("SELECT id, question FROM questions WHERE test_id=:test_id");
            $this->db->bind(":test_id", $testID);
            $this->db->execute();
            return $this->db->rowCount();
        }

        public function getQuestions($testID) {
            $this->db->query("SELECT id, question FROM questions WHERE test_id=:test_id");
            $this->db->bind(":test_id", $testID);
            $this->db->execute();
            return $this->db->resultSet();
        }

        // Function returns all answer options for the passed question
        public function getAnswers($questionID) {
            $this->db->query("SELECT id, question_id, answer FROM answers WHERE question_id=:question_id");
            $this->db->bind(":question_id", $questionID);
            $this->db->execute();
            return $this->db->resultSet();
        }

        public function getCorrectAnswerCount($attemptID) {
            $this->db->query("SELECT * FROM answered_questions WHERE attempt_id=:attempt_id AND correct=true");
            $this->db->bind(":attempt_id", $attemptID);
            $this->db->execute();
            return $this->db->rowCount();
        }

        public function submitAnswer($answerID, $questionID) {
            // Check if the answer user submitted is correct
            $this->db->query("SELECT * FROM answers WHERE id=:answer_id AND question_id=:question_id AND is_correct=true");
            $this->db->bind(":answer_id", $answerID);
            $this->db->bind(":question_id", $questionID);
            $this->db->execute();

            if($this->db->rowCount() > 0) {
                // If the answer is correct
                $this->db->query("INSERT INTO answered_questions (user_id, test_id, question_id, answer_chosen_id, attempt_id, correct) VALUES (:user_id, :test_id, :question_id, :answer_id, :attempt_id, true)");
            } else {
                // If the answer is incorrect
                $this->db->query("INSERT INTO answered_questions (user_id, test_id, question_id, answer_chosen_id, attempt_id, correct) VALUES (:user_id, :test_id, :question_id, :answer_id, :attempt_id, false)");
            }

            $this->db->bind(":user_id", $_SESSION["user_id"]);
            $this->db->bind(":test_id", $_SESSION["test_id"]);
            $this->db->bind(":question_id", $questionID);
            $this->db->bind(":answer_id", $answerID);
            $this->db->bind(":attempt_id", $_SESSION["attempt_id"]);
            $this->db->execute();
        }

        public function finishTest() {
            $_SESSION["test_finished"] = true;
            $correctAnswers = $this->getCorrectAnswerCount($_SESSION["attempt_id"]);
            $username = $this->fetchUserById($_SESSION["user_id"]);
            $totalQuestions = $this->getQuestionCount($_SESSION["test_id"]);

            // Once the test is finished, insert the test result in the database
            $this->db->query("INSERT INTO finished_tests (test_id, username, attempt_id, total_question_count, correct_answers) VALUES (:test_id, :username, :attempt_id, :total_questions, :correct_answers)");
            $this->db->bind(":test_id", $_SESSION["test_id"]);
            $this->db->bind(":username", $username);
            $this->db->bind(":attempt_id", $_SESSION["attempt_id"]);
            $this->db->bind(":total_questions", $totalQuestions);
            $this->db->bind(":correct_answers", $correctAnswers);
            $this->db->execute();

            /*
            * Also once the test is finished, set the attempt finished status to true
            * So the user doesn't get sent back to a finished test, instead start a new one
            */
            $this->db->query("UPDATE attempts SET finished=true WHERE id=:attempt_id");
            $this->db->bind(":attempt_id", $_SESSION["attempt_id"]);
            $this->db->execute();
        }

        public function createTestSession($data) {
            /* 
            *  Initialize a session for the current active test, 
            *  This is so it's easier to follow users steps during the test
            *  This also enables the user to leave during the test, and come back to the test where they left off
            */

            // IMPORTANT - Function will change and sessions will be removed due to scalability and reliability with high traffic!

            $_SESSION["test_active"] = $data["test_active"];
            $_SESSION["test_id"] = $data["test_id"];
            $_SESSION["user_id"] = $data["user_id"];
            $_SESSION["test_finished"] = $data["test_finished"];
            $_SESSION["attempt_id"] = $data["attempt_id"];
        }

        // This function executes once the test is finished, this allows the user to go back to the starting page
        public function removeTestSession() {
            unset($_SESSION["test_active"]);
            unset($_SESSION["test_id"]);
            unset($_SESSION["user_id"]);
            unset($_SESSION["test_finished"]);
            unset($_SESSION["attempt_id"]);
            session_destroy();
        }
    }