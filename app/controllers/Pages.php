<?php
    class Pages extends Controller {
        public $description = "This is a <b>Vendon</b> task for practicants";
        public function index() {
            $data = [
                "title" => "Starting view",
                "desc" => $this->description,
            ];
            $this->view("pages/start", $data);
        }

        public function quiz() {
            $data = [
                "title" => "Quiz view",
                "desc" => $this->description,
            ];
            $this->view("pages/quiz", $data);
        }

        public function result() {
            $data = [
                "title" => "Result view",
                "desc" => $this->description,
            ];
            $this->view("pages/result", $data);
        }
    }