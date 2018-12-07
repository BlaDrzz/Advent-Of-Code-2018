<?php

class StepRepository
{
    /**
     * @var array
     */
    private $steps;

    /**
     * StepRepository constructor.
     * @param array $steps
     */
    public function __construct(array $steps = [])
    {
        $this->steps = $steps;
    }

    /**
     * @return array
     */
    public function getSteps(): array
    {
        return $this->steps;
    }

    public function addStep(Step $step): void
    {
        $this->steps[$step->getId()] = $step;
    }

    /**
     * @param string $id
     * @return null|Step
     */
    public function getStepById(string $id): ?Step
    {
        /** @var Step $step */
        foreach ($this->steps as $step) {
            if ($step->getId() === $id) {
                return $step;
            }
        }
        return null;
    }

    /**
     * @return string
     */
    public function executeAllSteps(): string
    {
        $result = '';
        $stepCount = \count($this->steps);
        while (\strlen($result) !== $stepCount) {
            $stepToExecute = $this->getNextStepToExecute()->getId();

            $this->executeSingleStep($stepToExecute);
            unset($this->steps[$stepToExecute]);

            $result .= $stepToExecute;
        }

        return $result;
    }

    /**
     * @param int $availableWorkers
     * @return int
     */
    public function executeStepsWithWorkers(int $availableWorkers = 5): int
    {
        $time = -1;
        $workInProgress = [];

        do {
            $workInProgress = array_filter($workInProgress, function (Work $work): bool {
                $work->work();
                $done = $work->isDone();

                if ($done) {
                    $id = $work->getStepId();
                    $this->executeSingleStep($id);
                    unset($this->steps[$id]);
                }

                return !$done;
            });

            while ($availableWorkers > \count($workInProgress)) {
                $nextSteps = $this->getNextStepsToExecute();
                $workInProgressIds = array_map(function (Work $work): string {
                    return $work->getStepId();
                }, $workInProgress);


                $nextStep = null;
                foreach ($nextSteps as $step) {
                    if (!in_array($step->getId(), $workInProgressIds, true)) {
                        $nextStep = $step;
                        break;
                    }
                }

                if ($nextStep !== null) {
                    $workInProgress[] = new Work($nextStep);
                } else {
                    break;
                }
            }

            $time++;
        } while (count($workInProgress) > 0);

        return $time;
    }

    /**
     * @return Step|false
     */
    private function getNextStepToExecute()
    {
        $nextSteps = $this->getNextStepsToExecute();
        return reset($nextSteps);
    }

    /**
     * @return Step[]
     */
    private function getNextStepsToExecute(): array
    {
        $stepsWithoutRequirements = $this->getStepsWithoutRequirements();

        if (\count($stepsWithoutRequirements) > 1) {
            usort($stepsWithoutRequirements, function (Step $step, Step $otherStep) {
                return ord($step->getId()) - ord($otherStep->getId());
            });
        }

        return $stepsWithoutRequirements;
    }

    /**
     * @return Step[]
     */
    private function getStepsWithoutRequirements(): array
    {
        return \array_filter($this->steps, function (Step $step): bool {
            return $step->canExecute();
        });
    }

    /**
     * @param string $id
     */
    private function executeSingleStep(string $id): void
    {
        foreach ($this->steps as $step) {
            $step->removeRequirementIfExist($id);
        }
    }
}