<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

 interface UserDao  extends GeneralDaoInterface
 {
     public function getByUsername($userName);
 }
