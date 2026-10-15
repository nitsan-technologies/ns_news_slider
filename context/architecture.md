# ns_news_slider — Architecture

Five Extbase plugins (one per slider library, action `list`, all non-cacheable), no own tables, no backend
module. The controllers extend EXT:news `NewsController` and render news records. Backend additions: Page
module previews, FormEngine resolver for the premium strip.

## Configuration

| File | What |
|---|---|
| `ext_localconf.php` | Plugins `NivoSlider`, `OwlcarouselSlider`, `RoyalSlider`, `SliderjsSlider`, `SlickSlider`; news `findDemanded` hook (`OverrideNewsDemand`, not called on news 14, see `core.md`); FormEngine `nodeResolver` 1792055417 (`flexFormTabsContainer`, priority 41) |
| `Configuration/TCA/Overrides/tt_content.php` | v14: `registerPlugin()` with the FlexForm as 7th argument (CType). v12/v13: `registerPlugin()` + `subtypes_addlist` / `addPiFlexFormValue()` / `subtypes_excludelist` per `list_type` |
| `Configuration/FlexForms/{Nivoslider,OwlcarouselSlider,RoyalSlider,SliderJs,SlickSlider}.xml` | Four sheets each: news "Settings", "Additional", "Template", plus one slider-specific sheet |
| `Configuration/page.tsconfig` | Wizard group "News Slider" (legacy `list_type` items) + `web_layout.tt_content.preview.list.<signature>` (v12/v13) and `web_layout.tt_content.preview.<signature>` (v14) → `Templates/Backend/*.html` / `*14.html`. Loaded globally by core since v12; the site set imports it again |
| `Configuration/TCA/Overrides/sys_template.php` | Static template "News Slider" (`Configuration/TypoScript`) |
| `Configuration/TypoScript/` | Constants and setup: `plugin.tx_nsnewsslider_nsnewsslider` (view, persistence, news settings) and per-library settings `plugin.tx_nsnewsslider_{owlcarousel,nivoslider,royalslider,slickslider,sliderjs}.settings.*` |
| `Configuration/Sets/NsNewsSlider/` | Site set `nitsan/ns-news-slider`; `settings.definitions.yaml` (179 settings below `ns_newsslider.{view,persistence,owl,nivo,royal,slick,sliderjs}`); setup imports the classic setup and maps the settings onto it; imports `page.tsconfig` |
| `Configuration/Services.yaml` | Autowires `Classes/*` |
| `Configuration/Icons.php` | `ns_news_slider-plugin-nsnewsslider` |

## Classes

| Class | Role |
|---|---|
| `Controller\SliderBaseController` | Extends news `NewsController`; `findNews()` builds the news demand from settings (flash message when empty); `getPath()` for Composer-mode asset URLs |
| `Controller\{Nivo,Owl,Royal,Sliderjs,Slick}Controller` | `listAction`: news + settings to the view, CSS via `addHeaderData`, JS via `addJsFooterFile`, inline init script (FlexForm value, else TypoScript constant) |
| `Hooks\OverrideNewsDemand` | Adds `type = 0` when `newsOnly` is set |
| `Backend\PremiumStrip` | Strip HTML + trial URL; `''` when the ns_license route is missing |
| `Form\Resolver\PremiumStripFlexFormTabsContainerResolver` | Picks the strip container for `pi_flexform` of the five plugins |
| `Form\Container\PremiumStripFlexFormTabsContainer` | Core FlexForm tabs container + strip |
| `ViewHelpers\Be\PremiumStripViewHelper` | Strip in the Page module previews |

## Views

- Frontend: `Templates/{Nivo,Owl,Royal,Sliderjs,Slick}/List.html` → `Layouts/Default.html` → per-library
  partials (`Partials/{Nivoslider,Owlcarousel,RoyalSlider,Sliderjs,SlickSlider}/Items.html`; `Partials/Owl/`
  holds a second Owl partial). Templates use news ViewHelpers (`n:link`, `n:excludeDisplayedNews`, …).
- Backend: `Templates/Backend/<Slider>.html` (v12/v13, `pi_flexform_transformed`) and `<Slider>14.html`
  (v14, `record.pi_flexform`): premium strip + table with starting point, detail page, selected news.

## Assets

- Frontend: `Resources/Public/slider/<Library>/`, `Js/jquery-3.6.0.min.js`, `Img/no-image.jpg`.
- Backend: `Css/backend-premium-strip.css`.
