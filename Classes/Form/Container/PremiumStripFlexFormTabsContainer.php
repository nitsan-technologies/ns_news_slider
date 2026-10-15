<?php

declare(strict_types=1);

namespace NITSAN\NsNewsSlider\Form\Container;

use NITSAN\NsNewsSlider\Backend\PremiumStrip;
use TYPO3\CMS\Backend\Form\Container\FlexFormTabsContainer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Core FlexForm tabs container with the premium strip above the sheet tabs of the news slider plugin options.
 */
final class PremiumStripFlexFormTabsContainer extends FlexFormTabsContainer
{
    public function render(): array
    {
        $resultArray = parent::render();

        $strip = GeneralUtility::makeInstance(PremiumStrip::class)->render();
        if ($strip !== '') {
            $resultArray['html'] = $strip . $resultArray['html'];
            $resultArray['stylesheetFiles'][] = PremiumStrip::STYLESHEET;
        }

        return $resultArray;
    }
}
