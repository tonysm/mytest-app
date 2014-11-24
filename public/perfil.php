<?php

require __DIR__ . "/../bootstrap/app.php";
require __DIR__ . "/../bootstrap/sessions.php";

if ( ! isset($_SESSION["logged_in"]))
{
    header("Location:/index.php");
    exit;
}

$user = $container["MyTest.Users.UserRepository"]->findByUserId($_SESSION["user_id"]);

echo $twig->render("users/perfil.html", compact("user"));