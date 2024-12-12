<?php

namespace PrestaC\Models;

use PDO;

class Student
{
    private const MAX_FILE_SIZE = 5242880; // 5MB
    private const ALLOWED_FILE_TYPES = ['image/jpeg', 'image/png', 'image/jpg'];
    private const UPLOAD_BASE_PATH = '@storage/profile/';
    private const UPLOAD_FOLDERS = [
        'imageFile' => 'image',
        'imageBgFile' => 'imageBackground'
    ];
    public static function getStudentById(PDO $db, int $userId)
    {
        $stmt = $db->prepare("SELECT * FROM dbo.Student WHERE UserId = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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

    private function validateFile()
    {
        $fileInputs = ['image', 'imageBackground'];

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

    private function storeFile($file, $fileType){
        $uploadPath = str_replace('@storage', $_SERVER['DOCUMENT_ROOT'] . '/public/storage', self::UPLOAD_BASE_PATH) . '/';

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

    }
    public static function handleFileUpload(array $file, string $folder): string
    {
        $uploadDir = __DIR__ . '/../../../app/public/storage/achievements/' . '/';

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

        return '/' . $fileName;
    }
    
}