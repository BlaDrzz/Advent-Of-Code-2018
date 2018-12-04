<?php
/**
 * Copyright (C) A&C systems nv - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by A&C systems <web.support@ac-systems.com>
 */

class GuardRepository
{
    /**
     * @var array
     */
    private $guards;

    public function __construct(array $guards)
    {
        $this->guards = $guards;
    }

    public function getGuards(): array
    {
        return $this->guards;
    }

    public function addGuard(Guard $guard): void
    {
        $this->guards[] = $guard;
    }

    public function getGuardById(int $id): ?Guard
    {
        foreach ($this->guards as $guard) {
            if ($guard->getId() === $id) {
                return $guard;
            }
        }

        return null;
    }

    public function getGuardWithMostSleep(): Guard
    {
        $guardWithMostSleep = $this->guards[0];

        /** @var Guard $guard */
        foreach ($this->guards as $guard) {
            if ($guardWithMostSleep->getTotalTimeAsleepInMinutes() < $guard->getTotalTimeAsleepInMinutes()) {
                $guardWithMostSleep = $guard;
            }
        }
        return $guardWithMostSleep;
    }

    public function getGuardWithMostConsistentSleep(): Guard
    {
        $mostConsistentSleeper = $this->guards[0];
        $mostConsistentSleeperAmount = $mostConsistentSleeper->getMinuteMostSleptOn()[1];

        /** @var Guard $guard */
        foreach ($this->guards as $guard) {
            $mostSleptAmount = $guard->getMinuteMostSleptOn()[1];

            if ($mostSleptAmount > $mostConsistentSleeperAmount) {
                $mostConsistentSleeper = $guard;
                $mostConsistentSleeperAmount = $mostSleptAmount;
            }
        }

        return $mostConsistentSleeper;
    }
}