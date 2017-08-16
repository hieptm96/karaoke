<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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

if (! function_exists('import_from_csv')) {
    /**
     *
     * import data from csv file into table (ignore first line of file)
     *
     * @param string $pathFile: path file on the disk
     * @param string $table: destination table
     * @param string $columns: columns to fill data
     * @return mixed
     */
    function import_from_csv(string $pathFile, string $table, string $columns)
    {
        $query = sprintf("LOAD DATA local INFILE '%s'
                INTO TABLE %s
                CHARACTER SET UTF8
                FIELDS TERMINATED BY ',' 
                ENCLOSED BY '\"'
                LINES TERMINATED BY '\n'
                IGNORE 1 ROWS %s", addslashes($pathFile), $table, $columns);

        return DB::connection()->getpdo()->exec($query);
    }
}

if (! function_exists('generate_email')) {
    function generate_email($name)
    {
        $name = strtolower($name);

        $words = explode(" ", $name);

        $prefix = '';
        $nWords = count($words);
        for ($i = 0; $i < $nWords - 1; $i++) {
            $prefix .= $words[$i][0];
        }

        $email = sprintf('%s.%s@demo.com.vn', $words[$nWords-1], $prefix);

        return $email;
    }
}
