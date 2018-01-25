<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/luck")
     */
    public function index()
    {
        $number = mt_rand(0, 100);
        return $this->render('luck/number.html.twig', [
            'number'=>$number
        ]);
    }
}
