<?php

require __DIR__ . "/../bootstrap/app.php";

if (isset($_POST['register']))
{
    $data = array_only(
        $_POST['register'],
        ["username", "name", "email", "password", "password_confirmation"]
    );

    $command = new MyTest\Users\RegisterUserCommand($data);

    $container["App.Users.RegisterUserHandler"]->execute($command);
} else {
    $data = [
        'name' => '',
        'username' => '',
        'email' => ''
    ];
}

echo $twig->render("pages/register.html", ['register' => $data]);