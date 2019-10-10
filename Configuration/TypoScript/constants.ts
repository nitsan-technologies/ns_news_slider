
plugin.tx_nsnewsslider_nsnewsslider {
  view {
    # cat=plugin.tx_nsnewsslider_nsnewsslider/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:ns_news_slider/Resources/Private/Templates/
    # cat=plugin.tx_nsnewsslider_nsnewsslider/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:ns_news_slider/Resources/Private/Partials/
    # cat=plugin.tx_nsnewsslider_nsnewsslider/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:ns_news_slider/Resources/Private/Layouts/
  }
  settings {
    # cat=plugin.tx_newsslider/enable/001; type=boolean; label=Load jQuery library by Google CDN:
    includeJquery = 0
    # cat=plugin.tx_newsslider/enable/002; type=small; label=jQuery version:
    jQueryVersion = 3.3.1
    # cat=plugin.tx_newsslider/enable/003; type=boolean; label=Load jQuery Mobile: if you want to use some functionalities with Camera slideshow
    includeJqueryMobile = 0
    # cat=plugin.tx_newsslider/enable/004; type=boolean; label=Load jQuery Easing: if you want to use some functionalities with Camera slideshow
    includeJqueryEasing = 0
  }
  persistence {
    # cat=plugin.tx_nsnewsslider_nsnewsslider//a; type=string; label=Default storage PID
    storagePid =
  }

}
