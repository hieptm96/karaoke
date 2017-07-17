<?php

use Illuminate\Support\Str;

if (! function_exists('str_abbr')) {
    function str_abbr($string)
    {
        $string = Str::ascii($string);
        $words = explode(" ", $string);
        $acronym = '';

        foreach ($words as $w) {
            if (is_numeric($w)) {
                $acronym.= $w;
            } else {
                $acronym .= $w[0];
            }
        }

        return $acronym;
    }
}