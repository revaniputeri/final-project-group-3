<?php

namespace PrestaC\Models;

use DateTime;
use InvalidArgumentException;
use PDO;

class Achievement
{
    private const MAX_FILE_SIZE = 5242880; // 5MB
    private const ALLOWED_FILE_TYPES = ['application/pdf', 'image/jpeg', 'image/png'];
    private const UPLOAD_BASE_PATH = 'public/storage/achievements/';
    private const UPLOAD_FOLDERS = [
        'letterFile' => 'letters',
        'certificateFile' => 'certificates',
        'documentationFile' => 'documentation',
        'posterFile' => 'posters'
    ];

    private const COMPETITION_RANKS = [
        1 => ['name' => 'Juara 1', 'points' => 3.5],
        2 => ['name' => 'Juara 2', 'points' => 3],
        3 => ['name' => 'Juara 3', 'points' => 2.5],
        4 => ['name' => 'Penghargaan', 'points' => 2],
        5 => ['name' => 'Juara Harapan', 'points' => 1]
    ];

    private const COMPETITION_LEVELS = [
        1 => ['name' => 'Internasional', 'points' => 4.0],
        2 => ['name' => 'Nasional', 'points' => 3.0],
        3 => ['name' => 'Provinsi', 'points' => 2.0],
        4 => ['name' => 'Kab/Kota', 'points' => 1.5],
        5 => ['name' => 'Kecamatan', 'points' => 1.0],
        6 => ['name' => 'Sekolah', 'points' => 1.0],
        7 => ['name' => 'Jurusan', 'points' => 0.5]
    ];

    private const ROLE_SUPERVISOR = 1;
    private const ROLE_TEAM_LEADER = 2;
    private const ROLE_TEAM_MEMBER = 3;

    public function __construct(
        public $userId,
        public $competitionType,
        public $competitionLevel,
        public $competitionTitle,
        public $competitionTitleEnglish,
        public $competitionPlace,
        public $competitionPlaceEnglish,
        public $competitionUrl,
        public DateTime $competitionStartDate,
        public DateTime $competitionEndDate,
        public $competitionRank,
        public $numberOfInstitutions,
        public $numberOfStudents,
        public $letterNumber,
        public DateTime $letterDate,
        public $letterFile,
        public $certificateFile,
        public $documentationFile,
        public $posterFile,
        public $competitionPoints,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public $id = null,
        public $supervisorValidationStatus = 'PENDING',
        public ?DateTime $supervisorValidationDate = null,
        public ?string $supervisorValidationNote = null,
        public $adminValidationStatus = 'PENDING',
        public ?DateTime $adminValidationDate = null,
        public ?string $adminValidationNote = null,
        public ?DateTime $deletedAt = null
    ) {}

    private function calculateCompetitionPoints(): float
    {
        $rankPoints = self::COMPETITION_RANKS[$this->competitionRank]['points'] ?? 0;
        $levelPoints = self::COMPETITION_LEVELS[$this->competitionLevel]['points'] ?? 0;

        return $rankPoints + $levelPoints;
    }

    public static function getCompetitionRanks(): array
    {
        return self::COMPETITION_RANKS;
    }

    public static function getCompetitionLevels(): array
    {
        return self::COMPETITION_LEVELS;
    }
    public static function getCompetitionRankName(int $rankId): string 
    {
        return self::COMPETITION_RANKS[$rankId]['name'] ?? 'Unknown';
    }

    public static function getCompetitionLevelName(int $levelId): string 
    {
        return self::COMPETITION_LEVELS[$levelId]['name'] ?? 'Unknown';
    }

    public function saveAchievement(PDO $db, array $supervisors = [], array $teamMembers = [])
    {
        $this->validateFileInputs();

        $this->competitionPoints = $this->calculateCompetitionPoints();

        $createdAt = (new DateTime())->format('Y-m-d H:i:s');
        $updatedAt = (new DateTime())->format('Y-m-d H:i:s');

        $row = $db->prepare('INSERT INTO [dbo].[Achievement] (
            UserId,
            CompetitionType,
            CompetitionLevel,
            CompetitionTitle,
            CompetitionTitleEnglish,
            CompetitionPlace,
            CompetitionPlaceEnglish,
            CompetitionUrl,
            CompetitionStartDate,
            CompetitionEndDate,
            CompetitionRank,
            NumberOfInstitutions,
            NumberOfStudents,
            LetterNumber,
            LetterDate,
            LetterFile,
            CertificateFile,
            DocumentationFile,
            PosterFile,
            CompetitionPoints,
            SupervisorValidationStatus,
            SupervisorValidationDate,
            SupervisorValidationNote,
            AdminValidationStatus,
            AdminValidationDate,
            AdminValidationNote,
            CreatedAt,
            UpdatedAt
        ) VALUES (
            :userId,
            :competitionType,
            :competitionLevel,
            :competitionTitle,
            :competitionTitleEnglish,
            :competitionPlace,
            :competitionPlaceEnglish,
            :competitionUrl,
            :competitionStartDate,
            :competitionEndDate,
            :competitionRank,
            :numberOfInstitutions,
            :numberOfStudents,
            :letterNumber,
            :letterDate,
            :letterFile,
            :certificateFile,
            :documentationFile,
            :posterFile,
            :competitionPoints,
            :supervisorValidationStatus,
            :supervisorValidationDate,
            :supervisorValidationNote,
            :adminValidationStatus,
            :adminValidationDate,
            :adminValidationNote,
            :createdAt,
            :updatedAt
        )');

        $row->execute([
            ':userId' => $this->userId,
            ':competitionType' => $this->competitionType,
            ':competitionLevel' => $this->competitionLevel,
            ':competitionTitle' => $this->competitionTitle,
            ':competitionTitleEnglish' => $this->competitionTitleEnglish,
            ':competitionPlace' => $this->competitionPlace,
            ':competitionPlaceEnglish' => $this->competitionPlaceEnglish,
            ':competitionUrl' => $this->competitionUrl,
            ':competitionStartDate' => $this->competitionStartDate->format('Y-m-d H:i:s'),
            ':competitionEndDate' => $this->competitionEndDate->format('Y-m-d H:i:s'),
            ':competitionRank' => $this->competitionRank,
            ':numberOfInstitutions' => $this->numberOfInstitutions,
            ':numberOfStudents' => $this->numberOfStudents,
            ':letterNumber' => $this->letterNumber,
            ':letterDate' => $this->letterDate->format('Y-m-d H:i:s'),
            ':letterFile' => $this->letterFile,
            ':certificateFile' => $this->certificateFile,
            ':documentationFile' => $this->documentationFile,
            ':posterFile' => $this->posterFile,
            ':competitionPoints' => $this->competitionPoints,
            ':supervisorValidationStatus' => $this->supervisorValidationStatus,
            ':supervisorValidationDate' => $this->supervisorValidationDate?->format('Y-m-d H:i:s'),
            ':supervisorValidationNote' => $this->supervisorValidationNote,
            ':adminValidationStatus' => $this->adminValidationStatus,
            ':adminValidationDate' => $this->adminValidationDate?->format('Y-m-d H:i:s'),
            ':adminValidationNote' => $this->adminValidationNote,
            ':createdAt' => $createdAt,
            ':updatedAt' => $updatedAt
        ]);

        $achievementId = $db->lastInsertId();

        // Save supervisors and team members
        $this->saveUserAchievements($db, $achievementId, $supervisors, $teamMembers);

        return $achievementId;
    }

    private function saveUserAchievements(PDO $db, int $achievementId, array $supervisors, array $teamMembers)
    {
        $stmt = $db->prepare('INSERT INTO [dbo].[UserAchievement] 
        (UserId, AchievementId, AchievementRole) 
        VALUES (:userId, :achievementId, :role)');

        if (!empty($supervisors)) {
            foreach ($supervisors as $supervisorId) {
                $stmt->execute([
                    ':userId' => $supervisorId,
                    ':achievementId' => $achievementId,
                    ':role' => self::ROLE_SUPERVISOR
                ]);
            }
        }

        if (!empty($teamMembers)) {
            foreach ($teamMembers as $member) {
                $role = ($member['role'] === 'Ketua') ? self::ROLE_TEAM_LEADER : self::ROLE_TEAM_MEMBER;
                $stmt->execute([
                    ':userId' => $member['userId'],
                    ':achievementId' => $achievementId,
                    ':role' => $role
                ]);
            }
        }
    }

    public static function getUsersByRole(PDO $db, int $achievementId, int $role): array
    {
        $stmt = $db->prepare('
        SELECT u.Id, u.FullName, ua.AchievementRole
        FROM [dbo].[UserAchievement] ua
        JOIN [dbo].[User] u ON ua.UserId = u.Id
        WHERE ua.AchievementId = :achievementId 
        AND ua.AchievementRole = :role
        AND u.DeletedAt IS NULL
    ');

        $stmt->execute([
            ':achievementId' => $achievementId,
            ':role' => $role
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function validateFileInputs()
    {
        $fileInputs = ['letterFile', 'certificateFile', 'documentationFile', 'posterFile'];

        foreach ($fileInputs as $input) {
            if ($this->$input && is_array($this->$input)) {
                $this->validateFileSize($this->$input['tmp_name']);
                $this->validateFileType($this->$input['tmp_name']);
                $this->$input = $this->storeFile($this->$input, $input);
            }
        }
    }

    private function validateFileSize($file)
    {
        if (filesize($file) > self::MAX_FILE_SIZE) {
            throw new InvalidArgumentException("File size exceeds the maximum limit of 5MB.");
        }
    }

    private function validateFileType($file)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file);
        finfo_close($finfo);

        if (!in_array($mimeType, self::ALLOWED_FILE_TYPES)) {
            throw new InvalidArgumentException("Invalid file type. Allowed types are PDF, JPEG, and PNG.");
        }
    }

    private function storeFile($file, $fileType)
    {
        $folder = self::UPLOAD_FOLDERS[$fileType] ?? 'others';
        $uploadPath = self::UPLOAD_BASE_PATH . $folder . '/';

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = ($this->id ?? 'temp_' . uniqid()) . '_' . $fileType . '.' . $extension;
        $destination = $uploadPath . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new InvalidArgumentException("Failed to upload file.");
        }

        return $destination;
    }

    public static function getAchievement(PDO $db, int $id)
    {
        $stmt = $db->prepare('SELECT * FROM [dbo].[Achievement] WHERE Id = :id AND DeletedAt IS NULL');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllAchievements(PDO $db)
    {
        $stmt = $db->query('SELECT * FROM [dbo].[Achievement] WHERE DeletedAt IS NULL');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAchievementsByUserId(PDO $db, int $userId)
    {
        $stmt = $db->prepare('SELECT * FROM [dbo].[Achievement] WHERE UserId = :userId AND DeletedAt IS NULL');
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAchievementsBySupervisorId(PDO $db, int $supervisorId)
    {
        $stmt = $db->prepare('SELECT * FROM [dbo].[Achievement] WHERE SupervisorValidationStatus = :status AND DeletedAt IS NULL');
        $stmt->execute([':status' => 'PENDING']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAchievementsByAdminId(PDO $db, int $adminId)
    {
        $stmt = $db->prepare('SELECT * FROM [dbo].[Achievement] WHERE AdminValidationStatus = :status AND DeletedAt IS NULL');
        $stmt->execute([':status' => 'PENDING']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateAchievement(PDO $db, int $id)
    {
        $updatedAt = (new DateTime())->format('Y-m-d H:i:s');

        $stmt = $db->prepare('UPDATE [dbo].[Achievement] SET
            CompetitionType = :competitionType,
            CompetitionLevel = :competitionLevel,
            CompetitionPoints = :competitionPoints,
            CompetitionTitle = :competitionTitle,
            CompetitionTitleEnglish = :competitionTitleEnglish,
            CompetitionPlace = :competitionPlace,
            CompetitionPlaceEnglish = :competitionPlaceEnglish,
            CompetitionUrl = :competitionUrl,
            CompetitionStartDate = :competitionStartDate,
            CompetitionEndDate = :competitionEndDate,
            CompetitionRank = :competitionRank,
            NumberOfInstitutions = :numberOfInstitutions,
            NumberOfStudents = :numberOfStudents,
            LetterNumber = :letterNumber,
            LetterDate = :letterDate,
            LetterFile = :letterFile,
            CertificateFile = :certificateFile,
            DocumentationFile = :documentationFile,
            PosterFile = :posterFile,
            SupervisorValidationStatus = :supervisorValidationStatus,
            AdminValidationStatus = :adminValidationStatus,
            UpdatedAt = :updatedAt
        WHERE Id = :id AND DeletedAt IS NULL');

        return $stmt->execute([
            ':id' => $id,
            ':competitionType' => $this->competitionType,
            ':competitionLevel' => $this->competitionLevel,
            ':competitionPoints' => $this->competitionPoints,
            ':competitionTitle' => $this->competitionTitle,
            ':competitionTitleEnglish' => $this->competitionTitleEnglish,
            ':competitionPlace' => $this->competitionPlace,
            ':competitionPlaceEnglish' => $this->competitionPlaceEnglish,
            ':competitionUrl' => $this->competitionUrl,
            ':competitionStartDate' => $this->competitionStartDate->format('Y-m-d H:i:s'),
            ':competitionEndDate' => $this->competitionEndDate->format('Y-m-d H:i:s'),
            ':competitionRank' => $this->competitionRank,
            ':numberOfInstitutions' => $this->numberOfInstitutions,
            ':numberOfStudents' => $this->numberOfStudents,
            ':letterNumber' => $this->letterNumber,
            ':letterDate' => $this->letterDate->format('Y-m-d H:i:s'),
            ':letterFile' => $this->letterFile,
            ':certificateFile' => $this->certificateFile,
            ':documentationFile' => $this->documentationFile,
            ':posterFile' => $this->posterFile,
            ':supervisorValidationStatus' => $this->supervisorValidationStatus,
            ':adminValidationStatus' => $this->adminValidationStatus,
            ':updatedAt' => $updatedAt
        ]);
    }

    public static function deleteAchievement(PDO $db, int $id)
    {
        $deletedAt = (new DateTime())->format('Y-m-d H:i:s');
        $stmt = $db->prepare('UPDATE [dbo].[Achievement] SET DeletedAt = :deletedAt WHERE Id = :id AND DeletedAt IS NULL');
        return $stmt->execute([':id' => $id, ':deletedAt' => $deletedAt]);
    }

    public static function updateSupervisorValidation(PDO $db, int $achievementId, string $status, string $note)
    {
        $date = (new DateTime())->format('Y-m-d H:i:s');
        $stmt = $db->prepare('UPDATE [dbo].[Achievement] 
            SET SupervisorValidationStatus = :status, 
                SupervisorValidationDate = :date, 
                SupervisorValidationNote = :note 
        WHERE Id = :achievementId');
        return $stmt->execute([
            ':achievementId' => $achievementId,
            ':status' => $status,
            ':date' => $date,
            ':note' => $note
        ]);
    }

    public static function updateAdminValidation(PDO $db, int $achievementId, string $status, string $note)
    {
        $date = (new DateTime())->format('Y-m-d H:i:s');
        $stmt = $db->prepare('UPDATE [dbo].[Achievement] 
            SET AdminValidationStatus = :status, 
                AdminValidationDate = :date, 
                AdminValidationNote = :note 
        WHERE Id = :achievementId');
    }

    public static function getTopAchievements(PDO $db, int $limit = 10): array
    {
        $stmt = $db->prepare('
            SELECT TOP :limit
                a.CompetitionPoints as TotalPoints,
                u.FullName as Fullname,
                s.StudentMajor
            FROM [dbo].[Achievement] a
            INNER JOIN [dbo].[User] u ON a.UserId = u.Id 
            INNER JOIN [dbo].[Student] s ON u.Id = s.UserId
            WHERE a.DeletedAt IS NULL
                AND a.AdminValidationStatus = \'APPROVED\'
                AND a.SupervisorValidationStatus = \'APPROVED\'
            ORDER BY a.CompetitionPoints DESC
        ');
        
        $stmt->execute([':limit' => $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
