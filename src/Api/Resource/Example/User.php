<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/4/26
 * Time: 14:49
 */

namespace App\Api\Resource\Example;


use Symfony\Component\HttpFoundation\Request;

class User
{
    /**
     * api/example/2/user/2
     * @param Request $request
     * @param $exampleId
     * @param $userId
     * @return array
     */
    public function get(Request $request, $exampleId, $userId)
    {
        return [$request->query->all(),$exampleId, $userId];
    }
}