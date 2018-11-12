<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 12/11/18
 * Time: 15:59
 */

namespace App\Controller;

// use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('home/home.html.twig');
    }
}