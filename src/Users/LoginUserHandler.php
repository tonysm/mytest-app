<?php namespace MyTest\Users;

class LoginUserHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param LoginUserCommand $command
     * @return User|null
     */
    public function execute(LoginUserCommand $command)
    {
        $user = $this->userRepository->findUserByEmail($command->email);

        if ($user && $user->password == md5($command->password))
        {
            return $user;
        }

        return null;
    }
} 