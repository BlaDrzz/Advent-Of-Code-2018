<?php

class Node
{
    /**
     * @var Node[]
     */
    private $children = [];

    /**
     * @var int[]
     */
    private $metaData = [];

    /**
     * @param ArrayObject $input
     */
    public function parseInput(ArrayObject $input): void
    {
        [$childCount, $metaDataCount] = array_slice($input->getArrayCopy(), 0, 2);
        $input->offsetUnset(0);
        $input->offsetUnset(1);
        $input->exchangeArray(array_values($input->getArrayCopy()));

        for ($i = 0; $i < $childCount; $i++) {
            $child = new self();
            $child->parseInput($input);
            $this->children[] = $child;
        }

        for ($i = 0; $i < $metaDataCount; $i++) {
            $this->metaData[] = $input->offsetGet($i);
            $input->offsetUnset($i);
        }
        $input->exchangeArray(array_values($input->getArrayCopy()));
    }

    /**
     * @return int
     */
    public function getTotalMetaDataValue(): int
    {
        $result = \array_sum($this->metaData);
        foreach ($this->children as $child) {
            $result += $child->getTotalMetaDataValue();
        }
        return $result;
    }

    /**
     * @return int
     */
    public function getRootMetaDataValue(): int
    {
        if (empty($this->children)) {
            return \array_sum($this->metaData);
        }

        return \array_sum(\array_map(function (int $metaData): int {
            $index = --$metaData;
            if (isset($this->children[$index])) {
                return $this->children[$index]->getRootMetaDataValue();
            }
            return 0;
        }, $this->metaData));
    }
}