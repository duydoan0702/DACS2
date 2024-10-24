<?php
    $dsn = 'mysql:host=localhost;dbname=network_security_db';
    $username = 'root';
    $password = 'Ns369369';

    try{
        $db = new PDO($dsn, $username, $password);
    }catch(PDOException $e){
        $error_message = $e -> getMessage();
        echo "Error : " . $error_message;
        exit();
    }
?>