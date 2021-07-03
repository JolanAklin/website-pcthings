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

use App\Entity\BlogPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method BlogPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPost[]    findAll()
 * @method BlogPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPost::class);
    }

    public function findByWriter($writer, $page)
    {
        try {
            $writer = filter_var($writer, FILTER_SANITIZE_NUMBER_INT);
            $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT);
            $page -= 1;
            if($page !== null && $page !== false)
            {
                $offset = $page * 10;
                $query = $this->getEntityManager()->createQuery('SELECT b FROM App\Entity\BlogPost b
                    JOIN b.publicationDate d
                    JOIN b.writer u
                    WHERE u.id = ?1
                    ORDER BY d.date DESC');
                $query->setParameter(1, $writer);
                $query->setFirstResult($offset);
                $query->setMaxResults(10);
                return $query->getResult();
            }
        } catch (\Throwable $th) {
            die();
        }
    }

    public function Search($searchValue)
    {
        $searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING);
        if($searchValue !== null && $searchValue !== false)
        {
            $conn = $this->getEntityManager()->getConnection();

            $sql = 'SELECT blog_post.id, title, user.username, user.profil_pic, date.date FROM blog_post
                JOIN user ON writer_id = user.id
                JOIN date ON publication_date_id = date.id
                WHERE MATCH(blog_post.title, content_indexable) AGAINST(:searchValue) 
                ORDER BY MATCH(blog_post.title, content_indexable) AGAINST(:searchValue) DESC LIMIT 10';

            $stmt = $conn->prepare($sql);
            $resultset = $stmt->executeQuery([':searchValue' => $searchValue]);

            // returns an array of arrays (i.e. a raw data set)
            return $stmt->fetchAllAssociative();
        }
    }
    
    public function findBlogByDate()
    {
        try {
            $query = $this->getEntityManager()->createQuery('SELECT b.title, u.username, b.id FROM App\Entity\BlogPost b
                JOIN b.publicationDate d
                JOIN b.writer u
                ORDER BY d.date DESC');
            $query->setMaxResults(5);
            return $query->getResult();
        } catch (\Throwable $th) {
            die();
        }
    }

    public function findByWriterJoined($page)
    {
        try {
            $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT);
            $page -= 1;
            if($page !== null && $page !== false)
            {
                $offset = $page * 10;
                $entityManager = $this->getEntityManager();
                $query = $entityManager->createQueryBuilder()
                    ->select('u.username, u.profilPic', 'u.displayedNickName')
                    ->from('App\Entity\BlogPost','b')
                    ->innerJoin('App\Entity\User', 'u')
                    ->innerJoin('App\Entity\Date', 'd')
                    ->groupBy('u.id')
                    ->orderBy('max(d.date)','DESC')
                    ->setFirstResult($offset)
                    ->setMaxResults(10)
                    ->getQuery();
                return $query->getResult();
                
            }
        } catch (\Throwable $th) {
            die();
        }
    }

    public function CountBlogPostWriter()
    {
        try {
            $query = $this->getEntityManager()->createQuery('SELECT COUNT(DISTINCT u.id) as count FROM App\Entity\BlogPost b
                JOIN b.writer u
                JOIN b.publicationDate d');
            return $query->getResult();
        } catch (\Throwable $th) {
            die();
        }
    }

    public function CountBlogPostByUser($user)
    {
        try {
            $user = filter_var($user, FILTER_SANITIZE_STRING);
            if($user !== null && $user !== false)
            {
                $query = $this->getEntityManager()->createQuery('SELECT COUNT(b.id) as count FROM App\Entity\BlogPost b JOIN b.writer u WHERE u.username = :user')
                ->setParameter('user', $user);
                return $query->getResult();
            }
        } catch (\Throwable $th) {
            die();
        }
    }

    // /**
    //  * @return BlogPost[] Returns an array of BlogPost objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlogPost
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
