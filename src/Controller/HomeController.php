<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    public function Pages()
    {
        return $this->render('home/pages.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    public function Blog()
    {
        return $this->render('home/blog.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    public function Contact()
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
