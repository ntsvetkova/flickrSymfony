<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 31.08.15
 * Time: 10:55
 */

namespace AppBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('app');
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('end_point')
                    ->defaultValue('https://api.flickr.com/services/rest')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}