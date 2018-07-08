<?php

namespace App\Model;

use Nette\Database\Context;
use Nette\Database\UniqueConstraintViolationException;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\Passwords;

/**
 * Created by PhpStorm.
 * User: olangr
 * Date: 7/5/18
 * Time: 2:53 PM
 */

class AuthManager extends BaseManager implements IAuthenticator
{

    const
        TABLE_NAME = 'user',
        COLUMN_ID = 'user_id',
        COLUMN_EMAIL = 'email',
        COLUMN_NAME = 'name',
        COLUMN_PASSWORD_HASH = 'password',
        COLUMN_ROLE = 'role';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Performs an authentication against e.g. database.
     * and returns IIdentity on success or throws AuthenticationException
     * @param array $credentials
     * @return Identity
     * @throws AuthenticationException
     */
    function authenticate(array $credentials)
    {
        list($email, $password) = $credentials; // Parameter extract

        // Returns user or false
        $user = $this->db->table(self::TABLE_NAME)->where(self::COLUMN_EMAIL, $email)->fetch();

        // User check
        if (!$user) {
            // Throw exception if user does not exists
            throw new AuthenticationException('This user name does not exists.', self::IDENTITY_NOT_FOUND);
        } elseif (!Passwords::verify($password, $user[self::COLUMN_PASSWORD_HASH])) { // Cechks password.
            // Throws exception if password is not right
            throw new AuthenticationException('This password is not correct.', self::INVALID_CREDENTIAL);
        } elseif (Passwords::needsRehash($user[self::COLUMN_PASSWORD_HASH])) { // Rehash if needed
            // Password rehash
            $user->update(array(self::COLUMN_PASSWORD_HASH => Passwords::hash($password)));
        }

        // User data preparation
        $userData = $user->toArray(); // User Data extract
        unset($userData[self::COLUMN_PASSWORD_HASH]); // Unset session password due to safety reason

        // Returns user identity
        return new Identity($user[self::COLUMN_ID], $user[self::COLUMN_ROLE], $userData);
    }

    /**
     * @param $email
     * @param $password
     * @throws DuplicateNameException
     */
    public function register($email, $password)
    {
        try {
            $name = 'user_' . time();
            $this->db->table(self::TABLE_NAME)->insert(array(
                self::COLUMN_EMAIL => $email,
                self::COLUMN_NAME => $name,
                self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
            ));
        } catch (UniqueConstraintViolationException $e) {
            // Throw exception if user already exists
            throw new DuplicateNameException;
        }
    }
}

class DuplicateNameException extends \Exception
{
    public function __construct()
    {
        parent::__construct();
        $this->message = 'User with this name already exists';
    }
}