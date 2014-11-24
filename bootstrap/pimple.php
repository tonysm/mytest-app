<?php

use Pimple\Container;
$container = new Container();

$container["pdo_connection"] = function($c) use ($db) {
    return $db;
};

$container["App.Users.RegisterUserHandler"] = function($c) {
    return new \MyTest\Users\RegisterUserHandler();
};