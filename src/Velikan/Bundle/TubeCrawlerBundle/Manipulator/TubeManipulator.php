<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Manipulator;

use Velikan\Bundle\TubeCrawlerBundle\Model\Video;

class TubeManipulator extends AbstractManipulator
{
    public function testAndCreateVideo(Video $video)
    {
        $this->manager->createObject($video);
        $this->manager->getObjectManager()->flush();
    }
}