
plugin.tx_nsnewsslider_nsnewsslider {
  view {
    # cat=plugin.tx_nsnewsslider_nsnewsslider/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:ns_news_slider/Resources/Private/Templates/
    # cat=plugin.tx_nsnewsslider_nsnewsslider/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:ns_news_slider/Resources/Private/Partials/
    # cat=plugin.tx_nsnewsslider_nsnewsslider/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:ns_news_slider/Resources/Private/Layouts/
  }  
  persistence {
    # cat=plugin.tx_nsnewsslider_nsnewsslider//a; type=string; label=Default storage PID
    storagePid =
  }

}

plugin.tx_nsnewsslider_royalslider {
  settings{
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=boolean; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.jQuery
    jQuery = 0    
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[true,false]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.deeplinking_enabled
    deeplinking_enabled = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[true,false]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.deeplinking_change
    deeplinking_change = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=string; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.deeplinking_prefix
    deeplinking_prefix = gallery-   
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[true,false]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumbs_appendSpan
    thumbs_appendSpan = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[true,false]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumbs_firstMargin
    thumbs_firstMargin = true   
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.arrowsNav
    arrowsNav = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.loop
    loop = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.keyboardNavEnabled
    keyboardNavEnabled = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.controlsInside
    controlsInside = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=string; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.imageScaleMode
    imageScaleMode = fit-if-smaller
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.arrowsNavAutoHide
    arrowsNavAutoHide = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.autoScaleSlider
    autoScaleSlider = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=string; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.autoScaleSliderWidth
    autoScaleSliderWidth = 960
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=string; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.autoScaleSliderHeight
    autoScaleSliderHeight = 350
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[thumbnails,tabs,none]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.controlNavigation
    controlNavigation = thumbnails    
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.navigateByClick
    navigateByClick = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=string; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.startSlideId
    startSlideId = 1
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.autoPlay
    autoPlay = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=string; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.transitionType
    transitionType = move
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.globalCaption
    globalCaption = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.arrowsNavHideOnTouch
    arrowsNavHideOnTouch = true   
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.imageAlignCenter
    imageAlignCenter = true   
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=string; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.imgWidth
    imgWidth = 800
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=string; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.imgHeight
    imgHeight = 500
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=int; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.slidesSpacing
    slidesSpacing = 8
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.loopRewind
    loopRewind = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.randomizeSlides
    randomizeSlides = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=int; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.numImagesToPreload
    numImagesToPreload = 4
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.usePreloader
    usePreloader = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[vertical,horizontal]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.slidesOrientation
    slidesOrientation = horizontal
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=int; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.transitionSpeed
    transitionSpeed = 600
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[easeOutSine,easeInOutSine,linear]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.easeInOut
    easeInOut = easeInOutSine
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[easeOutSine,easeInOutSine,linear]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.easeOut
    easeOut = easeOutSine
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.sliderDrag
    sliderDrag = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.sliderTouch
    sliderTouch = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.fadeinLoadedSlide
    fadeinLoadedSlide= true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.allowCSS3
    allowCSS3 = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.addActiveClass
    addActiveClass = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=int; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.minSlideOffset
    minSlideOffset = 10
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.autoHeight
    autoHeight = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumb_drag
    thumb_drag = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumb_touch
    thumb_touch = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[horizontal,vertical]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumb_orientation
    thumb_orientation = horizontal
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumb_arrows
    thumb_arrows = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=int; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumb_spacing
    thumb_spacing = 4
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumb_arrowsAutoHide
    thumb_arrowsAutoHide = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumb_autoCenter
    thumb_autoCenter = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=int; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumb_transitionSpeed
    thumb_transitionSpeed = 600
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumb_fitInViewport
    thumb_fitInViewport = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=string; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumb_arrowLeft
    thumb_arrowLeft = null
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=string; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.thumb_arrowRight
    thumb_arrowRight = null
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.fullScreen_enabled
    fullScreen_enabled = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.fullScreen_keyboardNav
    fullScreen_keyboardNav = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.fullScreen_buttonFS
    fullScreen_buttonFS = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:flexform.fullScreen_nativeFS
    fullScreen_nativeFS = false
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:autoPlay_stopAtAction
    autoPlay_stopAtAction = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=options[false,true]; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:autoPlay_pauseOnHover
    autoPlay_pauseOnHover = true
    # cat=plugin.tx_nsnewsslider_royalslider//a; type=string; label=LLL:EXT:ns_news_slider/Resources/Private/Language/locallang_db.xlf:autoPlay_delay
    autoPlay_delay = 3000
  }
}
