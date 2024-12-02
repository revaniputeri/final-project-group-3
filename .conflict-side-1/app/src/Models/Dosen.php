<?php

namespace PrestaC\Models;

use PDO;

class Dosen
{
    public static function createDosen(PDO $db, array $data)
    {
        $stmt = $db->prepare("INSERT INTO dosen (username, email, bio, profile_picture) VALUES (:username, :email, :bio, :profilePicture)");
        $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':bio' => $data['bio'],
            ':profilePicture' => $data['profilePicture']
        ]);
        return $db->lastInsertId();
    }

    public static function getDosenById(PDO $db, int $id)
    {
        $stmt = $db->prepare("SELECT * FROM dosen WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateDosenProfile(PDO $db, int $id, array $data)
    {
        $stmt = $db->prepare("UPDATE dosen SET username = :username, email = :email, bio = :bio, profile_picture = :profilePicture WHERE id = :id");
        $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':bio' => $data['bio'],
            ':profilePicture' => $data['profilePicture'],
            ':id' => $id
        ]);
    }

    public static function deleteDosen(PDO $db, int $id)
    {
        $stmt = $db->prepare("DELETE FROM dosen WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}