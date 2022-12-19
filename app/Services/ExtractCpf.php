<?php

namespace app\Services;

class ExtractCpf {
    public function getCpf($pdfText): array {
        // Regex to get all CPF including the ones with dots and dashes, starting at the end of "CPF: "
        // Otherwise it would jump one case and the final number would be more than number of names, so names and CPFs
            // would not match, therefore I included any final space.
        $pattern = "/CPF: ([0-9.-]+)?/";
        preg_match_all($pattern, $pdfText, $matches);
        $allCpf = [];
        foreach ($matches[1] as $match) {
            $allCpf[] = $match;
        }
        return $allCpf;
    }
}