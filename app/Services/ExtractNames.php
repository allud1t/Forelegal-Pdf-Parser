<?php

namespace app\Services;

class ExtractNames {
    public function getNames($pdfText): array {
        // Regex to get all names, starting at the end of "Nome: "
        // The secure way to get full names is taking all the text and single space until the end of the line or line break
        $pattern = "/Nome: (.*)/";
        preg_match_all($pattern, $pdfText, $matches);
        $names = [];
        foreach ($matches[1] as $match) {
            $names[] = preg_replace("/\d/", "", $match);
        }
        return $names;
    }
}