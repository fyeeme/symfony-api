<?php

namespace App\Api\Resource\Example;


use App\Api\Resource\Resource;
use Symfony\Component\HttpFoundation\Request;

class UserCourse extends Resource
{
    /**
     * /example/2/user/1/course/5
     *
     * @param Request $request
     * @param $exampleId
     * @param $userId
     * @param $courseId
     * @return array
     */
    public function get(Request $request, $exampleId, $userId, $courseId)
    {
        return [$request->query->all(), $exampleId, $userId, $courseId];
    }
}