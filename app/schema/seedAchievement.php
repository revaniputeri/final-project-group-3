<?php

$config = require_once __DIR__ . '/../config.php';

function getRandomCompetitionType()
{
    $types = ['Sains', 'Seni', 'Olahraga', 'Lainnya'];
    return $types[array_rand($types)];
}

function getRandomCompetitionLevel()
{
    
    $randomCompetitionLevel = rand(1, 6); // 1 = International, 2 = National, 3 = Provincial, 4 = City, 5 = District, 6 = School
    return $randomCompetitionLevel;
}

function getRandomCompetitionRank()
{
    $randomCompetitionRank =  rand(1, 5); // 1 = 1st, 2 = 2nd, 3 = 3rd, 4 = Honorable Mention, 5 = Finalist
    return $randomCompetitionRank;
}

function getPoints($competitionLevel, $competitionRank )
{
    $levelPoints = [
        1 => 4.0, // Internasional
        2 => 3.0, // Nasional
        3 => 2.0, // Provinsi
        4 => 1.5, // Kab/Kota
        5 => 1.0, // Kecamatan
        6 => 1.0, // Sekolah
        7 => 0.5  // Jurusan
    ];

    $rankPoints = [
        1 => 3.5, // Juara 1
        2 => 3.0, // Juara 2
        3 => 2.5, // Juara 3
        4 => 2.0, // Penghargaan
        5 => 1.0  // Juara Harapan
    ];

    $totalPoints = (float)($levelPoints[$competitionLevel] + $rankPoints[$competitionRank]);
    return $totalPoints;
}

function getRandomInstitutions()
{
    return rand(5, 10);
}

function getRandomStudents()
{
    $numberOfStudents = rand(1, 5);
    return $numberOfStudents;
}

function getRandomLetterNumber()
{
    return 'SRT/' . rand(1000, 9999) . '/' . date('Y');
}

try {
    $conn = new PDO(
        "sqlsrv:Server={$config['host']};Database={$config['name']}",
        $config['username'],
        $config['password']
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully\n";

    // Get all student and lecturer IDs
    $studentQuery = "SELECT u.Id FROM [User] u INNER JOIN Student s ON u.Id = s.UserId";
    $lecturerQuery = "SELECT Id FROM Lecturer";

    $students = $conn->query($studentQuery)->fetchAll(PDO::FETCH_COLUMN);
    $lecturers = $conn->query($lecturerQuery)->fetchAll(PDO::FETCH_COLUMN);

    if (empty($students) || empty($lecturers)) {
        die("Error: No students or lecturers found in the database. Please seed users and lecturers first.\n");
    }

    $conn->beginTransaction();

    try {
        $achievementStmt = $conn->prepare("
            INSERT INTO Achievement (
                UserId, CompetitionType, CompetitionLevel, CompetitionPoints,
                CompetitionTitle, CompetitionTitleEnglish, CompetitionPlace,
                CompetitionPlaceEnglish, CompetitionUrl, CompetitionStartDate,
                CompetitionEndDate, CompetitionRank, NumberOfInstitutions,
                NumberOfStudents, LetterNumber, LetterDate, LetterFile,
                CertificateFile, DocumentationFile, PosterFile,
                AdminValidationStatus,
                CreatedAt, UpdatedAt
            ) OUTPUT INSERTED.Id VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                GETDATE(), GETDATE()
            )
        ");

        $userAchievementStmt = $conn->prepare("
            INSERT INTO UserAchievement (
                UserId, AchievementId, AchievementRole
            ) VALUES (?, ?, ?)
        ");

        for ($i = 0; $i < 1000; $i++) {
            $userId = $students[array_rand($students)];
            $competitionType = getRandomCompetitionType();
            $competitionLevel = getRandomCompetitionLevel();
            $competitionRank = getRandomCompetitionRank();
            $numberOfStudents = getRandomStudents();
            $startDate = new DateTime(date('Y-m-d', strtotime('-' . rand(1, 365) . ' days')));
            $endDate = clone $startDate;
            $endDate->modify('+' . rand(1, 7) . ' days');
            $letterDate = clone $endDate;
            $letterDate->modify('+' . rand(1, 14) . ' days');

            $achievementStmt->execute([
                $userId,
                $competitionType,
                $competitionLevel,
                getPoints($competitionLevel, $competitionRank),
                "Competition Title " . ($i + 1),
                "Competition Title English " . ($i + 1),
                "Competition Place " . ($i + 1),
                "Competition Place English " . ($i + 1),
                "https://competition" . ($i + 1) . ".example.com",
                $startDate->format('Y-m-d H:i:s'),
                $endDate->format('Y-m-d H:i:s'),
                $competitionRank,
                getRandomInstitutions(),
                $numberOfStudents,
                getRandomLetterNumber(),
                $letterDate->format('Y-m-d H:i:s'),
                'letter_' . ($i + 1) . '.pdf',
                'certificate_' . ($i + 1) . '.pdf',
                'documentation_' . ($i + 1) . '.jpg',
                'poster_' . ($i + 1) . '.jpg',
                ['PROSES', 'DITERIMA', 'DITOLAK'][rand(0, 2)]
            ]);

            $achievementId = $achievementStmt->fetch(PDO::FETCH_COLUMN);

            // Randomly add team members based on numberOfStudents
            $teamMembers = $numberOfStudents; // ketua
            if ($teamMembers == 1) {
                $userAchievementStmt->execute([
                    $userId,
                    $achievementId,
                    4 // 4 = Personal
                ]);
            } else {
                $userAchievementStmt->execute([
                    $userId,
                    $achievementId,
                    2 // 2 = Team Leader
                ]);

                // Add team members
                for ($j = 0; $j < $teamMembers - 1; $j++) {
                    $teamMemberId = $students[array_rand($students)];
                    if ($teamMemberId != $userId) {
                        $userAchievementStmt->execute([
                            $teamMemberId,
                            $achievementId,
                            3 // 3 = Team Member
                        ]);
                    }
                }
            }

            // Add 1 random supervisor
            $supervisorId = $lecturers[array_rand($lecturers)];
            $userAchievementStmt->execute([
                $supervisorId,
                $achievementId,
                1 // 1 = Supervisor
            ]);
        }

        $conn->commit();
        echo "Achievement data seeded successfully\n";
    } catch (Exception $e) {
        $conn->rollBack();
        echo "Error seeding achievement data: " . $e->getMessage() . "\n";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
