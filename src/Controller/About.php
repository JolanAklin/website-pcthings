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
use App\Entity\Article;
use App\Entity\BlogPost;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Doctrine\Persistence\ManagerRegistry;

class About extends AbstractController
{
    public function AboutUser(ManagerRegistry $doctrine, string $username)
    {
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        if ($username != "" && $username !== null && $username !== false)
        {
            $user = $doctrine->getRepository(User::class)->findOneByUserName($username);
            if($user)
            {
                return $this->render('about_user.html.twig', [
                    'user' => $user,
                ]);
            }
        }
        return new NotFoundHttpException();
    }
}
