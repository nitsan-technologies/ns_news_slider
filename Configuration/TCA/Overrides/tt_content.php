<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

defined('TYPO3') or die();

$versionNumber =  VersionNumberUtility::convertVersionStringToArray(VersionNumberUtility::getCurrentTypo3Version());

/***************
 * Plugin
 */
$pluginRegister = [
    'NivoSlider' => 'Nivo Slider',
    'OwlcarouselSlider' => 'Owlcarousel Slider',
    'RoyalSlider' => 'Royal Slider',
    'SliderjsSlider' => 'SliderjS Slider',
    'SlickSlider' => 'Slick Slider',
];

if ($versionNumber['version_main'] >= '14') {
    $pluginsPi = [
        'NivoSlider' => 'Nivoslider.xml',
        'OwlcarouselSlider' => 'OwlcarouselSlider.xml',
        'RoyalSlider' => 'RoyalSlider.xml',
        'SliderjsSlider' => 'SliderJs.xml',
        'SlickSlider' => 'SlickSlider.xml',
    ];

    foreach ($pluginRegister as $pluginName => $pluginTitle) {
        foreach ($pluginsPi as $pluginIdentifier => $pi_flexform) {
            if ($pluginIdentifier === $pluginName) {
                ExtensionUtility::registerPlugin(
                    'NsNewsSlider',
                    $pluginName,
                    $pluginTitle,
                    'ns_news_slider-plugin-nsnewsslider',
                    'NsNewsSlider',
                    '',
                    'FILE:EXT:ns_news_slider/Configuration/FlexForms/'.$pi_flexform
                );
            }
        }
    }
} else {
    foreach ($pluginRegister as $pluginName => $pluginTitle) {
        ExtensionUtility::registerPlugin(
            'NsNewsSlider',
            $pluginName,
            $pluginTitle,
            'ns_news_slider-plugin-nsnewsslider',
            'NsNewsSlider'
        );
    }

    $pluginsPi = [
        'nsnewsslider_nivoslider' => 'Nivoslider.xml',
        'nsnewsslider_owlcarouselslider' => 'OwlcarouselSlider.xml',
        'nsnewsslider_royalslider' => 'RoyalSlider.xml',
        'nsnewsslider_sliderjsslider' => 'SliderJs.xml',
        'nsnewsslider_slickslider' => 'SlickSlider.xml',
    ];

    foreach ($pluginsPi as $listType => $pi_flexform) {
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$listType] = 'pi_flexform';
        // @extensionScannerIgnoreLine
        ExtensionManagementUtility::addPiFlexFormValue($listType, 'FILE:EXT:ns_news_slider/Configuration/FlexForms/'.$pi_flexform);
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$listType] = 'layout,select_key,pages,recursive';
    }
}
