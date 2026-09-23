<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../src/Repositories/TicketRepository.php";

$ticketRepository = new TicketRepository($pdo);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$ticketId = isset($_POST["id"])
    ? (int) $_POST["id"]
    : null;

if (!$ticketId) {
    header("Location: index.php");
    exit;
}

$ticketRepository->delete($ticketId);

header("Location: index.php");
exit;
