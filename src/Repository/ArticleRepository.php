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

    public function Search($searchValue)
    {
        $searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING);
        if($searchValue !== null && $searchValue !== false)
        {
            $conn = $this->getEntityManager()->getConnection();

            $sql = 'SELECT path_title, image.path, article.title, description, date.date FROM article
            JOIN image ON thumbnail_id = image.id
            JOIN date ON publication_date_id = date.id
            WHERE MATCH(article.title, description, content_indexable) AGAINST(:searchValue) 
            ORDER BY MATCH(article.title, description, content_indexable) AGAINST(:searchValue) DESC LIMIT 10';

            $stmt = $conn->prepare($sql);
            $resultset = $stmt->executeQuery([':searchValue' => $searchValue]);

            // returns an array of arrays (i.e. a raw data set)
            return $stmt->fetchAllAssociative();
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
