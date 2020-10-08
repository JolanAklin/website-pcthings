<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Article;
use App\Entity\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
        ]);
    }

    public function Pages()
    {
        $pages = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('home/pages.html.twig', [
            'pages' => $pages,
            'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
        ]);
    }

    public function Blog()
    {
        $blogPostLinks = $this->getDoctrine()->getRepository(BlogPost::class)->findByWriterJoined();
        return $this->render('home/blog.html.twig', [
            'blogPostLinks' => $blogPostLinks,
            'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
        ]);
    }

    public function Contact()
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
            'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
        ]);
    }
}
