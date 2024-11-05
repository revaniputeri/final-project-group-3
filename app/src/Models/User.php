<?php

namespace PrestaC\Models;

use DateTime;
use PDO;

class User
{
    // Constructor to initialize user properties
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
        $row = $db->prepare('SELECT * FROM [dbo].[User] WHERE Username=:username');
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

    public static function register(
        PDO $db,
        string $fullName,
        string $username,
        string $password,
        string $email,
        string $phone,
        string $avatar,
        string $role
    ) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $createdAt = (new DateTime())->format('Y-m-d H:i:s');
        $updatedAt = (new DateTime())->format('Y-m-d H:i:s');

        $row = $db->prepare(
            'INSERT INTO [dbo].[User] (FullName, Username, Password, Email, Phone, Avatar, Role)
                    VALUES (:fullName, :username, :password, :email, :phone, :avatar, :role)'
        );
        // intinya bindParam -> securely add data to db
        $row->bindParam(':fullName', $fullName);
        $row->bindParam(':username', $username);
        $row->bindParam(':password', $hashedPassword);
        $row->bindParam(':email', $email);
        $row->bindParam(':phone', $phone);
        $row->bindParam(':avatar', $avatar);
        $row->bindParam(':role', $role);

        $row->execute();
    }

    public static function getAll(PDO $db): array {
        $row = $db->query("SELECT * FROM [dbo].[User]");
        $results = $row->fetchAll();
    
        return array_map(fn($user) => self::fromArray($user), $results);
    }

    public static function getById(PDO $db, int $id): ?self
    {
        $row = $db->prepare("SELECT * FROM [dbo].[User] WHERE Id = :id");
        $row->execute(['id' => $id]);
        $data = $row->fetch();

        return $data ? self::fromArray($data) : null;
    }

    public static function search(PDO $db, string $query): array
    {
        $row = $db->prepare("
            SELECT * FROM [dbo].[User]
            WHERE FullName LIKE :query OR
                  Username LIKE :query OR
                  Email LIKE :query
        ");
        $row->execute(['query' => '%' . $query . '%']);
        $results = $row->fetchAll();

        return array_map(fn($user) => self::fromArray($user), $results);
    }
}
