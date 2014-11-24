<?php namespace MyTest\Users;

class LoginUserCommand
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @param array $data
     */
    function __construct(array $data = [])
    {
        isset($data["email"]) && $this->email = $data["email"];
        isset($data["password"]) && $this->password = $data["password"];
    }

}