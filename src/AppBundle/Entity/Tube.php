<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Velikan\Bundle\TubeCrawlerBundle\Model\Tube as BaseTube;

/**
 * Tube
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Tube extends BaseTube
{
}
