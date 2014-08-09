<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Bundle\GoogleAnalyticsBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class EndroidGoogleAnalyticsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        foreach ($configs as $config) {
            if (isset($config['trackers']) && is_array($config['trackers'])) {
                foreach ($config['trackers'] as $identifier => $code) {
                    $container->setParameter('endroid_google_analytics.'.$identifier, $code);
                }
            }

            $trackDisplayFeatures = isset($config['track_display_features'])? $config['track_display_features']:false;
            $container->setParameter('endroid_google_analytics.track_display_features', $trackDisplayFeatures);
        }
    }
}
