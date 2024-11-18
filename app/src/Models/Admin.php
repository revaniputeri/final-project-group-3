<?php

namespace PrestaC\Models;

use PDO;
use DateTime;

class Admin
{
    public function __construct(
        public $id,
        public $name,
        public $email,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ?DateTime $deletedAt = null
    ) {}

    public function saveAdmin(PDO $db)
    {
        $createdAt = (new DateTime())->format('Y-m-d H:i:s');
        $updatedAt = (new DateTime())->format('Y-m-d H:i:s');

        $row = $db->prepare('INSERT INTO [dbo].[Admin] (name, email, created_at, updated_at) VALUES (:name, :email, :createdAt, :updatedAt)');
        $row->execute([
            ':name' => $this->name,
            ':email' => $this->email,
            ':createdAt' => $createdAt,
            ':updatedAt' => $updatedAt
        ]);

        return $db->lastInsertId();
    }

    public static function getAdminById(PDO $db, int $id)
    {
        $row = $db->prepare('SELECT * FROM [dbo].[Admin] WHERE id = :id AND deleted_at IS NULL');
        $row->execute([':id' => $id]);
        return $row->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllAdmins(PDO $db)
    {
        $row = $db->query('SELECT * FROM [dbo].[Admin] WHERE deleted_at IS NULL');
        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteAdmin(PDO $db, int $id)
    {
        $deletedAt = (new DateTime())->format('Y-m-d H:i:s');
        $row = $db->prepare('UPDATE [dbo].[Admin] SET deleted_at = :deletedAt WHERE id = :id');
        return $row->execute([':id' => $id, ':deletedAt' => $deletedAt]);
    }
}