<?php

namespace PrestaC\Models;

use PDO;


class Student
{
    public static function getStudentById(PDO $db, int $userId): mixed
    {
        $stmt = $db->prepare("
            SELECT
                u.Id AS UserId,
                u.FullName,
                u.Username,
                u.Email,
                u.Phone,
                u.Role,
                CASE
                    WHEN s.StudentMajor = 1 THEN 'Teknik Informatika'
                    WHEN s.StudentMajor = 2 THEN 'Sistem Informasi Bisnis'
                    ELSE 'Unknown'
                END AS StudentMajor,    
                CASE
                    WHEN s.StudentStatus = 1 THEN 'Aktif'
                    WHEN s.StudentStatus = 2 THEN 'Pasif'
                    ELSE 'Unknown'
                END AS StudentStatus,
                a.CompetitionPoints,
                COUNT(a.Id) AS AchievementCount
            FROM
                [User] u
            INNER JOIN
                [Student] s
            ON
                u.Id = s.UserId
            INNER JOIN
                [Achievement] a
            ON
                u.Id = a.UserId
            WHERE
                u.Id = :userId
            GROUP BY
                u.Id, u.FullName, u.Username, u.Email, u.Phone, u.Role, s.StudentMajor, s.StudentStatus, a.CompetitionPoints
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public static function getTotalAchievementsAndPoints(PDO $db, int $userId): array
{
    $stmt = $db->prepare("
        SELECT 
            COUNT(a.Id) AS TotalAchievements,
            SUM(a.CompetitionPoints) AS TotalPoints
        FROM 
            Achievement a
        WHERE 
            a.UserId = :userId
        AND
            a.AdminValidationStatus = 'DITERIMA'
    ");
    $stmt->execute(['userId' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?? ['TotalAchievements' => 0, 'TotalPoints' => 0];
}
}
?>