<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Form\Type;

use AppBundle\Entity\Tube;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('title', 'text')
            ->add('tube', 'entity', [
                'class' => 'Velikan\Bundle\TubeCrawlerBundle\Model\Tube',
            ])
        ;
    }

    public function getName()
    {
        return 'video_type';
    }
}