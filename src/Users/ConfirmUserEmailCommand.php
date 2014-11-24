<?php namespace MyTest\Users;

class ConfirmUserEmailCommand
{
    /**
     * @var string
     */
    public $token;

    /**
     * @param array $data
     */
    function __construct(array $data = [])
    {
        isset($data['token']) && $this->token = $data['token'];
    }

} 