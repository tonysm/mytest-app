<?php

use Pimple\Container;

$container = new Container();

$container["pdo.connection"] = function($c) use ($db) {
    return $db;
};


$container["SwiftMailer"] = function($c) use ($mail_config) {
    $transport = Swift_SmtpTransport::newInstance($mail_config["host"], $mail_config["port"])
        ->setUsername($mail_config["username"])
        ->setPassword($mail_config["password"]);

    return Swift_Mailer::newInstance($transport);
};

$container["MyTest.Mailers.UserNotifier"] = function($c) use ($twig) {
    return new \MyTest\Mailers\UserNotifier($c["SwiftMailer"], $twig);
};

$container["MyTest.Users.RegistrationRepository"] = function($c) {
    return new \MyTest\Users\RegistrationRepository($c["pdo.connection"]);
};

$container["MyTest.Users.ConfirmUserEmailHandler"] = function($c) {
    return new \MyTest\Users\ConfirmUserEmailHandler(
        $c["MyTest.Users.RegistrationRepository"]
    );
};

$container["MyTest.Users.RegisterUserHandler"] = function($c) {
    return new \MyTest\Users\RegisterUserHandler(
        new \MyTest\Users\RegisterUserValidator(),
        $c["MyTest.Users.RegistrationRepository"]
    );
};