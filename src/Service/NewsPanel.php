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