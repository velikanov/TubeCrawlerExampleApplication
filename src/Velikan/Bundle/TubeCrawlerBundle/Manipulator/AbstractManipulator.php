<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Manipulator;

use Velikan\Bundle\TubeCrawlerBundle\Model\AbstractCommonManager;

abstract class AbstractManipulator
{
    protected $manager;

    public function __construct(AbstractCommonManager $manager)
    {
        $this->manager = $manager;
    }

    public function find($id)
    {
        return $this->manager->find($id);
    }

    public function findAll()
    {
        return $this->manager->findAll();
    }
}