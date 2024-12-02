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
}
