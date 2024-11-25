<?php

namespace PrestaC\Models;

use PDO;
use DateTime;

class Admin
{
    public function __construct(
        public $id = null, 
        public $userId,
        public $name,
        public $email,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ?DateTime $deletedAt = null
    ) {}

    public static function getAdminById(PDO $db, int $id)
    {
        $row = $db->prepare('SELECT * FROM [dbo].[Admin] WHERE id = :id AND deleted_at IS NULL');
        $row->execute([':id' => $id]);
        return $row->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateAdminProfile(PDO $db, int $userId, array $data)
    {
        $stmt = $db->prepare("UPDATE admins SET username = ?, email = ?, bio = ? WHERE user_id = ?");
        return $stmt->execute([$data['username'], $data['email'], $data['bio'], $userId]);
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