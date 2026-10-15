# Feature — News slider plugins

*Status: Done (free version). Code-read (2026-10-15); Slick Slider edit form and Page module preview seen on
v14.3.7, frontend not tested.*

## Editor flow

1. Create news records with EXT:news (images from the news media are the slides).
2. Add one of the plugins (wizard group "News Slider"; signatures below) and set the news options in the
   FlexForm sheets "Settings" (starting point, categories, ordering, limit, …), "Additional" (detail page, …)
   and "Template", plus the slider sheet.
3. Include the static template "News Slider" or the site set `nitsan/ns-news-slider`, next to the news
   TypoScript.

| Plugin (title) | Signature (CType on v14, `list_type` on v12/v13) | Controller | Slider sheet / TypoScript key |
|---|---|---|---|
| Nivo Slider | `nsnewsslider_nivoslider` | `NivoController` | `plugin.tx_nsnewsslider_nivoslider` |
| Owlcarousel Slider | `nsnewsslider_owlcarouselslider` | `OwlController` | `plugin.tx_nsnewsslider_owlcarousel` |
| Royal Slider | `nsnewsslider_royalslider` | `RoyalController` | `plugin.tx_nsnewsslider_royalslider` |
| SliderjS Slider | `nsnewsslider_sliderjsslider` | `SliderjsController` | `plugin.tx_nsnewsslider_sliderjs` |
| Slick Slider | `nsnewsslider_slickslider` | `SlickController` | `plugin.tx_nsnewsslider_slickslider` |

## Rendering

- `SliderBaseController::findNews()`: news demand from the plugin settings (`createDemandObjectFromSettings`),
  `findDemanded()`; warning flash message "No News!" when empty.
- Each `listAction()` adds the library CSS (`addHeaderData`) and JS (`addJsFooterFile`), jQuery 3.6.0 only when
  the TypoScript `jQuery` constant is on, and an inline footer script that initialises the slider. Every option
  takes the FlexForm value first and falls back to the TypoScript constant (read from the full TypoScript, not
  from the plugin settings).
- Owl, Royal, SlidesJS and Slick scope the script to the content element uid
  (`currentContentObject` → `data['uid']`); Nivo uses the fixed id `#slider` (one Nivo slider per page).
- Asset URLs: Composer mode `_assets/…` via `getPath()`, Classic mode `typo3conf/ext/ns_news_slider/…`.

## Settings

| Classic constants | Site set settings |
|---|---|
| `plugin.tx_nsnewsslider_nsnewsslider.view.*`, `.persistence.storagePid` | `ns_newsslider.view.*`, `ns_newsslider.persistence.storagePid` |
| `plugin.tx_nsnewsslider_owlcarousel.settings.*` | `ns_newsslider.owl.*` |
| `plugin.tx_nsnewsslider_nivoslider.settings.*` | `ns_newsslider.nivo.*` |
| `plugin.tx_nsnewsslider_royalslider.settings.*` | `ns_newsslider.royal.*` |
| `plugin.tx_nsnewsslider_slickslider.settings.*` | `ns_newsslider.slick.*` |
| `plugin.tx_nsnewsslider_sliderjs.settings.*` | `ns_newsslider.sliderjs.*` |

The `tx_nsnewsslider_nsnewsslider` block does not reach the plugins (see `core.md`).

## Page module preview

`Templates/Backend/<Slider>.html` (v12/v13) and `<Slider>14.html` (v14): premium strip + table with the slider
title, starting point, detail page and selected news (rows only when set).
