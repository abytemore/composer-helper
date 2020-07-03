<?php

namespace abytemore\ComposerHelper;

use Composer\Installer\InstallerEvent;
use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class ComposerHelper
{
    public static function preUpdate(Event $event)
    {
        $composer = $event->getComposer();
        // do stuff
    }

    public static function postUpdate(Event $event)
    {
        $composer = $event->getComposer();
        // do stuff
    }

    public static function preInstall(InstallerEvent $event)
    {
        $composer = $event->getComposer();
        // do stuff
    }
    public static function postInstall(InstallerEvent $event)
    {
        $composer = $event->getComposer();
        // do stuff
    }

    public static function postAutoloadDump(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        require $vendorDir . '/autoload.php';

//        some_function_from_an_autoloaded_file();
    }

    public static function postPackageInstall(PackageEvent $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
        // do stuff
    }

    public static function warmCache(Event $event)
    {
        // make cache toasty
    }
}
