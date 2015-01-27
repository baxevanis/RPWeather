<?php

require_once __DIR__ . '/../vendor/autoload.php';

use RPWeather\Weather;

var_dump(Weather::getWeather('123123'));

var_dump(Weather::getWeather('123123', 'Brighton,UK'));

