<?php

namespace think\composer;


use Composer\Composer;
use Composer\Installer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        $manager = $composer->getInstallationManager();

        $manager->addInstaller(new ThinkFramework($io, $composer));

        $manager->addInstaller(new ThinkTesting($io, $composer));

    }
}