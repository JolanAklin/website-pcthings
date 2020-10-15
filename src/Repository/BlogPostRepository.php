<?php

namespace App\Repository;

use App\Entity\BlogPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
            $writer = intval($writer);
            $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT);
            $page -= 1;
            if($page !== null && $page !== false)
            {
                $offset = $page * 10;
                return $this->createQueryBuilder('b')
                    ->innerJoin('App\Entity\Date', 'd')
                    ->andWhere('b.writer = :val')
                    ->setParameter('val', $writer)
                    ->orderBy('d.date', 'DESC')
                    ->setFirstResult($offset)
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult();
            }
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
                    ->select('u.username, u.profilPic')
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

    public function findBlogByDate()
    {
        try {
            $conn = $this->getEntityManager()->getConnection();
            $sql = '
                SELECT title, username FROM blog_post b
                INNER JOIN date ON date.id = publication_date_id
                INNER JOIN user ON user.id = writer_id
                ORDER BY date.date DESC
                LIMIT 5
                ';
            $stmt = $conn->prepare($sql);
            $stmt->execute([]);
            return $stmt->fetchAll();
        } catch (\Throwable $th) {
            die();
        }
    }

    public function CountBlogPostWriter()
    {
        try {
            $conn = $this->getEntityManager()->getConnection();
            $sql = '
                SELECT COUNT(DISTINCT user.id) as count FROM user
                INNER JOIN blog_post ON user.id = writer_id
                INNER JOIN date ON date.id = publication_date_id
                ';
            $stmt = $conn->prepare($sql);
            $stmt->execute([]);
            return $stmt->fetchAll();
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
                $conn = $this->getEntityManager()->getConnection();
                $sql = '
                    SELECT COUNT(*) as count FROM blog_post
                    INNER JOIN user on user.id = blog_post.writer_id
                    WHERE user.username = :user
                    ';
                $stmt = $conn->prepare($sql);
                $stmt->execute(['user' => $user]);
                return $stmt->fetchAll();
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
