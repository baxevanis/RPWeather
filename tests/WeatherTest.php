<?php

namespace Tests;

use Weather\Weather;

class WeatherTest extends \PHPUnit_Framework_TestCase
{

    const DEMO_OPEN_WEATHER_API_KEY = '1234567890';
    const DEMO_CITY = 'Brighton';
    const DEMO_COUNTRY = 'UK';

    /**
     * @expectedException Exception
     */
    public function testDBNotFound()
    {
        $weather = new Weather(self::DEMO_OPEN_WEATHER_API_KEY, false, 'invalid/path/');
    }
}