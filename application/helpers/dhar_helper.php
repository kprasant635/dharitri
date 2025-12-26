<?php
if (!function_exists('getDharCodeByLgd')) {
    function getDharCodeByLgd($lgd_code) {
        $lgd_to_dha = array(
            289 => 'dha41',
            280 => 'dha1',
            291 => 'dha7',
            283 => 'dha19',
            301 => 'dha12',
            281 => 'dha2',
            300 => 'dha14',
            293 => 'dha6',
            706 => 'dha17',
            705 => 'dha20',
            709 => 'dha21',
            708 => 'dha22',
            707 => 'dha25',
            285 => 'dha3',
            298 => 'dha11',
            290 => 'dha5',
            284 => 'dha23',
            739 => 'dha39',
            297 => 'dha16',
            287 => 'dha8',
            295 => 'dha13',
            288 => 'dha6',
            302 => 'dha9',
            286 => 'dha4',
            618 => 'dha10',
            296 => 'dha15'
        );
        return isset($lgd_to_dha[$lgd_code]) ? $lgd_to_dha[$lgd_code] : null;
    }
}

if (!function_exists('getDistCodeByLgd')) {
    function getDistCodeByLgd($lgd_code) {
        $lgd_to_dist = array(
            "289" => "22",
            "280" => "05",
            "291" => "07",
            "283" => "08",
            "301" => "11",
            "281" => "13",
            "300" => "16",
            "293" => "21",
            "706" => "34",
            "705" => "35",
            "709" => "36",
            "708" => "37",
            "707" => "38",
            "285" => "02",
            "298" => "06",
            "290" => "15",
            "284" => "25",
            "739" => "39",
            "297" => "33",
            "287" => "03",
            "295" => "12",
            "288" => "14",
            "302" => "18",
            "286" => "17",
            "618" => "24",
            "296" => "32"
        );

        // Return mapped code or null if not found
        return isset($lgd_to_dist[$lgd_code]) ? $lgd_to_dist[$lgd_code] : null;
    }
}