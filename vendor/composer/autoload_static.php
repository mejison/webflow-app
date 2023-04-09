<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit553ef1719bd444a02058fc4d5e322980
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit553ef1719bd444a02058fc4d5e322980::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit553ef1719bd444a02058fc4d5e322980::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit553ef1719bd444a02058fc4d5e322980::$classMap;

        }, null, ClassLoader::class);
    }
}
