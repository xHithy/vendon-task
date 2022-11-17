<?php
    session_start();

    // Call this function to fetch if the user has an test currently started
    // Function is used to prevent people from going directly into the test and result view via URL
    function fetchTestProgress() {
        if($_SESSION["test_active"] == true) {
            return true;
        } else {
            return false;
        }
    }