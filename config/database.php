<?php

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(
    dirname(__DIR__)
);

$dotenv->safeLoad();

$host = $_ENV["DB_HOST"] ?? "localhost";
$port = $_ENV["DB_PORT"] ?? "3306";
$dbname = $_ENV["DB_NAME"] ?? "";
$username = $_ENV["DB_USER"] ?? "";
$password = $_ENV["DB_PASSWORD"] ?? "";

try {

    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );
} catch (PDOException $error) {

    die("Error de conexión a la base de datos: "
        . $error->getMessage());
}
