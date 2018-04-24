<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 09/02/2018
 * Time: 16:29
 */

namespace App\Api\Resource;


use Codeages\Biz\Framework\Context\Biz;
use Symfony\Component\DependencyInjection\Container;

class Resource
{

    protected $biz;

    private $container;

    public function __construct(Container $container,  Biz $biz)
    {
        $this->container = $container;
        $this->biz = $biz;
    }
}