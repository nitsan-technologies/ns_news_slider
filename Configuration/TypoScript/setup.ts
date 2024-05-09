
plugin.tx_nsnewsslider_nsnewsslider {
  view {
    templateRootPaths.0 = EXT:ns_news_slider/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_nsnewsslider_nsnewsslider.view.templateRootPath}
    partialRootPaths.0 = EXT:ns_news_slider/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_nsnewsslider_nsnewsslider.view.partialRootPath}
    layoutRootPaths.0 = EXT:ns_news_slider/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_nsnewsslider_nsnewsslider.view.layoutRootPath}
  }
  persistence {
    storagePid = {$plugin.tx_nsnewsslider_nsnewsslider.persistence.storagePid}
  }
    settings < plugin.tx_news.settings
    settings {
        list.media.image.maxWidth = 100
        list.media.image.maxHeigh = 100
    # If using multiple JS-Libraries.
            jqueryNoConflict = 0
    # Move the JS to the Footer if set.
            moveJsFromHeaderToFooter = 1
            # Move the inlineJS to the Footer if set.
            moveInlineJsFromHeaderToFooter = 1
            # Shows only news from type=0 in the slider (no internal- and no external links) ... clear all cache!
        newsOnly = 0        
  }
}

plugin.tx_nsnewsslider_royalslider {
    settings {       
      jQuery = {$plugin.tx_nsnewsslider_royalslider.settings.jQuery}
      deeplinking_enabled = {$plugin.tx_nsnewsslider_royalslider.settings.deeplinking_enabled}
      deeplinking_change = {$plugin.tx_nsnewsslider_royalslider.settings.deeplinking_change}
      deeplinking_prefix = {$plugin.tx_nsnewsslider_royalslider.settings.deeplinking_prefix}    
      thumbs_appendSpan = {$plugin.tx_nsnewsslider_royalslider.settings.thumbs_appendSpan}
      thumbs_firstMargin = {$plugin.tx_nsnewsslider_royalslider.settings.thumbs_firstMargin}    
      arrowsNav = {$plugin.tx_nsnewsslider_royalslider.settings.arrowsNav}
      loop = {$plugin.tx_nsnewsslider_royalslider.settings.loop}
      keyboardNavEnabled = {$plugin.tx_nsnewsslider_royalslider.settings.keyboardNavEnabled}
      controlsInside = {$plugin.tx_nsnewsslider_royalslider.settings.controlsInside}
      imageScaleMode = {$plugin.tx_nsnewsslider_royalslider.settings.imageScaleMode}
      arrowsNavAutoHide = {$plugin.tx_nsnewsslider_royalslider.settings.arrowsNavAutoHide}
      autoScaleSlider = {$plugin.tx_nsnewsslider_royalslider.settings.autoScaleSlider}
      autoScaleSliderWidth = {$plugin.tx_nsnewsslider_royalslider.settings.autoScaleSliderWidth}
      autoScaleSliderHeight = {$plugin.tx_nsnewsslider_royalslider.settings.autoScaleSliderHeight}
      controlNavigation = {$plugin.tx_nsnewsslider_royalslider.settings.controlNavigation}    
      navigateByClick = {$plugin.tx_nsnewsslider_royalslider.settings.navigateByClick}
      startSlideId = {$plugin.tx_nsnewsslider_royalslider.settings.startSlideId}
      autoPlay = {$plugin.tx_nsnewsslider_royalslider.settings.autoPlay}
      transitionType = {$plugin.tx_nsnewsslider_royalslider.settings.transitionType}
      globalCaption = {$plugin.tx_nsnewsslider_royalslider.settings.globalCaption}
      arrowsNavHideOnTouch = {$plugin.tx_nsnewsslider_royalslider.settings.arrowsNavHideOnTouch}    
      imageAlignCenter = {$plugin.tx_nsnewsslider_royalslider.settings.imageAlignCenter}
      imgWidth = {$plugin.tx_nsnewsslider_royalslider.settings.imgWidth}
      imgHeight = {$plugin.tx_nsnewsslider_royalslider.settings.imgHeight}
      slidesSpacing = {$plugin.tx_nsnewsslider_royalslider.settings.slidesSpacing}
      loopRewind = {$plugin.tx_nsnewsslider_royalslider.settings.loopRewind}
      randomizeSlides = {$plugin.tx_nsnewsslider_royalslider.settings.randomizeSlides}
      numImagesToPreload = {$plugin.tx_nsnewsslider_royalslider.settings.numImagesToPreload}
      usePreloader = {$plugin.tx_nsnewsslider_royalslider.settings.usePreloader}
      slidesOrientation = {$plugin.tx_nsnewsslider_royalslider.settings.slidesOrientation}
      transitionSpeed = {$plugin.tx_nsnewsslider_royalslider.settings.transitionSpeed}
      easeInOut = {$plugin.tx_nsnewsslider_royalslider.settings.easeInOut}
      easeOut = {$plugin.tx_nsnewsslider_royalslider.settings.easeOut}
      sliderDrag = {$plugin.tx_nsnewsslider_royalslider.settings.sliderDrag}
      sliderTouch = {$plugin.tx_nsnewsslider_royalslider.settings.sliderTouch}
      fadeinLoadedSlide= {$plugin.tx_nsnewsslider_royalslider.settings.fadeinLoadedSlide}
      allowCSS3 = {$plugin.tx_nsnewsslider_royalslider.settings.allowCSS3}
      addActiveClass = {$plugin.tx_nsnewsslider_royalslider.settings.addActiveClass}
      minSlideOffset = {$plugin.tx_nsnewsslider_royalslider.settings.minSlideOffset}
      autoHeight = {$plugin.tx_nsnewsslider_royalslider.settings.autoHeight}
      thumb_drag =  {$plugin.tx_nsnewsslider_royalslider.settings.thumb_drag}
      thumb_touch =  {$plugin.tx_nsnewsslider_royalslider.settings.thumb_touch}
      thumb_orientation =  {$plugin.tx_nsnewsslider_royalslider.settings.thumb_orientation}
      thumb_arrows =  {$plugin.tx_nsnewsslider_royalslider.settings.thumb_arrows}
      thumb_spacing =  {$plugin.tx_nsnewsslider_royalslider.settings.thumb_spacing}
      thumb_arrowsAutoHide =  {$plugin.tx_nsnewsslider_royalslider.settings.thumb_arrowsAutoHide}
      thumb_autoCenter =  {$plugin.tx_nsnewsslider_royalslider.settings.thumb_autoCenter}
      thumb_transitionSpeed =  {$plugin.tx_nsnewsslider_royalslider.settings.thumb_transitionSpeed}
      thumb_fitInViewport =  {$plugin.tx_nsnewsslider_royalslider.settings.thumb_fitInViewport}
      thumb_arrowLeft =  {$plugin.tx_nsnewsslider_royalslider.settings.thumb_arrowLeft}
      thumb_arrowRight =  {$plugin.tx_nsnewsslider_royalslider.settings.thumb_arrowRight}
      fullScreen_enabled = {$plugin.tx_nsnewsslider_royalslider.settings.fullScreen_enabled}
      fullScreen_keyboardNav   = {$plugin.tx_nsnewsslider_royalslider.settings.fullScreen_keyboardNav}
      fullScreen_buttonFS  = {$plugin.tx_nsnewsslider_royalslider.settings.fullScreen_buttonFS}
      fullScreen_nativeFS = {$plugin.tx_nsnewsslider_royalslider.settings.fullScreen_nativeFS}
      autoPlay_stopAtAction = {$plugin.tx_nsnewsslider_royalslider.settings.autoPlay_stopAtAction}
      autoPlay_pauseOnHover = {$plugin.tx_nsnewsslider_royalslider.settings.autoPlay_pauseOnHover}
      autoPlay_delay = {$plugin.tx_nsnewsslider_royalslider.settings.autoPlay_delay}
  }
}
