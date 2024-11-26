<?php

namespace PrestaC\Models;

use PDO;

class Student
{
    public static function getStudentById(PDO $db, int $userId)
    {
        $stmt = $db->prepare("SELECT * FROM students WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateStudentProfile(PDO $db, int $userId, array $data)
    {
        // Implementation for updating student profile
        $stmt = $db->prepare("UPDATE students SET username = ?, email = ?, bio = ? WHERE user_id = ?");
        return $stmt->execute([$data['username'], $data['email'], $data['bio'], $userId]);
    }
}