<?php

namespace PrestaC\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PDO;
use PrestaC\Models\Achievement;

class AssetsController
{
    protected PDO $db;

    function __construct(array $dependencies)
    {
        if (isset($dependencies['db'])) {
            $this->db = $dependencies['db']->getConnection();
        }
        $this->ensureSession(); // Initialize session for all controller methods
    }

    private function ensureSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

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
    public function downloadSkemaPoin()
    {
        $filePath = __DIR__ . '/../../public/assets/Skema_Poin_Mahasiswa.pdf';

        error_log("Requested file path: " . $filePath);

        if (file_exists($filePath)) {
            error_log("File exists at path: " . $filePath);
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        } else {
            error_log("File not found at path: " . $filePath);
            echo "File tidak ditemukan.";
        }
    }

    public function downloadLaporanExcel()
    {
        $headerData = [
            'institution' => 'KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI',
            'institution2' => 'POLITEKNIK NEGERI MALANG',
            'department' => 'TEKNOLOGI INFORMASI',
            'studyProgram' => 'D-IV Sistem Informasi Bisnis',
            'startDate' => isset($_GET['start']) ? date('j F Y', strtotime($_GET['start'])) : '-',
            'endDate' => isset($_GET['end']) ? date('j F Y', strtotime($_GET['end'])) : '-'
        ];

        $achievementData = [];
        $filter = [
            'status' => isset($_GET['status']) ? $_GET['status'] : null,
            'start' => isset($_GET['start']) ? $_GET['start'] : null,
            'end' => isset($_GET['end']) ? $_GET['end'] : null,
        ];
        if ($_SESSION['user']['fullName'] == 'Admin Pusat') {
            $achievements = Achievement::getAllAchievements($this->db, $filter);
        } elseif ($_SESSION['user']['fullName'] == 'Admin Program Studi Sistem Informasi Bisnis') {
            $filter['studentMajor'] = 2;
            $achievements = Achievement::getAllAchievements($this->db, $filter);
        } else {
            $filter['studentMajor'] = 1;
            $achievements = Achievement::getAllAchievements($this->db, $filter);
        }

        foreach ($achievements as $achievement) {
            $achievementData[] = [
                'nim' => $achievement['username'],
                'name' => $achievement['Fullname'],
                'competition' => $achievement['CompetitionTitle'],
                'level' => Achievement::getCompetitionLevelName($achievement['CompetitionLevel']),
                'achievement' => Achievement::getCompetitionRankName($achievement['CompetitionRank']),
                'status' => $achievement['AdminValidationStatus'],
                'created_date' => date('d/m/y', strtotime($achievement['CreatedAt'])),
                'modified_date' => date('d/m/y', strtotime($achievement['UpdatedAt']))
            ];
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column widths for achievement data
        $sheet->getColumnDimension('A')->setWidth(5);   // No
        $sheet->getColumnDimension('B')->setWidth(15);  // NIM
        $sheet->getColumnDimension('C')->setWidth(25);  // Nama Mahasiswa
        $sheet->getColumnDimension('D')->setWidth(35);  // Competition Title
        $sheet->getColumnDimension('E')->setWidth(15);  // Level
        $sheet->getColumnDimension('F')->setWidth(15);  // Achievement
        $sheet->getColumnDimension('G')->setWidth(15);  // Status
        $sheet->getColumnDimension('H')->setWidth(15);  // Created Date
        $sheet->getColumnDimension('I')->setWidth(15);  // Modified Date

        // Set logo placeholder (you'll need to add the actual logo separately)
        $sheet->mergeCells('A1:B6');

        // Header section remains the same
        $sheet->setCellValue('C1', $headerData['institution']);
        $sheet->setCellValue('C2', $headerData['institution2']);
        $sheet->setCellValue('C3', 'JURUSAN         ');
        $sheet->setCellValue('C4', 'PROGRAM STUDI   ');
        $sheet->setCellValue('C5', 'DARI TANGGAL    ');
        $sheet->setCellValue('C6', 'SAMPAI TANGGAL  ');
        $sheet->setCellValue('D3', ': ' . $headerData['department']);
        $sheet->setCellValue('D4', ': ' . $headerData['studyProgram']);
        $sheet->setCellValue('D5', ': ' . $headerData['startDate']);
        $sheet->setCellValue('D6', ': ' . $headerData['endDate']);

        // Achievement header
        $sheet->setCellValue('A8', 'No');
        $sheet->setCellValue('B8', 'NIM');
        $sheet->setCellValue('C8', 'Nama Mahasiswa');
        $sheet->setCellValue('D8', 'Judul Kompetisi');
        $sheet->setCellValue('E8', 'Tingkat');
        $sheet->setCellValue('F8', 'Peringkat');
        $sheet->setCellValue('G8', 'Status');
        $sheet->setCellValue('H8', 'Tanggal Dibuat');
        $sheet->setCellValue('I8', 'Tanggal Diubah');

        // Fill in achievement data
        $row = 9;
        foreach ($achievementData as $index => $achievement) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $achievement['nim']);
            $sheet->setCellValue('C' . $row, $achievement['name']);
            $sheet->setCellValue('D' . $row, $achievement['competition']);
            $sheet->setCellValue('E' . $row, $achievement['level']);
            $sheet->setCellValue('F' . $row, $achievement['achievement']);
            $sheet->setCellValue('G' . $row, $achievement['status']);
            $sheet->setCellValue('H' . $row, $achievement['created_date']);
            $sheet->setCellValue('I' . $row, $achievement['modified_date']);

            $row++;
        }

        // Styling
        $headerStyle = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        // Apply styles to header row
        $sheet->getStyle('A8:I8')->applyFromArray($headerStyle);

        // Style for data cells
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        // Apply styles to data rows
        $lastRow = $row - 1;
        $sheet->getStyle('A9:I' . $lastRow)->applyFromArray($dataStyle);

        // Center align certain columns
        $sheet->getStyle('A9:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F9:I' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Wrap text in name and competition columns
        $sheet->getStyle('C9:E' . $lastRow)->getAlignment()->setWrapText(true);

        // Status column color coding
        foreach ($achievementData as $index => $achievement) {
            $rowNum = $index + 9;
            $statusCell = 'G' . $rowNum;

            switch ($achievement['status']) {
                case 'DITERIMA':
                    $sheet->getStyle($statusCell)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->setStartColor(new \PhpOffice\PhpSpreadsheet\Style\Color('90EE90'));
                    break;
                case 'DITOLAK':
                    $sheet->getStyle($statusCell)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->setStartColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFB6C1'));
                    break;
                case 'PROSES':
                    $sheet->getStyle($statusCell)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->setStartColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFD700'));
                    break;
            }
        }

        // Set the worksheet title
        $sheet->setTitle('Prestasi Mahasiswa');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Prestasi_Mahasiswa.xlsx"');
        header('Cache-Control: max-age=0');

        // Create the writer and save the file
        $writer = new Xlsx($spreadsheet);

        // Output the file to the browser
        $writer->save('php://output');
        exit;
    }
}
