<?php
    /*
     * Base Controller
     * Loads the models and views
    */

    class Controller {
        // Load model function
        public function model($model) {
            require_once("../app/models/" . $model . ".php");
            return new $model();
        }

        //Load view function
        public function view($view, $data = []) {
            // Check if the view file exists
            if(file_exists("../app/views/" . $view . ".php")) {
                require_once("../app/views/" . $view . ".php");
                return new $view();
            } else {
                die("View does not exist!");
            }
        }
    }