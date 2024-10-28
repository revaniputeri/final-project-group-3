<?php

namespace PrestaC\Models;

use PDO;
use DateTime;

class Dosen
{
    public function __construct(
        public $id = null, // Made id nullable since it's auto-generated
        public $userId, // Added userId field to match User table relationship
        public $name,
        public $email,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ?DateTime $deletedAt = null
    ) {}

    public static function getDosenById(PDO $db, int $id)
    {
        $row = $db->prepare('SELECT * FROM [dbo].[Lecturer] WHERE id = :id AND deleted_at IS NULL');
        $row->execute([':id' => $id]);
        return $row->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateDosenProfile(PDO $db, int $userId, array $data)
    {
        $stmt = $db->prepare("UPDATE dosen SET username = ?, email = ?, bio = ? WHERE user_id = ?");
        return $stmt->execute([$data['username'], $data['email'], $data['bio'], $userId]);
    }

    public static function getAllDosens(PDO $db)
    {
        $row = $db->query('SELECT * FROM [dbo].[Lecturer] WHERE deleted_at IS NULL');
        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteDosen(PDO $db, int $id)
    {
        $deletedAt = (new DateTime())->format('Y-m-d H:i:s');
        $stmt = $db->prepare('UPDATE [dbo].[Lecturer] SET deleted_at = :deletedAt WHERE id = :id');
        return $stmt->execute([':id' => $id, ':deletedAt' => $deletedAt]);
    }
}