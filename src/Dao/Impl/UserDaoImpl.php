<?php

namespace App\Dao\Impl;

use App\Dao\UserDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserDaoImpl extends GeneralDaoImpl implements UserDao
{

    protected $table = 'user';

    public function declares()
    {
        return [
            'timestamps' => array('created_time', 'updated_time'),
            'serializes' => array(
                'role' => 'delimiter',
            ),
        ];
    }

    public function getByUsername($userName)
    {
            $sql = "SELECT * FROM USER WHERE username = ? OR email = ?";

            return $this->db()->fetchAssoc($sql, [$userName, $userName]);


    }


}