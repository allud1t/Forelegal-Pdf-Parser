<?php

require_once "../vendor/autoload.php";

use Smalot\PdfParser\Config;
use Smalot\PdfParser\Parser;

$config = new Config();
$config->setRetainImageContent(false);

$parser = new Parser([], $config);

// Parse the uploaded PDF file
try {
    $pdf = $parser->parseFile('pdf-fvp-compactado.pdf');
} catch (Exception $e) {
    echo $e->getMessage();
}
$text = $pdf->getText();

// Regex to get the names starting at the end of "Nome: " and ending at the end of the line
// The secure way to get full names is taking all the text and single space until the end of the line or line break
$pattern = "/Nome: (.*)/";
preg_match_all($pattern, $text, $matches);
$names = [];
foreach ($matches[1] as $match) {
    $names[] = preg_replace("/\d/", "", $match);
}

// Regex to get all CPF including the ones with dots and dashes, starting at the end of "CPF: "
// Otherwise it would jump one case and the final number would be more than number of names, so names and CPFs
// would not match, therefore I included any final space.
$pattern = "/CPF: ([0-9.-]+)?/";
preg_match_all($pattern, $text, $matches);
$allCpf = [];
foreach ($matches[1] as $match) {
    $allCpf[] = $match;
}

// Output result with names and respective CPFs in a txt file
$fp = fopen("output.txt", 'wb');
for ($i = 0, $iMax = count($names); $i < $iMax; $i++) {
    $cpf = $allCpf[$i];
    $name = $names[$i];
    fwrite($fp, $name . " - " . $cpf . "\r");
}
fclose($fp);

//Size of array names
echo "O tamanho do array de nome é: " . count($names) . "\n";
//Size of array allCpf
echo "O tamanho do array de cpf é: " . count($allCpf) . "\n";
