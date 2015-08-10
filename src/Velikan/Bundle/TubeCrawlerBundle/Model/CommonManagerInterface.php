<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;

interface CommonManagerInterface
{
    public function getMetadataForObject();

    public function find($id);
    public function findAll();

    public function createObject($object);
    public function removeObject($object);

    /** @return ObjectManager */
    public function getObjectManager();
}