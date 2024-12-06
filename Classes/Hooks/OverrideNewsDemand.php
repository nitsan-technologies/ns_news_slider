<?php

namespace NITSAN\NsNewsSlider\Hooks;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class OverrideNewsDemand
{
    /**
     * Summary of modify
     * @param array $params
     * @return void
     */
    public function modify(array $params): void
    {
        $this->updateConstraints($params['query'], $params['constraints']);
    }

    /**
     * @param QueryInterface $query
     * @param array $constraints
     * @return void
     */
    protected function updateConstraints(QueryInterface $query, array &$constraints): void
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $typoScriptSetup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

        $newsOnly = intval($typoScriptSetup['plugin.']['tx_nsnewsslider_nsnewsslider.']['settings.']['newsOnly'] ?? 0);
        if ($newsOnly) {
            $constraints[] = $query->equals('type', 0);
        }
    }
}
