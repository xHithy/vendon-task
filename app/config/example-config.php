<?php
    /*
    * IMPORTANT
    * After editing the config rename the file to config.php
    */

    define("DB_HOST", "YOUR_DATABASE_HOST"); // Example: localhost:8889
    define("DB_USER", "YOUR_DATABASE_USERNAME"); // Example: test
    define("DB_PASS", "YOUR_DATABASE_PASSWORD"); // Example: test123
    define("DB_NAME", "vendon-task"); // If you didn't rename the SQL dump file the name should be vendon-task
    

    // This shouldn't be changed!
    define("APPROOT", dirname(dirname(__FILE__)));
    
    /*
    * SOURCE CODE FOLDER'S CONTENT MUST BE IN THE ROOT DIRECTORY
    * If the sourcecode folders content is the root directory, then the URL root should just be the domain;
    * Example: http://localhost:8888/
    * ! The slash at the end is important !
    */
    define("URLROOT", "YOUR_ROOT_URL"); 

    define("SITENAME", "Vendon Task");

    // MAKE SURE THE SERVER IS RUNNING PHP7.4.21!
