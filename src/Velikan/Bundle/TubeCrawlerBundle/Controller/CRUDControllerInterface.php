<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

interface CRUDControllerInterface
{
    public function getObjectName();
    public function getFormType();
    public function getCommonManager();

    public function indexAction();
    public function newAction();
    public function createAction(Request $request);
    public function editAction($id);
    public function updateAction(Request $request, $id);
    public function deleteAction($id);
}