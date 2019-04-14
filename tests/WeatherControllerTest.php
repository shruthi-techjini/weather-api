<?php
/**
 * Created by PhpStorm.
 * User: techjini
 * Date: 12/4/19
 * Time: 2:04 PM
 */

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherControllerTest extends WebTestCase
{
    public function testGetWeather()
    {
        $client = static::createClient();

        $client->request('GET', '/weather/London');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}