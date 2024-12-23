<?php

namespace NITSAN\NsNewsSlider\Controller;

use GeorgRinger\News\Controller\NewsController;
use GeorgRinger\News\Domain\Repository\NewsRepository;
use TYPO3\CMS\Core\Core\Environment;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Resource\Exception\InvalidFileException;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;

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
class RoyalController extends NewsController
{
    /**
     * @var NewsRepository
     */
    protected NewsRepository $newsRepository;

    /**
     * @var string
     */
    protected string $extKey = '';

    /**
     * action list
     *
     * @param array|null $overwriteDemand
     * @return ResponseInterface
     * @throws InvalidFileException
     */
    public function listAction(array $overwriteDemand = null): ResponseInterface
    {
        $this->extKey = $this->request->getControllerExtensionKey();
        $news = $this->findNews();
        if (Environment::isComposerMode()) {
            $assetPath = $this->getPath('/', 'ns_news_slider');
            $extpath = GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . $assetPath;
        } else {
            $extpath = PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('ns_news_slider')).'Resources/Public/';
        }
        $pluginName = $this->request->getPluginName();
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $currentContentObject = $this->request->getAttribute('currentContentObject');
        $getContentId = $currentContentObject->data['uid'];
        // add css js in header
        $GLOBALS['TSFE']->additionalHeaderData[$this->extKey . 'CSS1'] = '<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Royal-Slider/css/style.css" />';
        $GLOBALS['TSFE']->additionalHeaderData[$this->extKey . 'CSS2'] = '<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Royal-Slider/css/vendor/royalslider.css" />';
        $GLOBALS['TSFE']->additionalHeaderData[$this->extKey . 'CSS3'] = '<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Royal-Slider/css/vendor/skins/minimal-white/rs-minimal-white.css" />';

        // set js value for slider

        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $typoScriptSetup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $constant = $typoScriptSetup['plugin.']['tx_nsnewsslider_royalslider.']['settings.'] ?? [];

        //vendar js file path
        $extvendorjspath = $extpath . 'slider/Royal-Slider/js/vendor/';

        if ($constant['jQuery'] ?? 0) {
            $ajax1 = $extvendorjspath .'jquery.min.js';
            $pageRenderer->addJsFooterFile($ajax1, 'text/javascript', false, false, '');
        }
        $ajax2 = $extvendorjspath . 'jquery.royalslider.min.js';
        $ajax3 = $extvendorjspath . 'jquery.easing-1.3.js';
        $pageRenderer->addJsFooterFile($ajax2, 'text/javascript', false, false, '');
        $pageRenderer->addJsFooterFile($ajax3, 'text/javascript', false, false, '');

        $slider_type = $this->settings['slider_type_royal'] ?? '';
        $type = '';
        $id = "(function($) { $('#full-width-slider-" . $getContentId . "').royalSlider({";
        if ($slider_type == 'fullwidth') {
            $type = '
                deeplinking: {
                   enabled: ' . (isset($this->settings['deeplinking_enabled']) && $this->settings['deeplinking_enabled'] != '' ? $this->settings['deeplinking_enabled'] : $constant['deeplinking_enabled']) . ',
                   change: ' . (isset($this->settings['deeplinking_change']) && $this->settings['deeplinking_change'] != '' ? $this->settings['deeplinking_change'] : $constant['deeplinking_change']) . ',
                   prefix: "' . (isset($this->settings['deeplinking_prefix']) && $this->settings['deeplinking_prefix'] != '' ? $this->settings['deeplinking_prefix'] : $constant['deeplinking_prefix']) . '"
                },
                ';
        } elseif ($slider_type == 'fullscreen') {
            $type = '
                fullscreen:{
                    enabled : ' . (isset($this->settings['fullScreen_enabled']) && $this->settings['fullScreen_enabled'] != '' ? $this->settings['fullScreen_enabled'] : $constant['fullScreen_enabled']) . ',
                    keyboardNav : ' . (isset($this->settings['fullScreen_keyboardNav']) && $this->settings['fullScreen_keyboardNav'] != '' ? $this->settings['fullScreen_keyboardNav'] : $constant['fullScreen_keyboardNav']) . ',
                    buttonFS : ' . (isset($this->settings['fullScreen_buttonFS']) && $this->settings['fullScreen_buttonFS'] != '' ? $this->settings['fullScreen_buttonFS'] : $constant['fullScreen_buttonFS']) . ',
                    nativeFS : ' . (isset($this->settings['fullScreen_nativeFS']) && $this->settings['fullScreen_nativeFS'] != '' ? $this->settings['fullScreen_nativeFS'] : $constant['fullScreen_nativeFS']) . ',
                },
                ';
        }
        $type .= '
                imgWidth: ' . (isset($this->settings['imgWidth']) && $this->settings['imgWidth'] != '' ? $this->settings['imgWidth'] : $constant['imgWidth']) . ',
                imgHeight: ' . (isset($this->settings['imgHeight']) && $this->settings['imgHeight'] != '' ? $this->settings['imgHeight'] : $constant['imgHeight']) . ',
                arrowsNavHideOnTouch: ' . (isset($this->settings['arrowsNavHideOnTouch']) && $this->settings['arrowsNavHideOnTouch'] != '' ? $this->settings['arrowsNavHideOnTouch'] : $constant['arrowsNavHideOnTouch']) . ',
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
                    arrowLeft: ' . (isset($this->settings['thumb_arrowLeft']) && $this->settings['thumb_arrowLeft'] != '' ? $this->settings['thumb_arrowLeft'] : $constant['thumb_arrowLeft']) . ',
                    arrowRight: ' . (isset($this->settings['thumb_arrowRight']) && $this->settings['thumb_arrowRight'] != '' ? $this->settings['thumb_arrowRight'] : $constant['thumb_arrowRight']) . '}';
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

        $this->view->assignMultiple(
            [
                'pluginName' => $pluginName,
                'settings' => $this->settings,
                'slider_type' => $slider_type,
                'news' => $news
            ]
        );
        return $this->htmlResponse();
    }

    /**
     * @param array|null $overwriteDemand
     * @return QueryResultInterface|array
     */
    public function findNews(array $overwriteDemand = null): QueryResultInterface|array
    {
        $demand = parent::createDemandObjectFromSettings($this->settings);
        if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== null) {
            $demand = parent::overwriteDemandObject($demand, $overwriteDemand);
        }
        $news = $this->newsRepository->findDemanded($demand);
        if (!count($news)) {
            $this->addFlashMessage(
                LocalizationUtility::translate('fe.nonews', 'ns_news_slider'),
                LocalizationUtility::translate('fe.nonewsTitle', 'ns_news_slider'),
                ContextualFeedbackSeverity::WARNING
            );
        }
        return $news;
    }

    /**
     * getPath for composer based setup
     * @param string $path
     * @param string $extName
     * @return string
     * @throws InvalidFileException
     */
    public function getPath(string $path, string $extName): string
    {
        $arguments = ['path' => $path, 'extensionName' => $extName];
        $path = $arguments['path'];
        $publicPath = sprintf('EXT:%s/Resources/Public/%s', $arguments['extensionName'], ltrim($path, '/'));
        $uri = PathUtility::getPublicResourceWebPath($publicPath);
        return substr($uri, 1);
    }
}
