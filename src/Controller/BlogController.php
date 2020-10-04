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
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    public function ShowBlog($useruuid)
    {
        try {
            $useruuid = intval($useruuid);
            if($useruuid != -1)
            {
                $user = $this->getDoctrine()->getRepository(User::class)->findOneByUuid($useruuid);
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
