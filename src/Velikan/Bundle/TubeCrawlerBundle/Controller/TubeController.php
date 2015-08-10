<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Velikan\Bundle\TubeCrawlerBundle\Form\Type\TubeType;

class TubeController extends AbstractCRUDController implements CRUDControllerInterface
{
    public function indexAction()
    {
        return parent::indexAction();
    }

    public function newAction()
    {
        return parent::newAction();
    }

    public function createAction(Request $request)
    {
        return parent::createAction($request);
    }

    public function editAction($id)
    {
        return parent::editAction($id);
    }

    public function updateAction(Request $request, $id)
    {
        return parent::updateAction($request, $id);
    }

    public function deleteAction($id)
    {
        return parent::deleteAction($id);
    }

    public function getObjectName()
    {
        return 'AppBundle:Tube';
    }

    public function getFormType()
    {
        return new TubeType();
    }

    public function getCommonManager()
    {
        return $this->get('velikan_tube_crawler.tube_manager');
    }
}
