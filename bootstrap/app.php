<?php

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/twig.php";
require __DIR__ . "/database.php";
require __DIR__ . "/helpers.php";
require __DIR__ . "/swift_mailer.php";
require __DIR__ . "/pimple.php";

// define the host of the app
define("APP_HOST", "http://192.168.56.101.xip.io");