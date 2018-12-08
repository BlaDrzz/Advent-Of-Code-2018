<?php

include 'src/Node.php';

const BR = '<br/>';

$start = microtime(true);

class DayEight
{
    /**
     * @var Node
     */
    private $startNode;

    public function __construct()
    {
        $input = new ArrayObject(\explode(' ', \file_get_contents('input')));

        $node = new Node();
        $node->parseInput($input);
        $this->startNode = $node;
    }

    public function executePartOne(): void
    {
        echo $this->startNode->getTotalMetaDataValue();
    }

    public function executePartTwo(): void
    {
        echo $this->startNode->getRootMetaDataValue();
    }
}

$dayEight = new DayEight();
echo 'PART ONE: ';$dayEight->executePartOne(); echo BR;
echo 'PART TWO: ';$dayEight->executePartTwo(); echo BR . BR;

echo microtime(true) - $start;