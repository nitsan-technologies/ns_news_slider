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

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);

        if (Environment::isComposerMode()) {
            $assetPath = $this->getPath('/', 'ns_news_slider');
            $extpath = GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . $assetPath;
            $cssPath = 'slider/Royal-Slider/css/';
            $jsPath = 'slider/Royal-Slider/js/vendor/';
            $ajax2 = $extpath . $jsPath . 'jquery.royalslider.min.js';
            $ajax3 = $extpath . $jsPath . 'jquery.easing.js';
        } else {
            $extpath = PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('ns_news_slider'));
            $cssPath = 'Resources/Public/slider/Royal-Slider/css/';
            $jsPath = 'Resources/Public/slider/Royal-Slider/js/vendor/';
            $ajax2 = 'EXT:ns_news_slider/' . $jsPath . 'jquery.royalslider.min.js';
            $ajax3 = 'EXT:ns_news_slider/' . $jsPath . 'jquery.easing.js';
        }

        $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . $cssPath . 'style.css" />');
        $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . $cssPath . 'vendor/royalslider.css" />');
        $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . $cssPath . 'vendor/skins/minimal-white/rs-minimal-white.css" />');

        $pluginName = $this->request->getPluginName();

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        // @extensionScannerIgnoreLine
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
                        enabled: ' . (isset($this->settings['deeplinking_enabled']) && $this->settings['deeplinking_enabled'] != '' ? $this->settings['deeplinking_enabled'] : (($constant['deeplinking_enabled'] ?? '') === '' ? 'false' : 'true')) . ',
                        change: ' . (isset($this->settings['deeplinking_change']) && $this->settings['deeplinking_change'] != '' ? $this->settings['deeplinking_change'] : (($constant['deeplinking_change'] ?? '') === '' ? 'false' : 'true')) . ",
                        prefix: '" . (isset($this->settings['deeplinking_prefix']) && $this->settings['deeplinking_prefix'] != '' ? $this->settings['deeplinking_prefix'] : (($constant['deeplinking_prefix'] ?? '') === '' ? 'false' : $constant['deeplinking_prefix'])) . "'
                    },

                    imgWidth: " . (isset($this->settings['imgWidth']) && $this->settings['imgWidth'] != '' ? $this->settings['imgWidth'] : (($constant['imgWidth'] ?? '') === '' ? 'false' : $constant['imgWidth'])) . ',
                    imgHeight: ' . (isset($this->settings['imgHeight']) && $this->settings['imgHeight'] != '' ? $this->settings['imgHeight'] : (($constant['imgHeight'] ?? '') === '' ? 'false' : $constant['imgHeight'])) . ',

                    thumbs: {
                        appendSpan: ' . (isset($this->settings['thumbs_appendSpan']) && $this->settings['thumbs_appendSpan'] != '' ? $this->settings['thumbs_appendSpan'] : (($constant['thumbs_appendSpan'] ?? '') === '' ? 'false' : 'true')) . ',
                        firstMargin: ' . (isset($this->settings['thumbs_firstMargin']) && $this->settings['thumbs_firstMargin'] != '' ? $this->settings['thumbs_firstMargin'] : (($constant['thumbs_firstMargin'] ?? '') === '' ? 'false' : 'true')) . ',

                        drag: ' . (isset($this->settings['thumb_drag']) && $this->settings['thumb_drag'] != '' ? $this->settings['thumb_drag'] : (($constant['thumb_drag'] ?? '') === '' ? 'false' : 'true')) . ',

                        touch: ' . (isset($this->settings['thumb_touch']) && $this->settings['thumb_touch'] != '' ? $this->settings['thumb_touch'] : (($constant['thumb_touch'] ?? '') === '' ? 'false' : 'true')) . ",

                        orientation: '" . (isset($this->settings['thumb_orientation']) && $this->settings['thumb_orientation'] != '' ? $this->settings['thumb_orientation'] : (($constant['thumb_orientation'] ?? '') === '' ? 'false' : $constant['thumb_orientation'])) . "',

                        arrows: " . (isset($this->settings['thumb_arrows']) && $this->settings['thumb_arrows'] != '' ? $this->settings['thumb_arrows'] : (($constant['thumb_arrows'] ?? '') === '' ? 'false' : 'true')) . ',

                        spacing: ' . (isset($this->settings['thumb_spacing']) && $this->settings['thumb_spacing'] != '' ? $this->settings['thumb_spacing'] : (($constant['thumb_spacing'] ?? '') === '' ? 'false' : $constant['thumb_spacing'])) . ',

                        arrowsAutoHide: ' . (isset($this->settings['thumb_arrowsAutoHide']) && $this->settings['thumb_arrowsAutoHide'] != '' ? $this->settings['thumb_arrowsAutoHide'] : (($constant['thumb_arrowsAutoHide'] ?? '') === '' ? 'false' : 'true')) . ',

                        autoCenter: ' . (isset($this->settings['thumb_autoCenter']) && $this->settings['thumb_autoCenter'] != '' ? $this->settings['thumb_autoCenter'] : (($constant['thumb_autoCenter'] ?? '') === '' ? 'false' : 'true')) . ',

                        transitionSpeed: ' . (isset($this->settings['thumb_transitionSpeed']) && $this->settings['thumb_transitionSpeed'] != '' ? $this->settings['thumb_transitionSpeed'] : (($constant['thumb_transitionSpeed'] ?? '') === '' ? 'false' : $constant['thumb_transitionSpeed'])) . ',

                        fitInViewport: ' . (isset($this->settings['thumb_fitInViewport']) && $this->settings['thumb_fitInViewport'] != '' ? $this->settings['thumb_fitInViewport'] : (($constant['thumb_fitInViewport'] ?? '') === '' ? 'false' : 'true')) . ',

                        arrowLeft: ' . (isset($this->settings['thumb_arrowLeft']) && $this->settings['thumb_arrowLeft'] != '' ? "$('" . $this->settings['thumb_arrowLeft'] . "')" : (($constant['thumb_arrowLeft'] ?? '') === '' ? '0' : $constant['thumb_arrowLeft'])) . ',

                        arrowRight: ' . (isset($this->settings['thumb_arrowRight']) && $this->settings['thumb_arrowRight'] != '' ? "$('" . $this->settings['thumb_arrowRight'] . "')" : (($constant['thumb_arrowRight'] ?? '') === '' ? '0' : $constant['thumb_arrowRight'])) . ',
                    }

                    ';
        } elseif ($slider_type == 'fullscreen') {
            $id = "(function($) { $('#full-width-slider-" . $getContentId . "').royalSlider({";
            $type = '
                    imgWidth: ' . (!empty($this->settings['imgWidth'])
                        ? $this->settings['imgWidth']
                        : (($constant['imgWidth'] ?? '') === '' ? '0' : $constant['imgWidth'])) . ',

                    imgHeight: ' . (!empty($this->settings['imgHeight'])
                        ? $this->settings['imgHeight']
                        : (($constant['imgHeight'] ?? '') === '' ? '0' : $constant['imgHeight'])) . ',

                    arrowsNavHideOnTouch: ' . (!empty($this->settings['arrowsNavHideOnTouch'])
                        ? $this->settings['arrowsNavHideOnTouch']
                        : (($constant['arrowsNavHideOnTouch'] ?? '') === '' ? 'false' : $constant['arrowsNavHideOnTouch'])) . ',

                    fullscreen:{
                        enabled : ' . (!empty($this->settings['fullScreen_enabled'])
                            ? $this->settings['fullScreen_enabled']
                            : (($constant['fullScreen_enabled'] ?? '') === '' ? 'false' : $constant['fullScreen_enabled'])) . ',

                        keyboardNav : ' . (!empty($this->settings['fullScreen_keyboardNav'])
                            ? $this->settings['fullScreen_keyboardNav']
                            : (($constant['fullScreen_keyboardNav'] ?? '') === '' ? 'false' : $constant['fullScreen_keyboardNav'])) . ',

                        buttonFS : ' . (!empty($this->settings['fullScreen_buttonFS'])
                            ? $this->settings['fullScreen_buttonFS']
                            : (($constant['fullScreen_buttonFS'] ?? '') === '' ? 'false' : $constant['fullScreen_buttonFS'])) . ',

                        nativeFS : ' . (!empty($this->settings['fullScreen_nativeFS'])
                            ? $this->settings['fullScreen_nativeFS']
                            : (($constant['fullScreen_nativeFS'] ?? '') === '' ? 'false' : $constant['fullScreen_nativeFS'])) . ',
                    },

                    thumbs: {
                        appendSpan: ' . (!empty($this->settings['thumbs_appendSpan'])
                            ? $this->settings['thumbs_appendSpan']
                            : (($constant['thumbs_appendSpan'] ?? '') === '' ? 'false' : $constant['thumbs_appendSpan'])) . ',

                        firstMargin: ' . (!empty($this->settings['thumbs_firstMargin'])
                            ? $this->settings['thumbs_firstMargin']
                            : (($constant['thumbs_firstMargin'] ?? '') === '' ? 'false' : $constant['thumbs_firstMargin'])) . ',

                        drag: ' . (!empty($this->settings['thumb_drag'])
                            ? $this->settings['thumb_drag']
                            : (($constant['thumb_drag'] ?? '') === '' ? 'false' : $constant['thumb_drag'])) . ',

                        touch: ' . (!empty($this->settings['thumb_touch'])
                            ? $this->settings['thumb_touch']
                            : (($constant['thumb_touch'] ?? '') === '' ? 'false' : $constant['thumb_touch'])) . ",

                        orientation: '" . (!empty($this->settings['thumb_orientation'])
                            ? $this->settings['thumb_orientation']
                            : (($constant['thumb_orientation'] ?? '') === '' ? 'horizontal' : $constant['thumb_orientation'])) . "',

                        arrows: " . (!empty($this->settings['thumb_arrows'])
                            ? $this->settings['thumb_arrows']
                            : (($constant['thumb_arrows'] ?? '') === '' ? 'false' : $constant['thumb_arrows'])) . ',

                        spacing: ' . (!empty($this->settings['thumb_spacing'])
                            ? $this->settings['thumb_spacing']
                            : (($constant['thumb_spacing'] ?? '') === '' ? '0' : $constant['thumb_spacing'])) . ',

                        arrowsAutoHide: ' . (!empty($this->settings['thumb_arrowsAutoHide'])
                            ? $this->settings['thumb_arrowsAutoHide']
                            : (($constant['thumb_arrowsAutoHide'] ?? '') === '' ? 'false' : $constant['thumb_arrowsAutoHide'])) . ',

                        autoCenter: ' . (!empty($this->settings['thumb_autoCenter'])
                            ? $this->settings['thumb_autoCenter']
                            : (($constant['thumb_autoCenter'] ?? '') === '' ? 'false' : $constant['thumb_autoCenter'])) . ',

                        transitionSpeed: ' . (!empty($this->settings['thumb_transitionSpeed'])
                            ? $this->settings['thumb_transitionSpeed']
                            : (($constant['thumb_transitionSpeed'] ?? '') === '' ? '300' : $constant['thumb_transitionSpeed'])) . ',

                        fitInViewport: ' . (!empty($this->settings['thumb_fitInViewport'])
                            ? $this->settings['thumb_fitInViewport']
                            : (($constant['thumb_fitInViewport'] ?? '') === '' ? 'false' : $constant['thumb_fitInViewport'])) . ',

                        arrowLeft: ' . (!empty($this->settings['thumb_arrowLeft'])
                            ? "$('" . $this->settings['thumb_arrowLeft'] . "')"
                            : (($constant['thumb_arrowLeft'] ?? '') === '' ? 'false' : $constant['thumb_arrowLeft'])) . ',

                        arrowRight: ' . (!empty($this->settings['thumb_arrowRight'])
                            ? "$('" . $this->settings['thumb_arrowRight'] . "')"
                            : (($constant['thumb_arrowRight'] ?? '') === '' ? 'false' : $constant['thumb_arrowRight'])) . ',
                    }';
        }

        $footerData = "<script>
            if (typeof jQuery == 'undefined') {
                alert('Please include Jquery library first!');
            }
        </script>";
        $footerData .= '<script>
                    ' . $id . '
                    arrowsNav: ' . (!empty($this->settings['arrowsNav'])
                        ? $this->settings['arrowsNav']
                        : (($constant['arrowsNav'] ?? '') === '' ? 'false' : 'true')) . ',

                    loop: ' . (!empty($this->settings['loop'])
                        ? $this->settings['loop']
                        : (($constant['loop'] ?? '') === '' ? 'false' : 'true')) . ',

                    keyboardNavEnabled: ' . (!empty($this->settings['keyboardNavEnabled'])
                        ? $this->settings['keyboardNavEnabled']
                        : (($constant['keyboardNavEnabled'] ?? '') === '' ? 'false' : 'true')) . ',

                    controlsInside: ' . (!empty($this->settings['controlsInside'])
                        ? $this->settings['controlsInside']
                        : (($constant['controlsInside'] ?? '') === '' ? 'false' : 'true')) . ",

                    imageScaleMode: '" . (!empty($this->settings['imageScaleMode'])
                        ? $this->settings['imageScaleMode']
                        : (($constant['imageScaleMode'] ?? '') === '' ? 'fit-if-smaller' : $constant['imageScaleMode'])) . "',

                    arrowsNavAutoHide: " . (!empty($this->settings['arrowsNavAutoHide'])
                        ? $this->settings['arrowsNavAutoHide']
                        : (($constant['arrowsNavAutoHide'] ?? '') === '' ? 'false' : 'true')) . ',

                    autoScaleSlider: ' . (!empty($this->settings['autoScaleSlider'])
                        ? $this->settings['autoScaleSlider']
                        : (($constant['autoScaleSlider'] ?? '') === '' ? 'false' : 'true')) . ',

                    autoScaleSliderWidth: ' . (!empty($this->settings['autoScaleSliderWidth'])
                        ? $this->settings['autoScaleSliderWidth']
                        : (($constant['autoScaleSliderWidth'] ?? '') === '' ? '0' : $constant['autoScaleSliderWidth'])) . ',

                    autoScaleSliderHeight: ' . (!empty($this->settings['autoScaleSliderHeight'])
                        ? $this->settings['autoScaleSliderHeight']
                        : (($constant['autoScaleSliderHeight'] ?? '') === '' ? '0' : $constant['autoScaleSliderHeight'])) . ",

                    controlNavigation: '" . (!empty($this->settings['controlNavigation'])
                        ? $this->settings['controlNavigation']
                        : (($constant['controlNavigation'] ?? '') === '' ? 'thumbnails' : $constant['controlNavigation'])) . "',

                    navigateByClick: " . (!empty($this->settings['navigateByClick'])
                        ? $this->settings['navigateByClick']
                        : (($constant['navigateByClick'] ?? '') === '' ? 'false' : 'true')) . ',

                    startSlideId: ' . (!empty($this->settings['startSlideId'])
                        ? $this->settings['startSlideId']
                        : (($constant['startSlideId'] ?? '') === '' ? '0' : $constant['startSlideId'])) . ",

                    transitionType: '" . (!empty($this->settings['transitionType'])
                        ? $this->settings['transitionType']
                        : (($constant['transitionType'] ?? '') === '' ? 'move' : $constant['transitionType'])) . "',

                    globalCaption: " . (!empty($this->settings['globalCaption'])
                        ? $this->settings['globalCaption']
                        : (($constant['globalCaption'] ?? '') === '' ? 'false' : 'true')) . ',

                    imageAlignCenter: ' . (!empty($this->settings['imageAlignCenter'])
                        ? $this->settings['imageAlignCenter']
                        : (($constant['imageAlignCenter'] ?? '') === '' ? 'false' : 'true')) . ',

                    slidesSpacing: ' . (!empty($this->settings['slidesSpacing'])
                        ? $this->settings['slidesSpacing']
                        : (($constant['slidesSpacing'] ?? '') === '' ? '0' : $constant['slidesSpacing'])) . ',

                    loopRewind: ' . (!empty($this->settings['loopRewind'])
                        ? $this->settings['loopRewind']
                        : (($constant['loopRewind'] ?? '') === '' ? 'false' : 'true')) . ',

                    randomizeSlides: ' . (!empty($this->settings['randomizeSlides'])
                        ? $this->settings['randomizeSlides']
                        : (($constant['randomizeSlides'] ?? '') === '' ? 'false' : $constant['randomizeSlides'])) . ',

                    numImagesToPreload: ' . (!empty($this->settings['numImagesToPreload'])
                        ? $this->settings['numImagesToPreload']
                        : (($constant['numImagesToPreload'] ?? '') === '' ? '0' : $constant['numImagesToPreload'])) . ',

                    usePreloader: ' . (!empty($this->settings['usePreloader'])
                        ? $this->settings['usePreloader']
                        : (($constant['usePreloader'] ?? '') === '' ? 'false' : $constant['usePreloader'])) . ",

                    slidesOrientation: '" . (!empty($this->settings['slidesOrientation'])
                        ? $this->settings['slidesOrientation']
                        : (($constant['slidesOrientation'] ?? '') === '' ? 'horizontal' : $constant['slidesOrientation'])) . "',

                    transitionSpeed: " . (!empty($this->settings['transitionSpeed'])
                        ? $this->settings['transitionSpeed']
                        : (($constant['transitionSpeed'] ?? '') === '' ? '500' : $constant['transitionSpeed'])) . ",

                    easeInOut: '" . (!empty($this->settings['easeInOut'])
                        ? $this->settings['easeInOut']
                        : (($constant['easeInOut'] ?? '') === '' ? 'easeInOutSine' : $constant['easeInOut'])) . "',

                    easeOut: '" . (!empty($this->settings['easeOut'])
                        ? $this->settings['easeOut']
                        : (($constant['easeOut'] ?? '') === '' ? 'easeOutSine' : $constant['easeOut'])) . "',

                    sliderDrag: " . (!empty($this->settings['sliderDrag'])
                        ? $this->settings['sliderDrag']
                        : (($constant['sliderDrag'] ?? '') === '' ? 'false' : 'true')) . ',

                    sliderTouch: ' . (!empty($this->settings['sliderTouch'])
                        ? $this->settings['sliderTouch']
                        : (($constant['sliderTouch'] ?? '') === '' ? 'false' : 'true')) . ',

                    allowCSS3: ' . (!empty($this->settings['allowCSS3'])
                        ? $this->settings['allowCSS3']
                        : (($constant['allowCSS3'] ?? '') === '' ? 'false' : $constant['allowCSS3'])) . ',

                    addActiveClass: ' . (!empty($this->settings['addActiveClass'])
                        ? $this->settings['addActiveClass']
                        : (($constant['addActiveClass'] ?? '') === '' ? 'false' : $constant['addActiveClass'])) . ',

                    minSlideOffset: ' . (!empty($this->settings['minSlideOffset'])
                        ? $this->settings['minSlideOffset']
                        : (($constant['minSlideOffset'] ?? '') === '' ? '0' : $constant['minSlideOffset'])) . ',

                    autoHeight: ' . (!empty($this->settings['autoHeight'])
                        ? $this->settings['autoHeight']
                        : (($constant['autoHeight'] ?? '') === '' ? 'false' : 'true')) . ',

                    autoPlay: {
                        enabled: ' . (!empty($this->settings['autoPlay'])
                            ? $this->settings['autoPlay']
                            : (($constant['autoPlay'] ?? '') === '' ? 'false' : 'true')) . ',

                        stopAtAction: ' . (!empty($this->settings['autoPlay_stopAtAction'])
                            ? $this->settings['autoPlay_stopAtAction']
                            : (($constant['autoPlay_stopAtAction'] ?? '') === '' ? 'false' : 'true')) . ',

                        pauseOnHover: ' . (!empty($this->settings['autoPlay_pauseOnHover'])
                            ? $this->settings['autoPlay_pauseOnHover']
                            : (($constant['autoPlay_pauseOnHover'] ?? '') === '' ? 'false' : 'true')) . ',

                        delay: ' . (!empty($this->settings['autoPlay_delay'])
                            ? $this->settings['autoPlay_delay']
                            : (($constant['autoPlay_delay'] ?? '') === '' ? '5000' : $constant['autoPlay_delay'])) . ',
                    },

                    ' . $type . '
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
