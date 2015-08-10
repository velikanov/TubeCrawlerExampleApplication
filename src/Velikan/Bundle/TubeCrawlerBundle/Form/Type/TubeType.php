<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Form\Type;

use AppBundle\Entity\Tube;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TubeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('name', 'text')
            ->add('scheme', 'choice', [
                'choices' => Tube::$schemeList,
            ])
            ->add('host', 'text')
            ->add('urn', 'text')
            ->add('startingPageNumber', 'integer')
            ->add('canFetchMultithreaded', 'checkbox')
            ->add('threadCount', 'integer')
            ->add('videoBlockSelector', 'textarea')
            ->add('videoUriSelector', 'textarea')
            ->add('videoImageSelector', 'textarea')
            ->add('videoTitleSelector', 'textarea')
        ;
    }

    public function getName()
    {
        return 'tube_type';
    }
}