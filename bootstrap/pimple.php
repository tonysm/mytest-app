<?php

use Pimple\Container;
$container = new Container();

$container["pdo.connection"] = function($c) use ($db) {
    return $db;
};

$container["App.Users.RegistrationRepository"] = function($c) {
    return new \MyTest\Users\RegistrationRepository($c["pdo.connection"]);
};

$container["App.Users.RegisterUserHandler"] = function($c) {
    return new \MyTest\Users\RegisterUserHandler(
        new \MyTest\Users\RegisterUserValidator(),
        $c["App.Users.RegistrationRepository"]
    );
};