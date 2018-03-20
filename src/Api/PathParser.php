<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 20/03/2018
 * Time: 14:38
 */

namespace App\Api;


use Symfony\Component\HttpFoundation\Request;

class PathParser
{
    /**
     * @param Request $request
     * @return PathMeta
     */
    public function parse(Request $request)
    {
        $pathMeta = new PathMeta();
        $this->parsePathInfo($pathMeta, $request);
        $pathMeta->setHttpMethod($request->getMethod());

        return $pathMeta;
    }

    /**
     * 解析 url 构造 资源类，
     * resName 用于组成资源类的全路径，这里对[me, app]进行了特殊处理，即[me, app]后面的slug 当做 res解析了
     * api/users/
     * slug  最终调用的资源类中的 方法的参数
     * @param $pathMeta
     * @param Request $request
     */
    private function parsePathInfo($pathMeta, Request $request)
    {
        $pathInfo = str_replace(Kernel::API_PREFIX, '', $request->getPathInfo());
        $pathExplode = explode('/', $pathInfo);
        //默认第一个是资源名称
        $nextIsResName = 1;
        foreach ($pathExplode as $part) {
            if ($part == '') {
                continue;
            }

            if ($part == 'me') {
                $pathMeta->addResName($part);
                continue;
            }

            if ($part == 'app') {
                $pathMeta->addResName($part);
                continue;
            }

            if ($nextIsResName) {
                $pathMeta->addResName($part);
                $nextIsResName = 0;
            } else {
                $pathMeta->addSlug($part);
                $nextIsResName = 1;
            }
        }
    }
}