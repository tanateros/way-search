<?php

namespace WaySearch\Entity;

/**
 * Class Direction
 *
 * @package WaySearch\Entity
 */
class Direction extends DomainEntity
{
    /** @var PointInterface $points */
    protected $point;

    /** @var float $currentTurn */
    protected $currentTurn = 0;

    /**
     * Direction constructor.
     *
     * @param string $data
     */
    public function __construct(string $data)
    {
        $this->point = $this->parseData($data);
    }

    /**
     * @param string $data
     *
     * @return array
     */
    public function parseData(string $data): array
    {
        $points = [];

        $pattern = "/^([0-9]*\.?[0-9]+)\s([0-9]*\.?[0-9]+)\sstart\s([+-]*[0-9]*\.?[0-9]*)\swalk\s([+-]*[0-9]*\.?[0-9]+)(.*)/u";

        preg_match_all(
            $pattern,
            $data,
            $res
        );

        $points['x'] = (float)$res[1][0];
        $points['y'] = (float)$res[2][0];
        $points['turn'][] = (float)$res[3][0]; // turn[0] is start turn
        $points['walk'][] = (float)$res[4][0];

        if (!empty($res[5]) && !empty($res[5][0])) {
            $patternTurns = "/((turn|walk)\s([+-]*[0-9]*\.?[0-9]+))/u";

            preg_match_all(
                $patternTurns,
                $res[5][0],
                $turns
            );

            if (!empty($turns[3])) {
                for ($i = 0, $count = count($turns[3]); $i < $count; $i++) {
                    $points[$turns[2][$i]][] = (float)$turns[3][$i];
                }
            }
        }

        return $points;
    }

    /**
     * @return PointInterface
     */
    public function getDirectionEndPoint(): PointInterface
    {
        $x = $this->point['x'];
        $y = $this->point['y'];

        for ($i = 0, $count = count($this->point['turn']); $i < $count; $i++) {
            list($x, $y) = $this->nextPoint($x, $y, $i);
        }

        return new CartesianPoint($x, $y);
    }

    /**
     * @param float $x
     * @param float $y
     * @param int   $i
     *
     * @return array
     */
    protected function nextPoint(float $x, float $y, int $i)
    {
        $r = $this->point['walk'][$i];
        $f = $this->point['turn'][$i];
        $this->currentTurn += $f;

        if ($this->currentTurn > 360) {
            $this->currentTurn -= 360;
        }

        $x += $r * cos(deg2rad($this->currentTurn));
        $y += $r * sin(deg2rad($this->currentTurn));

        return [$x, $y];
    }
}
