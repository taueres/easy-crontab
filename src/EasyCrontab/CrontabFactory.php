<?php

namespace EasyCrontab;

use EasyCrontab\Crontab;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class CrontabFactory
{
    private static $RESOURCE_PATH = __DIR__ . '/Resources';
    private static $RESOURCE_FILE = 'container_config.xml';

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

        $container = new ContainerBuilder();
        $loader = new XmlFileLoader($container, new FileLocator(self::$RESOURCE_PATH));
        $loader->load(self::$RESOURCE_FILE);

        return $container;
    }
}
