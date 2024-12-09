<?php

namespace PrestaC\Models;

use DateTime;
use InvalidArgumentException;
use PDO;

class Achievement
{
    private const MAX_FILE_SIZE = 5242880; // 5MB
    private const ALLOWED_FILE_TYPES = ['application/pdf', 'image/jpeg', 'image/png'];
    private const UPLOAD_BASE_PATH = '@storage/achievements/';
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
    private const ROLE_PERSONAL = 4;

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

    public static function getAchievementById(PDO $db, int $id)
    {
        $stmt = $db->prepare('SELECT * FROM Achievement WHERE Id = :id AND DeletedAt IS NULL');
        $stmt->execute([':id' => $id]);
        $achievement = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($achievement) {
            error_log("Achievement files:");
            error_log("LetterFile: " . $achievement['LetterFile']);
            error_log("CertificateFile: " . $achievement['CertificateFile']);
            error_log("DocumentationFile: " . $achievement['DocumentationFile']);
            error_log("PosterFile: " . $achievement['PosterFile']);
        }

        return $achievement;
    }

    public static function getTopAchievements(PDO $db, int $limit = 10, int $userId = null)
    {
        $sql = '
            SELECT TOP (:limit) * 
            FROM [dbo].[Achievement] 
            WHERE DeletedAt IS NULL 
            AND AdminValidationStatus = \'APPROVED\'
            AND SupervisorValidationStatus = \'APPROVED\'';

        if ($userId) {
            $sql .= ' AND UserId = :userId';
        }

        $sql .= ' ORDER BY CompetitionPoints DESC';

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        if ($userId) {
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAchievementsByProdi(PDO $db, int $prodi)
    {
        $stmt = $db->prepare('SELECT * FROM [dbo].[Achievement] WHERE UserId IN (SELECT UserId FROM [dbo].[Student] WHERE StudentMajor = :prodi) AND DeletedAt IS NULL AND AdminValidationStatus = \'PENDING\'');
        $stmt->execute([':prodi' => $prodi]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllAchievements(PDO $db)
    {
        $stmt = $db->prepare('SELECT * FROM [dbo].[Achievement] WHERE DeletedAt IS NULL');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSupervisorsByAchievementId(PDO $db, int $achievementId): array
    {
        $stmt = $db->prepare("
            SELECT u.* 
            FROM [dbo].[User] u
            JOIN [dbo].[UserAchievement] ua ON u.Id = ua.UserId
            WHERE ua.AchievementId = :achievementId
            AND ua.AchievementRole = :role
        ");
        $stmt->execute([
            ':achievementId' => $achievementId,
            ':role' => self::ROLE_SUPERVISOR
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTeamMembersByAchievementId(PDO $db, int $achievementId, int $role): array
    {
        $stmt = $db->prepare("
            SELECT u.*, ua.AchievementRole 
            FROM [dbo].[User] u
            JOIN [dbo].[UserAchievement] ua ON u.Id = ua.UserId
            WHERE ua.AchievementId = :achievementId 
            AND ua.AchievementRole = :role
        ");
        $stmt->execute([
            ':achievementId' => $achievementId,
            ':role' => $role
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalOfAchievementsByProdi(PDO $db, int $prodi)
    {
        $stmt = $db->prepare('SELECT COUNT(DISTINCT a.Id) FROM [dbo].[Achievement] a JOIN [dbo].[Student] s ON a.UserId = s.UserId WHERE s.StudentMajor = :prodi AND a.DeletedAt IS NULL');
        $stmt->execute([':prodi' => $prodi]);
        return $stmt->fetchColumn();
    }

    public static function getPendingCount(PDO $db, int $prodi)
    {
        $stmt = $db->prepare('SELECT COUNT(DISTINCT a.Id) FROM [dbo].[Achievement] a JOIN [dbo].[Student] s ON a.UserId = s.UserId WHERE s.StudentMajor = :prodi AND a.AdminValidationStatus = \'PENDING\' AND a.DeletedAt IS NULL');
        $stmt->execute([':prodi' => $prodi]);
        return $stmt->fetchColumn();
    }

    public static function getAcceptedCount(PDO $db, int $prodi)
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM [dbo].[Achievement] WHERE AdminValidationStatus = \'APPROVED\' AND DeletedAt IS NULL AND UserId IN (SELECT UserId FROM [dbo].[Student] WHERE StudentMajor = :prodi)');
        $stmt->execute([':prodi' => $prodi]);
        return $stmt->fetchColumn();
    }

    public static function getRejectedCount(PDO $db, int $prodi)
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM [dbo].[Achievement] WHERE AdminValidationStatus = \'REJECTED\' AND DeletedAt IS NULL AND UserId IN (SELECT UserId FROM [dbo].[Student] WHERE StudentMajor = :prodi)');
        $stmt->execute([':prodi' => $prodi]);
        return $stmt->fetchColumn();
    }

    public static function getAcceptedCountPusat(PDO $db)
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM [dbo].[Achievement] WHERE AdminValidationStatus = \'APPROVED\' AND DeletedAt IS NULL');
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function getRejectedCountPusat(PDO $db)
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM [dbo].[Achievement] WHERE AdminValidationStatus = \'REJECTED\' AND DeletedAt IS NULL');
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function getPendingCountPusat(PDO $db)
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM [dbo].[Achievement] WHERE AdminValidationStatus = \'PENDING\' AND DeletedAt IS NULL');
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function getTotalOfAchievementsPusat(PDO $db)
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM [dbo].[Achievement] WHERE DeletedAt IS NULL');
        $stmt->execute();
        return $stmt->fetchColumn();
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
                $role = match ($member['role']) {
                    'Ketua' => self::ROLE_TEAM_LEADER,
                    'Anggota' => self::ROLE_TEAM_MEMBER,
                    'Personal' => self::ROLE_PERSONAL,
                    default => self::ROLE_TEAM_MEMBER
                };
                $stmt->execute([
                    ':userId' => $member['userId'],
                    ':achievementId' => $achievementId,
                    ':role' => $role
                ]);
            }
        }
    }


    private function validateFileInputs()
    {
        $fileInputs = ['letterFile', 'certificateFile', 'documentationFile', 'posterFile'];

        foreach ($fileInputs as $input) {
            // Skip if no file was uploaded (for edit form)
            if (empty($this->$input)) {
                continue;
            }

            // Handle multiple files
            $files = is_array($this->$input['tmp_name']) ?
                $this->restructureFilesArray($this->$input) :
                [$this->$input];

            $processedFiles = [];
            foreach ($files as $file) {
                if (empty($file['tmp_name'])) {
                    continue;
                }

                if ($file['error'] === UPLOAD_ERR_OK) {
                    $this->validateFileSize($file['tmp_name']);
                    $this->validateFileType($file['tmp_name']);
                    $processedFiles[] = $this->storeFile($file, $input);
                } elseif ($file['error'] !== UPLOAD_ERR_NO_FILE) {
                    throw new InvalidArgumentException("Error uploading file: " . $file['error']);
                }
            }

            // Store processed files back to property
            $this->$input = count($processedFiles) === 1 ? $processedFiles[0] : $processedFiles;
        }
    }

    private function restructureFilesArray($fileInput)
    {
        $files = [];
        foreach ($fileInput['tmp_name'] as $key => $tmpName) {
            if ($tmpName === '') continue;

            $files[] = [
                'name' => $fileInput['name'][$key],
                'type' => $fileInput['type'][$key],
                'tmp_name' => $tmpName,
                'error' => $fileInput['error'][$key],
                'size' => $fileInput['size'][$key]
            ];
        }
        return $files;
    }

    private function validateFileSize($file)
    {
        if (filesize($file) > self::MAX_FILE_SIZE) {
            throw new InvalidArgumentException("File size exceeds the maximum limit of 5MB.");
        }
    }

    private function validateFileType($file)
    {
        if (!file_exists($file)) {
            throw new InvalidArgumentException("File does not exist");
        }

        $finfo = @finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo === false) {
            // If finfo_open fails, try alternative mime type detection
            $mimeType = mime_content_type($file);
            if ($mimeType === false) {
                throw new InvalidArgumentException("Could not determine file type");
            }
        } else {
            $mimeType = finfo_file($finfo, $file);
            finfo_close($finfo);
        }

        if (!in_array($mimeType, self::ALLOWED_FILE_TYPES)) {
            throw new InvalidArgumentException("Invalid file type. Allowed types are PDF, JPEG, and PNG.");
        }
    }

    private function storeFile($file, $fileType)
    {
        $folder = self::UPLOAD_FOLDERS[$fileType] ?? 'others';
        $uploadPath = str_replace('@storage', $_SERVER['DOCUMENT_ROOT'] . '/public/storage', self::UPLOAD_BASE_PATH) . $folder . '/';

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = ($this->id ?? 'temp_' . uniqid()) . '_' . $fileType . '.' . $extension;

        // Save full path for moving the file
        $destination = $uploadPath . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new InvalidArgumentException("Failed to upload file.");
        }

        // Return relative path to store in database
        return $folder . '/' . $filename;
    }

    public static function handleFileUpload(array $file, string $folder): string
    {
        $uploadDir = __DIR__ . '/../../../app/public/storage/achievements/' . $folder . '/';

        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new \Exception('Failed to create upload directory');
            }
        }

        // Validate file size
        if ($file['size'] > 5 * 1024 * 1024) { // 5MB limit
            throw new \Exception('File size exceeds maximum limit of 5MB');
        }

        // Validate file type
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            throw new \Exception('Invalid file type. Only PDF, JPEG and PNG files are allowed');
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new \Exception('Failed to upload file');
        }

        return $folder . '/' . $fileName;
    }

    public static function updateAdminValidation(PDO $db, int $achievementId, string $status, string $note)
    {
        $date = (new DateTime())->format('Y-m-d H:i:s');
        $stmt = $db->prepare('UPDATE [dbo].[Achievement] 
            SET AdminValidationStatus = :status, 
                AdminValidationDate = :date, 
                AdminValidationNote = :note 
        WHERE Id = :achievementId');
        return $stmt->execute([
            ':achievementId' => $achievementId,
            ':status' => $status,
            ':date' => $date,
            ':note' => $note
        ]);
    }

    public static function updateAchievement(PDO $db, int $achievementId, array $updateData): bool
    {
        $setClauses = [];
        $params = [];

        foreach ($updateData as $key => $value) {
            $setClauses[] = "$key = ?";
            $params[] = $value;
        }

        $params[] = $achievementId;
        $sql = "UPDATE [dbo].[Achievement] SET " . implode(', ', $setClauses) . " WHERE Id = ?";

        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }

    public static function updateSupervisors(PDO $db, int $achievementId, array $supervisorIds): bool
    {
        // Delete existing supervisors
        $db->prepare("DELETE FROM [dbo].[UserAchievement] WHERE AchievementId = ? AND AchievementRole = ?")->execute([
            $achievementId,
            self::ROLE_SUPERVISOR
        ]);

        // Insert new supervisors
        $stmt = $db->prepare("INSERT INTO [dbo].[UserAchievement] (AchievementId, UserId, AchievementRole) VALUES (?, ?, ?)");
        foreach ($supervisorIds as $supervisorId) {
            if (!empty($supervisorId)) {
                $stmt->execute([
                    $achievementId,
                    $supervisorId,
                    self::ROLE_SUPERVISOR
                ]);
            }
        }

        return true;
    }

    public static function updateTeamMembers(PDO $db, int $achievementId, array $teamData): bool
    {
        $db->prepare("DELETE FROM [dbo].[UserAchievement] WHERE AchievementId = ? AND AchievementRole IN (?, ?)")->execute([
            $achievementId,
            self::ROLE_TEAM_LEADER,
            self::ROLE_TEAM_MEMBER
        ]);

        $stmt = $db->prepare("INSERT INTO [dbo].[UserAchievement] (AchievementId, UserId, AchievementRole) VALUES (?, ?, ?)");
        foreach ($teamData as $member) {
            if (!empty($member['memberId'])) {
                $role = $member['role'] === 'Ketua' ? self::ROLE_TEAM_LEADER : self::ROLE_TEAM_MEMBER;
                $stmt->execute([
                    $achievementId,
                    $member['memberId'],
                    $role
                ]);
            }
        }

        return true;
    }

    public static function deleteAchievement(PDO $db, int $id)
    {
        $deletedAt = (new DateTime())->format('Y-m-d H:i:s');
        $stmt = $db->prepare('UPDATE [dbo].[Achievement] SET DeletedAt = :deletedAt WHERE Id = :id AND DeletedAt IS NULL');
        return $stmt->execute([':id' => $id, ':deletedAt' => $deletedAt]);
    }
}
