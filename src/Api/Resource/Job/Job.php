<?php

namespace App\Api\Resource\Job;

use App\Api\Resource\Resource;
use Symfony\Component\HttpFoundation\Request;

class Job extends Resource
{
    public function get(Request $request, $id)
    {
        var_dump($this->getUser());

        return $id;
    }
}
