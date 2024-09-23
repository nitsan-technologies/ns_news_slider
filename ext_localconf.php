<?php

use NITSAN\NsNewsSlider\Controller\RoyalController;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die('Access denied.');


ExtensionUtility::configurePlugin(
    'NsNewsSlider',
    'Nsnewsslider',
    [
        RoyalController::class => 'list',
    ]
);

$iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
$iconRegistry->registerIcon(
    'ns_news_slider-plugin-nsnewsslider',
    SvgIconProvider::class,
    ['source' => 'EXT:ns_news_slider/Resources/Public/Icons/user_plugin_nsnewsslider.svg']
);

// Hook for override news demand.
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['Domain/Repository/AbstractDemandedRepository.php']['findDemanded']['ns_news_slider'] =
    'NITSAN\\NsNewsSlider\\Hooks\\OverrideNewsDemand->modify';
