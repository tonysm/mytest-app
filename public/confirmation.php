<?php

require __DIR__ . "/../bootstrap/app.php";

$help = [];

if ( ! isset($_GET['token']))
{
    $help[] = "Oops, looks like you are in the wrong page";
    echo $twig->render("errors/404.html", ["help" => $help]);
}
else
{
    $data = [
        "token" => $_GET["token"]
    ];

    $command = new \MyTest\Users\ConfirmUserEmailCommand($data);

    $confirmed = $container["MyTest.Users.ConfirmUserEmailHandler"]->execute($command);

    if ($confirmed)
    {
        header('Location:/login.php?confirmed=true');
        exit;
    }
}