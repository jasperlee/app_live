<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitab3223d4db39ecd6871572a61ec91bb7
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'soweredu\\live\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'soweredu\\live\\' => 
        array (
            0 => __DIR__ . '/../..' . '/live',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitab3223d4db39ecd6871572a61ec91bb7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitab3223d4db39ecd6871572a61ec91bb7::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}