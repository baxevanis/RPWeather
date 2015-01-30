<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Weather\Weather;

$weatherService = new Weather('12313', 'Brighton, UK');

$weatherService->getWeather();

