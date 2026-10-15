<?php

declare(strict_types=1);

namespace NITSAN\NsNewsSlider\ViewHelpers\Be;

use NITSAN\NsNewsSlider\Backend\PremiumStrip;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Renders the premium strip in the Page module preview of the news slider plugins.
 */
final class PremiumStripViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function render(): string
    {
        $strip = GeneralUtility::makeInstance(PremiumStrip::class)->render();
        if ($strip !== '') {
            GeneralUtility::makeInstance(PageRenderer::class)->addCssFile(PremiumStrip::STYLESHEET);
        }

        return $strip;
    }
}
