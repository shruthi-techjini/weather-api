<?php
namespace App\Service;


class WeatherService
{
    /**
     * @var OpenWeatherApiService
     */
    private $openWeatherApi;

    /**
     * @var ApiResponseHandlerService
     */
    private $apiResponseHandler;

    public function __construct(OpenWeatherApiService $openWeatherApi, ApiResponseHandlerService $apiResponseHandler)
    {
        $this->openWeatherApi = $openWeatherApi;
        $this->apiResponseHandler = $apiResponseHandler;
    }


    /**
     * Get City Weather.
     *
     * @return array
     */
    public function getWeatherByCitiName(string $citiName) : array
    {
        $response = $this->apiResponseHandler->getWeatherResponse($this->openWeatherApi->getByCityName($citiName));

        return $response;
    }
}