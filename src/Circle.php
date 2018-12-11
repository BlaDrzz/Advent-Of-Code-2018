<?php
/**
 * Copyright (C) A&C systems nv - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by A&C systems <web.support@ac-systems.com>
 */

class Circle
{
    /**
     * @var int[]
     */
    private $placedMarbles = [0];

    /**
     * @var int[]
     */
    private $leftoverMarbles;

    /**
     * @var int
     */
    private $current = 1;

    /**
     * @var int
     */
    private $marbleCount = 1;

    /**
     * @var int
     */
    private $it = 1;

    /**
     * @var int
     */
    private $count;

    /**
     * Circle constructor.
     * @param int $marbleAmount
     */
    public function __construct(int $marbleAmount)
    {
        for ($i = 1; $i <= $marbleAmount; $i++) {
            $this->leftoverMarbles[$i] = $i;
        }

        $this->count = $marbleAmount;
    }

    public function gameOver(): bool
    {
        return $this->it === $this->count;
    }

    /**
     * @return int The amount of points gained from playing a marble
     */
    public function placeMarble(): int
    {
        $marbleValue = $this->leftoverMarbles[$this->it];
        ++$this->it;

        if ($marbleValue % 23 !== 0) {
            $this->current = $this->getNextPosition($this->current + 2);

            $this->insertMarble($this->current, $marbleValue);
            return 0;
        }

        if ($this->marbleCount === 1) {
            ++$this->current;
            $this->insertMarble($this->current, $marbleValue);
            return 0;
        }

        $this->current = $this->getNextPosition($this->current - 7);
        $position = $this->getNextPosition($this->current + 1);

        $score = $this->placedMarbles[$position] + $marbleValue;
        unset($this->placedMarbles[$position]);
        --$this->marbleCount;

        return $score;
    }

    /**
     * @param int $current
     * @return int
     */
    private function getNextPosition(int $current): int
    {
        if ($current >= $this->marbleCount) {
            $current -= $this->marbleCount;
            return $current;
        }

        if ($current < 0) {
            $current += $this->marbleCount;
            return $current;
        }

        return $current;
    }

    /**
     * @return string
     */
    public function getCircleAsString(): string
    {
        return \implode(', ', $this->placedMarbles);
    }

    /**
     * @param int $position
     * @param int $value
     */
    public function insertMarble(int $position, int $value): void
    {
        \array_splice($this->placedMarbles, $position + 1, 0, [$value]);
        ++$this->marbleCount;
    }
}