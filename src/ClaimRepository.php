<?php

class ClaimRepository {
    /**
     * @var Claim[]
     */
    private $claims = [];

    public function addClaim(Claim $claim): void
    {
        $this->claims[$claim->getId()] = $claim;
    }

    public function getClaimById(int $id): ?Claim
    {
        return $this->claims[$id] ?? null;
    }

    public function getTotalOverlap(): int
    {
        $overlapMap = $this->getOverlapMap();
        $overlapCount = 0;
        foreach ($overlapMap as $row) {
            foreach ($row as $column) {
                if ($column > 1) {
                    $overlapCount++;
                }
            }
        }
        return $overlapCount;
    }

    public function getOverlapMap(): array
    {
        $fabricSize = $this->getFabricSize();
        $overlapMap = array_fill(0, $fabricSize->getX(), array_fill(0, $fabricSize->getY(), 0));
        /** @var Claim $claim */
        foreach ($this->claims as $claim) {
            for ($i = $claim->getLocation()->getX(); $i < $claim->getLocation()->getX() + $claim->getSizeAsTuple()->getX(); $i++) {
                for ($j = $claim->getLocation()->getY(); $j < $claim->getLocation()->getY() + $claim->getSizeAsTuple()->getY(); $j++) {
                    $overlapMap[$i][$j]++;
                }
            }
        }
        return $overlapMap;
    }

    public function printOverlapMap(): void
    {
        $overlapMap = $this->getOverlapMap();
        foreach ($overlapMap as $row) {
            foreach ($row as $column) {
                echo (string)$column;
            }
            echo '<br/>';
        }
    }

    public function getFabricSize(): Tuple
    {
        $bottomRights = array_map(function(Claim $claim): Tuple {
            return $claim->getLocation()->add($claim->getSizeAsTuple());
        }, $this->claims);

        $biggest = new Tuple(0, 0);
        /** @var Tuple $bottomRight */
        foreach ($bottomRights as $bottomRight) {
            if ($bottomRight->getX() > $biggest->getX()) {
                $biggest->setX($bottomRight->getX());
            }
            if ($bottomRight->getY() > $biggest->getY()) {
                $biggest->setY($bottomRight->getY());
            }
        }
        return $biggest;
    }

    public function getOneWithoutOverlap(): ?Claim
    {
        foreach ($this->claims as $claim) {
            $amountOverlap = -1;
            foreach ($this->claims as $otherClaim) {
                if ($claim->getOverlap($otherClaim) > 0) {
                    $amountOverlap++;
                }
            }
            if ($amountOverlap === 0) {
                return $claim;
            }
        }
        return null;
    }
}