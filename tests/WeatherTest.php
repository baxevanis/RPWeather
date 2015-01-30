<?php

namespace Tests;

use Weather\Weather;

class WeatherTest extends \PHPUnit_Framework_TestCase
{

    const DEMO_OPEN_WEATHER_API_KEY = '1234567890';
    const DEMO_CITY = 'Brighton';
    const DEMO_COUNTRY = 'UK';

    public function testOverrideUsage()
    {
        $weather = new Weather(self::DEMO_OPEN_WEATHER_API_KEY, self::DEMO_CITY.', '.self::DEMO_COUNTRY);
        $weatherResponse = $weather->getWeather();

        $this->assertInstanceOf('stdClass', $weatherResponse);
        $this->assertObjectHasAttribute('weather', $weatherResponse);
    }

    public function testInvalidIP()
    {
        $weather = new Weather(self::DEMO_OPEN_WEATHER_API_KEY);

        $this->assertFalse($weather->getWeather());

    }
    /**
     * @expectedException Exception
     */
    public function testDBNotFound()
    {
        $weather = new Weather(self::DEMO_OPEN_WEATHER_API_KEY, false, 'invalid/path/');
    }
}