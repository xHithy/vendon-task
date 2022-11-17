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
                        /*
                        * If an unfinished attempt is found
                        * call function that finds the question that they left the test on
                        * and return it
                        */

                        // !!! UNFINISHED FUNCTION !!!!


                        $found = true;
                        return $attempt->id;
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
                    return $this->db->lastID();
                }
            } else {
                // If a previous attempt was never found then create a new attempt
                $this->db->query("INSERT INTO attempts (user_id, test_id, finished) VALUES (:user_id, :test_id, :finished)");
                $this->db->bind(":user_id", $userID);
                $this->db->bind(":test_id", $testID);
                $this->db->bind(":finished", false);
                $this->db->execute();

                // Return 1, because it's a new test, therefore it's the first question
                return $this->db->lastID();
            }
        }


        public function fetchUser($username) {
            /*
            * !!!! FIX THIS DUPLICATE LATER !!!!
            */
            $this->db->query("SELECT id FROM users WHERE username=:username");
            $this->db->bind(":username", $username);
            $this->db->execute();

            /*
            * If the user exists, fetch the users ID
            * If the user doesn't exist, create the user and fetch the last ID
            */
            if($this->db->rowCount() > 0) {
                $this->db->query("SELECT id FROM users WHERE username=:username");
                $this->db->bind(":username", $username);
                return $this->db->execute();
            } else {
                $this->db->query("INSERT INTO users (username) VALUES (:username)");
                $this->db->bind(":username", $username);
                $this->db->execute();
                return $this->db->lastID();
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
            $_SESSION["question_nr"]++;
        }

        public function finishTest() {
            $correctAnswers = $this->getCorrectAnswerCount($_SESSION["attempt_id"]);
            $this->db->query("INSERT INTO finished_tests (test_id, username, attempt_id, total_question_count, correct_answers) VALUES (:test_id, :username, :attempt_id, :total_questions, :correct_answers)");
            $this->db->bind(":test_id", $_SESSION["test_id"]);
            $this->db->bind(":username", $_SESSION["username"]);
            $this->db->bind(":attempt_id", $_SESSION["attempt_id"]);
            $this->db->bind(":total_questions", $_SESSION["question_total_count"]+1); // I add 1 here, because I removed 1 when I start a test. It's easier to work with arrays when the index is 0, instead of 1
            $this->db->bind(":correct_answers", $correctAnswers);
            $this->db->execute();

            $this->db->query("UPDATE attempts SET finished=true WHERE id=:attempt_id");
            $this->db->bind(":attempt_id", $_SESSION["attempt_id"]);
            $this->db->execute();
        }


        // This function executes once the test is finished, this allows the user to go back to the starting page
        public function removeTestSession() {
            unset($_SESSION["test_active"]);
            unset($_SESSION["test_id"]);
            unset($_SESSION["username"]);
            unset($_SESSION["user_id"]);
            unset($_SESSION["test_finished"]);
            unset($_SESSION["attempt_id"]);
            unset($_SESSION["question_list"]);
            unset($_SESSION["question_nr"]);
            unset($_SESSION["question_total_count"]);
            session_destroy();
        }
    }