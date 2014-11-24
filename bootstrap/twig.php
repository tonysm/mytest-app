<?php

// configure twig
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem(__DIR__ . '/../resources/views');

$twig = new Twig_Environment($loader);