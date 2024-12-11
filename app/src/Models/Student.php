<?php

namespace PrestaC\Models;

use PDO;

class Student
{
    public static function getStudentById(PDO $db, int $userId)
    {
        $stmt = $db->prepare("SELECT * FROM dbo.Student WHERE UserId = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateStudentProfile(PDO $db, int $userId, array $data)
    {
        $sql = "UPDATE dbo.Student SET username = ?, email = ?, bio = ?, profile_image = ? WHERE UserId = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $data['username'],
            $data['email'],
            $data['bio'],
            $data['profile_image'] ?? null,
            $userId
        ]);
    }
    
}