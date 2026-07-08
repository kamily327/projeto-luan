<?php
    $host = "localhost";
    $user = "root";
    $pass = '';
    $db = "db_luan";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db" , $user , $pass);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 

    catch(PDOException $e){
        echo "Erro na conexão: " . $e->getMessage();
    }

?>