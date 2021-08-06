<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nsnewsslider_domain_model_newsslider', 'EXT:ns_news_slider/Resources/Private/Language/locallang_csh_tx_nsnewsslider_domain_model_newsslider.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nsnewsslider_domain_model_newsslider');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ns_news_slider/Configuration/TSconfig/ContentElementWizard.tsconfig">');
