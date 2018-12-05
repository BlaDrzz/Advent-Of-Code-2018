<?php

const BR = '<br/>';

include 'src/Tuple.php';
include 'src/Claim.php';
include 'src/ClaimRepository.php';

$start = microtime(true);

class DayThree
{
    /**
     * @var ClaimRepository
     */
    private $claimRepository;

    public function __construct()
    {
        $input = explode("\r\n", file_get_contents('input'));

        $this->claimRepository = new ClaimRepository();
        foreach ($input as $line) {
            $this->claimRepository->addClaim(new Claim($line));
        }
    }

    public function executePartOne(): int
    {
        return $this->claimRepository->getTotalOverlap();
    }

    public function executePartTwo(): int
    {
        $claimWithoutOverlap = $this->claimRepository->getOneWithoutOverlap();
        if ($claimWithoutOverlap === null) {
            return -1;
        }
        return $claimWithoutOverlap->getId();
    }
}

$dayThree = new DayThree();
echo 'PART ONE: ' . $dayThree->executePartOne() . BR;
echo 'PART TWO: ' . $dayThree->executePartTwo() . BR . BR;


echo microtime(true) - $start;
