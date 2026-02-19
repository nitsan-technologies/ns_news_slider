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
            $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . $cssFile . '" />');
        }

        if (isset($this->settings['owllightbox']) && $this->settings['owllightbox']) {
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
                            autoplay : " . (isset($this->settings['owlautoPlay']) && $this->settings['owlautoPlay'] != '' ? $this->settings['owlautoPlay'] : (empty($constant['ConAutoPlay']) || $constant['ConAutoPlay'] == 'false' ? 'false' : 'true')) . ',
                            nav : ' . (isset($this->settings['owlnavigation']) && $this->settings['owlnavigation'] != '' ? $this->settings['owlnavigation'] : (empty($constant['Connavigation']) || $constant['Connavigation'] == 'false' ? 'false' : 'true')) . ',
                            items : ' . (isset($this->settings['owlitems']) && $this->settings['owlitems'] != '' ? $this->settings['owlitems'] : (empty($constant['Conitems']) || $constant['Conitems'] == 'false' ? 'false' : 'true')) . ',
                            lazyLoad : ' . (isset($this->settings['owllazyLoad']) && $this->settings['owllazyLoad'] != '' ? $this->settings['owllazyLoad'] : (empty($constant['ConlazyLoad']) || $constant['ConlazyLoad'] == 'false' ? 'false' : 'true')) . ',
                            mouseDrag:' . (isset($this->settings['owlmouseDrag']) && $this->settings['owlmouseDrag'] != '' ? $this->settings['owlmouseDrag'] : (empty($constant['ConmouseDrag']) || $constant['ConmouseDrag'] == 'false' ? 'false' : 'true')) . ',
                            touchDrag:' . (isset($this->settings['owltouchDrag']) && $this->settings['owltouchDrag'] != '' ? $this->settings['owltouchDrag'] : (empty($constant['ContouchDrag']) || $constant['ContouchDrag'] == 'false' ? 'false' : 'true')) . ',

                            margin:' . (isset($this->settings['owlmargin']) && $this->settings['owlmargin'] != '' ? $this->settings['owlmargin'] : (($constant['Conmargin'] ?? '') === '' ? 'false' : $constant['Conmargin'])) . ',
                            loop:' . (isset($this->settings['owlloop']) && $this->settings['owlloop'] != '' ? $this->settings['owlloop'] : (empty($constant['Conloop']) || $constant['Conloop'] == 'false' ? 'false' : 'true')) . ',

                            pullDrag:' . (isset($this->settings['owlpullDrag']) && $this->settings['owlpullDrag'] != '' ? $this->settings['owlpullDrag'] : (empty($constant['ConpullDrag']) || $constant['ConpullDrag'] == 'false' ? 'false' : 'true')) . ',
                            freeDrag:' . (isset($this->settings['owlfreeDrag']) && $this->settings['owlfreeDrag'] != '' ? $this->settings['owlfreeDrag'] : (empty($constant['ConfreeDrag']) || $constant['ConfreeDrag'] == 'false' ? 'false' : 'true')) . ',
                            stagePadding:' . (isset($this->settings['owlstagePadding']) && $this->settings['owlstagePadding'] != '' ? $this->settings['owlstagePadding'] : (($constant['ConstagePadding'] ?? '') === '' ? 'false' : $constant['ConstagePadding'])) . ',
                            merge:' . (isset($this->settings['owlmerge']) && $this->settings['owlmerge'] != '' ? $this->settings['owlmerge'] : (empty($constant['Conmerge']) || $constant['Conmerge'] == 'false' ? 'false' : 'true')) . ',
                            mergeFit:' . (isset($this->settings['owlmergeFit']) && $this->settings['owlmergeFit'] != '' ? $this->settings['owlmergeFit'] : (empty($constant['ConmergeFit']) || $constant['ConmergeFit'] == 'false' ? 'false' : 'true')) . ',
                            autoWidth:' . (isset($this->settings['owlmergeFit']) && $this->settings['owlmergeFit'] != '' ? $this->settings['owlmergeFit'] : (empty($constant['ConautoWidth']) || $constant['ConautoWidth'] == 'false' ? 'false' : 'true')) . ',

                            startPosition: "' . (isset($this->settings['owlstartPosition']) && $this->settings['owlstartPosition'] != '' ? $this->settings['owlstartPosition'] : (($constant['ConstartPosition'] ?? '') === '' ? 'false' : $constant['ConstartPosition'])) . '",

                            URLhashListener:' . (isset($this->settings['owlURLhashListener']) && $this->settings['owlURLhashListener'] != '' ? $this->settings['owlURLhashListener'] : (empty($constant['ConURLhashListener']) || $constant['ConURLhashListener'] == 'false' ? 'false' : 'true')) . ',
                            rewind:' . (isset($this->settings['owlrewind']) && $this->settings['owlrewind'] != '' ? $this->settings['owlrewind'] : (empty($constant['Conrewind']) || $constant['Conrewind'] == 'false' ? 'false' : 'true')) . ',

                            navElement:"' . (isset($this->settings['owlnavElement']) && $this->settings['owlnavElement'] != '' ? $this->settings['owlnavElement'] : (($constant['ConnavElement'] ?? '') === '' ? 'false' : $constant['ConnavElement'])) . '",
                            slideBy:' . (isset($this->settings['owlslideBy']) && $this->settings['owlslideBy'] != '' ? $this->settings['owlslideBy'] : (($constant['ConslideBy'] ?? '') === '' ? 'false' : $constant['ConslideBy'])) . ',
                            slideTransition:"' . (isset($this->settings['owlslideTransition']) && $this->settings['owlslideTransition'] != '' ? $this->settings['owlslideTransition'] : (($constant['ConslideTransition'] ?? '') === '' ? 'false' : $constant['ConslideTransition'])) . '",

                            dots:' . (isset($this->settings['owldots']) && $this->settings['owldots'] != '' ? $this->settings['owldots'] : (empty($constant['Condots']) || $constant['Condots'] == 'false' ? 'false' : 'true')) . ',
                            dotsEach:' . (isset($this->settings['owldotsEach']) && $this->settings['owldotsEach'] != '' ? $this->settings['owldotsEach'] : (empty($constant['CondotsEach']) || $constant['CondotsEach'] == 'false' ? 'false' : 'true')) . ',

                            lazyLoadEager:' . (isset($this->settings['owllazyLoadEager']) && $this->settings['owllazyLoadEager'] != '' ? $this->settings['owllazyLoadEager'] : (($constant['ConlazyLoadEager'] ?? '') === '' ? 'false' : $constant['ConlazyLoadEager'])) . ',
                            autoplayTimeout:' . (isset($this->settings['owlautoplayTimeout']) && $this->settings['owlautoplayTimeout'] != '' ? $this->settings['owlautoplayTimeout'] : (($constant['ConautoplayTimeout'] ?? '') === '' ? 'false' : $constant['ConautoplayTimeout'])) . ',
                            autoplayHoverPause:' . (isset($this->settings['owlautoplayHoverPause']) && $this->settings['owlautoplayHoverPause'] != '' ? $this->settings['owlautoplayHoverPause'] : (empty($constant['ConautoplayHoverPause']) || $constant['ConautoplayHoverPause'] == 'false' ? 'false' : 'true')) . ',

                            autoplaySpeed:' . (isset($this->settings['owlolwautoplaySpeed']) && $this->settings['owlolwautoplaySpeed'] != '' ? $this->settings['owlolwautoplaySpeed'] : (($constant['ConautoplaySpeed'] ?? '') === '' ? 'false' : $constant['ConautoplaySpeed'])) . ',
                            navSpeed:' . (isset($this->settings['owlnavSpeed']) && $this->settings['owlnavSpeed'] != '' ? $this->settings['owlnavSpeed'] : (($constant['ConnavSpeed'] ?? '') === '' ? 'false' : $constant['ConnavSpeed'])) . ',
                            dotsSpeed:' . (isset($this->settings['owldotsSpeed']) && $this->settings['owldotsSpeed'] != '' ? $this->settings['owldotsSpeed'] : (empty($constant['CondotsSpeed']) || $constant['CondotsSpeed'] == 'false' ? 'false' : 'true')) . ',
                            dragEndSpeed:' . (isset($this->settings['owldragEndSpeed']) && $this->settings['owldragEndSpeed'] != '' ? $this->settings['owldragEndSpeed'] : (empty($constant['CondragEndSpeed']) || $constant['CondragEndSpeed'] == 'false' ? 'false' : 'true')) . ',

                            smartSpeed: 450,

                            animateOut:"' . (isset($this->settings['owlanimateOut']) && $this->settings['owlanimateOut'] != '' ? $this->settings['owlanimateOut'] : (($constant['ConanimateOut'] ?? '') === '' ? 'false' : $constant['ConanimateOut'])) . '",
                            animateIn:"' . (isset($this->settings['owlanimateIn']) && $this->settings['owlanimateIn'] != '' ? $this->settings['owlanimateIn'] : (($constant['ConanimateIn'] ?? '') === '' ? 'false' : $constant['ConanimateIn'])) . '",
                            fallbackEasing:"' . (isset($this->settings['owlfallbackEasing']) && $this->settings['owlfallbackEasing'] != '' ? $this->settings['owlfallbackEasing'] : (($constant['ConfallbackEasing'] ?? '') === '' ? 'false' : $constant['ConfallbackEasing'])) . '",

                            info:' . (isset($this->settings['owlinfo']) && $this->settings['owlinfo'] != '' ? $this->settings['owlinfo'] : (($constant['Coninfo'] ?? '') === '' ? 'false' : $constant['Coninfo'])) . ',

                            nestedItemSelector:' . (isset($this->settings['owlnestedItemSelector']) && $this->settings['owlnestedItemSelector'] != '' ? "'" . $this->settings['owlnestedItemSelector'] . "'" : (($constant['ConnestedItemSelector'] ?? '') === '' ? 'false' : $constant['ConnestedItemSelector'])) . ',

                            itemElement:"' . (isset($this->settings['owlitemElement']) && $this->settings['owlitemElement'] != '' ? $this->settings['owlitemElement'] : (($constant['ConitemElement'] ?? '') === '' ? 'false' : $constant['ConitemElement'])) . '",
                            navContainer:' . (isset($this->settings['owlnavContainer']) && $this->settings['owlnavContainer'] != '' ? $this->settings['owlnavContainer'] : (($constant['ConnavContainer'] ?? '') === '' ? 'false' : $constant['ConnavContainer'])) . ',
                            center:' . (isset($this->settings['owlcenter']) && $this->settings['owlcenter'] != '' ? $this->settings['owlcenter'] : (($constant['Concenter'] ?? '') === '' ? 'false' : $constant['Concenter'])) . ',
                            dotsContainer:' . (isset($this->settings['owldotsContainer']) && $this->settings['owldotsContainer'] != '' ? $this->settings['owldotsContainer'] : (($constant['CondotsContainer'] ?? '') === '' ? 'false' : $constant['CondotsContainer'])) . ',
                            checkVisible:' . (isset($this->settings['owlcheckVisible']) && $this->settings['owlcheckVisible'] != '' ? $this->settings['owlcheckVisible'] : (empty($constant['ConcheckVisible']) || $constant['ConcheckVisible'] == 'false' ? 'false' : 'true')) . ',
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
