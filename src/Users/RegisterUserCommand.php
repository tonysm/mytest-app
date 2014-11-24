<?php namespace MyTest\Users;

class RegisterUserCommand
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $password_confirmation;

    /**
     * @param array $data
     */
    function __construct(array $data = [])
    {
        isset($data['username']) && $this->username = $data["username"];
        isset($data['name']) && $this->name = $data["name"];
        isset($data['email']) && $this->email = $data["email"];
        isset($data['password']) && $this->password = $data["password"];
        isset($data['password_confirmation']) && $this->password_confirmation = $data["password_confirmation"];
    }
} 