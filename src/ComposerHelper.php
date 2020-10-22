<?php
namespace ComposerHelper;

use Composer\Installer\InstallerEvent;
use Composer\Script\Event;
use Composer\Installer\PackageEvent;
use Composer\Script\ScriptEvents;
use Symfony\Component\Dotenv\Dotenv;

class ComposerHelper
{
    const DEV = 'dev';

    /**
     * Composer PRE-INSTALL event
     * @param Event $event
     */
    public static function preInstall(Event $event)
    {
    }

    /**
     * Composer POST-INSTALL event
     * @param Event $event
     */
    public static function postInstall(Event $event)
    {
        if(self::getEnvironment($event) == self::DEV){
            $ach = new AbstractComposerHelper($event);
            $ach->composerPostInstall();
        }
    }

    /**
     * Composer POST-UPDATE event
     * @param Event $event
     */
    public static function postUpdate(Event $event)
    {
        if(self::getEnvironment($event) == self::DEV){
            $ach = new AbstractComposerHelper($event);
            $ach->composerPostInstall();
        }
    }

    /**
     * Get environment by dotenv files
     *
     * @return array|false|string
     */
    private static function getEnvironment($event){
        $serverRoot = getcwd();
        $io = $event->getIO();

        $dotenv = new Dotenv();
        try {
            $dotenv->load($serverRoot.'/.env');
        } catch(\Exception $exception){
            $io->write('<comment>ComposerHelper message: Do you have created dotenv files (.env, .env.dev) in root folder of your server?</comment>', true);
        }

        return getenv('COMPOSERHELPER');
    }

}
