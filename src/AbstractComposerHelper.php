<?php

namespace abytemore\ComposerHelper;


use Composer\Util\ProcessExecutor;
use Symfony\Component\Yaml\Yaml;

class AbstractComposerHelper
{

    private $path;
    private $config;
    private $event;
    private $io;
    private $filesystem;

    /**
     * AbstractComposerHelper constructor.
     */
    public function __construct($event)
    {
        $this->path = static::getCurrentPath();
        $this->config = Yaml::parseFile($this->path . '/composer-helper.yml');
        $this->event = $event;
        $this->io = $this->event->getIO();
        $this->filesystem = $this->getComposerFilesystem();
    }

    /**
     * @param $event
     * @return string
     */
    public function composerPreInstall() {
        if($this->config['packages']) {
            foreach ($this->config['packages'] as $package) {
                $target = $package['target'];
                $link = $package['link'];

                // Remove symlink
                try {
                    $this->getComposerFilesystem()->unlink($link);

                    $this->io->write('<info>ComposerHelper message: Symlink to "' . $link . '" removed successfully!</info>', true);
                } catch (\RuntimeException $exception) {
                    $this->io->write('<comment>ComposerHelper message: Unable to remove symlink to "' . $link . '"!</comment>', true);
                }
            }
        } else {
            $this->io->write('<comment>ComposerHelper message:No Packages in config - see "composer-helper.yml" file?</comment>', true);
        }
    }

    /**
     * @param $event
     * @return string
     */
    public function composerPostInstall() {
        if($this->config['packages']) {
            foreach ($this->config['packages'] as $package) {
                $target = $package['target'];
                $link = $package['link'];
                $pimcoreAssetsLink = isset($package['pimcore-assets-link']) ? $package['pimcore-assets-link'] : false;

                // Remove package folder from vendor
                try {
                    $this->filesystem->removeDirectory($link);
                    $this->io->write('<info>ComposerHelper message: Package "' . $link . '" removed successfully!</info>', true);
                } catch( \RuntimeException $exception) {
                    $this->io->write('<comment>ComposerHelper message: Error removeing package "' . $link . '"!</comment>', true);
                }

                // Create symlink from target folder
                try {
                    $this->filesystem->relativeSymlink($target, $link );
                    $this->io->write('<info>ComposerHelper message: Symlink to "' . $link . '" created successfully!</info>', true);

                    // Create Symlink for bundle assets (Pimcore only)
                    if($pimcoreAssetsLink) {
                        try {
                            $this->filesystem->relativeSymlink($target . '/Resources/public', $pimcoreAssetsLink );
                            $this->io->write('<info>ComposerHelper message: Symlink to assets folder"' . $pimcoreAssetsLink . '" created successfully!</info>', true);
                        } catch (\RuntimeException $exception) {
                            $this->io->write('<comment>ComposerHelper message: Error creating symlink to assets folder "' . $target . '"!</comment>', true);
                        }
                    }
                } catch( \RuntimeException $exception) {
                    $this->io->write('<comment>ComposerHelper message: Error creating symlink to "' . $target . '"!</comment>', true);
                }
            }
        } else {
            $this->io->write('<comment>ComposerHelper message:No Packages in config - see "composer-helper.yml" file?</comment>', true);
        }
    }

    /**
     * @return \Composer\Util\Filesystem
     */
    private function getComposerFilesystem() {
        $processExecutor = new ProcessExecutor($this->io);

        return new \Composer\Util\Filesystem($processExecutor);
    }

    /**
     * @return mixed
     */
    private static function getCurrentPath() {
        return $_SERVER['PWD'];
    }
}
