<?php

namespace RPWeather;

use GeoIp2\Database\Reader as GeoDBReader;
use Endroid\OpenWeatherMap\OpenWeatherMap;

class Weather
{
    const GEO_DB_FILE = 'db/GeoLite2-City.mmdb';

    public static function getWeather($openWeatherMapAPIKey, $overrideLocation = false)
    {
        $weather = false;

        $clientIP = self::getClientIP();

        if($clientIP || $overrideLocation) {

            if(!$overrideLocation) {
                $DBReader = new GeoDBReader(self::GEO_DB_FILE);
                $record = $DBReader->city($clientIP);
                $queryString = $record->postal->code . ', ' . $record->country->isoCode;
            }else{
                $queryString = $overrideLocation;
            }

            if($queryString) {
                $openWeatherMap = new OpenWeatherMap($openWeatherMapAPIKey);
                $weather = $openWeatherMap->getWeather($queryString);
            }
        }

        return $weather;
    }

    private function getClientIP()
    {
        $ipAddress = false;

        if (getenv('HTTP_CLIENT_IP'))
            $ipAddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipAddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipAddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipAddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipAddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipAddress = getenv('REMOTE_ADDR');

        return $ipAddress;
    }
}