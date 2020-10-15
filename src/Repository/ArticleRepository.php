<?php

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
            die();
        }
    }

    public function findArticleByDate()
    {
        try {
            $conn = $this->getEntityManager()->getConnection();
            $sql = '
                SELECT title, path_title FROM article a
                INNER JOIN date ON date.id = publication_date_id
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
            die();
        }
    }

    public function CountArticle()
    {
        try {
            $conn = $this->getEntityManager()->getConnection();
            $sql = '
                SELECT COUNT(*) FROM article
                ';
            $stmt = $conn->prepare($sql);
            $stmt->execute([]);
            return $stmt->fetchAll();
        } catch (\Throwable $th) {
            die();
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
