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
            'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
        ]);
    }

    public function Pages($page)
    {
        $countImage = $this->getDoctrine()->getRepository(Article::class)->CountArticle();
        $pagesTot = ceil($countImage[0]['COUNT(*)']/10);
        if($pagesTot != 0)
        {
            if($page > $pagesTot || $page <= 0)
            {
                return $this->redirectToRoute('pages');
            }
        }else
        {
            if($page != 1)
            {
                return $this->redirectToRoute('pages');
            }
        }
        $pagesArray = [];
        for ($i=1; $i <= $pagesTot; $i++)
        { 
            array_push($pagesArray, ['numero' => $i]);
        }

        $pages = $this->getDoctrine()->getRepository(Article::class)->findByGroupOf10($page);
        return $this->render('home/pages.html.twig', [
            'pages' => $pages,
            'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
            'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
            'nbPages' => $pagesArray,
            'baseLink' => '/pages/',
            'currentPage' => $page,
        ]);
    }

    public function Blog()
    {
        $blogPostLinks = $this->getDoctrine()->getRepository(BlogPost::class)->findByWriterJoined();
        return $this->render('home/blog.html.twig', [
            'blogPostLinks' => $blogPostLinks,
            'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
            'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
        ]);
    }

    public function Contact()
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
            'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
            'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
        ]);
    }
}
