<?php

namespace NITSAN\NsNewsSlider\Hooks;

use GeorgRinger\News\Domain\Model\Dto\NewsDemand;
use GeorgRinger\News\Domain\Repository\NewsRepository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class OverrideNewsDemand
{
    /**
     * Summary of modify
     * @param array $params
     * @param NewsRepository $newsRepository
     * @return void
     */
    public function modify(array $params, NewsRepository $newsRepository): void
    {
        $this->updateConstraints($params['demand'], $params['respectEnableFields'], $params['query'], $params['constraints']);
    }

    /**
     * @param NewsDemand $demand
     * @param bool $respectEnableFields
     * @param QueryInterface $query
     * @param array $constraints
     * @return void
     */
    protected function updateConstraints(NewsDemand $demand,bool $respectEnableFields, QueryInterface $query, array &$constraints): void
    {
        $newsOnly = intval($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_nsnewsslider_nsnewsslider.']['settings.']['newsOnly']);
        if ($newsOnly) {
            $constraints[] = $query->equals('type', 0);
        }
    }
}
