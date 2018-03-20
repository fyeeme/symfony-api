<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 20/03/2018
 * Time: 11:25
 */

namespace App\Api\Resource\Login;

use App\Api\Resource\Resource;
use Symfony\Component\HttpFoundation\Request;

class Login extends Resource
{

    public function update(Request $request, $id)
    {
        return ['user_id'=>$id];
    }

    public function get(Request $request, $id){
        return ['user_id'=>$id];
    }
}