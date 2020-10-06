<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;

class ArticleController extends AbstractController
{
    public function showPage($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if ($id != 0 && $id !== null && $id !== false) {
            $page = $this->getDoctrine()->getRepository(Article::class)->find($id);
            if ($page !== null) {
                return $this->render('page/page.html.twig', [
                    'page' => $page
                ]);
            } else {
                throw $this->createNotFoundException('The page does not exist');
            }
            try {
            } catch (\Throwable $th) {
                throw $this->createNotFoundException('The page does not exist');
            }
        }
    }
}
