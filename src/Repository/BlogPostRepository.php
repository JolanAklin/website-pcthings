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

    public function findByWriter($writer)
    {
        try {
            $writer = intval($writer);
            return $this->createQueryBuilder('b')
                ->andWhere('b.writer = :val')
                ->setParameter('val', $writer)
                ->orderBy('b.id', 'DESC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
        } catch (\Throwable $th) {
            die();
        }
    }
    
    public function findByWriterJoined()
    {
        try {
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQueryBuilder()
                ->select('u.username, u.profilPic')
                ->from('App\Entity\BlogPost','b')
                ->innerJoin('App\Entity\User', 'u')
                ->groupBy('u.id')
                ->orderBy('u.username','ASC')
                ->getQuery();
            return $query->getResult();
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
                LIMIT 10
                ';
            $stmt = $conn->prepare($sql);
            $stmt->execute([]);
            return $stmt->fetchAll();
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
