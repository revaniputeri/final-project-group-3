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

function getRandomExpertiseField()
{
    $expertiseFields = [
        'Computer Science',
        'Information Systems',
        'Software Engineering',
        'Computer Networks',
        'Artificial Intelligence',
        'Database Systems',
        'Information Technology',
        'Data Science',
        'Cyber Security',
        'Mobile Computing',
        'Other'
    ];
    return $expertiseFields[array_rand($expertiseFields)];
}

function getRandomMajor()
{
    // Based on StudentMajor INT enum in create.sql
    return rand(1, 2); // 1 = D-IV Informatics, 2 = D-IV Business Information System
}

try {
    $conn = new PDO(
        "sqlsrv:Server={$config['host']};Database={$config['name']}",
        $config['username'],
        $config['password']
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully\n";

    // Lecturer data array
    $lecturers = [
        ['D001', 'Abdul Chalim, SAg., MPd.I'],
        ['D002', 'Ade Ismail'],
        ['D003', 'Agung Nugroho Pramudhita ST., MT.'],
        ['D004', 'Ahmadi Yuli Ananta ST., MM.'],
        ['D005', 'Ane Fany Novitasari, SH.MKn.'],
        ['D006', 'Annisa Puspa Kirana MKom.'],
        ['D007', 'Annisa Taufika Firdausi ST., MT.'],
        ['D008', 'Anugrah Nur Rahmanto SSn., MDs.'],
        ['D009', 'Ariadi Retno Ririd SKom., MKom.'],
        ['D010', 'Arie Rachmad Syulistyo SKom., MKom.'],
        ['D011', 'Atiqah Nurul Asri ST., MT.'],
        ['D012', 'Bayu Kristianto ST., MT.'],
        ['D013', 'Budi Harijanto ST., MM.'],
        ['D014', 'Cahya Rahmad ST., M.Kom.'],
        ['D015', 'Deddy Kusbianto Purwoko Aji ST., MKom.'],
        ['D016', 'Deasy Sandhya Elya Ikawati ST., MT.'],
        ['D017', 'Dedy Hidayat Kusuma ST., MT.'],
        ['D018', 'Dian Hanifudin Subhi ST., MT.'],
        ['D019', 'Dimas Wahyu Wibowo ST., MT.'],
        ['D020', 'Dwi Puspitasari SKom., MKom.'],
        ['D021', 'Ekojono ST., MKom.'],
        ['D022', 'Elok Nur Hamdana ST., MT.'],
        ['D023', 'Ely Setyo Astuti ST., MT.'],
        ['D024', 'Erfan Rohadi ST., MEng.'],
        ['D025', 'Erick Alfons Lisangan ST., MCs.'],
        ['D026', 'Farid Angga Pribadi ST., MKom.'],
        ['D027', 'Hendra Pradibta ST., MEng.'],
        ['D028', 'Heny Kuswanti Daryono ST., MT.'],
        ['D029', 'Imam Fahrur Rozi ST., MT.'],
        ['D030', 'Indra Dharma Wijaya ST., MMT.']
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
                Role,
                CreatedAt,
                UpdatedAt
            ) OUTPUT INSERTED.Id
            VALUES (
                ?, 
                ?, 
                ?, 
                ?, 
                ?, 
                'default-avatar.png', 
                3,
                GETDATE(),
                GETDATE()
            )
        ");

        $lecturerStmt = $conn->prepare("
            INSERT INTO Lecturer (
                UserId,
                ExpertiseField,
                Major
            ) VALUES (
                ?,
                ?,
                ?
            )
        ");

        foreach ($lecturers as $lecturer) {
            $code = $lecturer[0];
            $name = $lecturer[1];
            $email = generateEmail($name);
            $phone = '08' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
            
            // Insert user and get ID directly
            $userStmt->execute([
                $name,
                $code,
                password_hash($code, PASSWORD_DEFAULT),
                $email,
                $phone,
            ]);
            
            // Get the inserted ID directly from the OUTPUT clause
            $userId = $userStmt->fetch(PDO::FETCH_COLUMN);
            
            $expertiseField = getRandomExpertiseField();
            $major = getRandomMajor();
            
            // Debug output
            echo "Inserting lecturer with UserId: $userId\n";
            
            // Insert lecturer
            $lecturerStmt->execute([
                $userId,
                $expertiseField,
                $major
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