<?php
    // Config
    require_once "../app/config/config.php";

    // Libraries
    require_once "helpers/progressTracker.php";
    require_once "helpers/redirect.php";

    // Autoload core libraries
    spl_autoload_register(function($className) {
        require_once "libraries/" . $className . ".php";
    });