<?php
/**
 * Copyright (C) A&C systems nv - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by A&C systems <web.support@ac-systems.com>
 */

$start = microtime(true);

include 'src/Action.php';
include 'src/Guard.php';
include 'src/GuardRepository.php';

const BR = '<br/>';

$input = explode("\r\n", file_get_contents('input'));

\usort($input, function (string $a, string $b) {
    $dateA = Action::extractDateFromActionString($a);
    $dateB = Action::extractDateFromActionString($b);
    if ($dateA === $dateB) {
        return 0;
    }
    return $dateA < $dateB ? -1 : 1;
});


$currGuard = null;
$guardRepository = new GuardRepository([]);

foreach ($input as $action) {
    if (($id = Guard::extractIdFromActionString($action)) !== null) {
        if ($currGuard !== null) {
            $guardRepository->addGuard($currGuard);
        }

        $potentialNextGuard = $guardRepository->getGuardById($id);
        $currGuard = $potentialNextGuard ?? new Guard($id);
    }

    $currGuard->addActionToSchedule(new Action($action, $currGuard));
}

$mostTotalSleep = $guardRepository->getGuardWithMostSleep();
$mostSleptOn = $mostTotalSleep->getMinuteMostSleptOn()[0];
echo 'MOST TOTAL SLEEPER: ' . $mostTotalSleep->getId() . BR;
echo 'MINUTE MOST SLEPT: ' . $mostSleptOn . BR;
echo 'PART ONE: ' . ($mostTotalSleep->getId() * $mostSleptOn) . BR . BR;

$mostSleepOneMinute = $guardRepository->getGuardWithMostConsistentSleep();
$mostSleptOnMinute =  $mostSleepOneMinute->getMinuteMostSleptOn()[0];
echo 'MOST CONSISTENT SLEEPER: ' . $mostSleepOneMinute->getId() . BR;
echo 'MINUTE MOST SLEPT: ' . $mostSleptOnMinute . BR;
echo 'PART TWO: ' . ($mostSleepOneMinute->getId() * $mostSleptOnMinute) . BR . BR;

echo microtime(true) - $start;