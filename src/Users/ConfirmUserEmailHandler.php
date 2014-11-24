<?php namespace MyTest\Users;

class ConfirmUserEmailHandler
{
    /**
     * @var RegistrationRepository
     */
    private $registrationRepository;

    /**
     * @param RegistrationRepository $registrationRepository
     */
    function __construct(RegistrationRepository $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }

    /**
     * @param ConfirmUserEmailCommand $command
     * @return bool
     */
    public function execute(ConfirmUserEmailCommand $command)
    {
        return $this->registrationRepository->confirmToken($command->token);
    }
} 