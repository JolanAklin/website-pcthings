<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use App\Entity\BlogPost;
use App\Form\NewArticleType;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController
{
    public function showPage($pathTitle)
    {
        //try {
            $pathTitle = filter_var($pathTitle, FILTER_SANITIZE_STRING);
            if ($pathTitle != "" && $pathTitle !== null && $pathTitle !== false) {
                $page = $this->getDoctrine()->getRepository(Article::class)->findOneByPathTitle($pathTitle);
                if ($page !== null) {
                    return $this->render('article/page.html.twig', [
                        'page' => $page,
                        'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
                        'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
                    ]);
                } else {
                    throw $this->createNotFoundException('The page does not exist');
                }
            }
        /*} catch (\Throwable $th) {
            throw $this->createNotFoundException('The page does not exist');
        }*/
    }
    public function editPage($pathTitle, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN',null,'User tried to access a page without having the right permission');
        //try {
            $pathTitle = filter_var($pathTitle, FILTER_SANITIZE_STRING);
            if ($pathTitle != "" && $pathTitle !== null && $pathTitle !== false) {
                $page = $this->getDoctrine()->getRepository(Article::class)->findOneByPathTitle($pathTitle);
                //checking if that user is the author or not
                if ($page->getWriter() !== $this->getUser()) {
                    throw $this->createAccessDeniedException();
                }

                //creating form
                $form = $this->createForm(NewArticleType::class,$page);

                // handling form return
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $page = $form->getData();

                    //persist the user entity
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($page);
                    $entityManager->flush();
                }


                if ($page !== null) {
                    return $this->render('article/edit.html.twig', [
                        'page' => $page,
                        'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
                        'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
                        'form' => $form->createView(),
                    ]);
                } else {
                    throw $this->createNotFoundException('The page does not exist');
                }
            }
        /*} catch (\Throwable $th) {
            throw $this->createNotFoundException('The page does not exist');
        }*/
    }
}
