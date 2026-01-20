<?php

declare(strict_types=1);

namespace NITSAN\NsNewsSlider\Controller;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Page\PageRenderer;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Resource\Exception\InvalidFileException;
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
 * OwlController
 */
class OwlController extends SliderBaseController
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
     * @throws InvalidFileException
     */
    public function listAction(?array $overwriteDemand = null): ResponseInterface
    {
        $news = $this->findNews();

        // Get settings.
        $settings = $this->settings;
        $settings['sliderType'] = $this->sliderName;
        $this->view->assignMultiple([
            'news' => $news,
            'settings' => $settings
        ]);
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $extensionKey = $this->request->getControllerExtensionKey();
        //$additionalHeaderData = &$GLOBALS['TSFE']->additionalHeaderData;

        //$additionalHeaderData[$extensionKey . 'CSS1'] = '<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet"> ';
        $pageRenderer->addHeaderData('<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">');

        if (Environment::isComposerMode()) {
            $assetPath = $this->getPath('/', 'ns_news_slider');
            $extpath = GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . $assetPath;
            $cssFiles = [
                'slider/owl.carousel/assets/css/custom.css',
                'slider/owl.carousel/owl-carousel/owl.carousel.css',
                'slider/owl.carousel/owl-carousel/owl.theme.default.css',
                'slider/owl.carousel/owl-carousel/owl.transitions.css',
                'slider/owl.carousel/assets/js/google-code-prettify/prettify.css',
                'slider/owl.carousel/assets/css/animate.css',
            ];
        } else {
            $extpath = PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('ns_news_slider'));
            $cssFiles = [
                'Resources/Public/slider/owl.carousel/assets/css/custom.css',
                'Resources/Public/slider/owl.carousel/owl-carousel/owl.carousel.css',
                'Resources/Public/slider/owl.carousel/owl-carousel/owl.theme.default.css',
                'Resources/Public/slider/owl.carousel/owl-carousel/owl.transitions.css',
                'Resources/Public/slider/owl.carousel/assets/js/google-code-prettify/prettify.css',
                'Resources/Public/slider/owl.carousel/assets/css/animate.css',
            ];
        }

        foreach ($cssFiles as $index => $cssFile) {
            //$additionalHeaderData[$extensionKey . 'CSS' . ($index + 3)] = '<link rel="stylesheet" type="text/css" href="' . $extpath . $cssFile . '" />';
            $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . $cssFile . '" />');
        }

        if (isset($this->settings['owllightbox']) && $this->settings['owllightbox']) {
            //$additionalHeaderData[$extensionKey . 'CSS9'] = '<link rel="stylesheet" type="text/css" href="' . $extpath . (Environment::isComposerMode() ? 'slider/Fancybox/jquery.fancybox.min.css' : 'Resources/Public/slider/Fancybox/jquery.fancybox.min.css') . '" />';
            $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . (Environment::isComposerMode() ? 'slider/Fancybox/jquery.fancybox.min.css' : 'Resources/Public/slider/Fancybox/jquery.fancybox.min.css') . '" />');
        }

        $pluginName = $this->request->getPluginName();
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $typoScriptSetup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $constant = $typoScriptSetup['plugin.']['tx_nsnewsslider_owlcarousel.']['settings.'];
        // @extensionScannerIgnoreLine
        $getContentId = $this->request->getAttribute('currentContentObject')->data['uid'];

        // add js at footer
        if ($constant['jQuery']) {
            $pageRenderer->addJsFooterFile('EXT:ns_news_slider/Resources/Public/Js/jquery-3.6.0.min.js', 'text/javascript', false, false, '');
        }
        $pageRenderer->addJsFooterFile('EXT:ns_news_slider/Resources/Public/slider/owl.carousel/owl-carousel/owl.carousel.js', 'text/javascript', false, false, '');

        if (isset($this->settings['owllightbox']) && $this->settings['owllightbox'] == 1) {
            $pageRenderer->addJsFooterFile('EXT:ns_news_slider/Resources/Public/slider/Fancybox/jquery.fancybox.min.js', 'text/javascript', false, false, '');
        }
        $thumbs = '';
        if (isset($this->settings['owlthumbs']) && $this->settings['owlthumbs'] == 1) {
            $pageRenderer->addJsFooterFile('EXT:ns_news_slider/Resources/Public/slider/owl.carousel/assets/js/owl.carousel2.thumbs.js', 'text/javascript', false, false, '');

            $thumbs = '
                    thumbs: true,
                    thumbImage:true
                ';
        }

        $this->extKey = $this->extKey ?? '';
        $footerData= "
                <script>
                    if (typeof jQuery == 'undefined') {
                        alert('Please include Jquery library first!');
                    } 
                    (function($) {
                        var owl = $('.owl-demo-" . $getContentId . "');
                            owl.owlCarousel({
                               autoplay : " . (isset($this->settings['owlautoPlay']) && $this->settings['owlautoPlay'] != '' ? $this->settings['owlautoPlay'] : $constant['ConAutoPlay']) . ',
                            nav : ' . (isset($this->settings['owlnavigation']) && $this->settings['owlnavigation'] != '' ? $this->settings['owlnavigation'] : $constant['Connavigation']) . ',
                            items : ' . (isset($this->settings['owlitems']) && $this->settings['owlitems'] != '' ? $this->settings['owlitems'] : $constant['Conitems']) . ',
                            lazyLoad : ' . (isset($this->settings['owllazyLoad']) && $this->settings['owllazyLoad'] != '' ? $this->settings['owllazyLoad'] : $constant['ConlazyLoad']) . ',
                            mouseDrag:' . (isset($this->settings['owlmouseDrag']) && $this->settings['owlmouseDrag'] != '' ? $this->settings['owlmouseDrag'] : $constant['ConmouseDrag']) . ',
                            touchDrag:' . (isset($this->settings['owltouchDrag']) && $this->settings['owltouchDrag'] != '' ? $this->settings['owltouchDrag'] : $constant['ContouchDrag']) . ',

                            margin:' . (isset($this->settings['owlmargin']) && $this->settings['owlmargin'] != '' ? $this->settings['owlmargin'] : $constant['Conmargin']) . ',
                            loop:' . (isset($this->settings['owlloop']) && $this->settings['owlloop'] != '' ? $this->settings['owlloop'] : $constant['Conloop']) . ',


                            pullDrag:' . (isset($this->settings['owlpullDrag']) && $this->settings['owlpullDrag'] != '' ? $this->settings['owlpullDrag'] : $constant['ConpullDrag']) . ',
                            freeDrag:' . (isset($this->settings['owlfreeDrag']) && $this->settings['owlfreeDrag'] != '' ? $this->settings['owlfreeDrag'] : $constant['ConfreeDrag']) . ',
                            stagePadding:' . (isset($this->settings['owlstagePadding']) && $this->settings['owlstagePadding'] != '' ? $this->settings['owlstagePadding'] : $constant['ConstagePadding']) . ',
                            merge:' . (isset($this->settings['owlmerge']) && $this->settings['owlmerge'] != '' ? $this->settings['owlmerge'] : $constant['Conmerge']) . ',
                            mergeFit:' . (isset($this->settings['owlmergeFit']) && $this->settings['owlmergeFit'] != '' ? $this->settings['owlmergeFit'] : $constant['ConmergeFit']) . ',
                            startPosition: "' . (isset($this->settings['owlstartPosition']) && $this->settings['owlstartPosition'] != '' ? $this->settings['owlstartPosition'] : $constant['ConstartPosition']) . '",
                            URLhashListener:' . (isset($this->settings['owlURLhashListener']) && $this->settings['owlURLhashListener'] != '' ? $this->settings['owlURLhashListener'] : $constant['ConURLhashListener']) . ',
                            rewind:' . (isset($this->settings['owlrewind']) && $this->settings['owlrewind'] != '' ? $this->settings['owlrewind'] : $constant['Conrewind']) . ",
                            navElement:'" . (isset($this->settings['owlnavElement']) && $this->settings['owlnavElement'] != '' ? $this->settings['owlnavElement'] : $constant['ConnavElement']) . "',
                            slideBy:" . (isset($this->settings['owlslideBy']) && $this->settings['owlslideBy'] != '' ? $this->settings['owlslideBy'] : $constant['ConslideBy']) . ",
                            slideTransition:'" . (isset($this->settings['owlslideTransition']) && $this->settings['owlslideTransition'] != '' ? $this->settings['owlslideTransition'] : $constant['ConslideTransition']) . "',
                            dots:" . (isset($this->settings['owldots']) && $this->settings['owldots'] != '' ? $this->settings['owldots'] : $constant['Condots']) . ',
                            dotsEach:' . (isset($this->settings['owldotsEach']) && $this->settings['owldotsEach'] != '' ? $this->settings['owldotsEach'] : $constant['CondotsEach']) . ',
                            lazyLoadEager:' . (isset($this->settings['owllazyLoadEager']) && $this->settings['owllazyLoadEager'] != '' ? $this->settings['owllazyLoadEager'] : $constant['ConlazyLoadEager']) . ',
                            autoplayTimeout:' . (isset($this->settings['owlautoplayTimeout']) && $this->settings['owlautoplayTimeout'] != '' ? $this->settings['owlautoplayTimeout'] : $constant['ConautoplayTimeout']) . ',
                            autoplayHoverPause:' . (isset($this->settings['owlautoplayHoverPause']) && $this->settings['owlautoplayHoverPause'] != '' ? $this->settings['owlautoplayHoverPause'] : $constant['ConautoplayHoverPause']) . ',
                            autoplaySpeed:' . (isset($this->settings['owlolwautoplaySpeed']) && $this->settings['owlolwautoplaySpeed'] != '' ? $this->settings['owlolwautoplaySpeed'] : $constant['ConautoplaySpeed']) . ',
                            navSpeed:' . (isset($this->settings['owlnavSpeed']) && $this->settings['owlnavSpeed'] != '' ? $this->settings['owlnavSpeed'] : $constant['ConnavSpeed']) . ',
                            dotsSpeed:' . (isset($this->settings['owldotsSpeed']) && $this->settings['owldotsSpeed'] != '' ? $this->settings['owldotsSpeed'] : $constant['CondotsSpeed']) . ',
                            dragEndSpeed:' . (isset($this->settings['owldragEndSpeed']) && $this->settings['owldragEndSpeed'] != '' ? $this->settings['owldragEndSpeed'] : $constant['CondragEndSpeed']) . ",
                            smartSpeed: 450,
                            animateOut:'" . (isset($this->settings['owlanimateOut']) && $this->settings['owlanimateOut'] != '' ? $this->settings['owlanimateOut'] : $constant['ConanimateOut']) . "',
                            animateIn:'" . (isset($this->settings['owlanimateIn']) && $this->settings['owlanimateIn'] != '' ? $this->settings['owlanimateIn'] : $constant['ConanimateIn']) . "',
                            fallbackEasing:'" . (isset($this->settings['owlfallbackEasing']) && $this->settings['owlfallbackEasing'] != '' ? $this->settings['owlfallbackEasing'] : $constant['ConfallbackEasing']) . "',
                            info:" . (isset($this->settings['owlinfo']) && $this->settings['owlinfo'] != '' ? $this->settings['owlinfo'] : $constant['Coninfo']) . ',
                            nestedItemSelector: ' . (isset($this->settings['owlnestedItemSelector']) && $this->settings['owlnestedItemSelector'] != '' ? "'" . $this->settings['owlnestedItemSelector'] . "'" : $constant['ConnestedItemSelector']) . ",

                            itemElement:'" . (isset($this->settings['owlitemElement']) && $this->settings['owlitemElement'] != '' ? $this->settings['owlitemElement'] : $constant['ConitemElement']) . "',
                            navContainer:" . (isset($this->settings['owlnavContainer']) && $this->settings['owlnavContainer'] != '' ? $this->settings['owlnavContainer'] : $constant['ConnavContainer']) . ',
                            center:' . (isset($this->settings['owlcenter']) && $this->settings['owlcenter'] != '' ? $this->settings['owlcenter'] : $constant['Concenter']) . ',

                            dotsContainer:' . (isset($this->settings['owldotsContainer']) && $this->settings['owldotsContainer'] != '' ? $this->settings['owldotsContainer'] : $constant['CondotsContainer']) . ',
                            checkVisible:' . (isset($this->settings['owlcheckVisible']) && $this->settings['owlcheckVisible'] != '' ? $this->settings['owlcheckVisible'] : $constant['ConcheckVisible']) . ',
                            ' . $thumbs . "
                            });
                     })(jQuery);
                    function makePages() {
                        $.each(this.owl.userItems, function(i) {
                            $('.owl-controls .owl-page').eq(i)
                                .css({
                                    'background': 'url(' + $(this).find('img').attr('src') + ')',
                                    'background-size': 'cover'
                                })
                        });
                    }
                </script>";

        $this->settings['owllightbox'] = $this->settings['owllightbox'] ?? '';
        if ($this->settings['owllightbox']) {
            $footerData .= "
                    <script>
                        $().fancybox({
                          selector : '.owl-item:not(.cloned) a img',
                          backFocus : false
                        });
                    </script>";
        }
        $pageRenderer->addFooterData($footerData);
        $this->settings['owllazyLoad']=  isset($this->settings['owllazyLoad']) && $this->settings['owllazyLoad'] != '' ? $this->settings['owllazyLoad'] : $constant['ConlazyLoad'];

        //variable saved in flexform
        $this->view->assign('settings', $this->settings);

        // show pluging name
        $this->view->assign('pluginName', $pluginName);
        return $this->htmlResponse();
    }
}
