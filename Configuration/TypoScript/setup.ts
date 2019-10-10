
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
    #recursive = 1
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
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
}

page.includeJS {
  JQuery = EXT:ns_news_slider/Resources/Public/slider/JQuery/jquery.min.js
}

