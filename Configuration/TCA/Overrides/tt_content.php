<?php

defined('TYPO3') or die();

/**
 * Plugin register
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'NsNewsSlider',
    'Nsnewsslider',
    'NS News Slider'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'ns_news_slider',
    'tx_nsnewsslider_domain_model_newsslider'
);

/* Flexform configuration for the slider : START */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['nsnewsslider_nsnewsslider']='layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['nsnewsslider_nsnewsslider'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'nsnewsslider_nsnewsslider',
    'FILE:EXT:ns_news_slider/Configuration/FlexForms/PluginSettings.xml'
);
/* Flexform configuration for the slider : END */
