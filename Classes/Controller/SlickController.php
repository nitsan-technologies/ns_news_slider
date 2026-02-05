<?php

declare(strict_types=1);

namespace NITSAN\NsNewsSlider\Controller;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Page\PageRenderer;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2023
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * SlickController
 */
class SlickController extends SliderBaseController
{
    /**
     * @var string
     */
    protected string $sliderName = '';

    /**
     * @var string
     */
    protected string $extKey = '';

    /**
     * action list
     *
     * @param array|null $overwriteDemand
     * @return ResponseInterface
     */
    public function listAction(?array $overwriteDemand = null): ResponseInterface
    {

        // Get settings.
        $settings = $this->settings;
        $settings['sliderType'] = $this->sliderName;
        $news = $this->findNews();
        $this->view->assignMultiple([
            'news' => $news,
            'settings' => $settings
        ]);

        if (Environment::isComposerMode()) {
            $assetPath = $this->getPath('/', 'ns_news_slider');
            $extpath = GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . $assetPath;
            $cssPath = 'slider/Slick-Slider/css/';
            $jsPath = 'slider/Slick-Slider/js/';
            $ajax1 = $extpath . $jsPath . 'slick.js';
        } else {
            $extpath = PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('ns_news_slider'));
            $cssPath = 'Resources/Public/slider/Slick-Slider/css/';
            $jsPath = 'Resources/Public/slider/Slick-Slider/js/';
            $ajax1 = 'EXT:ns_news_slider/' . $jsPath . 'slick.js';
        }

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . $cssPath . 'slick.css" />');
        $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . $cssPath . 'slick-theme.css" />');
        $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . $cssPath . 'slick-custom.css" />');


        $pluginName = $this->request->getPluginName();
        // @extensionScannerIgnoreLine
        $getContentId = $this->request->getAttribute('currentContentObject')->data['uid'];

        // set js value for slider
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $typoScriptSetup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $constant = $typoScriptSetup['plugin.']['tx_nsnewsslider_slickslider.']['settings.'];

        if ($constant['jQuery']) {
            $pageRenderer->addJsFooterFile('EXT:ns_news_slider/Resources/Public/Js/jquery-3.6.0.min.js', 'text/javascript', false, false, '');
        }

        $pageRenderer->addJsFooterFile($ajax1, 'text/javascript', false, false, '');
        $sliderOption = '
                slideWidth: ' . (isset($this->settings['slicksldwidth']) && $this->settings['slicksldwidth'] != '' ? $this->settings['slicksldwidth'] : $constant['slideWidth']) . ',
                dots: ' . (isset($this->settings['slickdots']) && $this->settings['slickdots'] != '' ? $this->settings['slickdots'] : $constant['dots']) . ',

                autoplay: ' . (isset($this->settings['slickautoplay']) && $this->settings['slickautoplay'] != '' ? $this->settings['slickautoplay'] : $constant['autoplay']) . ',
                autoplaySpeed:' . (isset($this->settings['slickautoplaySpeed']) && $this->settings['slickautoplaySpeed'] != '' ? $this->settings['slickautoplaySpeed'] : $constant['autoplaySpeed']) . ',

                speed: ' . (isset($this->settings['slickspeed']) && $this->settings['slickspeed'] != '' ? $this->settings['slickspeed'] : $constant['speed']) . ',
                accessibility: ' . (isset($this->settings['slickaccessibility']) && $this->settings['slickaccessibility'] != '' ? $this->settings['slickaccessibility'] : $constant['accessibility']) . ',
                adaptiveHeight: ' . (isset($this->settings['slickadaptiveHeight']) && $this->settings['slickadaptiveHeight'] != '' ? $this->settings['slickadaptiveHeight'] : $constant['adaptiveHeight']) . ',
                arrows: ' . (isset($this->settings['slickarrows']) && $this->settings['slickarrows'] != '' ? $this->settings['slickarrows'] : $constant['arrows']) . ",
                centerPadding: '" . (isset($this->settings['slickcenterPadding']) && $this->settings['slickcenterPadding'] != '' ? $this->settings['slickcenterPadding'] : $constant['centerPadding']) . "',
                cssEase: '" . (isset($this->settings['slickcssEase']) && $this->settings['slickcssEase'] != '' ? $this->settings['slickcssEase'] : $constant['cssEase']) . "',
                draggable: " . (isset($this->settings['slickdraggable']) && $this->settings['slickdraggable'] != '' ? $this->settings['slickdraggable'] : (($constant['draggable'] ?? '') === '' ? 'false' : $constant['draggable'])) . ',
                fade: ' . (isset($this->settings['slickfade']) && $this->settings['slickfade'] != '' ? $this->settings['slickfade'] : (($constant['fade'] ?? '') === '' ? 'false' : $constant['fade'])) . ',
                focusOnSelect: ' . (isset($this->settings['slickfocusOnSelect']) && $this->settings['slickfocusOnSelect'] != '' ? $this->settings['slickfocusOnSelect'] : (($constant['focusOnSelect'] ?? '') === '' ? 'false' : $constant['focusOnSelect'])) . ',
                initialSlide: ' . (isset($this->settings['slickinitialSlide']) && $this->settings['slickinitialSlide'] > 0 ? $this->settings['slickinitialSlide'] : $constant['initialSlide']) . ',
                mobileFirst: ' . (isset($this->settings['slickmobileFirst']) && $this->settings['slickmobileFirst'] != '' ? $this->settings['slickmobileFirst'] : (($constant['mobileFirst'] ?? '') === '' ? 'false' : $constant['mobileFirst'])) . ',
                pauseOnFocus: ' . (isset($this->settings['slickpauseOnFocus']) && $this->settings['slickpauseOnFocus'] != '' ? $this->settings['slickpauseOnFocus'] : (($constant['pauseOnFocus'] ?? '') === '' ? 'false' : $constant['pauseOnFocus'])) . ',
                pauseOnHover: ' . (isset($this->settings['slickpauseOnHover']) && $this->settings['slickpauseOnHover'] != '' ? $this->settings['slickpauseOnHover'] : (($constant['pauseOnHover'] ?? '') === '' ? 'false' : $constant['pauseOnHover'])) . ',
                pauseOnDotsHover: ' . (isset($this->settings['slickpauseOnDotsHover']) && $this->settings['slickpauseOnDotsHover'] != '' ? $this->settings['slickpauseOnDotsHover'] : (($constant['pauseOnDotsHover'] ?? '') === '' ? 'false' : $constant['pauseOnDotsHover'])) . ',
                slidesToScroll: ' . (isset($this->settings['slickslidesToScroll']) && $this->settings['slickslidesToScroll'] != '' ? $this->settings['slickslidesToScroll'] : $constant['slidesToScroll']) . ',
                swipe: ' . (isset($this->settings['slickswipe']) && $this->settings['slickswipe'] != '' ? $this->settings['slickswipe'] : (($constant['swipe'] ?? '') === '' ? 'false' : $constant['swipe'])) . ',
                swipeToSlide: ' . (isset($this->settings['slickswipeToSlide']) && $this->settings['slickswipeToSlide'] != '' ? $this->settings['slickswipeToSlide'] : (($constant['swipeToSlide'] ?? '') === '' ? 'false' : $constant['swipeToSlide'])) . ',
                touchMove: ' . (isset($this->settings['slicktouchMove']) && $this->settings['slicktouchMove'] != '' ? $this->settings['slicktouchMove'] : (($constant['touchMove'] ?? '') === '' ? 'false' : $constant['touchMove'])) . ',
                touchThreshold: ' . (isset($this->settings['slicktouchThreshold']) && $this->settings['slicktouchThreshold'] != '' ? $this->settings['slicktouchThreshold'] : (($constant['touchThreshold'] ?? '') === '' ? 'false' : $constant['touchThreshold'])) . ',
                useCSS: ' . (isset($this->settings['slickuseCSS']) && $this->settings['slickuseCSS'] != '' ? $this->settings['slickuseCSS'] : (($constant['useCSS'] ?? '') === '' ? 'false' : $constant['useCSS'])) . ',
                useTransform: ' . (isset($this->settings['slickuseTransform']) && $this->settings['slickuseTransform'] != '' ? $this->settings['slickuseTransform'] : (($constant['useTransform'] ?? '') === '' ? 'false' : $constant['useTransform'])) . ',
                variableWidth: ' . (isset($this->settings['slickvariableWidth']) && $this->settings['slickvariableWidth'] != '' ? $this->settings['slickvariableWidth'] : (($constant['variableWidth'] ?? '') === '' ? 'false' : $constant['variableWidth'])) . ',
                rtl: ' . (isset($this->settings['slickrtl']) && $this->settings['slickrtl'] != '' ? $this->settings['slickrtl'] : (($constant['rtl'] ?? '') === '' ? 'false' : $constant['rtl'])) . ',
                waitForAnimate: ' . (isset($this->settings['slickwaitForAnimate']) && $this->settings['slickwaitForAnimate'] != '' ? $this->settings['slickwaitForAnimate'] : (($constant['waitForAnimate'] ?? '') === '' ? 'false' : $constant['waitForAnimate'])) . ',
                vertical: ' . (isset($this->settings['slickvertical']) && $this->settings['slickvertical'] != '' ? $this->settings['slickvertical'] : (($constant['vertical'] ?? '') === '' ? 'false' : $constant['vertical'])) . ',
                verticalSwiping: ' . (isset($this->settings['slickverticalSwiping']) && $this->settings['slickverticalSwiping'] != '' ? $this->settings['slickverticalSwiping'] : (($constant['verticalSwiping'] ?? '') === '' ? 'false' : $constant['verticalSwiping'])) . ',
                centerMode:' . (isset($this->settings['slickdisplay']) && $this->settings['slickdisplay'] != '' ? $this->settings['slickdisplay'] : (($constant['centerMode'] ?? '') === '' ? 'false' : $constant['centerMode'])) . ",
                lazyLoad:'" . (isset($this->settings['slicklazyLoad']) && $this->settings['slicklazyLoad'] != '' ? $this->settings['slicklazyLoad'] : $constant['lazyLoad']) . "',
                slidesToShow:" . (isset($this->settings['slickslidesToShow']) && $this->settings['slickslidesToShow'] > 0 ? $this->settings['slickslidesToShow'] : $constant['slidesToShow']) . ',
                infinite: ' . (isset($this->settings['slickinfinite']) && $this->settings['slickinfinite'] != '' ? $this->settings['slickinfinite'] : (($constant['infinite'] ?? '') === '' ? 'false' : $constant['infinite'])) . '';

        $footerData = "<script>
                if (typeof jQuery == 'undefined') {
                    alert('Please include Jquery library first!');
                }
                (function($) {
                      $('.vertical-center-4-" . $getContentId . "').slick({
                        " . $sliderOption . ',
                      });
                })(jQuery);
             </script>';

        $pageRenderer->addFooterData($footerData);

        //variable saved in flexform
        $this->view->assign('settings', $this->settings);

        // show pluging name
        $this->view->assign('pluginName', $pluginName);
        return $this->htmlResponse();
    }
}
