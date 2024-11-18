<?php

namespace PrestaC\Models;

use PDO;
use DateTime;

class Dosen
{
    public function __construct(
        public $id,
        public $name,
        public $email,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ?DateTime $deletedAt = null
    ) {}

    public function saveDosen(PDO $db)
    {
        $createdAt = (new DateTime())->format('Y-m-d H:i:s');
        $updatedAt = (new DateTime())->format('Y-m-d H:i:s');

        $row = $db->prepare('INSERT INTO [dbo].[Dosen] (name, email, created_at, updated_at) VALUES (:name, :email, :createdAt, :updatedAt)');
        $row->execute([
            ':name' => $this->name,
            ':email' => $this->email,
            ':createdAt' => $createdAt,
            ':updatedAt' => $updatedAt
        ]);

        return $db->lastInsertId();
    }

    public static function getDosenById(PDO $db, int $id)
    {
        $row = $db->prepare('SELECT * FROM [dbo].[Dosen] WHERE id = :id AND deleted_at IS NULL');
        $row->execute([':id' => $id]);
        return $row->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllDosens(PDO $db)
    {
        $row = $db->query('SELECT * FROM [dbo].[Dosen] WHERE deleted_at IS NULL');
        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteDosen(PDO $db, int $id)
    {
        $deletedAt = (new DateTime())->format('Y-m-d H:i:s');
        $stmt = $db->prepare('UPDATE [dbo].[Dosen] SET deleted_at = :deletedAt WHERE id = :id');
        return $stmt->execute([':id' => $id, ':deletedAt' => $deletedAt]);
    }
}