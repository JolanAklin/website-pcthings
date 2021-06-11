<?php
// src/Service/NewsPanel.php
namespace App\Service;

use App\Entity\BlogPost;
use App\Entity\Article;

use Doctrine\ORM\EntityManagerInterface;


class NewsPanel
{
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function BlogsLatest():array
    {
        return $this->em->getRepository(BlogPost::class)->findBlogByDate();
    }

    public function ArticlesLatest():array
    {
        return $this->em->getRepository(Article::class)->findArticleByDate();
    }
}