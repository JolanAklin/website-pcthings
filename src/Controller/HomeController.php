<?php

namespace App\Controller;

use App\Entity\BlogPost;
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
        $blogPostLinks = $this->getDoctrine()->getRepository(BlogPost::class)->findAll();
        return $this->render('home/blog.html.twig', [
            'blogPostLinks' => $blogPostLinks,
        ]);
    }

    public function Contact()
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
