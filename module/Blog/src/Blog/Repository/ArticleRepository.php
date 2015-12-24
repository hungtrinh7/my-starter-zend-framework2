<?php
/**
 * Created by PhpStorm.
 * User: HTR14290
 * Date: 21/12/2015
 * Time: 16:02
 */

namespace Blog\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function getArticles()
    {
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->getResult();
    }
}