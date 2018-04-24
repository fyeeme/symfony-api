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
        'PATCH' => 'update',
        'DELETE' => 'remove',
    );

    private $listMap = array(
        'GET' => 'search',
        'POST' => 'add',
        'DELETE' => 'remove',
    );

    public function getResourceClassName()
    {
        if (empty($this->resNames) || empty($this->resNames[0])) {
            throw new BadRequestHttpException('URL is not supported', null, ErrorCode::BAD_REQUEST);
        }

        return $this->getResClass(__NAMESPACE__);
    }

    public function fallbackToCustomApi($customApiNamespaces)
    {
        $result = array(
            'isFind' => false,
            'className' => '',
        );
        foreach ($customApiNamespaces as $namespace) {
            $className = $this->getResClass($namespace);
            if (class_exists($className)) {
                $result['isFind'] = true;
                $result['className'] = $className;
                break;
            }
        }

        return $result;
    }

    public function getResMethod()
    {
        $isSingleMethod = ($this->resNames[0] == 'me' && count($this->resNames) - 1 == count($this->slugs)) || (count(
                    $this->resNames
                ) == count($this->slugs));
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
        $qualifiedResName = $this->convertToSingular($this->resNames[0]).'\\';

        foreach ($this->resNames as $index => $resName) {
            //do not add prefix to resource name
            if (count($this->resNames) > 1 && $index == 0) {
                continue;
            }
            $qualifiedResName .= $this->convertToSingular($resName);
        }

        return   $namespace.'\\Resource\\'.$qualifiedResName;
    }

    private function convertToSingular($string)
    {
        return Inflector::singularize(Inflector::classify($string));
    }
}