<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\BlogPost;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class About extends AbstractController
{
    public function AboutUser(string $username)
    {
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        if ($username != "" && $username !== null && $username !== false)
        {
            $user = $this->getDoctrine()->getRepository(User::class)->findOneByUserName($username);
            if($user)
            {
                return $this->render('about_user.html.twig', [
                    'user' => $user,
                    'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
                    'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
                ]);
            }
        }
        return new NotFoundHttpException();
    }
}
