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

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findOneByPathTitle($value): ?Article
    {
        try {
            $value = filter_var($value, FILTER_SANITIZE_STRING);
            if($value != "" && $value !== null && $value !== false)
            {
                return $this->createQueryBuilder('a')
                    ->andWhere('a.pathTitle = :val')
                    ->setParameter('val', $value)
                    ->getQuery()
                    ->getOneOrNullResult()
                ;
            }
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function findArticleByDate()
    {
        try {
            $query = $this->getEntityManager()->createQuery('SELECT a.title, a.pathTitle FROM App\Entity\Article a
                JOIN a.publicationDate d
                ORDER BY d.date DESC');
            $query->setMaxResults(5);
            return $query->getResult();
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function findByGroupOf10($page)
    {
        $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT);
        $page -= 1;
        if($page !== null && $page !== false)
        {
            $offset = $page * 10;
            return $this->createQueryBuilder('a')
                ->innerJoin('App\Entity\Date', 'd')
                ->orderBy('d.date', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }else
        {
            return null;
        }
    }

    public function CountArticle()
    {
        try {
            $query = $this->getEntityManager()->createQuery('SELECT COUNT(a.id) as count FROM App\Entity\Article a');
            return $query->getResult();
        } catch (\Throwable $th) {
            return null;
        }
    }
    

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
