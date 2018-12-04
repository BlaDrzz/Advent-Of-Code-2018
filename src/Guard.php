<?php
/**
 * Copyright (C) A&C systems nv - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by A&C systems <web.support@ac-systems.com>
 */

class Guard
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var Action[]
     */
    private $schedule;
    /**
     * @var bool
     */
    private $changed = false;
    /**
     * @var array
     */
    private $cachedMinuteMap = [];

    public function __construct(int $id, array $schedule = [])
    {
        $this->id = $id;
        $this->schedule = $schedule;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSchedule(): array
    {
        return $this->schedule;
    }

    public function addActionToSchedule(Action $action): void
    {
        $this->changed = true;
        $this->schedule[] = $action;
    }

    public function getTotalTimeAsleepInMinutes(): int
    {
        $minutesAsleep = 0;

        /** @var Action $action */
        for ($i = 0; $i < \count($this->schedule) - 1; $i++) {
            $action1 = $this->schedule[$i];
            $action2 = $this->schedule[$i + 1];
            if ($action1->getAction() === Action::FALL_ASLEEP && $action2->getAction() === Action::WAKE_UP) {
                $minutesAsleep += $action1->getDateTime()->diff($action2->getDateTime())->i;
            }
        }

        return $minutesAsleep;
    }

    public function getMinuteMostSleptOn(): array
    {
        $minutes = $this->getMinuteMap();

        $mostAmount = 0;
        $mostMinute = 0;
        foreach ($minutes as $minute => $amount) {
            if ($mostAmount < $amount) {
                $mostAmount = $amount;
                $mostMinute = $minute;
            }
        }
        return [$mostMinute, $mostAmount];
    }

    public function getMinuteMap(): array
    {
        if (!$this->changed) {
            return $this->cachedMinuteMap;
        }

        $minutes = [];
        for ($i = 0; $i < 60; $i++) {
            $minutes[$i] = 0;
        }

        for ($i = 0; $i < \count($this->schedule) - 1; $i++) {
            $action1 = $this->schedule[$i];
            $action2 = $this->schedule[$i+1];

            if ($action1->getAction() === Action::FALL_ASLEEP && $action2->getAction() === Action::WAKE_UP) {
                $start = $action1->getDateTime()->format('i');
                $end = $action2->getDateTime()->format('i');
                for ($j = (int)$start; $j < (int)$end; $j++) {
                    $minutes[$j]++;
                }
            }
        }

        $this->changed = false;
        return $this->cachedMinuteMap = $minutes;
    }

    public static function extractIdFromActionString(string $action): ?int
    {
        $hash = strpos($action, '#');
        if ($hash === false) {
            return null;
        }

        $firstBit = substr($action, $hash + 1);
        return (int)substr($firstBit, 0, strlen($firstBit) - strpos(' ', $firstBit));
    }
}