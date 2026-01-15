<?php

defined('TYPO3') || die('Access denied.');

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use NITSAN\NsNewsSlider\Controller\NivoController;
use NITSAN\NsNewsSlider\Controller\OwlController;
use NITSAN\NsNewsSlider\Controller\SlickController;
use NITSAN\NsNewsSlider\Controller\RoyalController;
use NITSAN\NsNewsSlider\Controller\SliderjsController;

ExtensionUtility::configurePlugin(
    'NsNewsSlider',
    'NivoSlider',
    [
        NivoController::class => 'list',
    ],
    // non-cacheable actions
    [
        NivoController::class => 'list',
    ]
);

ExtensionUtility::configurePlugin(
    'NsNewsSlider',
    'OwlcarouselSlider',
    [
        OwlController::class => 'list',
    ],
    // non-cacheable actions
    [
        OwlController::class => 'list',
    ]
);

ExtensionUtility::configurePlugin(
    'NsNewsSlider',
    'RoyalSlider',
    [
        RoyalController::class => 'list',
    ],
    // non-cacheable actions
    [
        RoyalController::class => 'list',
    ]
);

ExtensionUtility::configurePlugin(
    'NsNewsSlider',
    'SliderjsSlider',
    [
        SliderjsController::class => 'list',
    ],
    // non-cacheable actions
    [
        SliderjsController::class => 'list',
    ]
);

ExtensionUtility::configurePlugin(
    'NsNewsSlider',
    'SlickSlider',
    [
        SlickController::class => 'list',
    ],
    // non-cacheable actions
    [
        SlickController::class => 'list',
    ]
);

// Hook for override news demand.
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['Domain/Repository/AbstractDemandedRepository.php']['findDemanded']['ns_news_slider'] =
    'NITSAN\\NsNewsSlider\\Hooks\\OverrideNewsDemand->modify';
