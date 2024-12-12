<?php

$config = require_once __DIR__ . '/../config.php';

function generateEmail($name)
{
    $name = explode(' ', $name);
    $name = $name[0] . '.' . $name[1];
    $name = strtolower($name);
    $email = trim($name);
    return $email . '@polinema.ac.id';
}

try {
    $conn = new PDO(
        "sqlsrv:Server={$config['host']};Database={$config['name']}",
        $config['username'],
        $config['password']
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully\n";

    //data array admin
    $admins = [
        ['ADM000', 'Admin Pusat'],
        ['ADM001', 'Admin Program Studi Sistem Informasi Bisnis'],
        ['ADM002', 'Admin Program Studi Teknik Informatika']
    ];

    $conn->beginTransaction();
    try {
        $userStmt = $conn->prepare("
            INSERT INTO [User] (
                FullName, 
                Username, 
                Password, 
                Email, 
                Phone, 
                Avatar, 
                Role,
                CreatedAt,
                UpdatedAt
            ) VALUES (?, ?, ?, ?, ?, 'default-avatar.png', 1, GETDATE(), GETDATE())
        ");

        foreach ($admins as $admin) {
            $code = $admin[0];
            $name = $admin[1];
            $email = generateEmail($name);
            $phone = '08' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);

            $userStmt->execute([
                $name,
                $code,
                password_hash($code, PASSWORD_DEFAULT),
                $email,
                $phone
            ]);
        }
        $conn->commit();
        echo "Data seeded successfully\n";
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error seeding data: " . $e->getMessage() . "\n";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}