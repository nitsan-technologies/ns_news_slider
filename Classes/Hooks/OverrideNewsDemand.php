<?php

namespace NITSAN\NsNewsSlider\Hooks;

class OverrideNewsDemand
{
    public function modify(array $params)
    {
        $this->updateConstraints($params['query'], $params['constraints']);
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param array $constraints
     */
    protected function updateConstraints(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query, array &$constraints)
    {
        $newsOnly = intval($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_nsnewsslider_nsnewsslider.']['settings.']['newsOnly']);
        if ($newsOnly == 1) {
            $constraints[] = $query->equals('type', 0);
        }
    }
}
