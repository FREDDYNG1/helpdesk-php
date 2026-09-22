<?php

require_once __DIR__ . "/../config/database.php";



if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}


$ticketId = $_POST["id"] ?? null;

if (!$ticketId) {
    header("Location: index.php");
    exit;
}

$sql = "
    DELETE FROM tickets
    WHERE id = :id
";

$statement = $pdo->prepare($sql);

$statement->execute([
    "id" => $ticketId
]);

header("Location: index.php");
exit;
