<?php
namespace MauticPlugin\AcmeSkeletonBundle;

use Mautic\IntegrationsBundle\Bundle\AbstractPluginBundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

final class AcmeSkeletonBundle extends AbstractPluginBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new \MauticPlugin\AcmeSkeletonBundle\DependencyInjection\AcmeSkeletonExtension();
    }
}
