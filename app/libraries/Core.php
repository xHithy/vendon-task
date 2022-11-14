<?php
    /*
    * App Core
    * Creates URL & Loads core controller
    * URL FORMAT - /controller/method/params
    */

    class Core {
        protected $currentController = "Pages";
        protected $currentMethod = "index";
        protected $params = [];

        public function __construct() {
            $url = $this->getUrl();

            /*
            * Function to remove controller name from link
            * URL FORMAT with function - https://localhost:8888/quiz
            * URL FORMAT without function - https://localhost:8888/pages/quiz
            */
            if (file_exists('../app/views/pages/'.strtolower($url[0]).'.php') && !file_exists('../app/controllers'.ucwords($url[0]).'.php')) {
                array_unshift($url,"Pages");
            }

            // Check for first URL index (CONTROLLER)
            if(isset($_GET["url"])) {
                if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                    // If exists, then reset current controller
                    $this->currentController = ucwords($url[0]);
                    // Unset first index
                    unset($url[0]);
                }  
            }

            // Require the controller fetched from URL
            require_once "../app/controllers/" . $this->currentController . ".php";
            $this->currentController = new $this->currentController;


            // Check for second URL index (METHOD)
            if(isset($url[1])) {
                // Check to see if the fetched method exists in current controller
                if(method_exists($this->currentController, $url[1])) {
                    $this->currentMethod = $url[1];
                    // Unset second index
                    unset($url[1]);
                }
            }

            // Get params
            $this->params = $url ? array_values($url) : [];

            // Call a callback with array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        public function getUrl() {
            if(isset($_GET['url'])) {
                /*
                * Devide URL into array
                * 1st index - Controller
                * 2nd index - Method
                * 3rd index - Params
                */
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
        }
    }