<?php
/*
Copyright 2021 Jolan Aklin and Yohan Zbinden

This website is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, version 3 of the License.

This website is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this software.  If not, see <https://www.gnu.org/licenses/>.
*/

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\BlogPost;
use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;

class HomeController extends AbstractController
{
    public function index()
    {
        return $this->render('home/index.html.twig', [
        ]);
    }

    public function Pages(ManagerRegistry $doctrine, $page)
    {
        $countArticle = $doctrine->getRepository(Article::class)->CountArticle();
        $pagesTot = ceil($countArticle[0]['count']/10);
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

        $pages = $doctrine->getRepository(Article::class)->findByGroupOf10($page);
        return $this->render('home/pages.html.twig', [
            'pages' => $pages,
            'nbPages' => $pagesArray,
            'baseLink' => '/pages/',
            'currentPage' => $page,
        ]);
    }

    public function Blog(ManagerRegistry $doctrine, $page)
    {
        $countBlogPost = $doctrine->getRepository(BlogPost::class)->CountBlogPostWriter();
        $pagesTot = ceil($countBlogPost[0]['count']/10);
        if($pagesTot != 0)
        {
            if($page > $pagesTot || $page <= 0)
            {
                return $this->redirectToRoute('blog');
            }
        }else
        {
            if($page != 1)
            {
                return $this->redirectToRoute('blog');
            }
        }
        $pagesArray = [];
        for ($i=1; $i <= $pagesTot; $i++)
        { 
            array_push($pagesArray, ['numero' => $i]);
        }

        $blogPostLinks = $doctrine->getRepository(BlogPost::class)->findByWriterJoined($page);
        return $this->render('home/blog.html.twig', [
            'blogPostLinks' => $blogPostLinks,
            'nbPages' => $pagesArray,
            'baseLink' => '/blog/',
            'currentPage' => $page,
        ]);
    }

    public function Contact()
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
