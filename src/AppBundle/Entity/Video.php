<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Velikan\Bundle\TubeCrawlerBundle\Model\Video as BaseVideo;

/**
 * Video
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Video extends BaseVideo
{
}
