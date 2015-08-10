<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Doctrine;

use Velikan\Bundle\TubeCrawlerBundle\Model\TubeManager as BaseTubeManager;

class TubeManager extends BaseTubeManager
{
    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }
}