<?php

namespace PrestaC\Models;

use PDO;
use InvalidArgumentException;
use RuntimeException;


class Student
{
    private const MAX_FILE_SIZE = 5242880; // 5MB
    private const ALLOWED_FILE_TYPES = ['image/jpeg', 'image/png', 'image/jpg'];
    private const STORAGE_BASE_PATH = __DIR__ . '/../../../app/public/storage';
    private const PROFILE_IMAGE_PATH = self::STORAGE_BASE_PATH . '/profile/';
    private const ACHIEVEMENTS_PATH = self::STORAGE_BASE_PATH . '/achievements/';

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Get student by full name
     */
    // public static function getStudentFullName(PDO $db, int $fullName)
    // {
    //     $stmt = $db->prepare("SELECT * FROM [dbo].[Student] WHERE userId = ?");
    //     $stmt->execute([$fullName]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }
    
    /**
     * Get student by username
     */
    // public static function getStudentByUsername(PDO $db, string $username)
    // {
    //     $stmt = $db->prepare("SELECT * FROM user WHERE Username = ?");
    //     $stmt->execute([$username]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

    /**
     * Update student profile
     */
    public static function updateStudentProfile(PDO $db, int $studentId, array $data): bool
    {
        $query = "UPDATE students SET 
                  name = :name, 
                  nim = :nim, 
                  email = :email, 
                  angkatan = :angkatan, 
                  profile_image = :profile_image, 
                  profile_background = :profile_background 
                  WHERE id = :id";

        $stmt = $db->prepare($query);
        $stmt->bindValue(':name', $data['name'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':nim', $data['nim'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':email', $data['email'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':angkatan', $data['angkatan'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':profile_image', $data['profile_image'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':profile_background', $data['profile_background'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':id', $studentId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Validate uploaded file
     */
    private function validateFile(array $file): void
    {
        $this->validateFileSize($file['tmp_name']);
        $this->validateFileType($file['tmp_name']);
    }

    /**
     * Validate file size
     */
    private function validateFileSize(string $filePath): void
    {
        if (filesize($filePath) > self::MAX_FILE_SIZE) {
            throw new InvalidArgumentException("File size exceeds the maximum limit of 5MB.");
        }
    }

    /**
     * Validate file type
     */
    private function validateFileType(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new InvalidArgumentException("File not found.");
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        if (!in_array($mimeType, self::ALLOWED_FILE_TYPES)) {
            throw new InvalidArgumentException("Invalid file type. Only JPEG and PNG are allowed.");
        }
    }

    /**
     * Store file on the server
     */
    private function storeFile(array $file, string $fileType): string
    {
        $uploadPath = self::PROFILE_IMAGE_PATH . $fileType . '/';

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid($fileType . '_') . '.' . $extension;
        $destination = $uploadPath . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new RuntimeException("Failed to upload file.");
        }

        return $filename;
    }

    /**
     * Handle public file upload
     */
    public static function handleFileUpload(array $file, string $folder): string
    {
        $uploadDir = self::STORAGE_BASE_PATH . '/' . $folder . '/';

        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new \Exception('Failed to create upload directory.');
            }
        }

        if ($file['size'] > self::MAX_FILE_SIZE) {
            throw new \Exception('File size exceeds the maximum limit of 5MB.');
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, self::ALLOWED_FILE_TYPES)) {
            throw new \Exception('Invalid file type. Only JPEG and PNG are allowed.');
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new \Exception('Failed to upload file.');
        }

        return $fileName;
    }
}
?>
