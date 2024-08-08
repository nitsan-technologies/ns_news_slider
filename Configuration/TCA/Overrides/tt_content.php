<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

/**
 * Plugin register
 */
ExtensionUtility::registerPlugin(
    'NsNewsSlider',
    'Nsnewsslider',
    'News Slider',
    'ns_news_slider-plugin-nsnewsslider',
    'plugins',
);

/* Flexform configuration for the slider : START */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['nsnewsslider_nsnewsslider'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['nsnewsslider_nsnewsslider'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'nsnewsslider_nsnewsslider',
    'FILE:EXT:ns_news_slider/Configuration/FlexForms/PluginSettings.xml'
);
/* Flexform configuration for the slider : END */
