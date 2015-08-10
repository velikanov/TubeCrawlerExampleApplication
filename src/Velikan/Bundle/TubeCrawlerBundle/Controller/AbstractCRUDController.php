<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Controller;


use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Velikan\Bundle\TubeCrawlerBundle\Model\CommonManagerInterface;

abstract class AbstractCRUDController extends Controller
{
    protected function indexAction()
    {
        $entities = $this->getCommonManager()->findAll();

        return $this->render('VelikanTubeCrawlerBundle:crud:index.html.twig', [
            'entities' => $entities,
            'heading' => $this->getObjectShortClassName().' list',
            'crud_path' => $this->getObjectCrudPath(),
        ]);
    }

    protected function newAction()
    {
        $objectClassName = $this->getFullObjectName();
        $object = new $objectClassName();

        $form = $this->createInteractionForm($object, 'create', 'POST', 'Create');

        return $this->render('VelikanTubeCrawlerBundle:crud:new.html.twig', [
            'form' => $form->createView(),
            'heading' => 'New '.strtolower($this->getObjectShortClassName()),
            'crud_path' => $this->getObjectCrudPath(),
        ]);
    }

    protected function createAction(Request $request)
    {
        $objectClassName = $this->getFullObjectName();
        $object = new $objectClassName();

        $form = $this->createInteractionForm($object, 'create', 'POST', 'Create');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getCommonManager()->createObject($object);
            $this->getCommonManager()->getObjectManager()->flush();

            return $this->redirect($this->generateUrl($this->getObjectCrudPath().'index'));
        }

        return $this->render('VelikanTubeCrawlerBundle:crud:new.html.twig', [
            'form' => $form->createView(),
            'heading' => 'New '.strtolower($this->getObjectShortClassName()),
            'crud_path' => $this->getObjectCrudPath(),
        ]);
    }

    protected function editAction($id)
    {
        $object = $this->findObjectById($id);

        $form = $this->createInteractionForm($object, 'update', 'PUT', 'Update', [
            'id' => $object->getId(),
        ]);

        return $this->render('VelikanTubeCrawlerBundle:crud:edit.html.twig', [
            'form' => $form->createView(),
            'heading' => 'Edit '.strtolower($this->getObjectShortClassName()).' "'.$object.'"',
            'crud_path' => $this->getObjectCrudPath(),
        ]);
    }

    protected function updateAction(Request $request, $id)
    {
        $object = $this->findObjectById($id);

        $form = $this->createInteractionForm($object, 'update', 'PUT', 'Update', [
            'id' => $object->getId(),
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getCommonManager()->getObjectManager()->flush();

            return $this->redirect($this->generateUrl($this->getObjectCrudPath().'index'));
        }

        return $this->render('VelikanTubeCrawlerBundle:crud:edit.html.twig', [
            'form' => $form->createView(),
            'heading' => 'Edit '.strtolower($this->getObjectShortClassName()).' "'.$object.'"',
            'crud_path' => $this->getObjectCrudPath(),
        ]);
    }

    protected function deleteAction($id)
    {
        $object = $this->findObjectById($id);

        $this->getCommonManager()->removeObject($object);
        $this->getCommonManager()->getObjectManager()->flush();

        return $this->redirect($this->generateUrl($this->getObjectCrudPath().'index'));
    }

    protected function createInteractionForm($object, $actionShortName, $method, $submitLabel, $routeParameters = [])
    {
        $form = $this->createForm($this->getFormType(), $object, [
            'action' => $this->generateUrl($this->getObjectCrudPath().$actionShortName, $routeParameters),
            'method' => $method,
        ]);

        $form->add('submit', 'submit', [
            'label' => $submitLabel,
        ]);

        return $form;
    }

    /**
     * @param $id
     * @return object
     * @throws NotFoundHttpException
     */
    protected function findObjectById($id)
    {
        $object = $this->getCommonManager()->find($id);

        if (null === $object) {
            throw $this->createNotFoundException($this->getObjectShortClassName().' not found');
        }

        return $object;
    }

    /**
     * @return ClassMetadata
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Exception
     */
    protected function getObjectMetadata()
    {
        return $this->getCommonManager()->getMetadataForObject();
    }

    /**
     * @return string
     */
    protected function getFullObjectName()
    {
        return $this->getObjectMetadata()->getName();
    }

    /**
     * @return string
     */
    protected function getObjectShortClassName()
    {
        $reflectionClass = new \ReflectionClass($this->getObjectMetadata()->getName());

        return $reflectionClass->getShortName();
    }

    /**
     * @return string
     */
    protected function getObjectCrudPath()
    {
        return 'velikan_tube_crawler_'.strtolower($this->getObjectShortClassName()).'_';
    }

    abstract public function getObjectName();
    abstract public function getFormType();
    /** @return CommonManagerInterface */
    abstract public function getCommonManager();
}