<?php
/**
 * Created by PhpStorm.
 * User: alanjhonnes
 * Date: 3/4/2015
 * Time: 8:57 PM
 */

namespace ACL\MainBundle\Entity;


use Doctrine\ORM\QueryBuilder;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;

class TrainningSessionRepository extends EntityRepository {

    /**
     * Get all active trainning sessions.
     * @return TrainningSession[]
     */
    public function getActiveTrainningSessions(){
        $qb = $this->getQueryWithCategory();
        $qb = $this->addActiveFilter($qb);
        $qb = $this->addOrderByDate($qb);
        return $qb->getQuery()->getResult();
    }

    /**
     * Get all active trainning sessions of category.
     * @return TrainningSession[]
     */
    public function getActiveTrainningSessionsByCategory($categoryId){
        $qb = $this->getQueryWithCategory();
        $qb = $this->addActiveFilter($qb);
        $qb = $this->addCategoryFilter($qb, $categoryId);
        $qb = $this->addOrderByDate($qb);
        return $qb->getQuery()->getResult();
    }

    /**
     * @param $id
     * @return TrainningSession
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTrainningSessionById($id){
        $qb = $this->getQueryWithCategory();
        $qb = $this->addIdFilter($qb, $id);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryWithCategory(){
        return $this->createQueryBuilder('t')
            ->select('t, c')
            ->leftJoin('t.category', 'c');
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @return QueryBuilder
     */
    private function addActiveFilter(QueryBuilder $queryBuilder){
        return $queryBuilder->andWhere('t.date >= :date')
            ->setParameter('date', new \DateTime(), Type::DATE);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $id
     * @return QueryBuilder
     */
    private function addIdFilter(QueryBuilder $queryBuilder, $id){
        return $queryBuilder->andWhere('t.id = :id')
            ->setParameter('id', $id);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $categoryId
     * @return QueryBuilder
     */
    private function addCategoryFilter(QueryBuilder $queryBuilder, $categoryId){
        return $queryBuilder->andWhere('c.id = :categoryId')
            ->setParameter('categoryId', $categoryId);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @return QueryBuilder
     */
    private function addOrderByDate(QueryBuilder $queryBuilder){
        return $queryBuilder->addOrderBy('t.date', 'ASC');
    }
}
