<?php

class TicketRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $sql = "
            SELECT *
            FROM tickets
            ORDER BY created_at DESC
        ";

        $statement = $this->pdo->query($sql);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array|false
    {
        $sql = "
        SELECT *
        FROM tickets
        WHERE id = :id
    ";

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            "id" => $id
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function create(
        string $title,
        string $description,
        string $priority,
        string $status,
    ): void {
        $sql = "
            INSERT INTO tickets (
                title,
                description,
                priority,
                status
            )
            VALUES(
                :title,
                :description,
                :priority,
                :status

            )
        ";

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            "title" => $title,
            "description" => $description,
            "priority" => $priority,
            "status" => $status
        ]);
    }


    public function update(
        int $id,
        string $title,
        string $description,
        string $priority,
        string $status
    ): void {

        $sql = "
        UPDATE tickets
        SET
            title = :title,
            description = :description,
            priority = :priority,
            status = :status
        WHERE id = :id
    ";

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            "id" => $id,
            "title" => $title,
            "description" => $description,
            "priority" => $priority,
            "status" => $status
        ]);
    }

    public function delete(int $id): void
    {
        $sql = "
        DELETE FROM tickets
        WHERE id = :id
    ";

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            "id" => $id
        ]);
    }
}
