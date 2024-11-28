<?php

namespace PrestaC\Controllers;

class AssetsController
{
    public function serve(array $args): void
    {
        $publicPath = __DIR__ . '/../../public/assets/' . $args['path'];

        // Check if file exists
        if (!file_exists($publicPath)) {
            http_response_code(404);
            return;
        }

        // Get file mime type
        $mimeType = $this->getMimeType($publicPath);

        // Set content type header
        header('Content-Type: ' . $mimeType);

        // Output file contents
        readfile($publicPath);
    }

    private function getMimeType(string $path): string
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'text/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    public function serveUploadedFile($path)
    {
        if (is_array($path)) {
            $path = $path['path'];
        }

        // Log the requested path
        error_log("Requested file path: " . $path);

        // Construct the full file path
        $filePath = __DIR__ . '/../../public/storage/achievements/' . $path;
        error_log("Full file path: " . $filePath);

        // Check if file exists
        if (!file_exists($filePath)) {
            error_log("File not found at path: " . $filePath);
            header("HTTP/1.0 404 Not Found");
            echo "File not found: " . htmlspecialchars($path);
            exit;
        }

        // Get and validate mime type
        $mimeType = mime_content_type($filePath);
        error_log("File mime type: " . $mimeType);

        // Set appropriate headers
        header("Content-Type: " . $mimeType);
        header("Content-Length: " . filesize($filePath));
        
        // For PDF files
        if ($mimeType === 'application/pdf') {
            header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        }
        
        // Check if file is readable
        if (!is_readable($filePath)) {
            error_log("File is not readable: " . $filePath);
            header("HTTP/1.0 403 Forbidden");
            echo "File is not readable";
            exit;
        }

        // Output the file
        readfile($filePath);
        exit;
    }
}
