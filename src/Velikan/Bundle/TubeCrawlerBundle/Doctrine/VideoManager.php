<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Doctrine;

use Velikan\Bundle\TubeCrawlerBundle\Model\VideoManager as BaseVideoManager;

class VideoManager extends BaseVideoManager
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