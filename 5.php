<?php

const BR = '<br/>';

$start = microtime(true);

class DayFive
{
    private $input;

    public function __construct()
    {
        $this->input = file_get_contents('input');
    }

    public function executePartOne(): int
    {
        $result = $this->recursivelyRemovePolarity($this->input);
        return \strlen($result);
    }

    private function recursivelyRemovePolarity(string $polymer): string
    {
        $arrToRemove = [];
        for ($i = 0; $i < \strlen($polymer) - 1; $i++) {
            if (abs(ord($polymer[$i]) - ord($polymer[$i + 1])) === 32) {
                $arrToRemove[] = $polymer[$i] . $polymer[$i + 1];
            }
        }

        foreach ($arrToRemove as $toRemove) {
            $count = 0;
            $polymer = str_replace($toRemove, '', $polymer, $count);
        }

        if (\count($arrToRemove) !== 0) {
            $polymer = $this->recursivelyRemovePolarity($polymer);
        }

        return $polymer;
    }

    public function executePartTwo(): int
    {
        return \min(array_map(function (string $character) {
            $strippedPolymer = $this->removeCharactersRegardlesOfCase($character, $this->input);
            return \strlen($this->recursivelyRemovePolarity($strippedPolymer));
        }, range('a', 'z')));
    }

    private function removeCharactersRegardlesOfCase(string $character, string $string): string
    {
        $lowerChar = strtolower($character);
        $upperChar = strtoupper($character);

        return str_replace([$upperChar, $lowerChar], '', $string);
    }
}

$dayFive = new DayFive();
echo 'PART ONE: ' . $dayFive->executePartOne() . BR;
echo 'PART TWO: ' . $dayFive->executePartTwo(). BR . BR;
echo 'OPERATION TOOK: ' . (microtime(true) - $start) . 's';
