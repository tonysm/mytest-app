<?php

require __DIR__ . "/../bootstrap/app.php";

$has_submitted = isset($_POST['register']);

$data = array_only(
    $has_submitted ? $_POST['register'] : [],
    ["username", "name", "email", "password", "password_confirmation"]
);

$errors = [];

if ($has_submitted)
{
    try
    {
        $command = new MyTest\Users\RegisterUserCommand($data);
        $user = $container["App.Users.RegisterUserHandler"]->execute($command);

        header('Location:/index.php?created=true');
    }
    catch (\MyTest\Users\Exceptions\UserRegistrationInvalidDataException $e)
    {
        $errors = $e->getErrorMessages();
    }
    catch (\MyTest\Users\Exceptions\CouldNotRegisterUserException $e)
    {
        $errors = ['Ops, houve um problema inesperado.'];
    }
    catch (\MyTest\Users\Exceptions\UsernameOrEmailBeenTakenException $e)
    {
        $errors = ['Nome de usuário ou email já estão sendo utilizados.'];
    }
}

echo $twig->render("pages/register.html", ['register' => $data, 'errors' => $errors]);