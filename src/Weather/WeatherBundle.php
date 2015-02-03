<?php

namespace Weather;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\TwigBundle\DependencyInjection\Compiler\TwigEnvironmentPass;
use Symfony\Bundle\TwigBundle\DependencyInjection\Compiler\TwigLoaderPass;
use Symfony\Bundle\TwigBundle\DependencyInjection\Compiler\ExceptionListenerPass;
use Symfony\Bundle\TwigBundle\DependencyInjection\Compiler\ExtensionPass;

/**
 * Bundle.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class WeatherBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
