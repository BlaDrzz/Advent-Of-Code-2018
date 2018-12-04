<?php

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
