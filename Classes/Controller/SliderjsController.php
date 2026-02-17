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
 * SliderjsController
 */
class SliderjsController extends SliderBaseController
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
     * @return ResponseInterface
     */
    public function listAction(?array $overwriteDemand = null): ResponseInterface
    {
        // Get settings.
        $settings = $this->settings;
        $settings['sliderType'] = $this->sliderName;
        $news = $this->findNews();
        $type = '';
        $this->view->assignMultiple([
            'news' => $news,
            'settings' => $settings
        ]);
        if (Environment::isComposerMode()) {
            $assetPath = $this->getPath('/', 'ns_news_slider');
            $extpath = GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . $assetPath;
        } else {
            $extpath = PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('ns_news_slider')).'Resources/Public/';
        }
        $pluginName = $this->request->getPluginName();

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        // @extensionScannerIgnoreLine
        $getContentId = $this->request->getAttribute('currentContentObject')->data['uid'];

        // set js value for slider
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $typoScriptSetup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $constant = $typoScriptSetup['plugin.']['tx_nsnewsslider_sliderjs.']['settings.'];

        if ($constant['jQuery']) {
            $pageRenderer->addJsFooterFile('EXT:ns_news_slider/Resources/Public/Js/jquery-3.6.0.min.js', 'text/javascript', false, false, '');
        }

        $ajax2 = 'EXT:ns_news_slider/Resources/Public/slider/Slides-SlidesJS/source/jquery.slides.min.js';

        $pageRenderer->addJsFooterFile($ajax2, 'text/javascript', false, false, '');

        $slider_type = $this->settings['slider_type'];
        $this->view->assign('slider_type', $slider_type);

        $basicOpt = "
                start:'" . (isset($this->settings['start']) && $this->settings['start'] > 0 ? $this->settings['start'] : $constant['Constart']) . "',
                navigation: {
                    active: " . (isset($this->settings['navigation']) && $this->settings['navigation'] != '' ? $this->settings['navigation'] : (($constant['ConnavigationActive'] ?? '') === '' ? '1' : $constant['ConnavigationActive'])) . ",
                    effect: '" . (isset($this->settings['navigation_effect']) && $this->settings['navigation_effect'] != '' ? $this->settings['navigation_effect'] : (($constant['Connavigation_effect'] ?? '') === '' ? '1' : $constant['Connavigation_effect'])) . "',
                },
                pagination: {
                  active: " . (isset($this->settings['pagination']) && $this->settings['pagination'] != '' ? $this->settings['pagination'] : (($constant['ConpaginationActive'] ?? '') === '' ? '1' : $constant['ConpaginationActive'])) . ",
                  effect: '" . (isset($this->settings['pagination_effect']) && $this->settings['pagination_effect'] != '' ? $this->settings['pagination_effect'] : (($constant['Conpagination_effect'] ?? '') === '' ? '1' : $constant['Conpagination_effect'])) . "',
                },
                ";

        $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Slides-SlidesJS/css/custom.css" />');

        if ($slider_type == 'fade') {
            $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Slides-SlidesJS/types/standard/css/example.css" />');
            $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Slides-SlidesJS/types/standard/css/font-awesome.min.css" />');
            $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Slides-SlidesJS/types/standard/css/custom.css" />');

            $type =
                $basicOpt . '
                effect: {
                  fade: {
                    speed: ' . (isset($this->settings['effect_fade_speed']) && $this->settings['effect_fade_speed'] != '' ? $this->settings['effect_fade_speed'] : (($constant['Coneffect_fade_speed'] ?? '') === '' ? 'false' : $constant['Coneffect_fade_speed'])) . ',
                    crossfade: ' . (isset($this->settings['crossFade']) && $this->settings['crossFade'] != '' ? $this->settings['crossFade'] : (($constant['Coneffect_cross_fade'] ?? '') === '' ? 'false' : $constant['Coneffect_cross_fade'])) . ',
                  }
                }';
        } elseif ($slider_type == 'slide') {
            // add css js in header
            $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Slides-SlidesJS/types/standard/css/example.css" />');
            $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Slides-SlidesJS/types/standard/css/font-awesome.min.css" />');
            $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Slides-SlidesJS/types/standard/css/custom.css" />');

            $type = $basicOpt;
        } elseif ($slider_type == 'playing') {
            // add css js in header
            $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Slides-SlidesJS/types/playing/css/example.css" />');
            $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Slides-SlidesJS/types/playing/css/font-awesome.min.css" />');
            $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . 'slider/Slides-SlidesJS/types/playing/css/custom.css" />');

            $type =
                $basicOpt . '
                    play: {
                    active: ' . (isset($this->settings['play_active'])  && $this->settings['play_active'] != '' ? $this->settings['play_active'] : (($constant['Conplay_active'] ?? '') === '' ? '1' : $constant['Conplay_active'])) . ',
                    auto: ' . (isset($this->settings['play_auto']) && $this->settings['play_auto'] != '' ? $this->settings['play_auto'] : (($constant['Conplay_auto'] ?? '') === '' ? '1' : $constant['Conplay_auto'])) . ',
                    interval: ' . (isset($this->settings['play_interval']) && $this->settings['play_interval'] != '' ? $this->settings['play_interval'] : (($constant['Conplay_interval'] ?? '') === '' ? '1' : $constant['Conplay_interval'])) . ',
                    swap: ' . (isset($this->settings['play_swap'])  && $this->settings['play_swap'] != '' ? $this->settings['play_swap'] : (($constant['Conplay_swap'] ?? '') === '' ? '1' : $constant['Conplay_swap'])) . ',
                    pauseOnHover: ' . (isset($this->settings['play_pauseOnHover']) && $this->settings['play_pauseOnHover'] != '' ? $this->settings['play_pauseOnHover'] : (($constant['ConplayPauseOnHover'] ?? '') === '' ? '1' : $constant['ConplayPauseOnHover'])) . ',
                    restartDelay:"' . (isset($this->settings['play_restartDelay']) && $this->settings['play_restartDelay'] != '' ? $this->settings['play_restartDelay'] : (($constant['ConrestartDelay'] ?? '') === '' ? '1' : $constant['ConrestartDelay'])) . '",
                    effect: "' . (isset($this->settings['play_effect']) && $this->settings['play_effect'] != '' ? $this->settings['play_effect'] : (($constant['Conplay_effect'] ?? '') === '' ? '1' : $constant['Conplay_effect'])) . '",
                    }
                ';
        }

        $this->extKey = $this->extKey ?? '';
        $footerData= "
                <script>
                    if (typeof jQuery == 'undefined') {
                        alert('Please include Jquery library first!');
                    }
                    (function($) {
                      $('#slides-" . $getContentId . "').slidesjs({
                          width: " . (isset($this->settings['slidewidth']) && $this->settings['slidewidth'] != '' ? $this->settings['slidewidth'] : (($constant['Conslidewidth'] ?? '') === '' ? '1' : $constant['Conslidewidth'])) . ',
                          height: ' . (isset($this->settings['slideheight']) && $this->settings['slideheight'] != '' ? $this->settings['slideheight'] : (($constant['Conslideheight'] ?? '') === '' ? '1' : $constant['Conslideheight'])) . ',
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
