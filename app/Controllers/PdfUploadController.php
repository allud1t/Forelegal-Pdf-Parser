<?php

namespace app\Controllers;

use app\Services\ExtractCpf;
use app\Services\ExtractNames;
use app\Services\ProcessPdfParse;

require_once '../../vendor/autoload.php';

$controller = new PdfUploadController();
try {
    $controller->execute();
} catch (\Exception $e) {
    echo $e->getMessage();
}

class PdfUploadController {

    /**
     * @throws \Exception
     */
    public function execute(): void {
        // Check if a file was uploaded
        if (isset($_FILES['theFile']) && !empty($_FILES['theFile']['tmp_name'])) {

            // Then move the uploaded file to the project folder
            $file = $_FILES['theFile'];
            $dir = __DIR__;
            $filePath = $dir . '/../../public/' . $file['name'];
            move_uploaded_file($file['tmp_name'], $filePath);

            // Call the ProcessPdfParse class to parse the uploaded PDF file
            $parser = new ProcessPdfParse();
            $pdfText = $parser->parsePdfFile($filePath);

            // Call the ExtractNames class to get the names from the PDF file text
            $extractNameService = new ExtractNames();
            $names = $extractNameService->getNames($pdfText);

            // Call the ExtractCpf class to get the CPFs from the PDF file text
            $extractCpfService = new ExtractCpf();
            $allCpf = $extractCpfService->getCpf($pdfText);

            // Print HTML with the names and respective CPFs in a table
            require_once '../Views/Result.php';
        }
    }
}
