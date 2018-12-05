<?php

class Claim
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Tuple
     */
    private $location;

    /**
     * @var Tuple
     */
    private $size;

    public function __construct(string $strClaim)
    {
        $matches = \preg_split("/[ \r\t\n]*(\@|\#|\,|\:|x)[ \r\t\n]*/", \ltrim($strClaim, '#'));

        $this->id = $matches[0];
        $this->location = new Tuple(
            $matches[1],
            $matches[2]
        );
        $this->size = new Tuple(
            $matches[3],
            $matches[4]
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Tuple
     */
    public function getLocation(): Tuple
    {
        return $this->location;
    }

    /**
     * @return Tuple
     */
    public function getSizeAsTuple(): Tuple
    {
        return $this->size;
    }

    public function getSize(): int
    {
        return $this->size->getX() * $this->size->getY();
    }

    /**
     * @param Claim $otherClaim
     * @return int
     */
    public function getOverlap(Claim $otherClaim): int
    {
        $thisBottomRight = $this->location->add($this->size);
        $otherBottomRight = $otherClaim->getLocation()->add($otherClaim->getSizeAsTuple());

        $overlapX = \max(0, \min($thisBottomRight->getX(), $otherBottomRight->getX()) - \max($this->location->getX(), $otherClaim->getLocation()->getX()));
        $overlapY = \max(0, \min($thisBottomRight->getY(), $otherBottomRight->getY()) - \max($this->location->getY(), $otherClaim->getLocation()->getY()));

        return $overlapX * $overlapY;
    }
}