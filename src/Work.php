<?php

class Work
{
    /**
     * @var int
     */
    private $timeRemaining;

    /**
     * @var string
     */
    private $stepId;

    /**
     * Work constructor.
     * @param Step $step
     */
    public function __construct(Step $step)
    {
        $this->timeRemaining = $step->getTimeToExecute();
        $this->stepId = $step->getId();
    }

    public function work(): void
    {
        $this->timeRemaining--;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->timeRemaining === 0;
    }

    /**
     * @return string
     */
    public function getStepId(): string
    {
        return $this->stepId;
    }
}