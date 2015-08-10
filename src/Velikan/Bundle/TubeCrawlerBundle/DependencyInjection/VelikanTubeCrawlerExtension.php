<?php

namespace Velikan\Bundle\TubeCrawlerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class VelikanTubeCrawlerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $managerService = 'velikan_tube_crawler.entity_manager';
        $doctrineService = 'doctrine';

        $container->setParameter('velikan_tube_crawler.model_manager_name', $config['model_manager_name']);
        switch ($config['db_driver']) {
            case 'orm':
                $container->setParameter('velikan_tube_crawler.backend_type_orm', true);

                break;
            case 'mongodb':
                $container->setParameter('velikan_tube_crawler.backend_type_mongodb', true);
                $managerService = 'velikan_tube_crawler.document_manager';
                $doctrineService = 'doctrine_mongodb';

                break;
        }

        $loader->load(sprintf('%s.xml', $config['db_driver']));

        $definition = $container->getDefinition($managerService);
        $definition->setFactory([
            new Reference($doctrineService),
            'getManager',
        ]);

        $container->setAlias('velikan_tube_crawler.tube_manager', $config['service']['tube_manager']);
        $container->setAlias('velikan_tube_crawler.video_manager', $config['service']['video_manager']);

        $this->setClassParameters($config, $container, [
            'tube_class' => 'velikan_tube_crawler.model.tube.class',
            'video_class' => 'velikan_tube_crawler.model.video.class',
        ]);

        $loader->load('services.xml');
    }

    protected function setClassParameters(array $config, ContainerBuilder $container, array $parameters)
    {
        foreach ($parameters as $name => $value) {
            $container->setParameter($value, $config[$name]);
        }
    }
}
