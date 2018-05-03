<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Security\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){

    }

    /**
     * @Route("/register", name="register")
     * @param UserPasswordEncoderInterface $encoder
     */
    public function register(UserPasswordEncoderInterface $encoder)
    {
       $user = $this->getUserService()->getUserByUsername('admin');
        $user = new User( $user);
        $plainPassword = 'admin';
        $a =  $encoder->isPasswordValid($user,'admin');
        $encoded = $encoder->encodePassword($user, $plainPassword);

        var_dump($encoded, $a);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        var_dump($this->getUser()->email);
        return $this->render('base.html.twig');
    }

    /**
     * @return UserService
     */
    private function getUserService()
    {
        return $this->get('biz')->service('UserService');
    }
}
