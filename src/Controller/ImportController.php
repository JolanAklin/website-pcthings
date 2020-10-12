<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\BlogPost;
use App\Entity\Article;
use App\Entity\Image;
use App\Form\ImportPictureFormType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class ImportController extends AbstractController
{
    public function importPicture($page, Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_IMPORT");

        $image = new Image();
        $form = $this->get('form.factory')->createNamed('editUserForm', ImportPictureFormType::class, $image);
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
                $entityManager = $this->getDoctrine()->getManager();
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

        $images = $this->getDoctrine()->getRepository(Image::class)->findByGroupOf10($page-1);
        $countImage = $this->getDoctrine()->getRepository(Image::class)->CountImages();
        $pagesTot = ceil(count($countImage)/8);
        $pages = [];
        for ($i=1; $i <= $pagesTot; $i++)
        { 
            array_push($pages, ['numero' => $i, 'link' => '/import-picture/'.$i]);
        }
        return $this->render('import/import_picture.html.twig', [
            'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
            'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
            'images' => $images,
            'pages' => $pages,
            'currentPage' => $page,
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }
}
