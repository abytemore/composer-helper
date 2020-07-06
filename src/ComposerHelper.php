<?php
namespace abytemore\ComposerHelper;

use Composer\Installer\InstallerEvent;
use Composer\Script\Event;
use Composer\Installer\PackageEvent;
use Composer\Script\ScriptEvents;

class ComposerHelper
{

    /**
     * Composer PRE-INSTALL event
     * @param Event $event
     */
    public static function preInstall(Event $event)
    {
        $ach = new AbstractComposerHelper($event);
        $ach->composerPreInstall();
    }

    /**
     * Composer POST-INSTALL event
     * @param Event $event
     */
    public static function postInstall(Event $event)
    {
        $ach = new AbstractComposerHelper($event);
        $ach->composerPostInstall();
    }

}
