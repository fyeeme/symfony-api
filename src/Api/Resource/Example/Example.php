<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/4/26
 * Time: 14:48
 */

namespace App\Api\Resource\Example;


use App\Api\Resource\Resource;
use Codeages\Biz\Framework\Service\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class Example extends Resource
{

    /**
     * api/example/2
     * api/examples/2
     *
     * @param Request $request
     * @param $id
     * @return mixed
     *
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function get(Request $request, $id)
    {
//        //The second parameter is used to specify on what object the role is tested.
//        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Unable to access this page!');

//        if (false === $this->isGranted('ROLE_SUPER_ADMIN')) {
//            throw new AccessDeniedException('Unable to access this page!', 403);
//        }

        // yay! Use this to see if the user is logged in
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return [$request->query->all(), $id];
    }
}