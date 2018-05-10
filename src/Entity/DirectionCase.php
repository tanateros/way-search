<?php

namespace WaySearch\Entity;

/**
 * Class DirectionCase
 *
 * @package WaySearch\Entity
 */
class DirectionCase extends DomainEntity
{
    /** @var int $countPeople */
    protected $countPeople;

    /** @var array $changeDirections */
    protected $changeDirections = [];

    /** @var PointInterface $endPoint */
    protected $endPoint;

    /** @var array $endPoint */
    protected $endPoints;

    /**
     * DirectionCase constructor.
     *
     * @param array $changeDirections
     */
    public function __construct(array $changeDirections)
    {
        $this->changeDirections = $changeDirections;
        $this->countPeople = count($changeDirections);
        $this->endPoints = $this->getEndPoints();
    }

    /**
     * @return CartesianPoint
     */
    public function getAvgEndPoint(): CartesianPoint
    {
        $points = $this->endPoints;
        $avgXCoordinate = $this->getAvgCoordinate(
            $this->exchangeCoordinate($points, 'x')
        );
        $avgYCoordinate = $this->getAvgCoordinate(
            $this->exchangeCoordinate($points, 'y')
        );
        $this->endPoint = new CartesianPoint(
            round($avgXCoordinate, 4),
            round($avgYCoordinate, 4)
        );

        return $this->endPoint;
    }

    /**
     * @return float
     */
    public function getDifference(): float
    {
        $diffs = [];
        $endPoints = $this->endPoints;

        /** @var PointInterface $point */
        foreach ($endPoints as $point) {
            $diffs[] = $this->getDiffPoints($point);
        }

        return round(max($diffs), 4);
    }

    /**
     * @return array
     */
    protected function getEndPoints(): array
    {
        return array_map(function ($direction) {
            /** @var Direction $direction */
            return $direction->getDirectionEndPoint();
        }, $this->changeDirections);
    }

    /**
     * @param PointInterface $point
     *
     * @return float
     */
    protected function getDiffPoints(PointInterface $point): float
    {
        return sqrt(
            ($this->endPoint->x - $point->x) ** 2 + ($this->endPoint->y - $point->y) ** 2
        );
    }

    /**
     * @param array  $points
     * @param string $find
     *
     * @return array
     */
    protected function exchangeCoordinate(array $points, string $find): array
    {
        return array_map(function ($point) use ($find) {
            return $point->{$find};
        }, $points);
    }

    /**
     * @param array $coordinates
     *
     * @return float
     */
    protected function getAvgCoordinate(array $coordinates): float
    {
        return array_sum($coordinates) / $this->countPeople;
    }
}
