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
                    'articles' => $this->getDoctrine()->getRepository(Article::class)->findBy(['category' => $category]),
                    'blogPosts' => $this->getDoctrine()->getRepository(BlogPost::class)->findBy(['category' => $category]),
                    'category' => $category,
                ]);
            }
        }
    }
}
