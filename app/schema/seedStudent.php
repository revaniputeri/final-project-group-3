<?php

$config = require_once __DIR__ . '/../config.php';

function generateEmail($name) 
{
    $name = explode(' ', $name);
    $name = $name[0] . '.' . $name[1];
    $name = strtolower($name);
    $email = trim($name);
    return $email . '@student.polinema.ac.id';
}




function getRandomMajor()
{
    // Based on StudentMajor INT enum in create.sql
    return rand(1, 2); // 1 = D-IV Informatics, 2 = D-IV Business Information System
}

function getRandomStatus()
{
    // Based on StudentStatus INT enum in create.sql
    return rand(1, 2); // 1 = Active, 2 = Non Active
}

try {
    $conn = new PDO(
        "sqlsrv:Server={$config['host']};Database={$config['name']}",
        $config['username'],
        $config['password']
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully\n";

    // Student data array
    $students = [
        ['2341760056', 'Revani Nanda Putri'],
        ['2341760124','Ardhelia Putri Maharani'],
        ['2341760191','Alvi Choirinnikmah'],
        ['2341760095','Susilowati Syafa Adilah'],
        ['2341760057', 'Ahmad Fauzi'],
        ['2341760058', 'Alya Putri'],
        ['2341760059', 'Anisa Rahma'],
        ['2341760060', 'Budi Santoso'],
        ['2341760061', 'Citra Dewi'],
        ['2341760062', 'Dian Pratama'],
        ['2341760063', 'Eka Saputra'],
        ['2341760064', 'Fajar Ramadhan'],
        ['2341760065', 'Gita Purnama'],
        ['2341760066', 'Hadi Wijaya'],
        ['2341760067', 'Indah Sari'],
        ['2341760068', 'Joko Susilo'],
        ['2341760069', 'Kartika Sari'],
        ['2141720015', 'Lutfi Ahmad'],
        ['2141720016', 'Maya Anggraini'],
        ['2141720017', 'Nanda Putra'],
        ['2141720018', 'Oktavia Dewi'],
        ['2141720019', 'Putri Rahayu'],
        ['2141720020', 'Rendi Pratama'],
        ['2141720021', 'Sinta Dewi'],
        ['2141720022', 'Taufik Hidayat'],
        ['2141720023', 'Umar Hakim'],
        ['2141720024', 'Vina Amalia'],
        ['2141720025', 'Wahyu Kusuma'],
        ['2141720026', 'Xena Putri'],
        ['2141720027', 'Yoga Pratama'],
        ['2141720028', 'Zahra Safitri'],
        ['2141720029', 'Aditya Nugroho'],
        ['2141720030', 'Bella Safira']
    ];

    $conn->beginTransaction();
    try {
        // Insert Users
        $userStmt = $conn->prepare("
            INSERT INTO [User] (
                FullName,
                Username,
                Password,
                Email,
                Phone,
                Avatar,
                Role
            ) OUTPUT INSERTED.Id VALUES (
                ?,
                ?,
                ?,
                ?,
                ?,
                'default-avatar.png',
                2 -- Role 2 = STUDENT based on enum in create.sql
            )
        ");

        $studentStmt = $conn->prepare("
            INSERT INTO Student (
                UserId,
                StudentMajor,
                StudentStatus
            ) VALUES (
                ?,
                ?,
                ?
            )
        ");

        foreach ($students as $student) {
            $nim = $student[0];
            $name = $student[1];
            $email = generateEmail($name);
            $phone = '08' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
            
            // Insert user and get ID directly
            $userStmt->execute([
                $name,
                $nim,
                password_hash($nim, PASSWORD_DEFAULT),
                $email,
                $phone,
            ]);
            
            // Get the inserted ID directly from the OUTPUT clause
            $userId = $userStmt->fetch(PDO::FETCH_COLUMN);
            
            $major = getRandomMajor();
            $status = getRandomStatus();
            
            // Debug output
            echo "Inserting student with UserId: $userId\n";
            
            // Insert student
            $studentStmt->execute([
                $userId,
                $major,
                $status
            ]);
        }
        $conn->commit();
        echo "Data seeded successfully\n";
    } catch (Exception $e) {
        $conn->rollBack();
        echo "Error seeding data: " . $e->getMessage() . "\n";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
