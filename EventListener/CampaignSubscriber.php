<?php
namespace MauticPlugin\AcmeSkeletonBundle\EventListener;

use Mautic\CampaignBundle\CampaignEvents;
use Mautic\CampaignBundle\Event\CampaignBuilderEvent;
use Mautic\CampaignBundle\Event\CampaignExecutionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CampaignSubscriber implements EventSubscriberInterface
{
    public const ACTION_KEY = 'skeleton.send_test';
    public const EVENT_NAME = 'plugin.skeleton.send_test';

    public static function getSubscribedEvents(): array
    {
        return [
            CampaignEvents::CAMPAIGN_ON_BUILD => ['onCampaignBuild', 0],
            self::EVENT_NAME                  => ['onExecuteAction', 0],
        ];
    }

    public function onCampaignBuild(CampaignBuilderEvent $event): void
    {
        $event->addAction(self::ACTION_KEY, [
            'label'       => 'skeleton.action.send_test.label',
            'description' => 'skeleton.action.send_test.desc',
            'formType'    => \MauticPlugin\AcmeSkeletonBundle\Form\Type\TestActionType::class,
            'eventName'   => self::EVENT_NAME,
            'category'    => 'Action',
        ]);
    }

    public function onExecuteAction(CampaignExecutionEvent $event): void
    {
        if (!$event->getContact()) {
            $event->setResult(false);
            $event->setFailed('No contact in context');
            return;
        }

        // $config = $event->getConfig(); // leer campos de formulario si los usas
        $event->setResult(true);
        $event->setSuccess();
    }
}
