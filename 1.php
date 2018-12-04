<?php
/**
 * Copyright (C) A&C systems nv - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by A&C systems <web.support@ac-systems.com>
 */

$input = file_get_contents('input');
$arr = explode("\r\n", $input);

$foundFreqs = [];
$res = 0;

while (true) {
    foreach ($arr as $number) {
        $res += $number;
        if (in_array($res, $foundFreqs, true)) {
            echo $res;die;
        }
        $foundFreqs[] = $res;
    }
}
