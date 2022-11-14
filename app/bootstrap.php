<?php
    // CONFIGS
    require_once "../app/config/config.php";

    // LIBRARIES
    // require_once "libraries/Core.php";
    // require_once "libraries/Controller.php";
    // require_once "libraries/Database.php";

    // AUTOLOAD CORE LIBRARIES
    spl_autoload_register(function($className) {
        require_once "libraries/" . $className . ".php";
    });