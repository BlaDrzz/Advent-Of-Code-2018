<?php
/**
 * Copyright (C) A&C systems nv - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by A&C systems <web.support@ac-systems.com>
 */

class Action
{
    public const WAKE_UP = 'wakes up';
    public const FALL_ASLEEP = 'falls asleep';
    public const BEGIN_SHIFT = 'begins shift';

    /**
     * @var string
     */
    private $action;
    /**
     * @var DateTime
     */
    private $dateTime;
    /**
     * @var Guard
     */
    private $guard;

    public function __construct(string $action, Guard $guard)
    {
        if (strpos($action, self::WAKE_UP)) {
            $this->action = self::WAKE_UP;
        } elseif (strpos($action, self::FALL_ASLEEP)) {
            $this->action = self::FALL_ASLEEP;
        } elseif (strpos($action, self::BEGIN_SHIFT)) {
            $this->action = self::BEGIN_SHIFT;
        } else {
            $this->action = 'INVALID ACTION';
        }

        $this->dateTime = self::extractDateFromActionString($action);
        $this->guard = $guard;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    public function getGuard(): Guard
    {
        return $this->guard;
    }

    public static function extractDateFromActionString(string $action): \DateTime
    {
        $dateBit = substr($action, 1, strpos($action, ']') - 1);
        return DateTime::createFromFormat('Y-m-d H:i', $dateBit);
    }
}