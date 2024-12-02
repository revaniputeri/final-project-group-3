<?php

namespace PrestaC\Models;

use PDO;

class Admin
{
    public static function createAdmin(PDO $db, array $data)
    {
        $stmt = $db->prepare("INSERT INTO admins (username, email, bio, profile_picture) VALUES (:username, :email, :bio, :profilePicture)");
        $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':bio' => $data['bio'],
            ':profilePicture' => $data['profilePicture']
        ]);
        return $db->lastInsertId();
    }

    public static function getAdminById(PDO $db, int $id)
    {
        $stmt = $db->prepare("SELECT * FROM admins WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateAdminProfile(PDO $db, int $id, array $data)
    {
        $stmt = $db->prepare("UPDATE admins SET username = :username, email = :email, bio = :bio, profile_picture = :profilePicture WHERE id = :id");
        $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':bio' => $data['bio'],
            ':profilePicture' => $data['profilePicture'],
            ':id' => $id
        ]);
    }

    public static function deleteAdmin(PDO $db, int $id)
    {
        $stmt = $db->prepare("DELETE FROM admins WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}