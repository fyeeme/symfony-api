<?php

namespace App\Api;

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PathMeta
{
    private $httpMethod = '';

    private $resNames = array();

    private $slugs = array();

    private $singleMap = array(
        'GET' => 'get',
        'POST' => 'update',
        'DELETE' => 'delete',
    );

    private $listMap = array(
        'GET' => 'search',
        'POST' => 'add',
        'DELETE' => 'delete',
    );

    public function getResourceClassName()
    {
        if (empty($this->resNames) || empty($this->resNames[0])) {
            throw new BadRequestHttpException('URL is not supported', null, ErrorCode::BAD_REQUEST);
        }

        return $this->getResClass(__NAMESPACE__);
    }

    /**
     * if not slug after res, then we parse the method as batch request or parse as single request
     * @return mixed
     */
    public function getResMethod()
    {
        $resCount = count($this->resNames);
        $slugCount = count($this->slugs);

        //except the excluded res
        if (in_array($this->resNames[0], PathParser::excludePathInfo())) {
            $resCount -= 1;
        }
        $isSingleMethod = $resCount === $slugCount;
        if ($isSingleMethod) {
            return $this->singleMap[$this->httpMethod];
        } else {
            return $this->listMap[$this->httpMethod];
        }
    }

    public function getSlugs()
    {
        return $this->slugs;
    }

    public function addResName($resName)
    {
        $this->resNames[] = $resName;
    }

    public function addSlug($slug)
    {
        $this->slugs[] = $slug;
    }

    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = strtoupper($httpMethod);
    }

    /**
     *
     * 根据 resName 组装资源类的全路径
     *  /me/orders =>App\Api\Resource\Me\Order
     *  /me/orders =>App\Api\Resource\Me\MeOrder
     * @param $namespace
     * @return string
     */
    private function getResClass($namespace)
    {
        $qualifiedResName = $this->convertToSingular($this->resNames[0]) . '\\';

        foreach ($this->resNames as $index => $resName) {
            //do not add prefix to resource name
            if (count($this->resNames) > 1 && $index == 0) {
                continue;
            }
            $qualifiedResName .= $this->convertToSingular($resName);
        }

        return $namespace . '\\Resource\\' . $qualifiedResName;
    }

    private function convertToSingular($string)
    {
        return Inflector::singularize(Inflector::classify($string));
    }
}
