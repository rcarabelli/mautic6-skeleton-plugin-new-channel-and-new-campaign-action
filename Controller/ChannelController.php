<?php
namespace MauticPlugin\AcmeSkeletonBundle\Controller;

use Mautic\CoreBundle\Controller\CommonController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChannelController extends CommonController
{
    public function indexAction(Request $request): Response
    {
        return $this->delegateView([
            'contentTemplate' => '@AcmeSkeletonBundle/Channel/index.html.twig',
            'viewParameters'  => [],
            'passthroughVars' => [
                // Más sólido: usa el ID del menú
                'activeLink'    => '#skeleton.menu.channel',
                'pageTitle'     => 'Test Channel',
                'route'         => $this->generateUrl('skeleton_channel_index'),
                'mauticContent' => 'skeleton.channel',
            ],
        ]);
    }
}
