<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/4/26
 * Time: 16:31
 */

namespace App\Service;


use App\Security\User;

class BaseService extends \Codeages\Biz\Framework\Service\BaseService
{

    /**
     * @return User
     */
    public function CurrentUser()
    {
        return $this->biz['user'];
    }

    public function createDao($alias)
    {
        return $this->biz->dao($alias);
    }

    public function createService($alias)
    {
        return $this->biz->service($alias);
    }

}