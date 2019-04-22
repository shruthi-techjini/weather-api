<?php

namespace App\Utils;

/**
 * Weather class hold the current weather data.
 */
class CurrentWeather
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var float
     */
    private $temperature;

    /**
     * @var float
     */
    private $windSpeed;

    /**
     * @var int
     */
    private $windDeg;

    /**
     * @var string
     */
    private $windDirection;


    public function __construct(array $data)
    {
        $this->type = $data['weather'][0]['main'];
        $this->temperature = $data['main']['temp'];
        $this->windSpeed = $data['wind']['speed'];
        $this->windDeg = $data['wind']['deg'];
        $this->windDirection = $this->getWindDirection($this->windDeg);
    }

    /**
     * Get Wind Direction
     *
     *  @param int $windDeg
     * @return string
     */
    private function getWindDirection(int $windDeg) : string
    {
        $direction = '';

        if($windDeg != null){
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
                if ($windDeg >= $angles[0] && $windDeg < $angles[1]) {
                    $direction = $dir;
                    break;
                }
            }
        }

        return $direction;
    }

    /**
     * Get Current Weather Detail.
     *
     * @return array
     */
    public function getWeatherDetail() : array
    {
        $response = array(
            "weather_type" => $this->type,
            "temperature" => $this->temperature,
            "wind" => array(
                "speed" => $this->windSpeed,
                "direction" => $this->windDirection
            )
        );

        return $response;
    }
}