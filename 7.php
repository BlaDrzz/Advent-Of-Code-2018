<?php

include 'src/Step.php';
include 'src/Work.php';
include 'src/StepRepository.php';

const BR = '<br/>';

$start = microtime(true);

class DaySeven
{
    /**
     * @var StepRepository
     */
    private $stepRepository;

    private function reInit(): void
    {
        $this->stepRepository = new StepRepository();

        $input = explode("\r\n", file_get_contents('input'));
        foreach ($input as $line) {
            $requirement = $line[5];
            $id = $line[36];

            $step = $this->stepRepository->getStepById($id);
            if ($step === null) {
                $step = new Step($id);
                $step->addRequirement($requirement);
                $this->stepRepository->addStep($step);
            } else {
                $step->addRequirement($requirement);
            }

            $requirementStep = $this->stepRepository->getStepById($requirement);
            if ($requirementStep === null) {
                $this->stepRepository->addStep(new Step($requirement));
            }
        }
    }

    public function executePartOne(): void
    {
        $this->reInit();
        echo $this->stepRepository->executeAllSteps();
    }

    public function executePartTwo(): void
    {
        $this->reInit();
        echo $this->stepRepository->executeStepsWithWorkers();
    }
}

$daySeven = new DaySeven();
echo 'PART ONE: ';$daySeven->executePartOne(); echo BR;
echo 'PART TWO: ';$daySeven->executePartTwo(); echo BR . BR;

echo microtime(true) - $start;