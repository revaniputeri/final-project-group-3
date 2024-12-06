<?php

namespace PrestaC\Models;

use PDO;

class Student
{
    public static function createStudent(PDO $db, array $data)
    {
        $stmt = $db->prepare("INSERT INTO students (username, email, bio, profile_picture) VALUES (:username, :email, :bio, :profilePicture)");
        $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':bio' => $data['bio'],
            ':profilePicture' => $data['profilePicture']
        ]);
        return $db->lastInsertId();
    }

    public static function getStudentById(PDO $db, int $id)
    {
        $stmt = $db->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateStudentProfile(PDO $db, int $id, array $data)
    {
        $stmt = $db->prepare("UPDATE students SET username = :username, email = :email, bio = :bio, profile_picture = :profilePicture WHERE id = :id");
        $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':bio' => $data['bio'],
            ':profilePicture' => $data['profilePicture'],
            ':id' => $id
        ]);
    }

    public static function deleteStudent(PDO $db, int $id)
    {
        $stmt = $db->prepare("DELETE FROM students WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}