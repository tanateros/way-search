<?php

namespace WaySearch\Entity;

/**
 * Class CartesianPoint
 *
 * @package WaySearch\Entity
 */
class CartesianPoint extends DomainEntity implements PointInterface
{
    /** @var float $x */
    protected $x;

    /** @var float $y */
    protected $y;

    /**
     * CartesianPoint constructor.
     *
     * @param float $x
     * @param float $y
     */
    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
}
