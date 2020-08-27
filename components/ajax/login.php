<?php
    //Load a class file containing all functionalities
    require_once "../../class.php";

    //Creating a new object from main class
    $db = new zadanieDB;

    //Connecting to the database
    $db->connect();

    //Checking if all POST data is set
    if (isset($_POST['email']) && isset($_POST['password'])) {
        try {

            //Login
            $db->login($_POST['email'], $_POST['password']);
            echo json_encode(array(0, "Succes"));
        }
        catch (Exception $e) {
            echo json_encode(array(1, $e->getMessage()));
        }
    }
        
    else
        echo json_encode(array(1, "Fields empty"));

?>