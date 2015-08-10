<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;

abstract class AbstractCommonManager implements CommonManagerInterface
{
    protected $objectManager;
    protected $repository;
    private $class;

    public function __construct(ObjectManager $objectManager, $class)
    {
        $this->objectManager = $objectManager;
        $this->repository = $this->objectManager->getRepository($class);
        $this->class = $class;
    }

    public function getMetadataForObject()
    {
        return $this->objectManager->getClassMetadata($this->class);
    }

    public function createObject($object)
    {
        $this->objectManager->persist($object);
    }

    public function removeObject($object)
    {
        $this->objectManager->remove($object);
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }
}