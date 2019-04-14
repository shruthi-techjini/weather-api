<?php
namespace App\Controller;


use App\Exception\ClientException;
use App\Exception\Exception;
use App\Service\WeatherService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Movie controller.
 * @Route("/", name="weather_")
 */

class WeatherController extends AbstractFOSRestController
{
    /**
     * @var WeatherService
     */
    private $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Get citi weather.
     * @Rest\Get("/weather/{citiName}")
     *
     * @return Response
     * @throws HttpException
     */
    public function getWeatherAction(string $citiName) : array
    {
        try {
            $data = $this->weatherService->getWeatherByCitiName($citiName);

        } catch (ClientException $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        return $data;
    }

}