<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5bf6205e1c5dae996c5c5147ed6b13c8
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Phpml\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Phpml\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-ai/php-ml/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5bf6205e1c5dae996c5c5147ed6b13c8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5bf6205e1c5dae996c5c5147ed6b13c8::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}