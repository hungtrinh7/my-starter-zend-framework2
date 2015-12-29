<?php
namespace Blog\Service\Factory;


use Blog\Repository\ArticleRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ArticleServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return ArticleRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $articleRepository = $entityManager->getRepository('Blog\Entity\Article');

        return new ArticleRepository(
            $entityManager,
            $articleRepository
        );
    }
}