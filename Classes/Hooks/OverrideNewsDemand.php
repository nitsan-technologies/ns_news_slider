<?php
namespace NITSAN\NsNewsSlider\Hooks;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use \GeorgRinger\News\Domain\Repository\NewsRepository;

class OverrideNewsDemand
{
    public function modify(array $params, NewsRepository $newsRepository) {
        $this->updateConstraints($params['demand'], $params['respectEnableFields'], $params['query'], $params['constraints']);
    }

    /**
     * @param \GeorgRinger\News\Domain\Model\Dto\NewsDemand $demand
     * @param bool $respectEnableFields
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param array $constraints
     */
    protected function updateConstraints($demand, $respectEnableFields, \TYPO3\CMS\Extbase\Persistence\QueryInterface $query, array &$constraints) {
        $newsOnly = intval($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_nsnewsslider_nsnewsslider.']['settings.']['newsOnly']);
        if ($newsOnly == 1) $constraints[] = $query->equals('type', 0);

    }
}