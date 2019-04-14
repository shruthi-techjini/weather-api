<?php

namespace App\Service;

use App\Utils\WindDirection;

class ApiResponseHandlerService
{
    /**
     * @var WindDirection
     */
    private $windDirection;

    public function __construct(WindDirection $windDirection)
    {
        $this->windDirection = $windDirection;
    }

    /**
     * Get Weather.
     *
     * @return array
     */
    public function getWeatherResponse(array $data) : array
    {
        if(empty($data)){
            throw new BadRequestException('Weather data not found.');
        }

        return array(
            "weather_type" => $data['weather'][0]['main'] ?? '',
            "temperature" => $data['main']['temp'] ?? '',
            "wind" => array(
                "speed" => $data['wind']['speed'] ?? '',
                "direction" => isset($data['wind']['deg']) ? $this->windDirection->getDirection($data['wind']['deg']) : ''
            )
        );
    }
}