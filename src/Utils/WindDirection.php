<?php

namespace App\Utils;


class WindDirection
{
    /**
     * Get Wind Direction
     *
     * @param int $bearing
     * @return string
     */
    public function getDirection(int $bearing) : string
    {
        $direction = '';
        $cardinalDirections = array(
            'north' => array(337.5, 22.5),
            'northeast' => array(22.5, 67.5),
            'east' => array(67.5, 112.5),
            'southeast' => array(112.5, 157.5),
            'south' => array(157.5, 202.5),
            'southwest' => array(202.5, 247.5),
            'west' => array(247.5, 292.5),
            'northwest' => array(292.5, 337.5)
        );

        foreach ($cardinalDirections as $dir => $angles) {
            if ($bearing >= $angles[0] && $bearing < $angles[1]) {
                $direction = $dir;
                break;
            }
        }

        return $direction;
    }
}