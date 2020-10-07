<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\BlogPost;
use App\Entity\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends AbstractController
{
    public function ShowBlog($username)
    {
        try {
            $username = filter_var($username, FILTER_SANITIZE_STRING);
            if($username != "" && $username !== null && $username !== false)
            {
                $user = $this->getDoctrine()->getRepository(User::class)->findOneByUserName($username);
                if($user !== null)
                {
                    $blogPosts = $this->getDoctrine()->getRepository(BlogPost::class)->findByWriter($user->getId());
                    return $this->render('blog/user_blog.html.twig', [
                        'user' => $user,
                        'blogPosts' => $blogPosts,
                    ]);
                }else
                {
                    throw $this->createNotFoundException('The user does not exist');
                }
            }
        } catch (\Throwable $th) {
            throw $this->createNotFoundException('The user does not exist');
        }
    }
}
