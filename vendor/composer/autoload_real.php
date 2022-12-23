<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit280d8a86b1722146e3920c90a8d66ffb
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit280d8a86b1722146e3920c90a8d66ffb', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit280d8a86b1722146e3920c90a8d66ffb', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit280d8a86b1722146e3920c90a8d66ffb::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
