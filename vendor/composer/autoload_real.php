<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitdeea8b72d93bb78c51b47c3ad5ba002a
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

        spl_autoload_register(array('ComposerAutoloaderInitdeea8b72d93bb78c51b47c3ad5ba002a', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitdeea8b72d93bb78c51b47c3ad5ba002a', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitdeea8b72d93bb78c51b47c3ad5ba002a::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
