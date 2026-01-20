<?php

declare(strict_types=1);

namespace NITSAN\NsNewsSlider\Hooks;

use GeorgRinger\News\Domain\Model\Dto\NewsDemand;
use GeorgRinger\News\Domain\Repository\NewsRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class OverrideNewsDemand
{
    public function modify(array $params, NewsRepository $newsRepository): void
    {
        $this->updateConstraints($params['demand'], $params['respectEnableFields'], $params['query'], $params['constraints']);
    }

    /**
     * @param NewsDemand $demand
     * @param bool $respectEnableFields
     * @param QueryInterface $query
     * @param array $constraints
     */
    protected function updateConstraints(NewsDemand $demand, bool $respectEnableFields, QueryInterface $query, array &$constraints): void
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $typoScriptSetup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $newsOnly = intval($typoScriptSetup['plugin.']['tx_nsnewsslider_nsnewsslider.']['settings.']['newsOnly'] ?? 0);
        if ($newsOnly) {
            $constraints[] = $query->equals('type', 0);
        }
    }
}
