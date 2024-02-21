<?php

defined('TYPO3') || die('Access denied.');


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'NsNewsSlider',
    'Nsnewsslider',
    [
        \NITSAN\NsNewsSlider\Controller\RoyalController::class => 'list',
    ],
    // non-cacheable actions
    [
        \NITSAN\NsNewsSlider\Controller\RoyalController::class => ''
    ]
);

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'ns_news_slider-plugin-nsnewsslider',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:ns_news_slider/Resources/Public/Icons/user_plugin_nsnewsslider.svg']
);

// Hook for override news demand.
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['Domain/Repository/AbstractDemandedRepository.php']['findDemanded']['ns_news_slider'] =
    'NITSAN\\NsNewsSlider\\Hooks\\OverrideNewsDemand->modify';
