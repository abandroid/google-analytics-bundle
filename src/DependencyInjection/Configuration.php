<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Bundle\GoogleAnalyticsBundle\DependencyInjection;

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

        $treeBuilder
            ->root('endroid_google_analytics')
                ->children()
                    ->arrayNode('trackers')
                        ->prototype('array')
                            ->beforeNormalization()
                                ->ifString()
                                ->then(function ($property_id) {
                                    return array('property_id' => $property_id);
                                })
                            ->end()
                            ->children()
                                ->scalarNode('property_id')->isRequired()->end()
                                ->booleanNode('require_display_features')
                                    ->defaultFalse()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
