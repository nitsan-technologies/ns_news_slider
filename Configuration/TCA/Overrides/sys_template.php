<?php

defined('TYPO3_MODE') || die('Access denied.');

// Adding fields to the tt_content table definition in TCA
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('ns_news_slider', 'Configuration/TypoScript', 'News Slider');
