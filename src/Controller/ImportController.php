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
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\BlogPost;
use App\Entity\Article;
use App\Entity\Image;
use App\Form\ImportPictureFormType;
use App\Form\ModifyPictureFormType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\Persistence\ManagerRegistry;

class ImportController extends AbstractController
{
    public function importPicture(ManagerRegistry $doctrine, $page, Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_IMPORT");

        $countImage = $doctrine->getRepository(Image::class)->CountImages();
        $pagesTot = ceil($countImage[0]['count']/8);
        if($pagesTot != 0)
        {
            if($page > $pagesTot || $page <= 0)
            {
                return $this->redirectToRoute('import_picture');
            }
        }else
        {
            if($page != 1)
            {
                return $this->redirectToRoute('import_picture');
            }
        }

        $image = new Image();
        $form = $this->createForm(ImportPictureFormType::class, $image);
        $errors = [];
        $form->handleRequest($request);
        try {
            if ($form->isSubmitted() && $form->isValid()) {
    
                //update the password
                $image = $form->getData();
    
                $imageFile = $form->get('image')->getData();
    
                $filesystem = new Filesystem();
                $imageFileName = "";
                do {
                    $imageFileName = uniqid('img_', true).".".$imageFile->guessExtension();
                } while ($filesystem->exists($this->getParameter('imported_image_dir')."/".$imageFileName));
    
                $image->setPath("/images/imported/".$imageFileName);
    
                try {
                    $imageFile->move($this->getParameter('imported_image_dir'), $imageFileName);
                } catch (\Throwable $th) {
                    array_push($errors, "Image couldn't be moved to the repository");
                }
    
                //persist the image entity
                $entityManager = $doctrine->getManager();
                $entityManager->persist($image);
                $entityManager->flush();
    
                $this->addFlash('success', 'Your image has been successfully imported');
    
                return $this->redirectToRoute('import_picture', $request->query->all());
            }
            if($form->isSubmitted())
            {
                //get all the error of the form
                foreach ($form as $child) {
                    foreach ($child->getErrors() as $error) {
                        array_push($errors, $error->getMessage());
                    }
                }
            }
        } catch (\Throwable $th) {
            array_push($errors, "An error occured at the reading of the form fields");
        }

        $images = $doctrine->getRepository(Image::class)->findByGroupOf8($page);
        $pages = [];
        for ($i=1; $i <= $pagesTot; $i++)
        { 
            array_push($pages, ['numero' => $i]);
        }
        return $this->render('import/import_picture.html.twig', [
            'images' => $images,
            'pages' => $pages,
            'currentPage' => $page,
            'baseLink' => '/import-picture/',
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    public function ChooseImage(ManagerRegistry $doctrine, $page)
    {
        $countImage = $doctrine->getRepository(Image::class)->CountImages();
        $pagesTot = ceil($countImage[0]['count']/8);
        if($pagesTot != 0)
        {
            if($page > $pagesTot || $page <= 0)
            {
                return $this->redirectToRoute('import_picture');
            }
        }else
        {
            if($page != 1)
            {
                return $this->redirectToRoute('import_picture');
            }
        }

        $images = $doctrine->getRepository(Image::class)->findByGroupOf8($page);
        $pages = [];
        for ($i=1; $i <= $pagesTot; $i++)
        { 
            array_push($pages, ['numero' => $i]);
        }

        return $this->render('import/choose_picture.html.twig', [
            'images' => $images,
            'pages' => $pages,
            'currentPage' => $page,
            'baseLink' => '/import-picture/',
        ]);
    }

    public function modifyPicture (ManagerRegistry $doctrine, $imageId, Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_IMPORT");

        $image = $doctrine->getRepository(Image::class)->find($imageId);
        if($image !== null)
        {
            $form = $this->createForm(ModifyPictureFormType::class, $image);
            $errors = [];
            $form->handleRequest($request);
            try {
                if ($form->isSubmitted() && $form->isValid()) {
        
                    //update the password
                    $image = $form->getData();
        
                    //persist the image entity
                    $entityManager = $doctrine->getManager();
                    $entityManager->persist($image);
                    $entityManager->flush();
        
                    $this->addFlash('success', 'Your image has been successfully updated');
        
                    return $this->redirectToRoute('import_picture');
                }
                if($form->isSubmitted())
                {
                    //get all the error of the form
                    foreach ($form as $child) {
                        foreach ($child->getErrors() as $error) {
                            array_push($errors, $error->getMessage());
                        }
                    }
                }
            } catch (\Throwable $th) {
                array_push($errors, "An error occured at the reading of the form fields");
            }
            return $this->render('import/import_picture_modify.html.twig', [
                'form' => $form->createView(),
                'image' => $image,
                'errors' => $errors
            ]);

        }else
        {
            $this->addFlash('error', 'The requested image doesn\'t exist');
            return $this->redirectToRoute('import_picture');
        }
    }
}
