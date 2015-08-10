<?php

namespace Velikan\Bundle\TubeCrawlerBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class VelikanTubeCrawlerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $modelDir = realpath($this->getPath().'/Resources/config/doctrine/model');

        $mappings = [
            $modelDir => 'Velikan\Bundle\TubeCrawlerBundle\Model'
        ];

        $bundleNameUnderscored = ContainerBuilder::underscore(substr($this->getName(), 0, -6));

        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        if (class_exists($ormCompilerClass)) {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createXmlMappingDriver(
                    $mappings,
                    [$bundleNameUnderscored.'.model_manager_name'],
                    $bundleNameUnderscored.'.backend_type_orm',
                    [$this->getName() => 'Velikan\Bundle\TubeCrawlerBundle\Model']
                )
            );
        }

        $mongoDBCompilerClass = 'Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass';
        if (class_exists($mongoDBCompilerClass)) {
            $container->addCompilerPass(
                DoctrineMongoDBMappingsPass::createXmlMappingDriver(
                    $mappings,
                    [$bundleNameUnderscored.'.model_manager_name'],
                    $bundleNameUnderscored.'.backend_type_mongodb',
                    [$this->getName() => 'Velikan\Bundle\TubeCrawlerBundle\Model']
                )
            );
        }
    }
}
