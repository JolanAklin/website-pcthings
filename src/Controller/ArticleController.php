<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\BlogPost;

class ArticleController extends AbstractController
{
    public function showPage($pathTitle)
    {
        try {
            $pathTitle = filter_var($pathTitle, FILTER_SANITIZE_STRING);
            if ($pathTitle != "" && $pathTitle !== null && $pathTitle !== false) {
                $page = $this->getDoctrine()->getRepository(Article::class)->findOneByPathTitle($pathTitle);
                if ($page !== null) {
                    return $this->render('article/page.html.twig', [
                        'page' => $page,
                    ]);
                } else {
                    throw $this->createNotFoundException('The page does not exist');
                }
            }
        } catch (\Throwable $th) {
            throw $this->createNotFoundException('The page does not exist');
        }
    }
}
