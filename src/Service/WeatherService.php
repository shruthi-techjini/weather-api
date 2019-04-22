<?php
namespace App\Service;


use App\Utils\CurrentWeather;

class WeatherService
{
    /**
     * @var OpenWeatherApiService
     */
    private $openWeatherApi;

    public function __construct(OpenWeatherApiService $openWeatherApi)
    {
        $this->openWeatherApi = $openWeatherApi;
    }

    /**
     * Get City Weather.
     *
     * @return array
     */
    public function getWeatherByCitiName(string $citiName) : array
    {
        $currentWeather = new CurrentWeather($this->openWeatherApi->getByCityName($citiName));

        return $currentWeather->getWeatherDetail();
    }
}