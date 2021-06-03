<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Article;
use App\Entity\Category;
use phpDocumentor\Reflection\PseudoTypes\False_;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
            'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
            'categories' => $this->getDoctrine()->getRepository(Category::class)->findall(),
        ]);
    }

    public function categoryList($name)
    {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        if($name !== null && $name !== false)
        {
            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['name' => $name]);
            if($category !== null)
            {
                return $this->render('category/list.html.twig', [
                    'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
                    'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
                    'articles' => $this->getDoctrine()->getRepository(Article::class)->findBy(['category' => $category]),
                    'blogPosts' => $this->getDoctrine()->getRepository(BlogPost::class)->findBy(['category' => $category]),
                    'category' => $category,
                ]);
            }
        }
    }
}
