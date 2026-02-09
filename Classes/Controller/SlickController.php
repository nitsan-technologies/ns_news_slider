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
                        slideWidth: ' . (!empty($this->settings['slicksldwidth'])
                            ? $this->settings['slicksldwidth']
                            : (($constant['slideWidth'] ?? '') === '' ? '0' : $constant['slideWidth'])) . ',

                        dots: ' . (!empty($this->settings['slickdots'])
                            ? $this->settings['slickdots']
                            : (($constant['dots'] ?? '') === '' ? 'false' : $constant['dots'])) . ',

                        autoplay: ' . (!empty($this->settings['slickautoplay'])
                            ? $this->settings['slickautoplay']
                            : (($constant['autoplay'] ?? '') === '' ? 'false' : $constant['autoplay'])) . ',

                        autoplaySpeed:' . (!empty($this->settings['slickautoplaySpeed'])
                            ? $this->settings['slickautoplaySpeed']
                            : (($constant['autoplaySpeed'] ?? '') === '' ? '0' : $constant['autoplaySpeed'])) . ',

                        speed: ' . (!empty($this->settings['slickspeed'])
                            ? $this->settings['slickspeed']
                            : (($constant['speed'] ?? '') === '' ? '0' : $constant['speed'])) . ',

                        accessibility: ' . (!empty($this->settings['slickaccessibility'])
                            ? $this->settings['slickaccessibility']
                            : (($constant['accessibility'] ?? '') === '' ? 'false' : $constant['accessibility'])) . ',

                        adaptiveHeight: ' . (!empty($this->settings['slickadaptiveHeight'])
                            ? $this->settings['slickadaptiveHeight']
                            : (($constant['adaptiveHeight'] ?? '') === '' ? 'false' : $constant['adaptiveHeight'])) . ',

                        arrows: ' . (!empty($this->settings['slickarrows'])
                            ? $this->settings['slickarrows']
                            : (($constant['arrows'] ?? '') === '' ? 'false' : $constant['arrows'])) . ",

                        centerPadding: '" . (!empty($this->settings['slickcenterPadding'])
                            ? $this->settings['slickcenterPadding']
                            : (($constant['centerPadding'] ?? '') === '' ? '0px' : $constant['centerPadding'])) . "',

                        cssEase: '" . (!empty($this->settings['slickcssEase'])
                            ? $this->settings['slickcssEase']
                            : (($constant['cssEase'] ?? '') === '' ? 'linear' : $constant['cssEase'])) . "',

                        draggable: " . (!empty($this->settings['slickdraggable'])
                            ? $this->settings['slickdraggable']
                            : (($constant['draggable'] ?? '') === '' ? 'false' : $constant['draggable'])) . ',

                        fade: ' . (!empty($this->settings['slickfade'])
                            ? $this->settings['slickfade']
                            : (($constant['fade'] ?? '') === '' ? 'false' : $constant['fade'])) . ',

                        focusOnSelect: ' . (!empty($this->settings['slickfocusOnSelect'])
                            ? $this->settings['slickfocusOnSelect']
                            : (($constant['focusOnSelect'] ?? '') === '' ? 'false' : $constant['focusOnSelect'])) . ',

                        initialSlide: ' . (isset($this->settings['slickinitialSlide']) && $this->settings['slickinitialSlide'] > 0
                            ? $this->settings['slickinitialSlide']
                            : (($constant['initialSlide'] ?? '') === '' ? '0' : $constant['initialSlide'])) . ',

                        mobileFirst: ' . (!empty($this->settings['slickmobileFirst'])
                            ? $this->settings['slickmobileFirst']
                            : (($constant['mobileFirst'] ?? '') === '' ? 'false' : $constant['mobileFirst'])) . ',

                        pauseOnFocus: ' . (!empty($this->settings['slickpauseOnFocus'])
                            ? $this->settings['slickpauseOnFocus']
                            : (($constant['pauseOnFocus'] ?? '') === '' ? 'false' : $constant['pauseOnFocus'])) . ',

                        pauseOnHover: ' . (!empty($this->settings['slickpauseOnHover'])
                            ? $this->settings['slickpauseOnHover']
                            : (($constant['pauseOnHover'] ?? '') === '' ? 'false' : $constant['pauseOnHover'])) . ',

                        pauseOnDotsHover: ' . (!empty($this->settings['slickpauseOnDotsHover'])
                            ? $this->settings['slickpauseOnDotsHover']
                            : (($constant['pauseOnDotsHover'] ?? '') === '' ? 'false' : $constant['pauseOnDotsHover'])) . ',

                        slidesToScroll: ' . (!empty($this->settings['slickslidesToScroll'])
                            ? $this->settings['slickslidesToScroll']
                            : (($constant['slidesToScroll'] ?? '') === '' ? '1' : $constant['slidesToScroll'])) . ',

                        swipe: ' . (!empty($this->settings['slickswipe'])
                            ? $this->settings['slickswipe']
                            : (($constant['swipe'] ?? '') === '' ? 'false' : $constant['swipe'])) . ',

                        swipeToSlide: ' . (!empty($this->settings['slickswipeToSlide'])
                            ? $this->settings['slickswipeToSlide']
                            : (($constant['swipeToSlide'] ?? '') === '' ? 'false' : $constant['swipeToSlide'])) . ',

                        touchMove: ' . (!empty($this->settings['slicktouchMove'])
                            ? $this->settings['slicktouchMove']
                            : (($constant['touchMove'] ?? '') === '' ? 'false' : $constant['touchMove'])) . ',

                        touchThreshold: ' . (!empty($this->settings['slicktouchThreshold'])
                            ? $this->settings['slicktouchThreshold']
                            : (($constant['touchThreshold'] ?? '') === '' ? '5' : $constant['touchThreshold'])) . ',

                        useCSS: ' . (!empty($this->settings['slickuseCSS'])
                            ? $this->settings['slickuseCSS']
                            : (($constant['useCSS'] ?? '') === '' ? 'false' : $constant['useCSS'])) . ',

                        useTransform: ' . (!empty($this->settings['slickuseTransform'])
                            ? $this->settings['slickuseTransform']
                            : (($constant['useTransform'] ?? '') === '' ? 'false' : $constant['useTransform'])) . ',

                        variableWidth: ' . (!empty($this->settings['slickvariableWidth'])
                            ? $this->settings['slickvariableWidth']
                            : (($constant['variableWidth'] ?? '') === '' ? 'false' : $constant['variableWidth'])) . ',

                        rtl: ' . (!empty($this->settings['slickrtl'])
                            ? $this->settings['slickrtl']
                            : (($constant['rtl'] ?? '') === '' ? 'false' : $constant['rtl'])) . ',

                        waitForAnimate: ' . (!empty($this->settings['slickwaitForAnimate'])
                            ? $this->settings['slickwaitForAnimate']
                            : (($constant['waitForAnimate'] ?? '') === '' ? 'false' : $constant['waitForAnimate'])) . ',

                        vertical: ' . (!empty($this->settings['slickvertical'])
                            ? $this->settings['slickvertical']
                            : (($constant['vertical'] ?? '') === '' ? 'false' : $constant['vertical'])) . ',

                        verticalSwiping: ' . (!empty($this->settings['slickverticalSwiping'])
                            ? $this->settings['slickverticalSwiping']
                            : (($constant['verticalSwiping'] ?? '') === '' ? 'false' : $constant['verticalSwiping'])) . ',

                        centerMode:' . (!empty($this->settings['slickdisplay'])
                            ? $this->settings['slickdisplay']
                            : (($constant['centerMode'] ?? '') === '' ? 'false' : $constant['centerMode'])) . ",

                        lazyLoad:'" . (!empty($this->settings['slicklazyLoad'])
                            ? $this->settings['slicklazyLoad']
                            : (($constant['lazyLoad'] ?? '') === '' ? 'ondemand' : $constant['lazyLoad'])) . "',

                        slidesToShow:" . (isset($this->settings['slickslidesToShow']) && $this->settings['slickslidesToShow'] > 0
                            ? $this->settings['slickslidesToShow']
                            : (($constant['slidesToShow'] ?? '') === '' ? '1' : $constant['slidesToShow'])) . ',

                        infinite: ' . (!empty($this->settings['slickinfinite'])
                            ? $this->settings['slickinfinite']
                            : (($constant['infinite'] ?? '') === '' ? 'false' : $constant['infinite'])) . '';

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
