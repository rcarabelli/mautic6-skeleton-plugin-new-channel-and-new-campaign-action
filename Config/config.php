<?php

return [
    'name'        => 'Acme Test Channel',
    'description' => 'Generic channel + campaign action skeleton',
    'version'     => '1.0.4',
    'author'      => 'Your Name',
    'metadata'    => [],       // o un array con info extra si quieres
    'features'    => [],       // ej. ['events'=>['campaign'=>true]]

    // ===== Menú (Channels > Test Channel) =====
    'menu' => [
        'main' => [
            'items' => [
                'skeleton.menu.channel' => [
                    'route'     => 'skeleton_channel_index',
                    'iconClass' => 'fa-puzzle-piece',
                    'parent'    => 'mautic.core.channels',
                    'access'    => 'mautic:core:default',
                    'priority'  => 50,
                ],
            ],
        ],
    ],

    // ===== Rutas =====
    'routes' => [
        'main' => [
            'skeleton_channel_index' => [
                'path'       => '/skeleton/channel',
                'controller' => 'MauticPlugin\\AcmeSkeletonBundle\\Controller\\ChannelController::indexAction',
            ],
        ],
    ],

    // ===== Hook para el Campaign Builder =====
    'events' => [
        'campaign' => [
            'mautic.campaign.on_build' => [
                'class'    => 'MauticPlugin\\AcmeSkeletonBundle\\EventListener\\CampaignSubscriber',
                'method'   => 'onCampaignBuild',
                'priority' => 0,
            ],
        ],
    ],

    // ===== Servicios =====
    'services' => [
        'events' => [
            'acme.skeleton.campaign.subscriber' => [
                'class'     => 'MauticPlugin\\AcmeSkeletonBundle\\EventListener\\CampaignSubscriber',
                'arguments' => [],
            ],
        ],
        'forms' => [
            'skeleton.form.type.test_action' => [
                'class' => 'MauticPlugin\\AcmeSkeletonBundle\\Form\\Type\\TestActionType',
                'alias' => 'skeleton_test_action',
            ],
        ],
    ],
];
