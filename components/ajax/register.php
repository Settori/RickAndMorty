<?php

    //Load a class file containing all functionalities
    require_once "../../class.php";

    //Creating a new object from main class
    $db = new zadanieDB;

    //Connecting to the database
    $db->connect();

    //Checking if all POST data is set
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['passwordrepeat'])) {

        //Checking if passwords are these same
        if ($_POST['password'] == $_POST['passwordrepeat']) {

            try {

                //Registering new account
                $db->register($_POST['email'], $_POST['password']);
                echo json_encode(array(0, "Succes"));
                
            }
            catch (Exception $e) {
                echo json_encode(array(1, $e->getMessage()));
            }
        }
        else {
            echo json_encode(array(2, "Passwords are not these same"));
        }
    }
        
    else
        echo json_encode(array(1, "Fields empty"));

?>