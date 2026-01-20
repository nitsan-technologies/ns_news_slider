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
 * NivoController
 */
class NivoController extends SliderBaseController
{
    /**
     * @var string
     */
    protected string $sliderName = '';

    /**
     * action list
     *
     * @param array|null $overwriteDemand
     * @return ResponseInterface
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

        if (Environment::isComposerMode()) {
            $assetPath = $this->getPath('/', 'ns_news_slider');
            $extpath = GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . $assetPath;
            $cssPath = 'slider/Nivo-Slider/';
            $jsPath = 'slider/Nivo-Slider/';
            $ajax1 = $extpath . $jsPath . 'jquery.nivo.slider.js';
        } else {
            $extpath = PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('ns_news_slider'));
            $cssPath = 'Resources/Public/slider/Nivo-Slider/';
            $jsPath = 'Resources/Public/slider/Nivo-Slider/';
            $ajax1 = 'EXT:ns_news_slider/' . $jsPath . 'jquery.nivo.slider.js';
        }

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' . $extpath . $cssPath . 'themes/default/default.css" />');
        $pageRenderer->addHeaderData('<link rel="stylesheet" type="text/css" href="' .  $extpath . $cssPath . 'nivo-slider.css" />');

        $pluginName = $this->request->getPluginName();

        // set js value for slider
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $typoScriptSetup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $constant = $typoScriptSetup['plugin.']['tx_nsnewsslider_nivoslider.']['settings.'];

        if ($constant['jQuery']) {
            $pageRenderer->addJsFooterFile('EXT:ns_news_slider/Resources/Public/Js/jquery-3.6.0.min.js', 'text/javascript', false, false, '');
        }
        $pageRenderer->addJsFooterFile($ajax1, 'text/javascript', false, false, '');
        $footerData= "
            <script>
                if (typeof jQuery == 'undefined') {
                    alert('Please include Jquery library first!');
                } 
                $('#slider img').removeAttr('width').removeAttr('height');
                (function($) {
                    $(window).on('load',function() {
                        $('#slider').nivoSlider({
                            effect: '" . (isset($this->settings['nivoeffect']) && $this->settings['nivoeffect'] != '' ? $this->settings['nivoeffect'] : $constant['effect']) . "',
                            slices: " . (isset($this->settings['nivoslices']) && $this->settings['nivoslices'] != '' ? $this->settings['nivoslices'] : $constant['slices']) . ',
                            boxCols: ' . (isset($this->settings['nivoboxCols']) && $this->settings['nivoboxCols'] != '' ? $this->settings['nivoboxCols'] : $constant['boxCols']) . ',
                            boxRows: ' . (isset($this->settings['nivoboxRows']) && $this->settings['nivoboxRows'] != '' ? $this->settings['nivoboxRows'] : $constant['boxRows']) . ',
                            animSpeed: ' . (isset($this->settings['nivoanimSpeed']) && $this->settings['nivoanimSpeed'] != '' ? $this->settings['nivoanimSpeed'] : $constant['animSpeed']) . ',
                            pauseTime: ' . (isset($this->settings['nivopauseTime']) && $this->settings['nivopauseTime'] != '' ? $this->settings['nivopauseTime'] : $constant['pauseTime']) . ',
                            startSlide: ' . (isset($this->settings['nivostartSlide']) && $this->settings['nivostartSlide'] != '' ? $this->settings['nivostartSlide'] : $constant['startSlide']) . ',
                            directionNav: ' . (isset($this->settings['nivonavagation_arrow']) && $this->settings['nivonavagation_arrow'] != '' ? $this->settings['nivonavagation_arrow'] : $constant['nivonavagation_arrow']) . ',
                            controlNav: ' . (isset($this->settings['nivocontrolNav']) && $this->settings['nivocontrolNav'] != '' ? $this->settings['nivocontrolNav'] : $constant['controlNav']) . ',
                            controlNavThumbs: ' . (isset($this->settings['nivocontrolNavThumbs']) && $this->settings['nivocontrolNavThumbs'] != '' ? $this->settings['nivocontrolNavThumbs'] : $constant['controlNavThumbs']) . ',
                            pauseOnHover: ' . (isset($this->settings['nivopauseOnHover']) && $this->settings['nivopauseOnHover'] != '' ? $this->settings['nivopauseOnHover'] : $constant['pauseOnHover']) . ',
                            manualAdvance: ' . (isset($this->settings['nivomanualAdvance']) && $this->settings['nivomanualAdvance'] != '' ? $this->settings['nivomanualAdvance'] : $constant['manualAdvance']) . ',
                            randomStart: ' . (isset($this->settings['nivorandomStart']) && $this->settings['nivorandomStart'] != '' ? $this->settings['nivorandomStart'] : $constant['randomStart']) . '
                        });
                    });
                })(jQuery);
            </script>';

        $pageRenderer->addFooterData($footerData);
        //variable saved in flexform
        $this->view->assign('settings', $this->settings);
        // show arrwo in slider
        $arrow = $this->settings['navagation_arrow'] ?? '';
        $this->view->assign('arrow', $arrow);

        // show pluging name
        $this->view->assign('pluginName', $pluginName);
        return $this->htmlResponse();
    }
}
