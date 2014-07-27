<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Bundle\GoogleAnalyticsBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GoogleAnalyticsExtension extends \Twig_Extension implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'google_analytics_tracker' => new \Twig_Function_Method($this, 'tracker', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders the tracker.
     *
     * @param  string $identifier
     * @return mixed
     */
    public function tracker($identifier = 'default')
    {
        $code = $this->container->getParameter('endroid_google_analytics.'.$identifier);

        if (!$code) {
            return '';
        }

        return $this->container->get('templating')->render('EndroidGoogleAnalyticsBundle::tracker.html.twig', array('code' => $code));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'endroid_google_analytics';
    }
}
