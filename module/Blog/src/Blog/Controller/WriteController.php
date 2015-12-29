<?php
/**
 * Created by PhpStorm.
 * User: HTR14290
 * Date: 21/12/2015
 * Time: 15:46
 */

namespace Blog\Controller;

use Blog\Entity\Article;
use Blog\Form\ArticleForm;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

class WriteController extends AbstractActionController
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
     * Add article
     *
     * @return ViewModel
     */
    public function addAction()
    {
        $em = $this->getEntityManager();
        $form = new ArticleForm($em);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $article = new Article();
            $form->setInputFilter($article->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $article->exchangeArray($form->getData());
                $author = $em->getRepository('User\Entity\User')->findOneById($article->getAuthor());
                $article->setAuthor($author);
                $em->persist($article);
                $em->flush();

                return $this->redirect()->toRoute('blog');
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    /**
     * Edit article
     *
     * @return ViewModel
     */
    public function editAction()
    {
        $em = $this->getEntityManager();
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('blog', array('action' => 'add'));
        }

        try {
            $article = $em->getRepository('Blog\Entity\Article')->findOneById($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('blog', array('action' => 'add'));
        }

        $form = new ArticleForm($em);
        $form->bind($article);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($article->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $author = $em->getRepository('User\Entity\User')->findOneById($article->getAuthor());
                $article->setAuthor($author);
                $em->persist($article);
                $em->flush();

                return $this->redirect()->toRoute('blog');
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    /**
     * Delete article
     *
     * @return ViewModel
     */
    public function deleteAction()
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

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del === 'Yes') {
                $em->remove($article);
                $em->flush();
            }
            return $this->redirect()->toRoute('blog');
        }

        return new ViewModel(array(
            'article'   => $article,
        ));
    }
}