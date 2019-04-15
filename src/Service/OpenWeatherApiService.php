<?php
namespace App\Service;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OpenWeatherApiService
{
    /**
     * @var string OpenWeatherMap API URL
     */
    private $apiUrl;

    /**
     * @var string OpenWeatherMap API key
     */
    private $apiKey;

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client, ParameterBagInterface $params)
    {
        $this->client = $client;
        $this->apiUrl = $params->get('open_weather')['api_url'];
        $this->apiKey = $params->get('open_weather')['app_id'];
    }

    /**
     * Get weather by city name
     *
     * @param string $cityName
     * @return array
     */
    public function getByCityName(string $cityName) : array
    {
        $response = $this->sendRequest(['q' => $cityName]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Send request to OpenWeatherMap API endpoint
     *
     * @param array $params query parameters
     * @return ResponseInterface
     * @throws HttpException
     */
    private function sendRequest(array $params) : ResponseInterface
    {
        $params = array_merge(['appid' => $this->apiKey], $params);

        try {
            $response = $this->client->get($this->apiUrl, [
                'query' => $params,
            ]);
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case Response::HTTP_UNAUTHORIZED:
                    throw new HttpException(Response::HTTP_UNAUTHORIZED, 'Invalid App ID or it has incorrect value.');
                case Response::HTTP_NOT_FOUND:
                    throw new HttpException(Response::HTTP_NOT_FOUND,'City not found');
                default:
                    throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal server error.');
            }
        }

        return $response;
    }
}