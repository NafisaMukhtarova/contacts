<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd7575e981f1f6b5096a60d8bf69c4aa8
{
    public static $prefixesPsr0 = array (
        'H' => 
        array (
            'Handlebars' => 
            array (
                0 => __DIR__ . '/..' . '/salesforce/handlebars-php/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitd7575e981f1f6b5096a60d8bf69c4aa8::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitd7575e981f1f6b5096a60d8bf69c4aa8::$classMap;

        }, null, ClassLoader::class);
    }
}