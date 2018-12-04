<?php

include 'src/Action.php';
include 'src/Guard.php';
include 'src/GuardRepository.php';

const BR = '<br/>';

class DayTwo
{
    /**
     * @var GuardRepository
     */
    private $guardRepository;

    public function __construct()
    {
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
        $this->guardRepository = new GuardRepository([]);

        foreach ($input as $action) {
            if (($id = Guard::extractIdFromActionString($action)) !== null) {
                if ($currGuard !== null) {
                    $this->guardRepository->addGuard($currGuard);
                }

                $potentialNextGuard = $this->guardRepository->getGuardById($id);
                $currGuard = $potentialNextGuard ?? new Guard($id);
            }

            $currGuard->addActionToSchedule(new Action($action, $currGuard));
        }
    }

    public function executePartOne(): void
    {
        $mostTotalSleep = $this->guardRepository->getGuardWithMostSleep();
        $mostSleptOn = $mostTotalSleep->getMinuteMostSleptOn()[0];
        echo 'MOST TOTAL SLEEPER: ' . $mostTotalSleep->getId() . BR;
        echo 'MINUTE MOST SLEPT: ' . $mostSleptOn . BR;
        echo 'PART ONE: ' . ($mostTotalSleep->getId() * $mostSleptOn) . BR . BR;
    }

    public function executePartTwo(): void
    {
        $mostSleepOneMinute = $this->guardRepository->getGuardWithMostConsistentSleep();
        $mostSleptOnMinute =  $mostSleepOneMinute->getMinuteMostSleptOn()[0];
        echo 'MOST CONSISTENT SLEEPER: ' . $mostSleepOneMinute->getId() . BR;
        echo 'MINUTE MOST SLEPT: ' . $mostSleptOnMinute . BR;
        echo 'PART TWO: ' . ($mostSleepOneMinute->getId() * $mostSleptOnMinute) . BR . BR;
    }
}

$start = microtime(true);
$dayTwo = new DayTwo();
$dayTwo->executePartOne();
$dayTwo->executePartTwo();
echo microtime(true) - $start;