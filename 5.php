<?php

const BR = '<br/>';

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
        $strippedPolymers = array_map(function (string $character) {
            return $this->removeCharactersRegardlesOfCase($character, $this->input);
        }, range('a', 'z'));

        $lengthsAfterReduction = array_map(function (string $polymer) {
            return \strlen($this->recursivelyRemovePolarity($polymer));
        }, $strippedPolymers);

        return \min($lengthsAfterReduction);
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
echo 'PART TWO: ' . $dayFive->executePartTwo();
