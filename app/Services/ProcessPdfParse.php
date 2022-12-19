<?php

namespace app\Services;

use Exception;
use Smalot\PdfParser\Config;
use Smalot\PdfParser\Parser;

class ProcessPdfParse
{
    /**
     * @throws Exception
     */
    public function parsePdfFile($filePath): string
    {
        $config = new Config();
        $config->setRetainImageContent(false);

        $parser = new Parser([], $config);

        // Parse the uploaded PDF file using Smalot lib
        // Performance is ok considering the size of the PDF file
        return $parser->parseFile($filePath)->getText();
    }
}