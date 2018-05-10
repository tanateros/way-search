<?php

namespace WaySearch\Service;

use WaySearch\Entity\Direction;

/**
 * Class DirectionFileParser
 *
 * @package WaySearch\Service
 */
class DirectionFileParser
{
    /** @var array $directions */
    protected $directions = [];

    /**
     * DirectionFileParser constructor.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $content = file($filePath);
        $case = 0;

        foreach ($content as $line) {
            $line = trim($line);

            if (filter_var($line, FILTER_VALIDATE_INT) !== false) {
                $case++;
            } else {
                $this->directions[$case][] = $line;
            }
        }
    }

    /**
     * @return array
     */
    public function getDirections(): array
    {
        $directions = [];
        $case = 0;

        foreach ($this->directions as $direction) {
            $case++;

            foreach ($direction as $point) {
                $directions[$case][] = new Direction($point);
            }
        }

        return $directions;
    }
}
