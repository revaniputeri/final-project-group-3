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
                END AS StudentStatus
            FROM
                [User] u
            INNER JOIN
                [Student] s
            ON
                u.Id = s.UserId
            WHERE
                u.Id = :userId
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>