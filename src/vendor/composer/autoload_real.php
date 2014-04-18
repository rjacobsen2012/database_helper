<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit25c1cf7c4c101eeac6b1a6d39b428071
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit25c1cf7c4c101eeac6b1a6d39b428071', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader();
        spl_autoload_unregister(array('ComposerAutoloaderInit25c1cf7c4c101eeac6b1a6d39b428071', 'loadClassLoader'));

        $vendorDir = dirname(__DIR__);
        $baseDir = dirname(dirname($vendorDir));

        $map = require __DIR__ . '/autoload_namespaces.php';
        foreach ($map as $namespace => $path) {
            $loader->set($namespace, $path);
        }

        $map = require __DIR__ . '/autoload_psr4.php';
        foreach ($map as $namespace => $path) {
            $loader->setPsr4($namespace, $path);
        }

        $classMap = require __DIR__ . '/autoload_classmap.php';
        if ($classMap) {
            $loader->addClassMap($classMap);
        }

        $loader->register(true);

        $includeFiles = require __DIR__ . '/autoload_files.php';
        foreach ($includeFiles as $file) {
            composerRequire25c1cf7c4c101eeac6b1a6d39b428071($file);
        }

        return $loader;
    }
}

function composerRequire25c1cf7c4c101eeac6b1a6d39b428071($file)
{
    require $file;
}