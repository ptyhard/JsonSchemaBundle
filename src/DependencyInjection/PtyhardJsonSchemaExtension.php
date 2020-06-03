<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PtyhardJsonSchemaExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $jsonFileDirectory = $config['json_file_directory'];
        if (null === $jsonFileDirectory) {
            $jsonFileDirectory = $container->getParameter('kernel.project_dir') . '/public/json_schema';
        }

        $container->setParameter('json_schema_bundle.json_file_directory', $jsonFileDirectory);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }
}
