<?php

namespace NITSAN\NsNewsSlider\Hooks;

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
        $newsOnly = intval($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_nsnewsslider_nsnewsslider.']['settings.']['newsOnly']);
        if ($newsOnly) {
            $constraints[] = $query->equals('type', 0);
        }
    }
}
