<?php

namespace PrestaC\Utils;

class FileUpload {
    private $uploadDirectory;
    
    public function __construct($uploadDirectory = 'uploads/') {
        $this->uploadDirectory = $uploadDirectory;
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }
    }

    public function uploadFile($file, $subDirectory = '') {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $targetDir = $this->uploadDirectory . $subDirectory;
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $targetPath = $targetDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $targetPath;
        }

        return null;
    }
} 