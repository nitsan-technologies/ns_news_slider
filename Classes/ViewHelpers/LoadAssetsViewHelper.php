<?php
namespace NITSAN\NsNewsSlider\ViewHelpers;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use \TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class LoadAssetsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    use CompileWithRenderStatic;

    protected $extPath;
    protected $config =[];
    protected $constant;

    /**
     * Initialize
     *
     * @return void
     */
    public function initializeArguments()
    {
        //$this->registerArgument('sliderType', 'string', 'Determine type of slider', true);
        parent::initializeArguments();
        $this->registerArgument('sliderType', 'string', 'name', true);
    }

    public function render() {

        $sliderType = $this->arguments['sliderType'];

        // Collect the settings.
        $settings = $this->templateVariableContainer->get('settings');
        $cData = $this->templateVariableContainer->get('contentObjectData');
        $elementId = $sliderType.'-'.$cData['uid'];

        // set js value for slider
        $this->constant = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_nsallsliders_royalslider.']['persistence.'];

        // Define assets path.
        $this->extPath = str_replace(PATH_site, '', ExtensionManagementUtility::extPath('ns_news_slider').'Resources/Public/slider/');;

        // Create pageRender instance.
        $pageRender = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);

        // Determine slider type.
        switch ($sliderType) {
            case 'royalSlider':
                $this->loadRoyalSliderResource($pageRender, $this->extPath, $settings);
                $this->loadRoyalSliderConfiguration($pageRender, $elementId, $settings);
                break;
        }
    }

    /**
     * Load static JS/CSS for the Owl-carousel Slider
     * @param $pageRender
     * @param $path
     */
    public function loadRoyalSliderResource($pageRender, $path, $settings)
    {
        $pageRender->addCssFile($path.'Royal-Slider/css/vendor/royalslider.css');
        if ($settings['royal_slider_type'] != 'fullscreen') {
            $pageRender->addCssFile($path.'Royal-Slider/css/style.css');
            $pageRender->addCssFile($path.'Royal-Slider/css/custom.css');
            $pageRender->addCssFile($path.'Royal-Slider/css/vendor/skins/minimal-white/rs-minimal-white.css');
        }else{
            $pageRender->addCssFile($path.'Royal-Slider/css/vendor/skins/default/rs-default.css');
        }

        $pageRender->addjsFooterFile($path.'Royal-Slider/js/vendor/jquery.royalslider.min.js');
        $pageRender->addjsFooterFile($path.'Royal-Slider/js/vendor/jquery.easing-1.3.js');
    }

    /**
     * Load static JS/CSS for the Owl-carousel Slider Plugin
     * @param $pageRender
     * @param $selector
     * @param $settings
     */
    public function loadRoyalSliderConfiguration($pageRender, $selector, $settings)
    {
        $commonBlock ="
            controlNavigation: '".$settings['controlNavigation']."',
            autoScaleSlider: ".$settings['autoScaleSlider'].",
            autoScaleSliderWidth: ".$settings['autoScaleSliderWidth'].",
            autoScaleSliderHeight: ".$settings['autoScaleSliderHeight'].",
            loop: ".$settings['loop'].",
            imageScaleMode: '".$settings['imageScaleMode']."',
            navigateByClick: ".$settings['navigateByClick'].",
            arrowsNav: ".$settings['arrowsNav'].",
            arrowsNavAutoHide: ".$settings['arrowsNavAutoHide'].",
            keyboardNavEnabled: ".$settings['keyboardNavEnabled'].",
            globalCaption: ".$settings['globalCaption'].",
            controlsInside: ".$settings['controlsInside'].",
            imgWidth: ".$settings['slidewidth'].",
            imgHeight: ".$settings['slideheight'].",
        ";

        if ($settings['controlNavigation'] == 'thumbnails') {
            $commonBlock .= "
                thumbsFitInViewport: ".($settings['thumbsFitInViewport']?$settings['thumbsFitInViewport']:0).",
                thumbsFitInViewport: '".($settings['thumbsOrientation']?$settings['thumbsOrientation']:0)."',
                thumbs: {
                  orientation: '".$settings['thumbsOrientation']."'
                },            
            ";
        }

        $codeBlock ="
            $('#".$selector."').royalSlider({            
                startSlideId: ".$settings['startSlideId'].",
                autoPlay: {
                        enabled: ".$settings['autoPlay'].",
                        stopAtAction:".($settings['autoPlay'] ? 'false' : 'true').",
                        pauseOnHover:".($settings['pauseOnHover'] ? 'true' : 'false').",
                        delay: ".($settings['pauseDelay'] ? $settings['pauseDelay'] : 1000).",
                },
                transitionType: '".$settings['transitionType']."',   
                deeplinking: {
                    enabled: ".$settings['deeplinking_enabled'].",
                    change: ".$settings['deeplinking_change']."
                },".$commonBlock."
            }); ";

        $pageRender->addJsFooterInlineCode('royal-slider-config', $codeBlock, TRUE);
    }
}
?>