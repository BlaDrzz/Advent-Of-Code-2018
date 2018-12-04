<?php
/**
 * Copyright (C) A&C systems nv - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by A&C systems <web.support@ac-systems.com>
 */

$input = file_get_contents('input');
$arr = explode("\r\n", $input);


// PART ONE
// $charCounts = [
//     2 => 0,
//     3 => 0
// ];
//
// $checkTwo = true;
// $checkThree = true;
// foreach ($arr as $string) {
//
//     foreach (array_unique(str_split($string)) as $char) {
//         $count = substr_count($string, $char);
//
//         if ($count === 2 && $checkTwo) {
//             $charCounts[2]++;
//             $checkTwo = false;
//         } elseif($count === 3 && $checkThree) {
//             $charCounts[3]++;
//             $checkThree = false;
//         }
//     }
//     $checkTwo = true;
//     $checkThree = true;
// }
//
// echo $charCounts[2] * $charCounts[3];


// PART TWO
$diffArr = [];
foreach ($arr as $line) {
    $diff = [];
    foreach ($arr as $otherLine) {
        if ($line === $otherLine) {
            continue;
        }
        $diff[$otherLine] = implode(array_diff(str_split($line), str_split($otherLine)));
    }
    $diffArr[$line] = $diff;
}

foreach ($diffArr as $line => $diff) {
    $sorted = usort($diff, function ($a, $b) {
        return count($a) - count($b);
    });
}