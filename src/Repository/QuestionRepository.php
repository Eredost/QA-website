<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @param Request $request
     *
     * @return Paginator
     */
    public function findAllQuestionsWithTags(Request $request)
    {
        $currentPage = $request->query->get('page', 1);
        $maxResults = $request->query->get('maxresults', 10);

        if (!preg_match('/\d+/', $currentPage)
            || $currentPage < 1) {
            $currentPage = 1;
            $request->query->set('page', 1);
        }

        if (!preg_match('/\d+/', $maxResults)
            || $maxResults < 1) {
            $maxResults = 10;
            $request->query->set('maxresults', 10);
        }

        $firstResult = ($currentPage - 1) * $maxResults;

        $query = $this->createQueryBuilder('q')
            ->join('q.tags', 't')
            ->addSelect('t')
            ->orderBy('q.createdAt', 'DESC')
            ->orderBy('q.id', 'ASC')
            ->setMaxResults($maxResults)
            ->setFirstResult($firstResult)
        ;

        if ($searchQ = $request->query->get('q')) {
            $query
                ->orWhere('q.title LIKE :searchQ')
                ->orWhere('q.content LIKE :searchQ')
                ->setParameter('searchQ', '%'.$searchQ.'%')
            ;
        }

        $paginator = new Paginator($query, true);
        $paginator->lastPage = intval(ceil($paginator->count() / $maxResults));
        $paginator->currentPage = intval($currentPage);
        $paginator->maxResults = intval($maxResults);

        return $paginator;
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findQuestionById(int $id)
    {
        return $this->createQueryBuilder('q')
            ->join('q.tags', 't')
            ->addSelect('t')
            ->join('q.user', 'u')
            ->addSelect('u')
            ->andWhere('q.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return Question[] Returns an array of Question objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Question
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
