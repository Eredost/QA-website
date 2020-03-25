<?php

namespace App\Repository;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    /**
     * @param Question $question
     * @param int      $page
     * @param int      $maxResults
     *
     * @return mixed
     */
    public function findAllAnswersByQuestionId(Question $question, int $page, int $maxResults)
    {
        $firstResult = ($page - 1) * $maxResults;

        $query = $this->createQueryBuilder('a')
            ->join('a.user', 'u')
            ->addSelect('u')
            ->andWhere('a.question = :question')
            ->setParameter('question', $question)
            ->orderBy('a.createdAt', 'ASC')
            ->setMaxResults($maxResults)
            ->setFirstResult($firstResult)
        ;

        $paginator = new Paginator($query, true);
        $paginator->lastPage = intval(ceil($paginator->count() / $maxResults));
        $paginator->currentPage = intval($page);

        return $paginator;
    }

    // /**
    //  * @return Answer[] Returns an array of Answer objects
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
    public function findOneBySomeField($value): ?Answer
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
