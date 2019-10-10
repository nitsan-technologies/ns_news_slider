<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'NITSAN.NsNewsSlider',
    'Nsnewsslider',
    [
        'NewsSlider' => 'nivoSlider, owlcarouselSlider, royalSlider, slidejsSlider, slickSlider'
    ],
    // non-cacheable actions
    [
        'NewsSlider' => ''
    ]
);

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'ns_news_slider-plugin-nsnewsslider',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:ns_news_slider/Resources/Public/Icons/user_plugin_nsnewsslider.svg']
);

// Hook for override news demand.
$GLOBALS['TYPO3_CONF_VARS']
        ['EXT']
        ['news']
        ['Domain/Repository/AbstractDemandedRepository.php']
        ['findDemanded']
        ['ns_news_slider'] = 'NITSAN\\NsNewsSlider\\Hooks\\OverrideNewsDemand->modify';
