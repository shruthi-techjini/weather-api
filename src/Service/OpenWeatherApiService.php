<?php
namespace App\Service;

use App\Exception\Exception;
use App\Exception\ClientException as ClientResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

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
     * @throws ClientResponseException
     * @throws Exception
     */
    private function sendRequest(array $params) : ResponseInterface
    {
        $params = array_merge(['appid' => $this->apiKey], $params);

        try {
            $response = $this->client->get($this->apiUrl, [
                'query' => $params,
            ]);

        } catch (ClientException $e) {
            $data = json_decode($e->getResponse()->getBody()->getContents(), true);
            throw new ClientResponseException($data['message'], $data['cod']);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return $response;
    }
}