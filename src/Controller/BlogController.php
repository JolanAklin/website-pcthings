<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\BlogPost;
use App\Entity\Article;
use App\Form\NewBlogPostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends AbstractController
{
    public function ShowBlog($username, $page)
    {
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
    }

    public function ShowBlogId($blogId)
    {
        $blogId = filter_var($blogId, FILTER_SANITIZE_STRING);
        if($blogId !== null && $blogId !== false)
        {
            $blogPost = $this->getDoctrine()->getRepository(BlogPost::class)->find($blogId);
            if($blogId !== null)
            {
                return $this->render('blog/blog_post.html.twig', [
                    'blogPost' => $blogPost,
                ]);
            }
        }
    }

    public function EditBlogPost($blogId, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_WRITER',null,'User tried to access a page without having the right permission');
        $blogId = filter_var($blogId, FILTER_SANITIZE_STRING);
        if($blogId !== null && $blogId !== false)
        {
            $blogPost = $this->getDoctrine()->getRepository(BlogPost::class)->find($blogId);

            if ($blogPost->getWriter() !== $this->getUser()) {
                throw $this->createAccessDeniedException();
            }
            
            //creating form
            $form = $this->createForm(NewBlogPostType::class,$blogPost);

            // handling form return
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $blogPost = $form->getData();

                //persist the user entity
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($blogPost);
                $entityManager->flush();
            }

            if($blogId !== null)
            {
                return $this->render('blog/edit.html.twig', [
                    'blogPost' => $blogPost,
                    'form' => $form->createView(),
                ]);
            }
        }
    }
}
