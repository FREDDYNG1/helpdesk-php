<?php

$host = "localhost";
$dbname = "helpdesk_php";
$username = "helpdesk_user";
$password = "TuClaveSegura123!";


try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $error){
    die("Error de conexion: " . $error->getMessage());
}


echo "Conexión correcta a MySQL";
