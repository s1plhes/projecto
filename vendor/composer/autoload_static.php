<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit280d8a86b1722146e3920c90a8d66ffb
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Dcblogdev\\PdoWrapper\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Dcblogdev\\PdoWrapper\\' => 
        array (
            0 => __DIR__ . '/..' . '/dcblogdev/pdo-wrapper/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit280d8a86b1722146e3920c90a8d66ffb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit280d8a86b1722146e3920c90a8d66ffb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit280d8a86b1722146e3920c90a8d66ffb::$classMap;

        }, null, ClassLoader::class);
    }
}
