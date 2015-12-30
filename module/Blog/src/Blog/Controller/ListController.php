<?php
/**
 * Created by PhpStorm.
 * User: HTR14290
 * Date: 21/12/2015
 * Time: 15:46
 */

namespace Blog\Controller;

use Blog\Entity\Article;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

class ListController extends AbstractActionController
{
    protected $em;

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    /**
     * List all articles
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $em = $this->getEntityManager();
        $articles = $em->getRepository('Blog\Entity\Article')->getArticles();

        return new ViewModel(array(
           'articles'  => $articles,
        ));
    }

    /**
     * display the article from its id
     *
     * @return ViewModel
     */
    public function showAction()
    {
        $em = $this->getEntityManager();
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('blog');
        }

        try {
            $article = $em->getRepository('Blog\Entity\Article')->findOneById($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('blog');
        }

        return new ViewModel(array(
           'article' => $article,
        ));
    }

    /**
     * test ajax
     *
     * @return \Zend\Stdlib\ResponseInterface
     */
    public function testAjaxAction()
    {
        $view = new ViewModel();
        $view->setTemplate('blog/ajax/test.phtml')
            ->setTerminal(true)
            ->setVariables(array(
                'name'  => $this->zfcUserAuthentication()->getIdentity()->getUsername(),
            ));

        $htmlOutput = $this->getServiceLocator()
            ->get('viewrenderer')
            ->render($view);

        $jsonModel = new JsonModel();
        $jsonModel->setVariables(array(
            'html' => $htmlOutput,
        ));

        return $jsonModel;
    }
}