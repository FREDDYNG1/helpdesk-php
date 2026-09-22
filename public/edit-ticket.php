<?php

require_once __DIR__ . "/../config/database.php";

$ticketId = $_GET["id"] ?? null;

if (!$ticketId) {
    header("Location: index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Buscar la incidencia
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT *
    FROM tickets
    WHERE id = :id
";

$statement = $pdo->prepare($sql);

$statement->execute([
    "id" => $ticketId
]);

$ticket = $statement->fetch(PDO::FETCH_ASSOC);

if (!$ticket) {
    header("Location: index.php");
    exit;
}

$error = '';

/*
|--------------------------------------------------------------------------
| Actualizar incidencia
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $priority = $_POST["priority"] ?? "Media";
    $status = $_POST["status"] ?? "Abierta";

    if ($title === "") {

        $error = "El título es obligatorio.";
    } elseif ($description === "") {

        $error = "La descripción es obligatoria.";
    }

    if ($error === "") {

        $sqlUpdate = "
            UPDATE tickets
            SET
                title = :title,
                description = :description,
                priority = :priority,
                status = :status
            WHERE id = :id
        ";

        $statementUpdate = $pdo->prepare($sqlUpdate);

        $statementUpdate->execute([
            "title" => $title,
            "description" => $description,
            "priority" => $priority,
            "status" => $status,
            "id" => $ticketId
        ]);

        header("Location: index.php");
        exit;
    }

    /*
     * Si ocurre un error, mantenemos lo que escribió
     * el usuario en el formulario.
     */

    $ticket["title"] = $title;
    $ticket["description"] = $description;
    $ticket["priority"] = $priority;
    $ticket["status"] = $status;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Editar incidencia</title>
</head>

<body>

    <h1>Editar incidencia</h1>

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
                value="<?= htmlspecialchars($ticket["title"]) ?>">

        </div>

        <br>

        <div>

            <label for="ticket-description">
                Descripción
            </label>

            <textarea
                id="ticket-description"
                name="description"><?= htmlspecialchars($ticket["description"]) ?></textarea>

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
                    <?= $ticket["priority"] === "Baja" ? "selected" : "" ?>>
                    Baja
                </option>

                <option
                    value="Media"
                    <?= $ticket["priority"] === "Media" ? "selected" : "" ?>>
                    Media
                </option>

                <option
                    value="Alta"
                    <?= $ticket["priority"] === "Alta" ? "selected" : "" ?>>
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
                    <?= $ticket["status"] === "Abierta" ? "selected" : "" ?>>
                    Abierta
                </option>

                <option
                    value="En progreso"
                    <?= $ticket["status"] === "En progreso" ? "selected" : "" ?>>
                    En progreso
                </option>

                <option
                    value="Resuelta"
                    <?= $ticket["status"] === "Resuelta" ? "selected" : "" ?>>
                    Resuelta
                </option>

            </select>

        </div>

        <br>

        <button type="submit">
            Guardar cambios
        </button>

        <a href="index.php">
            Cancelar
        </a>

    </form>

</body>

</html>
