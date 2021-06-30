<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use App\Entity\Date;
use App\Entity\Image;
use App\Form\NewArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
    public function editPage($pathTitle, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_WRITER',null,'User tried to access a page without having the right permission');
        try {
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
                        'form' => $form->createView(),
                    ]);
                } else {
                    throw $this->createNotFoundException('The page does not exist');
                }
            }
        } catch (\Throwable $th) {
            throw $this->createNotFoundException('The page does not exist');
        }
    }

    public function addPage(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_WRITER',null,'User tried to access a page without having the right permission');
        
        $page = new Article();
        
        //creating form
        $form = $this->createForm(NewArticleType::class,$page);
        
        // handling form return
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $page = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();

            $date = new Date();
            $date->setDate(new \DateTime());
            $entityManager->persist($date);
            $entityManager->flush();

            $page->setPublicationDate($date);
            $page->setWriter($this->getUser());

            //persist the user entity
            $entityManager->persist($page);
            $entityManager->flush();
        }


        if ($page !== null) {
            return $this->render('article/add.html.twig', [
                'page' => $page,
                'form' => $form->createView(),
            ]);
        } else {
            throw $this->createNotFoundException('An error occured');
        }
    }

    // ajax stuff

    /**
     * get the image link to show it. Used in the page-edit form
     */
    public function GetImageLink ($imageId) : Response
    {
        $imageId = filter_var($imageId, FILTER_SANITIZE_NUMBER_INT);
        if ($imageId !== null && $imageId !== false) {
            $image = $this->getDoctrine()->getRepository(Image::class)->findOneBy(['id' => $imageId]);
            if($image == null)
            {
                return $this->json(['code' => 404, 'message' => 'not found'], 404);
            }
            return $this->json(['code' => 200, 'imageLink' => $image->GetPath()], 200);
        }
        return $this->json(['code' => 404, 'message' => 'not found'], 404);
    }
}
