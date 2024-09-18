<?php
// creating database information to make connection

    $dns = "mysql:host=sql311.infinityfree.com;dbname=if0_37330678_native";
    $username = 'if0_37330678';
    $password = 'Native2024'; 
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    );


    // Trying the connection and handling any possible exception
    try{
        $connect = new PDO($dns,$username,$password,$option);
        $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        // displaying the connection error message
        echo "Connection Faild" . $e->getMessage();
    }

?>