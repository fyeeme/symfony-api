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

use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, EquatableInterface, \ArrayAccess, \Serializable
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getRoles()
    {
        return $this->offsetGet('role');
    }

    public function getPassword()
    {
        return $this->offsetGet('password');
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->offsetGet('username');
    }

    public function eraseCredentials()
    {
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof self) {
            return false;
        }

        if ($this->getPassword() !== $user->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        if ($this->getUsername() !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    public function __set($name, $value)
    {
        $this->user[$name] = $value;

        return $this;
    }

    public function __get($name)
    {
        if ($this->offsetExists($name)) {
            return $this->user[$name];
        }
        throw new \RuntimeException("{$name} is not exist in User.");
    }

    public function __unset($name)
    {
        throw  new \LogicException('can not unset attribute from User');
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->user);
    }

    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->__set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->__unset($offset);
    }

    public function serialize()
    {
        return serialize($this->user);
    }

    public function unserialize($serialized)
    {
        $this->user = unserialize($serialized);
    }
}
