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
use App\Entity\Article;
use App\Entity\Date;
use App\Form\NewArticleType;
use Symfony\Component\HttpFoundation\Request;

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
}
