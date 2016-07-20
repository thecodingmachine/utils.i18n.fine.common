<?php
namespace Mouf\Utils\I18n\Fine\Common;

use Mouf\Installer\PackageInstallerInterface;
use Mouf\MoufManager;
use Mouf\Actions\InstallUtils;

/**
 * Installer for common fine package. This create a defaultTranslationService
 */
class FineInstaller implements PackageInstallerInterface
{

    /**
     * (non-PHPdoc)
     * @see \Mouf\Installer\PackageInstallerInterface::install()
     */
    public static function install(MoufManager $moufManager)
    {
        $cascadingTranslator = InstallUtils::getOrCreateInstance("defaultTranslationService", "Mouf\\Utils\\I18n\\Fine\\Common\\FineCascadingTranslator", $moufManager);

        if ($moufManager->has('twigEnvironment') && !$moufManager->has('fineTwigExtension')) {
            $fineTwigExtension = $moufManager->createInstance(FineTwigExtension::class);

            $fineTwigExtension->getConstructorArgumentProperty('translator')->setValue($cascadingTranslator);

            $twigEnvironment = $moufManager->getInstanceDescriptor('twigEnvironment');
            $extensions = $twigEnvironment->getSetterProperty('setExtensions')->getValue();
            $extensions[] = $fineTwigExtension;
            $twigEnvironment->getSetterProperty('setExtensions')->setValue($extensions);
        }

        // Let's rewrite the MoufComponents.php file to save the component
        $moufManager->rewriteMouf();
    }
}
