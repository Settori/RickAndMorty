<?php
    //Load a class file containing all functionalities
    require_once "../../class.php";

    //Creating a new object from main class
    $db = new zadanieDB;

    //Connecting to the database
    $db->connect();

    //Checking if all POST data is set
    if (isset($_POST['content']) && isset($_POST['status']) && isset($_POST['gender']))

        try {

            //Return JSON data with search_character result
            echo json_encode($db->search_character($_COOKIE['user'], $_POST['content'], $_POST['status'], $_POST['gender']));
        }
        catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
    else
        echo json_encode("Fields are empty");

?>