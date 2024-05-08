<?php

defined('TYPO3_MODE') || die('Access denied.');

if (version_compare(TYPO3_branch, '10.0', '>=')) {
    $moduleClass = \NITSAN\NsNewsSlider\Controller\RoyalController::class;
} else {
    $moduleClass = 'Royal';
}
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'NITSAN.NsNewsSlider',
    'Nsnewsslider',
    [
        $moduleClass => 'list',
    ],
    // non-cacheable actions
    [
        $moduleClass => ''
    ]
);

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'ns_news_slider-plugin-nsnewsslider',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:ns_news_slider/Resources/Public/Icons/user_plugin_nsnewsslider.svg']
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ns_news_slider/Configuration/TSconfig/ContentElementWizard.tsconfig">');

// Hook for override news demand.
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['Domain/Repository/AbstractDemandedRepository.php']['findDemanded']['ns_news_slider'] = 'NITSAN\\NsNewsSlider\\Hooks\\OverrideNewsDemand->modify';
