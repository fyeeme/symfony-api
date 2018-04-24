<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Codeages\Biz\Framework\Provider\DoctrineServiceProvider;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    const CONFIG_EXITS = '.{php,xml,yaml,yml}';

    public function getCacheDir()
    {
        return $this->getProjectDir() . '/var/cache/' . $this->environment;
    }

    public function getLogDir()
    {
        return $this->getProjectDir() . '/var/log';
    }

    /**
     * Boots the current kernel.
     */
    public function boot()
    {
        parent::boot();
        $this->initializeKernel();
    }

    /**
     * The extension point similar to the Bundle::build() method.
     *
     * Use this method to register compiler passes and manipulate the container during the building process.
     */
    protected function build(ContainerBuilder $container)
    {
    }

    public function registerBundles()
    {
        $contents = require $this->getProjectDir() . '/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                yield new $class();
            }
        }
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->setParameter('container.autowiring.strict_mode', true);
        $container->setParameter('container.dumper.inline_class_loader', true);
        $confDir = $this->getProjectDir() . '/config';
        $loader->load($confDir . '/packages/*' . self::CONFIG_EXITS, 'glob');
        if (is_dir($confDir . '/packages/' . $this->environment)) {
            $loader->load($confDir . '/packages/' . $this->environment . '/**/*' . self::CONFIG_EXITS, 'glob');
        }
        $loader->load($confDir . '/services' . self::CONFIG_EXITS, 'glob');
        $loader->load($confDir . '/services_' . $this->environment . self::CONFIG_EXITS, 'glob');

    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $confDir = $this->getProjectDir() . '/config';
        if (is_dir($confDir . '/routes/')) {
            $routes->import($confDir . '/routes/*' . self::CONFIG_EXITS, '/', 'glob');
        }
        if (is_dir($confDir . '/routes/' . $this->environment)) {
            $routes->import($confDir . '/routes/' . $this->environment . '/**/*' . self::CONFIG_EXITS, '/', 'glob');
        }
        $routes->import($confDir . '/routes' . self::CONFIG_EXITS, '/', 'glob');

    }

    protected function initializeKernel()
    {
        $biz = $this->getContainer()->get('biz');
        $biz->register(new DoctrineServiceProvider());
        $biz['isDebug'] = $this->isDebug();
    }
}
