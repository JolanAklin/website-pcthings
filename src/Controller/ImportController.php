<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\BlogPost;
use App\Entity\Article;
use App\Entity\Image;

class ImportController extends AbstractController
{
    
    public function importPicture($page)
    {
        $images = $this->getDoctrine()->getRepository(Image::class)->findByGroupOf10($page-1);
        $countImage = $this->getDoctrine()->getRepository(Image::class)->CountImages();
        $pagesTot = (count($countImage)+10)/10;
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
        ]);
    }
}
