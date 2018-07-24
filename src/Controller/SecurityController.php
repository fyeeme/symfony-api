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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $helper,UserPasswordEncoderInterface $encoder): Response
    {
        return $this->render('security/login.html.twig', [
            // last username entered by the user (if any)
            'last_username' => $helper->getLastUsername(),
            // last authentication error (if any)
            'error' => $helper->getLastAuthenticationError(),
        ]);
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in config/packages/security.yaml
     *
     * @Route("/logout", name="security_logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * @Route("/register", name="register")
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function register(UserPasswordEncoderInterface $encoder)
    {

        $user =  $this->getUserService()->register(['username'=>'admin','password'=>'admin']);
//        $user = $this->getUserService()->getUserByUsername('admin');
//        $user = new User($user);
//        $plainPassword = 'admin';
//        $a = $encoder->isPasswordValid($user, 'admin');
//        $encoded = $encoder->encodePassword($user, $plainPassword);
//
//        var_dump($encoded, $a);

        return $this->json($user);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('base.html.twig', ['user' => $this->getUser()]);
    }

    /**
     * @return UserService
     */
    private function getUserService()
    {
        return $this->get('biz')->service('UserService');
    }
}
