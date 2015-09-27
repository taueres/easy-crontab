<?php

namespace EasyCrontab;

use EasyCrontab\Crontab;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class CrontabFactory
{
    const RESOURCES_DIRNAME = 'Resources';
    const CONTAINER_CONFIG_FILENAME = 'container_config.xml';

    /**
     * @var Crontab
     */
    private static $crontab;

    /**
     * @return Crontab
     */
    public static function getCrontab() {

        if (null === self::$crontab) {
            $container = self::getContainer();
            self::$crontab = $container->get('crontab');
        }

        return self::$crontab;
    }

    /**
     * @return ContainerInterface
     */
    private static function getContainer() {

        $resourcePath = __DIR__ . '/' . self::RESOURCES_DIRNAME;
        $container = new ContainerBuilder();
        $loader = new XmlFileLoader($container, new FileLocator($resourcePath));
        $loader->load(self::CONTAINER_CONFIG_FILENAME);

        return $container;
    }
}
