<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 20/03/2018
 * Time: 19:04
 */

namespace App\Security;


use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiKeyUserProvider implements UserProviderInterface
{
    public function __construct()
    {
    }

    public function getUsernameForApiKey($apiKey)
    {
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different
        $username = "";

        return $username;
    }

    public function loadUserByUsername($username)
    {
        // TODO: Implement loadUserByUsername() method.
        $user = [];

       // return new User();

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }
        $this->loadUserByUsername($user);
    }

    public function supportsClass($class)
    {
        User::class === $class;
    }


}