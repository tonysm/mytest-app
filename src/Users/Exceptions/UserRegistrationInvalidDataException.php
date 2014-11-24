<?php namespace MyTest\Users\Exceptions;

class UserRegistrationInvalidDataException  extends \InvalidArgumentException
{
    /**
     * @var array
     */
    private $errorsMessages;

    /**
     * @param array $errorsMessages
     */
    public function __construct(array $errorsMessages = [])
    {
        parent::__construct("Dados inválidos");

        $this->errorsMessages = $errorsMessages;
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return $this->errorsMessages;
    }
} 