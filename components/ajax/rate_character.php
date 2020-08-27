<?php
    //Load a class file containing all functionalities
    require_once "../../class.php";

    //Creating a new object from main class
    $db = new zadanieDB;

    //Connecting to the database
    $db->connect();

    //Checking if all POST data is set
    if (isset($_POST['rate']) && isset($_POST['character_id'])) {

        try {

            //Calling function for rating the character
            $db->rate_character($_COOKIE['user'], $_POST['character_id'], $_POST['rate']);
            echo json_encode(true);
        }
        catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
    }
        
    else
        echo json_encode("Fields are empty");

?>