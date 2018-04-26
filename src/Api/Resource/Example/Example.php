<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/4/26
 * Time: 14:48
 */

namespace App\Api\Resource\Example;


use App\Api\Resource\Resource;
use Symfony\Component\HttpFoundation\Request;

class Example extends Resource
{

    /**
     * api/example/2
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function get(Request $request, $id)
    {
        return [$request->query->all(), $id];
    }
}