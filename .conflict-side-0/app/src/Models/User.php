<?php

namespace PrestaC\Models;

use DateTime;
use PDO;

class User
{
    private const ROLE_ADMIN = 1;
    private const ROLE_STUDENT = 2;
    private const ROLE_LECTURER = 3;

    public function __construct(
        public int $id,
        public string $fullName,
        public string $username,
        public string $password,
        public string $email,
        public string $phone,
        public string $avatar,
        public string $role,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ?DateTime $deletedAt,
    ) {}

    public static function findByUsername(PDO $db, string $username)
    {
        $row = $db->prepare('SELECT * FROM [dbo].[User] WHERE Username=:username AND DeletedAt IS NULL');
        $row->execute([
            "username" => $username
        ]);
        $result = $row->fetchAll();
        if (sizeof($result) < 1) {
            return null;
        }

        return new User(
            id: $result[0]['Id'],
            fullName: $result[0]['FullName'],
            username: $result[0]['Username'],
            password: $result[0]['Password'],
            email: $result[0]['Email'],
            phone: $result[0]['Phone'],
            avatar: $result[0]['Avatar'],
            role: $result[0]['Role'],
            createdAt: DateTime::createFromFormat('Y-m-d H:i:s.u', $result[0]['CreatedAt']),
            updatedAt: DateTime::createFromFormat('Y-m-d H:i:s.u', $result[0]['UpdatedAt']),
            deletedAt: $result[0]['DeletedAt'] == null ? null : DateTime::createFromFormat('Y-m-d H:i:s.u', $result[0]['DeletedAt'])
        );
    }

    public function validatePassword(string $password)
    {
        return password_verify($password, $this->password);
    }

    public static function getAll(PDO $db): array
    {
        $row = $db->query("SELECT * FROM [dbo].[User] WHERE DeletedAt IS NULL");
        $results = $row->fetchAll();

        return array_map(fn($user) => User::fromArray($user), $results);
    }

    public static function getById(PDO $db, int $id): ?self
    {
        $row = $db->prepare("SELECT * FROM [dbo].[User] WHERE Id = :id AND DeletedAt IS NULL");
        $row->execute(['id' => $id]);
        $data = $row->fetch();

        return $data ? self::fromArray($data) : null;
    }

    public static function search(PDO $db, string $query): array
    {
        $row = $db->prepare("
            SELECT * FROM [dbo].[User]
            WHERE (FullName LIKE :query OR
                  Username LIKE :query OR
                  Email LIKE :query) AND
                  DeletedAt IS NULL
        ");
        $row->execute(['query' => '%' . $query . '%']);
        $results = $row->fetchAll();

        return array_map(fn($user) => self::fromArray($user), $results);
    }

    public function update(PDO $db): void
    {
        $row = $db->prepare("
            UPDATE [dbo].[User]
            SET FullName = :fullName,
                Username = :username,
                Password = :password,
                Email = :email,
                Phone = :phone,
                Avatar = :avatar,
                Role = :role,
                UpdatedAt = :updatedAt
            WHERE Id = :id AND DeletedAt IS NULL
        ");
        $row->execute([
            'id' => $this->id,
            'fullName' => $this->fullName,
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'role' => $this->role,
            'updatedAt' => (new DateTime())->format('Y-m-d H:i:s')
        ]);
    }

    public static function delete(PDO $db, int $id): void
    {
        $row = $db->prepare("UPDATE [dbo].[User] SET DeletedAt = :deletedAt WHERE Id = :id");
        $row->execute([
            'id' => $id,
            'deletedAt' => (new DateTime())->format('Y-m-d H:i:s')
        ]);
    }
    
    public static function getCount(PDO $db): int
    {
        $stmt = $db->query("SELECT COUNT(*) AS Count FROM [dbo].[User] WHERE DeletedAt IS NULL");
        return (int)$stmt->fetch()['Count'];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['Id'],
            fullName: $data['FullName'],
            username: $data['Username'],
            password: $data['Password'],
            email: $data['Email'],
            phone: $data['Phone'],
            avatar: $data['Avatar'],
            role: $data['Role'],
            createdAt: DateTime::createFromFormat('Y-m-d H:i:s.u', $data['CreatedAt']),
            updatedAt: DateTime::createFromFormat('Y-m-d H:i:s.u', $data['UpdatedAt']),
            deletedAt: $data['DeletedAt'] ? DateTime::createFromFormat('Y-m-d H:i:s.u', $data['DeletedAt']) : null
        );
    }

    public static function getAllActiveLecturers(PDO $db): array
    {
        $stmt = $db->prepare("
            SELECT u.* 
            FROM [dbo].[User] u
            INNER JOIN [dbo].[Lecturer] l ON u.Id = l.UserId
            WHERE u.Role = :role 
            AND u.DeletedAt IS NULL
            ORDER BY u.FullName ASC
        ");

        $stmt->execute([':role' => self::ROLE_LECTURER]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($lecturer) {
            return [
                'Id' => $lecturer['Id'],
                'FullName' => $lecturer['FullName'],
                'Username' => $lecturer['Username'],
                'Email' => $lecturer['Email']
            ];
        }, $results);
    }

    public static function getAllActiveStudents(PDO $db): array
    {
        $stmt = $db->prepare("
            SELECT u.* 
            FROM [dbo].[User] u
            INNER JOIN [dbo].[Student] s ON u.Id = s.UserId
            WHERE u.Role = :role 
            AND u.DeletedAt IS NULL
            ORDER BY u.FullName ASC
        ");

        $stmt->execute([':role' => self::ROLE_STUDENT]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($student) {
            return [
                'Id' => $student['Id'],
                'FullName' => $student['FullName'],
                'Username' => $student['Username'],
                'Email' => $student['Email']
            ];
        }, $results);
    }

    public function isLecturer(): bool
    {
        return $this->role === self::ROLE_LECTURER;
    }

    public function isStudent(): bool
    {
        return $this->role === self::ROLE_STUDENT;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }
    
}
