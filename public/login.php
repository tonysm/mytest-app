<?php

require __DIR__ . "/../bootstrap/app.php";
require __DIR__ . "/../bootstrap/sessions.php";

$confirmed = isset($_GET["confirmed"]) && $_GET["confirmed"] == "true" ? true : false;

if (isset($_POST["login"]))
{
    $data = $_POST["login"];

    $command = new \MyTest\Users\LoginUserCommand($data);

    $user = $container["MyTest.Users.LoginUserHandler"]->execute($command);

    if ($user)
    {
        $_SESSION["user_id"] = $user->id;
        $_SESSION["logged_in"] = true;

        header("Location:/perfil.php");
        exit();
    }
}

echo $twig->render("pages/login.html", compact('confirmed'));