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
            case 'nivoSlider':
                $this->loadNivoSliderResource($pageRender, $this->extPath, $settings);
                $this->loadNivoSliderConfiguration($pageRender, $elementId, $settings);
                break;
            case 'owlcarouselSlider':
                $this->loadOwlcarouselSliderResource($pageRender, $this->extPath, $settings);
                $this->loadOwlcarouselSliderConfiguration($pageRender, $elementId, $settings);
                break;
            case 'royalSlider':
                $this->loadRoyalSliderResource($pageRender, $this->extPath, $settings);
                $this->loadRoyalSliderConfiguration($pageRender, $elementId, $settings);
                break;
            case 'slickSlider':
                $this->loadSlickSliderResource($pageRender, $this->extPath, $settings);
                $this->loadSlickSliderConfiguration($pageRender, $elementId, $settings);
                break;
            default:
        }
    }

    /**
     * Load static JS/CSS for the Nivo Slider Plugin
     * @param $pageRender
     * @param $path
     * @param $settings
     */
    public function loadNivoSliderResource($pageRender, $path, $settings){

        $pageRender->addCssFile($path.'/Nivo-Slider/nivo-slider.css');
        $pageRender->addCssFile($path.'/Nivo-Slider/style.css');

        // Determine slider type.
        switch ($settings['theme']) {
            case 'bar':
                $pageRender->addCssFile($path.'/Nivo-Slider/themes/bar/bar.css');
                break;

            case 'dark':
                $pageRender->addCssFile($path.'/Nivo-Slider/themes/dark/dark.css');
                break;

            case 'light':
                $pageRender->addCssFile($path.'/Nivo-Slider/themes/light/light.css');
                break;

            default:
                $pageRender->addCssFile($path.'/Nivo-Slider/themes/default/default.css');
        }

        $pageRender->addjsFooterFile($path.'/Nivo-Slider/jquery.nivo.slider.js');

    }

    /**
     * Load settings for Nivo Slider
     * @param $pageRender
     * @param $selector
     * @param $settings
     */
    public function loadNivoSliderConfiguration($pageRender, $selector, $settings){
        $codeBlock = " $('img').removeAttr('width').removeAttr('height');
                    $('#".$selector."').nivoSlider({
                        effect: '".($settings['effectOpt'] ? $settings['effectOpt'] : 'fold' )."',                 // Specify sets like: 'fold,fade,sliceDown'
                        slices: ".($settings['slices'] ? $settings['slices'] : '5').",                       // For slice animations 
                        boxCols: ".($settings['boxCols'] ? $settings['boxCols'] : '5').",                       // For box animations
                        boxRows: ".($settings['boxRows'] ? $settings['boxRows'] : '5').",                       // For box animations
                        animSpeed: ".($settings['animSpeed'] ? $settings['animSpeed'] : '3000').",                   // Slide transition speed
                        pauseTime: ".($settings['pauseTime'] ? $settings['pauseTime'] : '3000').",                  // How long each slide will show
                        startSlide: ".($settings['startSlide'] ? $settings['startSlide'] : '0').",                    // Set starting Slide (0 index)
                        directionNav: ".($settings['directionNav'] ? $settings['directionNav'] : '0').",               // Next & Prev navigation
                        controlNav: ".($settings['controlNav'] ? $settings['controlNav'] : '0' ).",                 // 1,2,3... navigation
                        controlNavThumbs: ".($settings['controlNavThumbs'] ? $settings['controlNavThumbs'] : '0').",          // Use thumbnails for Control Nav
                        pauseOnHover: ".($settings['pauseOnHover'] ? $settings['pauseOnHover'] : '0').",               // Stop animation while hovering
                        manualAdvance: ".($settings['manualAdvance'] ? $settings['manualAdvance'] : '0').",             // Force manual transitions
                        prevText: '".($settings['prevText'] ? $settings['prevText'] : 'Next')."',                 // Prev directionNav text
                        nextText: '".($settings['nextText'] ? $settings['nextText'] : 'Prev')."',                 // Next directionNav text
                        randomStart: ".($settings['randomStart'] ? $settings['randomStart'] : 0)."
                    });";

        $pageRender->addJsFooterInlineCode('nivo-config', $codeBlock, TRUE);
    }

    /**
     * Load static JS/CSS for the Owl-carousel Slider
     * @param $pageRender
     * @param $path
     */
    public function loadOwlcarouselSliderResource($pageRender, $path)
    {
        $pageRender->addCssFile($path.'/owl.carousel/assets/css/bootstrapTheme.css');
        $pageRender->addCssFile($path.'/owl.carousel/assets/css/custom.css');
        $pageRender->addCssFile($path.'/owl.carousel/owl-carousel/owl.carousel.css');
        $pageRender->addCssFile($path.'/owl.carousel/owl-carousel/owl.theme.css');
        $pageRender->addCssFile($path.'/owl.carousel/owl-carousel/owl.transitions.css');
        $pageRender->addCssFile($path.'/owl.carousel/assets/js/google-code-prettify/prettify.css');

        $pageRender->addjsFooterFile($path.'/owl.carousel/owl-carousel/owl.carousel.js');
        $pageRender->addjsFooterFile($path.'/owl.carousel/assets/js/bootstrap-collapse.js');
        $pageRender->addjsFooterFile($path.'/owl.carousel/assets/js/bootstrap-transition.js');
        $pageRender->addjsFooterFile($path.'/owl.carousel/assets/js/bootstrap-tab.js');
        $pageRender->addjsFooterFile($path.'/owl.carousel/assets/js/google-code-prettify/prettify.js');
        $pageRender->addjsFooterFile($path.'/owl.carousel/assets/js/application.js');
    }

    /**
     * Load static JS/CSS for the Owl-carousel Slider Plugin
     * @param $pageRender
     * @param $selector
     * @param $settings
     */
    public function loadOwlcarouselSliderConfiguration($pageRender, $selector, $settings)
    {
        if ($settings['itemsDesktop']) {
            $itemsDesktop = ",itemsDesktop : [".$settings['itemsDesktop']."]";
        }
        if ($settings['itemsDesktop']) {
            $itemsDesktopSmall = ",itemsDesktopSmall : [".$settings['itemsDesktopSmall']."]";
        }

        $codeBlock = " 
            $('#".$selector."').owlCarousel({
                items : ".($settings['items']?$settings['items']:1).",
                autoPlay : ".($settings['autoPlay'] ? $settings['autoPlay'] : 1000).",
                stopOnHover : ".$settings['stopOnHover'].",
                navigation : ".$settings['navigation'].",
                paginationSpeed : ".($settings['paginationSpeed'] ? $settings['paginationSpeed']: 1000).",
                goToFirstSpeed : ".($settings['goToFirstSpeed'] ? $settings['goToFirstSpeed'] : 1000).",
                singleItem : ".$settings['singleItem'].",
                autoHeight : ".$settings['autoHeight'].",
                transitionStyle: '".$settings['transitionStyle']."',
                lazyLoad : ".$settings['lazyLoad'].",
                slideSpeed : ".$settings['slideSpeed'].$itemsDesktop.$itemsDesktopSmall.",
            }); ";

        $pageRender->addJsFooterInlineCode('nivo-config', $codeBlock, TRUE);
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

    public function loadSlidejsSliderResource($pageRender, $path, $settings)
    {
        // Determine slider type.
        switch ($settings['slider_type']) {
            case 'fade':
                $pageRender->addCssFile($path.'/Slides-SlidesJS/types/basic-fade/css/custom.css');
                break;
            case 'slide':
                $pageRender->addCssFile($path.'/Slides-SlidesJS/types/basic-slide/css/custom.css');
                break;
            case 'playing':
                $pageRender->addCssFile($path.'Slides-SlidesJS/types/playing/css/example.css');
                $pageRender->addCssFile($path.'Slides-SlidesJS/types/playing/css/font-awesome.min.css');
                $pageRender->addCssFile($path.'Slides-SlidesJS/types/playing/css/custom.css');
                break;
            case 'standard':
                $pageRender->addCssFile($path.'Slides-SlidesJS/types/standard/css/example.css');
                $pageRender->addCssFile($path.'Slides-SlidesJS/types/standard/css/font-awesome.min.css');
                $pageRender->addCssFile($path.'Slides-SlidesJS/types/standard/css/custom.css');
                break;
            default:
                $pageRender->addCssFile($path.'/Slides-SlidesJS/types/basic-fade/css/custom.css');

        }
        $pageRender->addjsFooterFile($path.'/Slides-SlidesJS/source/jquery.slides.min.js');
    }

    public function loadSlickSliderResource($pageRender, $path, $settings)
    {
        $pageRender->addCssFile($path.'/Slick-Slider/css/slick.css');
        $pageRender->addCssFile($path.'/Slick-Slider/css/slick-custom.css');
        $pageRender->addCssFile($path.'/Slick-Slider/css/slick-theme.css');

        $pageRender->addjsFooterFile($path.'/Slick-Slider/js/slick.min.js');
    }

    public function loadSlickSliderConfiguration($pageRender, $selector, $settings)
    {
        $effect = (($settings['slider_type'] =='sideways') ? 'false' : 'true');

        $codeBlock = " $('#".$selector."').slick({
                            dots: ".($settings['dots'] ? $settings['dots'] : 0).",
                            vertical: ".$effect.",
                            infinite: ".($settings['infinite']?$settings['infinite']:0).",
                            centerMode: ".($settings['display'] ? $settings['display'] : 0).",
                            slidesToShow: ".($settings['slidesToShow'] ? $settings['slidesToShow'] : 1).",
                            slidesToScroll: ".($settings['slidesToScroll'] ? $settings['slidesToScroll'] : 1).",                          
                            speed: ".($settings['speed'] ? $settings['speed'] : 1000).",
                            autoplay: ".($settings['autoplay'] ? 1 : 0).",
                            autoplaySpeed: ".($settings['autoplaySpeed'] ? $settings['autoplaySpeed'] : 3000).",
                            responsive: [
                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: ".($settings['slidesToShow'] ? $settings['slidesToShow'] : 1).",
                                    slidesToScroll: ".($settings['slidesToScroll'] ? $settings['slidesToScroll'] : 1).",
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: ".($settings['slidesToShow'] ? $settings['slidesToShow'] : 1).",
                                    slidesToScroll: ".($settings['slidesToScroll'] ? $settings['slidesToScroll'] : 1).",
                                }
                            }
                          ]
                        }) ";

        $pageRender->addJsFooterInlineCode('nivo-config', $codeBlock, TRUE);
    }
}
?>