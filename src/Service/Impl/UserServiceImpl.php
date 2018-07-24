<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Impl;

use App\Dao\UserDao;
use App\Service\BaseService;
use App\Service\UserService;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

class UserServiceImpl extends BaseService implements UserService
{
    public function getUser($id)
    {
        return $this->getUserDao()->get($id);
    }

    public function getUserByUsername($userName)
    {
        return  $this->getUserDao()->getByUsername($userName);
    }

    public function register($user)
    {
        $hash = $this->getPasswordEncoder()->encodePassword($user['password'], '');

        $user['password'] = $hash;
        $user['email'] = 'liuy.allen@symfony.com';

        return  $this->getUserDao()->create($user);
    }

    /**
     * @return UserDao
     */
    public function getUserDao()
    {
        return $this->createDao('UserDao');
    }

    /**
     * @return BCryptPasswordEncoder
     */
    private function getPasswordEncoder()
    {
        return  new BCryptPasswordEncoder(8);
    }
}
