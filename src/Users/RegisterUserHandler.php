<?php namespace MyTest\Users;

use MyTest\Users\Exceptions\UserRegistrationInvalidDataException;

class RegisterUserHandler
{
    /**
     * @var RegisterUserValidator
     */
    private $userValidator;
    /**
     * @var RegistrationRepository
     */
    private $registrationRepository;

    function __construct(RegisterUserValidator $userValidator, RegistrationRepository $registrationRepository)
    {
        $this->userValidator = $userValidator;
        $this->registrationRepository = $registrationRepository;
    }

    /**
     * @param RegisterUserCommand $command
     * @throws UserRegistrationInvalidDataException
     * @return User
     */
    public function execute(RegisterUserCommand $command)
    {
        $this->userValidator->validate($command);

        // hashing the password
        $command->password = md5($command->password);

        $user = $this->registrationRepository->register($command->name, $command->username, $command->email, $command->password);

        return $user;
    }
} 