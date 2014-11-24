<?php namespace MyTest\Users;

use MyTest\Users\Exceptions\CouldNotRegisterUserException;
use MyTest\Users\Exceptions\UsernameOrEmailBeenTakenException;

class RegistrationRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * @param \PDO $connection
     */
    function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $name
     * @param $username
     * @param $email
     * @param $password
     * @throws Exceptions\CouldNotRegisterUserException
     * @return User
     */
    public function register($name, $username, $email, $password)
    {
        $this->guardUsernameAndEmailUniqueness($username, $email);

        $sql = "INSERT INTO users (name, username, email, password, created_at, updated_at)
            VALUES (:name, :username, :email, :password, now(), now())";

        $stmt = $this->connection->prepare($sql);

        $data = compact('name', 'username', 'email', 'password');

        $executed = $stmt->execute($data);

        if ( ! $executed)
            throw new CouldNotRegisterUserException;

        $data['id'] = $this->connection->lastInsertId();

        $user = new User($data);

        $token = $this->createTokenForUserIfNotExists($user);

        $user->token = new Token(compact('token'));

        return $user;
    }

    private function guardUsernameAndEmailUniqueness($username, $email)
    {
        $sql = "SELECT COUNT(id) as count FROM users WHERE username = :username OR email = :email";

        $stmt = $this->connection->prepare($sql);

        $stmt->execute(compact('username', 'email'));

        $result = $stmt->fetch();

        if ($result['count'] > 0)
            throw new UsernameOrEmailBeenTakenException;
    }

    /**
     * @param User $user
     * @return string the token
     */
    private function createTokenForUserIfNotExists($user)
    {
        $token = $this->getUnusedTokenByUserId($user->id);

        if ($token)
            return $token;

        $sql = "INSERT INTO email_verification_tokens (token, created_at, user_id) VALUES(:token, :created_at, :user_id)";

        $stmt = $this->connection->prepare($sql);

        $token = uniqid();

        $stmt->execute([
            "token" => $token,
            "user_id" => $user->id,
            "created_at" => date("Y-m-d", strtotime("today"))
        ]);

        return $token;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function confirmToken($token)
    {
        $user = $this->getUserByToken($token);

        if ($user)
        {
            $this->confirmEmail($token);
            return true;
        }

        return false;
    }

    /**
     * @param $user_id
     * @return string the token
     */
    private function getUnusedTokenByUserId($user_id)
    {
        $sql = "SELECT token FROM email_verification_tokens WHERE user_id = :user_id AND used_at IS NULL";

        $stmt = $this->connection->prepare($sql);

        $stmt->execute(['user_id' => $user_id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ? $result["token"] : false;
    }

    /**
     * @param string $token
     * @return User
     */
    private function getUserByToken($token)
    {
        $sql = "SELECT * FROM users WHERE id = (SELECT user_id FROM email_verification_tokens WHERE token = :token LIMIT 1)";

        $stmt = $this->connection->prepare($sql);

        $stmt->execute(["token" => $token]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result)
        {
            return new User($result);
        }

        return null;
    }

    /**
     * @param string $token
     */
    private function confirmEmail($token)
    {
        $sql = "UPDATE email_verification_tokens SET used_at = now() WHERE token = :token";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(["token" => $token]);

        $sql = "UPDATE users SET verified_at = now() WHERE id = (SELECT user_id FROM email_verification_tokens WHERE token = :token LIMIT 1)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(["token" => $token]);
    }
} 