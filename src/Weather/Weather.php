<?php

namespace Weather;

use GeoIp2\Database\Reader as GeoDBReader;
use Endroid\OpenWeatherMap\OpenWeatherMap;

class Weather
{
    const GEO_DB_FILE = 'db/GeoLite2-City.mmdb';

    protected $clientIP;
    protected $openWeatherMapAPIKey;
    protected $clientCurrentLocation = false;
    protected $currentWeather = false;

    public function __construct($openWeatherMapAPIKey, $overrideLocation = false)
    {
        $this->clientIP = $this->_getClientIP();
        $this->openWeatherMapAPIKey = $openWeatherMapAPIKey;

        if($overrideLocation) {
            $this->clientCurrentLocation = $overrideLocation;
        }
    }

    public function getWeather()
    {
        if(!$this->currentWeather) {

            if(false === $this->clientCurrentLocation) {
                $this->_populateClientsCurrentLocation();
            }

            if($this->clientCurrentLocation) {
                $openWeatherMap = new OpenWeatherMap($this->openWeatherMapAPIKey);
                $this->currentWeather = $openWeatherMap->getWeather($this->clientCurrentLocation);
            }
        }

        return $this->currentWeather;
    }

    private function _populateClientsCurrentLocation()
    {
        //todo must validate that we have a valid IP
        $DBReader = new GeoDBReader(self::GEO_DB_FILE);
        $record = $DBReader->city($this->clientIP);

        //todo construct the string in a better way plz
        $this->clientCurrentLocation = $record->postal->code . ', ' . $record->country->isoCode;
    }

    private function _getClientIP()
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