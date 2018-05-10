<?php

namespace WaySearch\Service;

use WaySearch\Entity\DirectionCase;

/**
 * Class DirectionCases
 *
 * @package WaySearch\Service
 */
class DirectionCases implements \Iterator
{
    /** @var array $var */
    private $var = [];

    /**
     * DirectionCases constructor.
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->var = $array;
    }

    /**
     * Rewind to start
     *
     * @return $this
     */
    public function rewind()
    {
        reset($this->var);

        return $this;
    }

    /**
     * Get current direction case
     *
     * @return DirectionCase
     */
    public function current(): DirectionCase
    {
        return new DirectionCase(current($this->var));
    }

    /**
     * Get current number step of case
     *
     * @return int
     */
    public function key(): int
    {
        return key($this->var);
    }

    /**Get next direction case
     *
     * @return mixed|void
     */
    public function next()
    {
        return next($this->var);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        $key = key($this->var);

        return $key !== NULL && $key !== FALSE;
    }
}
