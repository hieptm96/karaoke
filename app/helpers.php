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

if (! function_exists('str_before')) {
    function str_before($subject, $search)
    {
        return $search == '' ? $subject : explode($search, $subject)[0];
    }
}

if (! function_exists('get_controller_name')) {
    function get_controller_name($string)
    {
        return camel_case(str_before(class_basename(str_before($string, '@')), 'Controller'));
    }
}

if (! function_exists('get_action_name')) {
    function get_action_name($string)
    {
        return camel_case(str_after($string, '@'));
    }
}