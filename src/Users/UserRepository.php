<?php namespace MyTest\Users;

use PDO;

class UserRepository
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * @param PDO $connection
     */
    function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email AND verified_at IS NOT NULL";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute(compact('email'));

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ( ! $result)
            return null;

        return new User($result);
    }

    /**
     * @param $user_id
     * @return User|null
     */
    public function findByUserId($user_id)
    {
        $sql = "SELECT * FROM users WHERE id = :user_id";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute(compact("user_id"));

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ( ! $result)
            return null;

        return new User($result);
    }
} 