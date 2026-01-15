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
 * RoyalController
 */
class RoyalController extends SliderBaseController
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
        $settings = $this->settings;
        $settings['sliderType'] = $this->sliderName;
        $news = $this->findNews();
        $id = '';
        $type = '';
        $this->view->assignMultiple([
            'news' => $news,
            'settings' => $settings
        ]);

        $extensionKey = $this->request->getControllerExtensionKey();
        $additionalHeaderData = &$GLOBALS['TSFE']->additionalHeaderData;

        if (Environment::isComposerMode()) {
            $assetPath = $this->getPath('/', 'ns_news_slider');
            $extpath = GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . $assetPath;
            $cssPath = 'slider/Royal-Slider/css/';
            $jsPath = 'slider/Royal-Slider/js/vendor/';
        } else {
            $extpath = PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('ns_news_slider'));
            $cssPath = 'Resources/Public/slider/Royal-Slider/css/';
            $jsPath = 'Resources/Public/slider/Royal-Slider/js/vendor/';
        }

        $additionalHeaderData[$extensionKey . 'CSS1'] = '<link rel="stylesheet" type="text/css" href="' . $extpath . $cssPath . 'style.css" />';
        $additionalHeaderData[$extensionKey . 'CSS2'] = '<link rel="stylesheet" type="text/css" href="' . $extpath . $cssPath . 'vendor/royalslider.css" />';
        $additionalHeaderData[$extensionKey . 'CSS3'] = '<link rel="stylesheet" type="text/css" href="' . $extpath . $cssPath . 'vendor/skins/minimal-white/rs-minimal-white.css" />';

        $ajax2 = $extpath . $jsPath . 'jquery.royalslider.min.js';
        $ajax3 = $extpath . $jsPath . 'jquery.easing.js';

        $pluginName = $this->request->getPluginName();

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $getContentId = $this->request->getAttribute('currentContentObject')->data['uid'];

        // set js value for slider
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $typoScriptSetup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $constant = $typoScriptSetup['plugin.']['tx_nsnewsslider_royalslider.']['settings.'];

        if ($constant['jQuery']) {
            $ajax1 = 'EXT:ns_news_slider/Resources/Public/Js/jquery-3.6.0.min.js';
            $pageRenderer->addJsFooterFile($ajax1, 'text/javascript', false, false, '');
        }

        $pageRenderer->addJsFooterFile($ajax2, 'text/javascript', false, false, '');
        $pageRenderer->addJsFooterFile($ajax3, 'text/javascript', false, false, '');

        $slider_type = $this->settings['slider_type_royal'];

        $this->view->assign('slider_type', $slider_type);
        if ($slider_type == 'fullwidth') {
            $id = "
                (function($) {
                    $('#full-width-slider-" . $getContentId . "').royalSlider({";
            $type = '
                        deeplinking: {
                           enabled: ' . (isset($this->settings['deeplinking_enabled']) && $this->settings['deeplinking_enabled'] != '' ? $this->settings['deeplinking_enabled'] : $constant['deeplinking_enabled']) . ',
                           change: ' . (isset($this->settings['deeplinking_change']) && $this->settings['deeplinking_change'] != '' ? $this->settings['deeplinking_change'] : $constant['deeplinking_change']) . ",
                           prefix: '" . (isset($this->settings['deeplinking_prefix']) && $this->settings['deeplinking_prefix'] != '' ? $this->settings['deeplinking_prefix'] : $constant['deeplinking_prefix']) . "'
                        },
                        imgWidth: " . (isset($this->settings['imgWidth']) && $this->settings['imgWidth'] != '' ? $this->settings['imgWidth'] : $constant['imgWidth']) . ',
                        imgHeight: ' . (isset($this->settings['imgHeight']) && $this->settings['imgHeight'] != '' ? $this->settings['imgHeight'] : $constant['imgHeight']) . ',
                        thumbs: {
                            appendSpan: ' . (isset($this->settings['thumbs_appendSpan']) && $this->settings['thumbs_appendSpan'] != '' ? $this->settings['thumbs_appendSpan'] : $constant['thumbs_appendSpan']) . ',
                            firstMargin: ' . (isset($this->settings['thumbs_firstMargin']) && $this->settings['thumbs_firstMargin'] != '' ? $this->settings['thumbs_firstMargin'] : $constant['thumbs_firstMargin']) . ',

                            drag: ' . (isset($this->settings['thumb_drag']) && $this->settings['thumb_drag'] != '' ? $this->settings['thumb_drag'] : $constant['thumb_drag']) . ',

                            touch: ' . (isset($this->settings['thumb_touch']) && $this->settings['thumb_touch'] != '' ? $this->settings['thumb_touch'] : $constant['thumb_touch']) . ",

                            orientation: '" . (isset($this->settings['thumb_orientation']) && $this->settings['thumb_orientation'] != '' ? $this->settings['thumb_orientation'] : $constant['thumb_orientation']) . "',

                            arrows: " . (isset($this->settings['thumb_arrows']) && $this->settings['thumb_arrows'] != '' ? $this->settings['thumb_arrows'] : $constant['thumb_arrows']) . ',

                            spacing: ' . (isset($this->settings['thumb_spacing']) && $this->settings['thumb_spacing'] != '' ? $this->settings['thumb_spacing'] : $constant['thumb_spacing']) . ',

                            arrowsAutoHide: ' . (isset($this->settings['thumb_arrowsAutoHide']) && $this->settings['thumb_arrowsAutoHide'] != '' ? $this->settings['thumb_arrowsAutoHide'] : $constant['thumb_arrowsAutoHide']) . ',

                            autoCenter: ' . (isset($this->settings['thumb_autoCenter']) && $this->settings['thumb_autoCenter'] != '' ? $this->settings['thumb_autoCenter'] : $constant['thumb_autoCenter']) . ',

                            transitionSpeed: ' . (isset($this->settings['thumb_transitionSpeed']) && $this->settings['thumb_transitionSpeed'] != '' ? $this->settings['thumb_transitionSpeed'] : $constant['thumb_transitionSpeed']) . ',

                            fitInViewport: ' . (isset($this->settings['thumb_fitInViewport']) && $this->settings['thumb_fitInViewport'] != '' ? $this->settings['thumb_fitInViewport'] : $constant['thumb_fitInViewport']) . ',

                            arrowLeft: ' . (isset($this->settings['thumb_arrowLeft']) && $this->settings['thumb_arrowLeft'] != '' ? "$('" . $this->settings['thumb_arrowLeft'] . "')" : $constant['thumb_arrowLeft']) . ',

                            arrowRight: ' . (isset($this->settings['thumb_arrowRight']) && $this->settings['thumb_arrowRight'] != '' ? "$('" . $this->settings['thumb_arrowRight'] . "')" : $constant['thumb_arrowRight']) . ',

                        }

                        ';
        } elseif ($slider_type == 'fullscreen') {
            $id = "(function($) { $('#full-width-slider-" . $getContentId . "').royalSlider({";
            $type = '
                        imgWidth: ' . (isset($this->settings['imgWidth']) && $this->settings['imgWidth'] != '' ? $this->settings['imgWidth'] : $constant['imgWidth']) . ',
                        imgHeight: ' . (isset($this->settings['imgHeight']) && $this->settings['imgHeight'] != '' ? $this->settings['imgHeight'] : $constant['imgHeight']) . ',
                        arrowsNavHideOnTouch: ' . (isset($this->settings['arrowsNavHideOnTouch']) && $this->settings['arrowsNavHideOnTouch'] != '' ? $this->settings['arrowsNavHideOnTouch'] : $constant['arrowsNavHideOnTouch']) . ',
                        fullscreen:{
                            enabled : ' . (isset($this->settings['fullScreen_enabled']) && $this->settings['fullScreen_enabled'] != '' ? $this->settings['fullScreen_enabled'] : $constant['fullScreen_enabled']) . ',
                            keyboardNav : ' . (isset($this->settings['fullScreen_keyboardNav']) && $this->settings['fullScreen_keyboardNav'] != '' ? $this->settings['fullScreen_keyboardNav'] : $constant['fullScreen_keyboardNav']) . ',
                            buttonFS : ' . (isset($this->settings['fullScreen_buttonFS']) && $this->settings['fullScreen_buttonFS'] != '' ? $this->settings['fullScreen_buttonFS'] : $constant['fullScreen_buttonFS']) . ',
                            nativeFS : ' . (isset($this->settings['fullScreen_nativeFS']) && $this->settings['fullScreen_nativeFS'] != '' ? $this->settings['fullScreen_nativeFS'] : $constant['fullScreen_nativeFS']) . ',
                        },
                        thumbs: {
                            appendSpan: ' . (isset($this->settings['thumbs_appendSpan']) && $this->settings['thumbs_appendSpan'] != '' ? $this->settings['thumbs_appendSpan'] : $constant['thumbs_appendSpan']) . ',
                            firstMargin: ' . (isset($this->settings['thumbs_firstMargin']) && $this->settings['thumbs_firstMargin'] != '' ? $this->settings['thumbs_firstMargin'] : $constant['thumbs_firstMargin']) . ',

                            drag: ' . (isset($this->settings['thumb_drag']) && $this->settings['thumb_drag'] != '' ? $this->settings['thumb_drag'] : $constant['thumb_drag']) . ',

                            touch: ' . (isset($this->settings['thumb_touch']) && $this->settings['thumb_touch'] != '' ? $this->settings['thumb_touch'] : $constant['thumb_touch']) . ",

                            orientation: '" . (isset($this->settings['thumb_orientation']) && $this->settings['thumb_orientation'] != '' ? $this->settings['thumb_orientation'] : $constant['thumb_orientation']) . "',

                            arrows: " . (isset($this->settings['thumb_arrows']) && $this->settings['thumb_arrows'] != '' ? $this->settings['thumb_arrows'] : $constant['thumb_arrows']) . ',

                            spacing: ' . (isset($this->settings['thumb_spacing']) && $this->settings['thumb_spacing'] != '' ? $this->settings['thumb_spacing'] : $constant['thumb_spacing']) . ',

                            arrowsAutoHide: ' . (isset($this->settings['thumb_arrowsAutoHide']) && $this->settings['thumb_arrowsAutoHide'] != '' ? $this->settings['thumb_arrowsAutoHide'] : $constant['thumb_arrowsAutoHide']) . ',

                            autoCenter: ' . (isset($this->settings['thumb_autoCenter']) && $this->settings['thumb_autoCenter'] != '' ? $this->settings['thumb_autoCenter'] : $constant['thumb_autoCenter']) . ',

                            transitionSpeed: ' . (isset($this->settings['thumb_transitionSpeed']) && $this->settings['thumb_transitionSpeed'] != '' ? $this->settings['thumb_transitionSpeed'] : $constant['thumb_transitionSpeed']) . ',

                            fitInViewport: ' . (isset($this->settings['thumb_fitInViewport']) && $this->settings['thumb_fitInViewport'] != '' ? $this->settings['thumb_fitInViewport'] : $constant['thumb_fitInViewport']) . ',

                            arrowLeft: ' . (isset($this->settings['thumb_arrowLeft']) && $this->settings['thumb_arrowLeft'] != '' ? "$('" . $this->settings['thumb_arrowLeft'] . "')" : $constant['thumb_arrowLeft']) . ',

                            arrowRight: ' . (isset($this->settings['thumb_arrowRight']) && $this->settings['thumb_arrowRight'] != '' ? "$('" . $this->settings['thumb_arrowRight'] . "')" : $constant['thumb_arrowRight']) . ',

                        }';
        }

        $this->extKey = $this->extKey ?? '';
        $GLOBALS['TSFE']->additionalFooterData[$this->extKey] = $GLOBALS['TSFE']->additionalFooterData[$this->extKey] ?? '';
        $GLOBALS['TSFE']->additionalFooterData[$this->extKey] .= "<script>
            if (typeof jQuery == 'undefined') {
                alert('Please include Jquery library first!');
            }
        </script>";
        $GLOBALS['TSFE']->additionalFooterData[$this->extKey] .= '<script>
                    ' . $id . '
                        arrowsNav: ' . (isset($this->settings['arrowsNav']) && $this->settings['arrowsNav'] != '' ? $this->settings['arrowsNav'] : $constant['arrowsNav']) . ',
                        loop: ' . (isset($this->settings['loop']) && $this->settings['loop'] != '' ? $this->settings['loop'] : $constant['loop']) . ',
                        keyboardNavEnabled: ' . (isset($this->settings['keyboardNavEnabled']) && $this->settings['keyboardNavEnabled'] != '' ? $this->settings['keyboardNavEnabled'] : $constant['keyboardNavEnabled']) . ',
                        controlsInside: ' . (isset($this->settings['controlsInside']) && $this->settings['controlsInside'] != '' ? $this->settings['controlsInside'] : $constant['controlsInside']) . ",
                        imageScaleMode: '" . (isset($this->settings['imageScaleMode']) && $this->settings['imageScaleMode'] != '' ? $this->settings['imageScaleMode'] : $constant['imageScaleMode']) . "',
                        arrowsNavAutoHide: " . (isset($this->settings['arrowsNavAutoHide']) && $this->settings['arrowsNavAutoHide'] != '' ? $this->settings['arrowsNavAutoHide'] : $constant['arrowsNavAutoHide']) . ',


                        autoScaleSlider: ' . (isset($this->settings['autoScaleSlider']) && $this->settings['autoScaleSlider'] != '' ? $this->settings['autoScaleSlider'] : $constant['autoScaleSlider']) . ',
                        autoScaleSliderWidth: ' . (isset($this->settings['autoScaleSliderWidth']) && $this->settings['autoScaleSliderWidth'] != '' ? $this->settings['autoScaleSliderWidth'] : $constant['autoScaleSliderWidth']) . ',
                        autoScaleSliderHeight: ' . (isset($this->settings['autoScaleSliderHeight']) && $this->settings['autoScaleSliderHeight'] != '' ? $this->settings['autoScaleSliderHeight'] : $constant['autoScaleSliderHeight']) . ",
                        controlNavigation: '" . (isset($this->settings['controlNavigation']) && $this->settings['controlNavigation'] != '' ? $this->settings['controlNavigation'] : $constant['controlNavigation']) . "',
                        navigateByClick: " . (isset($this->settings['navigateByClick']) && $this->settings['navigateByClick'] != '' ? $this->settings['navigateByClick'] : $constant['navigateByClick']) . ',
                        startSlideId: ' . (isset($this->settings['startSlideId'])  && $this->settings['startSlideId'] != '' ? $this->settings['startSlideId'] : $constant['startSlideId']) . ",
                        transitionType: '" . (isset($this->settings['transitionType']) && $this->settings['transitionType'] != '' ? $this->settings['transitionType'] : $constant['transitionType']) . "',
                        globalCaption: " . (isset($this->settings['globalCaption']) && $this->settings['globalCaption'] != '' ? $this->settings['globalCaption'] : $constant['globalCaption']) . ',

                        imageAlignCenter: ' . (isset($this->settings['imageAlignCenter']) && $this->settings['imageAlignCenter'] != '' ? $this->settings['imageAlignCenter'] : $constant['imageAlignCenter']) . ',
                        slidesSpacing: ' . (isset($this->settings['slidesSpacing']) && $this->settings['slidesSpacing'] != '' ? $this->settings['slidesSpacing'] : $constant['slidesSpacing']) . ',
                        loopRewind: ' . (isset($this->settings['loopRewind']) && $this->settings['loopRewind'] != '' ? $this->settings['loopRewind'] : $constant['loopRewind']) . ',
                        randomizeSlides: ' . (isset($this->settings['randomizeSlides']) && $this->settings['randomizeSlides'] != '' ? $this->settings['randomizeSlides'] : $constant['randomizeSlides']) . ',
                        numImagesToPreload: ' . (isset($this->settings['numImagesToPreload']) && $this->settings['numImagesToPreload'] != '' ? $this->settings['numImagesToPreload'] : $constant['numImagesToPreload']) . ',
                        usePreloader: ' . (isset($this->settings['usePreloader']) && $this->settings['usePreloader'] != '' ? $this->settings['usePreloader'] : $constant['usePreloader']) . ",
                        slidesOrientation: '" . (isset($this->settings['slidesOrientation']) && $this->settings['slidesOrientation'] != '' ? $this->settings['slidesOrientation'] : $constant['slidesOrientation']) . "',
                        transitionSpeed: " . (isset($this->settings['transitionSpeed']) && $this->settings['transitionSpeed'] > 0 ? $this->settings['transitionSpeed'] : $constant['transitionSpeed']) . ",
                        easeInOut: '" . (isset($this->settings['easeInOut']) && $this->settings['easeInOut'] != '' ? $this->settings['easeInOut'] : $constant['easeInOut']) . "',
                        easeOut: '" . (isset($this->settings['easeOut']) && $this->settings['easeOut'] != '' ? $this->settings['easeOut'] : $constant['easeOut']) . "',
                        sliderDrag: " . (isset($this->settings['sliderDrag']) && $this->settings['sliderDrag'] != '' ? $this->settings['sliderDrag'] : $constant['sliderDrag']) . ',
                        sliderTouch: ' . (isset($this->settings['sliderTouch']) && $this->settings['sliderTouch'] != '' ? $this->settings['sliderTouch'] : $constant['sliderTouch']) . ',
                        allowCSS3: ' . (isset($this->settings['allowCSS3']) && $this->settings['allowCSS3'] != '' ? $this->settings['allowCSS3'] : $constant['allowCSS3']) . ',
                        addActiveClass: ' . (isset($this->settings['addActiveClass']) && $this->settings['addActiveClass'] != '' ? $this->settings['addActiveClass'] : $constant['addActiveClass']) . ',
                        minSlideOffset: ' . (isset($this->settings['minSlideOffset']) && $this->settings['minSlideOffset'] != '' ? $this->settings['minSlideOffset'] : $constant['minSlideOffset']) . ',
                        autoHeight: ' . (isset($this->settings['autoHeight']) && $this->settings['autoHeight'] != '' ? $this->settings['autoHeight'] : $constant['autoHeight']) . ',

                        autoPlay: {
                            enabled: ' . (isset($this->settings['autoPlay']) && $this->settings['autoPlay'] != '' ? $this->settings['autoPlay'] : $constant['autoPlay']) . ',
                            stopAtAction: ' . (isset($this->settings['autoPlay_stopAtAction']) && $this->settings['autoPlay_stopAtAction'] != '' ? $this->settings['autoPlay_stopAtAction'] : $constant['autoPlay_stopAtAction']) . ',
                            pauseOnHover: ' . (isset($this->settings['autoPlay_pauseOnHover']) && $this->settings['autoPlay_pauseOnHover'] != '' ? $this->settings['autoPlay_pauseOnHover'] : $constant['autoPlay_pauseOnHover']) . ',
                            delay: ' . (isset($this->settings['autoPlay_delay']) && $this->settings['autoPlay_delay'] != '' ? $this->settings['autoPlay_delay'] : $constant['autoPlay_delay']) . ',
                        },

                        ' . $type . '
                    });
                })(jQuery);
            </script>';


        //variable saved in flexform
        $this->view->assign('settings', $this->settings);

        // show pluging name
        $this->view->assign('pluginName', $pluginName);
        return $this->htmlResponse();
    }
}
