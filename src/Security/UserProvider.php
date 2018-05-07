<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Security;

use App\Service\UserService;
use Codeages\Biz\Framework\Context\Biz;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $biz;

    public function __construct(Biz $biz)
    {
        $this->biz = $biz;
    }

    public function getUsernameForApiKey($apiKey)
    {
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different
        $username = 'REAL' === $apiKey ? 'admin' : '';

        return $username;
    }

    public function loadUserByUsername($username)
    {
        $arrayUser = $this->getUserService()->getUserByUsername($username);

        if (empty($arrayUser)) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        $user = new User($arrayUser);

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->username);
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }

    /**
     * @return UserService
     */
    private function getUserService()
    {
        return $this->biz->service('UserService');
    }
}
