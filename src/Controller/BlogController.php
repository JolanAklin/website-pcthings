<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\BlogPost;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends AbstractController
{
    public function ShowBlog($username, $page)
    {
        try {
            
            $username = filter_var($username, FILTER_SANITIZE_STRING);
            if($username != "" && $username !== null && $username !== false)
            {
                $countBlogPost = $this->getDoctrine()->getRepository(BlogPost::class)->CountBlogPostByUser($username);
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

                $user = $this->getDoctrine()->getRepository(User::class)->findOneByUserName($username);
                if($user !== null)
                {
                    $blogPosts = $this->getDoctrine()->getRepository(BlogPost::class)->findByWriter($user->getId(), $page);
                    return $this->render('blog/user_blog.html.twig', [
                        'user' => $user,
                        'blogPosts' => $blogPosts,
                        'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
                        'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
                        'nbPages' => $pagesArray,
                        'baseLink' => '/blog/'.$username."/",
                        'currentPage' => $page,
                    ]);
                }else
                {
                    throw $this->createNotFoundException('The user does not exist');
                }
            }else
            {
                throw $this->createNotFoundException('The user does not exist');
            }
        } catch (\Throwable $th) {
            throw $this->createNotFoundException('The user does not exist');
        }
    }
}
