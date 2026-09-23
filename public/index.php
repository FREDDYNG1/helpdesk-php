<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../src/Repositories/TicketRepository.php";

$ticketRepository = new TicketRepository($pdo);


$title = "HelpDesk PHP";

$ticketTitle = '';
$ticketDescription = '';
$ticketPriority = 'Media';
$ticketStatus = 'Abierta';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $ticketTitle = trim($_POST["title"] ?? "");
    $ticketDescription = trim($_POST["description"] ?? "");
    $ticketPriority = $_POST["priority"] ?? "Media";
    $ticketStatus = $_POST["status"] ?? "Abierta";

    if ($ticketTitle === "") {
        $error = "El título es obligatorio.";
    } elseif ($ticketDescription === "") {
        $error = "La descripción es obligatoria.";
    }

    if ($error === "") {

        $ticketRepository->create(
            $ticketTitle,
            $ticketDescription,
            $ticketPriority,
            $ticketStatus
        );

        $success = "Incidencia creada correctamente.";

        // Limpiar formulario después de guardar
        $ticketTitle = '';
        $ticketDescription = '';
        $ticketPriority = 'Media';
        $ticketStatus = 'Abierta';
    }
}
$tickets = $ticketRepository->findAll();


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($title) ?>
    </title>
</head>

<body>

    <h1>
        <?= htmlspecialchars($title) ?>
    </h1>

    <h2>Nueva incidencia</h2>

    <?php if ($success !== ""): ?>

        <p>
            <?= htmlspecialchars($success) ?>
        </p>

    <?php endif; ?>


    <?php if ($error !== ""): ?>

        <p>
            <?= htmlspecialchars($error) ?>
        </p>

    <?php endif; ?>


    <form method="POST">

        <div>

            <label for="ticket-title">
                Título
            </label>

            <input
                type="text"
                id="ticket-title"
                name="title"
                value="<?= htmlspecialchars($ticketTitle) ?>">

        </div>

        <br>


        <div>

            <label for="ticket-description">
                Descripción
            </label>

            <textarea
                id="ticket-description"
                name="description"><?= htmlspecialchars($ticketDescription) ?></textarea>

        </div>

        <br>


        <div>

            <label for="ticket-priority">
                Prioridad
            </label>

            <select
                id="ticket-priority"
                name="priority">

                <option
                    value="Baja"
                    <?= $ticketPriority === "Baja" ? "selected" : "" ?>>
                    Baja
                </option>

                <option
                    value="Media"
                    <?= $ticketPriority === "Media" ? "selected" : "" ?>>
                    Media
                </option>

                <option
                    value="Alta"
                    <?= $ticketPriority === "Alta" ? "selected" : "" ?>>
                    Alta
                </option>

            </select>

        </div>

        <br>


        <div>

            <label for="ticket-status">
                Estado
            </label>

            <select
                id="ticket-status"
                name="status">

                <option
                    value="Abierta"
                    <?= $ticketStatus === "Abierta" ? "selected" : "" ?>>
                    Abierta
                </option>

                <option
                    value="En progreso"
                    <?= $ticketStatus === "En progreso" ? "selected" : "" ?>>
                    En progreso
                </option>

                <option
                    value="Resuelta"
                    <?= $ticketStatus === "Resuelta" ? "selected" : "" ?>>
                    Resuelta
                </option>

            </select>

        </div>

        <br>


        <button type="submit">
            Crear incidencia
        </button>

    </form>


    <hr>


    <h2>Incidencias registradas</h2>


    <?php if (empty($tickets)): ?>

        <p>
            No existen incidencias registradas.
        </p>

    <?php else: ?>

        <?php foreach ($tickets as $ticket): ?>

            <div>

                <h3>
                    <?= htmlspecialchars($ticket["title"]) ?>
                </h3>

                <p>
                    <strong>ID:</strong>

                    <?= htmlspecialchars(
                        (string) $ticket["id"]
                    ) ?>
                </p>

                <p>
                    <strong>Descripción:</strong>

                    <?= htmlspecialchars(
                        $ticket["description"]
                    ) ?>
                </p>

                <p>
                    <strong>Prioridad:</strong>

                    <?= htmlspecialchars(
                        $ticket["priority"]
                    ) ?>
                </p>

                <p>
                    <strong>Estado:</strong>

                    <?= htmlspecialchars(
                        $ticket["status"]
                    ) ?>
                </p>

                <p>
                    <strong>Fecha:</strong>

                    <?= htmlspecialchars(
                        $ticket["created_at"]
                    ) ?>
                </p>
                <a href="edit-ticket.php?id=<?= (int) $ticket["id"] ?>">
                    <button type="button">
                        Editar
                    </button>
                </a>


                <form
                    method="POST"
                    action="delete-ticket.php">
                    <input
                        type="hidden"
                        name="id"
                        value="<?= (int) $ticket["id"] ?>">

                    <button type="submit">
                        Eliminar
                    </button>


                </form>

            </div>

            <hr>

        <?php endforeach; ?>

    <?php endif; ?>

</body>

</html>
