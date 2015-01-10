<?php

namespace Comments\Mapper;

use Doctrine\ORM\EntityManager;
use ZfModule\Mapper\Module as Module;
use Comments\Options\CommentOptions;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * comment mapper uses doctrine
 * @author gerard
 */
abstract class Comment
{
    abstract protected function getRelatorField(); 
    abstract protected function setRelatorField($rf);
    abstract protected function getFkField();
    abstract protected function setFkField($fk);
    
    /**
     * to be set in factory
     * @var \Doctrine\ORM\EntityManager
     */    
    protected $em;
    
    
    /**
     * to be set in factory
     * @var \Comments\Options\CommentOptions
     */
    protected $options;
    

    /**
     * some params required
     * @param \Doctrine\ORM\EntityManager $em
     * @param \Comments\Options\CommentOptions $options
     */
    public function __construct(EntityManager $em, CommentOptions $options) 
    {
        $this->em = $em;
        $this->options = $options;
    }
    /**
     * write to db here 
     * @param \Comments\Entity\Comment $entity
     * @return \Comments\Entity\Comment
     */
    public function insert($entity) 
    {
        return $this->persist($entity);
    }
     /**
     * write to db here 
     * @param \Comments\Entity\Comment $entity
     * @return \Comments\Entity\Comment
     */
    public function update($entity) {
        return $this->persist($entity);
    }
     /**
     * write to db here 
     * @param \Comments\Entity\Comment $entity
     * @return \Comments\Entity\Comment
     */
    protected function persist($entity) {
        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }
     /**
     * Removes an entity
     * @param \Comments\Entity\Comment $entity
     * @throws ORMInvalidArgumentException
     */
    public function delete($entity)
    {
       $this->em->remove($entity);
       $this->em->flush();
    }

    
     /**
     * gotta format colums properly eg. "c.xgy, c.xxx"
     * @param string $columns
     * @return Doctrine/ORM/QueryBuilder 
     */
    public function getBaseQueryBuilder($columns = '')
    {
        $qb = $this->em->createQueryBuilder();
       
        $qb->add('select', 'c')
           ->add('from', "Comments\Entity\Comment c $columns");
        
        return $qb;
    }
    /**
     * find all fires a not implemented event
     * @param int $limit
     * @param string $orderBy
     * @param string $sort
     * @return array
     */
    public function findAll($limit= null, $orderBy = null, $sort = 'ASC')
    {
         /** @var qb Doctrine/ORM/QueryBuilder */
       $qb = $this->getBaseQueryBuilder();
      
        if ($orderBy) {
            $qb->orderBy('c.'.$orderBy, $sort);
        }
         /** @var q \Doctrine\ORM\Query */
        $q = $qb->getQuery();
        if ($limit) {          
            $q->setMaxResults($limit);
        } 
        $result = $q->getResult();
        $this->postRead($result);
        
        return $result;
    }
    
    /**
     * does a where with the main entity.$by = $id
     * @param strin $by
     * @param mixed $id
     * @param int $limit
     * @param string $orderBy
     * @param string $sort
     * @return array
     */
    public function findBy($by, $id, $limit= null, $orderBy = null, $sort = 'ASC')
    {
         /** @var qb Doctrine/ORM/QueryBuilder */
       $qb = $this->getBaseQueryBuilder();
      
        if ($orderBy) {
            $qb->orderBy('c.'.$orderBy, $sort);
        }
       
        $qb->where('c.'.$by .'= :id');
        $qb->setParameter('id', $id);
       
        /** @var q \Doctrine\ORM\Query */
        $q = $qb->getQuery(); 
        if ($limit) {          
            $q->setMaxResults($limit);
        } 
        $result = $q->getResult();
        $this->postRead($result);
        
        return $result;
    }
    /**
     * finds only elements that are parents with a user specified where clause
     * @param string $where
     * @param mixed $id
     * @param int $limit
     * @param string $orderBy
     * @param string $sort
     * @return array
     */
    public function findParentsWhere($where, $id, $limit= null, $orderBy = null, $sort = 'ASC')
    {
         /** @var qb Doctrine/ORM/QueryBuilder */
        $qb = $this->em->createQueryBuilder();
        $entityName = $this->entityName;
        $qb->add('select', 'c')
           ->add('from', "$entityName c");
    
        if ($orderBy) {
            $qb->orderBy('c.'.$orderBy , $sort); 
        }
        $relatorField = $this->getRelatorField();
        $fkField = $this->getFkField();  
       
        $qb->join('c.'.$relatorField, 'r', $qb->expr()->eq('r.'.$fkField, 1));
        $qb->where('c.hasParent = 0');

        /** @var q \Doctrine\ORM\Query */
        $q = $qb->getQuery();
        if ($limit) {          
            $q->setMaxResults($limit);
        } 
        $result = $q->getResult();

        return $result;
    }
    /**
     * uses options
     * @return string
     */
    public function getCommentEntityClass()
    {
        return $this->options->getCommentEntityClassName();
    }
    /**
     * uses options
     * @return string
     */
    public function getUserEntityClass()
    {
        return $this->options->getUserEntityClassName();
    }
    /**
     * get the em set in contructor
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }
}
