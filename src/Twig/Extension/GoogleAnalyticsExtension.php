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
     * @var bool
     */
    protected $firstTracker = true;

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
     * @param string $name
     *
     * @return mixed
     */
    public function tracker($name = 'default')
    {
        $key = 'endroid_google_analytics.'.$name;

        if (!$this->container->hasParameter($key)) {
            return '';
        }

        $tracker = $this->container->getParameter($key);
        $tracker['name'] = $name;

        $html = $this->container->get('templating')->render('GoogleAnalyticsBundle::tracker.html.twig', array('tracker' => $tracker, 'loadGa' => $this->firstTracker));

        $this->firstTracker = false;

        return $html;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'endroid_google_analytics';
    }
}
