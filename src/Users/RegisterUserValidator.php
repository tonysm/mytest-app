<?php namespace MyTest\Users;

use MyTest\Users\Exceptions\UserRegistrationInvalidDataException;

class RegisterUserValidator
{
    /**
     * @param RegisterUserCommand $command
     * @throws UserRegistrationInvalidDataException
     */
    public function validate(RegisterUserCommand $command)
    {
        $errors = [];

        if ( ! $command->name)
            $errors[] = "Nome é obrigatório";

        if ( ! $command->username)
            $errors[] = "Username é obrigatório";

        if (false === filter_var($command->email, FILTER_VALIDATE_EMAIL))
            $errors[] = "Um e-mail válido é obrigatório";

        if ( ! $this->validatePassword($command->password, $command->password_confirmation))
            $errors[] = "Uma senha é obrigatória (6 digitos, 1 caracter maiusculo e 1 minusculo e números)";

        if (count($errors) > 0)
            throw new UserRegistrationInvalidDataException($errors);
    }

    /**
     * @param $password
     * @param $password_confirmation
     * @return bool
     */
    private function validatePassword($password, $password_confirmation)
    {
        if ($password != $password_confirmation)
            return false;

        if (strlen($password) < 6)
            return false;

        // validating if the password contains numbers, lowercase letters and uppercase letters
        if ( ! preg_match('/((?=.*\d)(?=.*[a-z])(?=.*[A-Z]))/', $password))
            return false;

        return true;
    }
}