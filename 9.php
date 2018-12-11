<?php

include 'src/Circle.php';

const BR = '<br/>';

$start = microtime(true);

ini_set('memory_limit', -1);
ini_set('max_execution_time', -1);

class DayNine
{
    /**
     * @var int[]
     */
    private $players;

    /**
     * @var Circle
     */
    private $circle;

    public function __construct()
    {
        $input = \file_get_contents('input');
        \preg_match_all('!\d+!', $input, $matches);
        [$players, $marbles] = $matches[0];

        for ($i = 0; $i < $players; $i++) {
            $this->players[$i] = 0;
        }

        $this->circle = new Circle($marbles);
    }

    public function executePartOne(): void
    {
        $currentPlayerId = 0;
        $playerCount = \count($this->players);

        while (!$this->circle->gameOver()) {
            $score = $this->circle->placeMarble();

            $this->players[$currentPlayerId] += $score;

            ++$currentPlayerId;
            if ($currentPlayerId === $playerCount) {
                $currentPlayerId = 0;
            }
        }

        echo \max($this->players);
    }

    public function executePartTwo(): void
    {
        // Same as part 1 with different input
    }
}

$dayNine = new DayNine();
echo 'ANSWER: ';$dayNine->executePartOne(); echo BR;

echo microtime(true) - $start;