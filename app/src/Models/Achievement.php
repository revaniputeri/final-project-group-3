<?php

namespace PrestaC\Models;

use DateTime;
use InvalidArgumentException;
use PDO;

class Achievement
{
    private const MAX_FILE_SIZE = 5242880; // 5MB
    private const ALLOWED_FILE_TYPES = ['application/pdf', 'image/jpeg', 'image/png'];

    public function __construct(
        public $userId,
        public $competitionType,
        public $competitionLevel,
        public $competitionPoints,
        public $competitionTitle,
        public $competitionTitleEnglish,
        public $competitionPlace,
        public $competitionPlaceEnglish,
        public $competitionUrl,
        public DateTime $competitionStartDate,
        public DateTime $competitionEndDate,
        public $numberOfInstitutions,
        public $numberOfStudents,
        public $letterNumber,
        public DateTime $letterDate,
        public $letterFile,
        public $certificateFile,
        public $documentationFile,
        public $posterFile,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ?DateTime $deletedAt
    ) {}

    public function saveAchievement(PDO $db)
    {
        $this->validateFileInputs();

        $createdAt = (new DateTime())->format('Y-m-d H:i:s');
        $updatedAt = (new DateTime())->format('Y-m-d H:i:s');

        $row = $db->prepare('INSERT INTO [dbo].[Achievement] (
            UserId,
            CompetitionType,
            CompetitionLevel,
            CompetitionPoints,
            CompetitionTitle,
            CompetitionTitleEnglish,
            CompetitionPlace,
            CompetitionPlaceEnglish,
            CompetitionUrl,
            CompetitionStartDate,
            CompetitionEndDate,
            NumberOfInstitutions,
            NumberOfStudents,
            LetterNumber,
            LetterDate,
            LetterFile,
            CertificateFile,
            DocumentationFile,
            PosterFile,
            CreatedAt,
            UpdatedAt
        ) VALUES (
            :userId,
            :competitionType,
            :competitionLevel,
            :competitionPoints,
            :competitionTitle,
            :competitionTitleEnglish,
            :competitionPlace,
            :competitionPlaceEnglish,
            :competitionUrl,
            :competitionStartDate,
            :competitionEndDate,
            :numberOfInstitutions,
            :numberOfStudents,
            :letterNumber,
            :letterDate,
            :letterFile,
            :certificateFile,
            :documentationFile,
            :posterFile,
            :createdAt,
            :updatedAt
        )');

        $row->execute([
            ':userId' => $this->userId,
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
            ':numberOfInstitutions' => $this->numberOfInstitutions,
            ':numberOfStudents' => $this->numberOfStudents,
            ':letterNumber' => $this->letterNumber,
            ':letterDate' => $this->letterDate->format('Y-m-d H:i:s'),
            ':letterFile' => $this->letterFile,
            ':certificateFile' => $this->certificateFile,
            ':documentationFile' => $this->documentationFile,
            ':posterFile' => $this->posterFile,
            ':createdAt' => $createdAt,
            ':updatedAt' => $updatedAt
        ]);

        return $db->lastInsertId();
    }

    private function validateFileInputs()
    {
        $fileInputs = ['letterFile', 'certificateFile', 'documentationFile', 'posterFile'];

        foreach ($fileInputs as $input) {
            if ($this->$input) {
                $this->validateFileSize($this->$input);
                $this->validateFileType($this->$input);
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

    public static function getAchievement(PDO $db, int $id)
    {
        $stmt = $db->prepare('SELECT * FROM [dbo].[Achievement] WHERE id = :id AND deleted_at IS NULL');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllAchievements(PDO $db)
    {
        $stmt = $db->query('SELECT * FROM [dbo].[Achievement] WHERE deleted_at IS NULL');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateAchievement(PDO $db, int $id)
    {
        $updatedAt = (new DateTime())->format('Y-m-d H:i:s');

        $stmt = $db->prepare('UPDATE [dbo].[Achievement] SET
            competition_type = :competitionType,
            competition_level = :competitionLevel,
            competition_points = :competitionPoints,
            competition_title = :competitionTitle,
            competition_title_english = :competitionTitleEnglish,
            competition_place = :competitionPlace,
            competition_place_english = :competitionPlaceEnglish,
            competition_url = :competitionUrl,
            competition_start_date = :competitionStartDate,
            competition_end_date = :competitionEndDate,
            number_of_institutions = :numberOfInstitutions,
            number_of_students = :numberOfStudents,
            letter_number = :letterNumber,
            letter_date = :letterDate,
            letter_file = :letterFile,
            certificate_file = :certificateFile,
            documentation_file = :documentationFile,
            poster_file = :posterFile,
            updated_at = :updatedAt
        WHERE id = :id AND deleted_at IS NULL');

        return $stmt->execute([
            ':id' => $id,
            ':userId' => $this->userId,
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
            ':numberOfInstitutions' => $this->numberOfInstitutions,
            ':numberOfStudents' => $this->numberOfStudents,
            ':letterNumber' => $this->letterNumber,
            ':letterDate' => $this->letterDate->format('Y-m-d H:i:s'),
            ':letterFile' => $this->letterFile,
            ':certificateFile' => $this->certificateFile,
            ':documentationFile' => $this->documentationFile,
            ':posterFile' => $this->posterFile,
            ':updatedAt' => $updatedAt
        ]);
    }

    public static function deleteAchievement(PDO $db, int $id)
    {
        $deletedAt = (new DateTime())->format('Y-m-d H:i:s');
        $stmt = $db->prepare('UPDATE [dbo].[Achievement] SET deleted_at = :deletedAt WHERE id = :id AND deleted_at IS NULL');
        return $stmt->execute([':id' => $id, ':deletedAt' => $deletedAt]);
    }
}
