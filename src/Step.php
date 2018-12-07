<?php

class Step
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string[]
     */
    private $requirements = [];

    /**
     * Step constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string[]
     */
    public function getRequirements(): array
    {
        return $this->requirements;
    }

    /**
     * @return bool
     */
    public function canExecute(): bool
    {
        return empty($this->requirements);
    }

    /**
     * @return int
     */
    public function getTimeToExecute(): int
    {
        return 61 + ord($this->id) - ord('A');
        //return ord($this->id) - ord('A') + 1;
    }

    /**
     * @param string $stepId
     */
    public function addRequirement(string $stepId): void
    {
        $this->requirements[$stepId] = $stepId;
    }

    /**
     * @param string $stepId
     */
    public function removeRequirementIfExist(string $stepId): void
    {
        if (isset($this->requirements[$stepId])) {
            unset($this->requirements[$stepId]);
        }
    }
}