<?php

require __DIR__ . "/../bootstrap/app.php";

$help = [];

if (isset($_GET['created']) && $_GET['created'] == "true")
{
    $help[] = "Um e-mail de confirmação foi enviado para o seu e-mail.";
    $help[] = "Siga as instruções lá para ativar sua conta.";
}

echo $twig->render("pages/index.html", ['help' => $help]);