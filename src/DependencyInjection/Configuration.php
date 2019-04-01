<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ptyhard_json_schema');
        $rootNode
            ->children()
                ->booleanNode('use_jms_serializer')->defaultTrue()->end()
                ->scalarNode('json_file_directory')->defaultNull()->end()
            ->end();

        return $treeBuilder;
    }
}
