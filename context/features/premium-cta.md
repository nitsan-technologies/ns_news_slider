# Feature — Premium strip and ns_license free trial

*Status: Done. Verified live on TYPO3 14.3.7 (2026-10-15) with a Slick Slider element: strip in the Page module
preview and in the Plugin tab above the FlexForm sheet tabs; the button opens the ns_license module with "News
Slider (ns_news_slider)" preselected in the trial modal. Requires ns_license 14.5.4 (deep-link support) to be
released. Other four sliders and v12/v13 not tested (same code path).*

## Licensing status

Freemium. Premium product (T3Planet catalog): "News Slider", €79,
https://t3planet.de/en/typo3-news-slider-extension (not linked from the UI; the trial stays inside the TYPO3
backend). Catalog features: multiple slider libraries, lazy image loading, vertical slider option, configurable
transitions, pause/loop controls, navigation controls, custom slider dimensions.

## Dependency

`composer.json` `"nitsan/ns-license": "^14.5.4"`, `ext_emconf.php` `'ns_license' => '14.5.4-14.9.99'`. The
minimum stays TYPO3 12.4.37 (see `core.md`).

## Placements

| Place | Position |
|---|---|
| Page module, preview of any of the five slider elements | Above the preview table (`<nss:be.premiumStrip />` in all ten `Templates/Backend/*.html`) |
| Content element edit form, tab "Plugin" | Below the "Plugin Options" label, above the FlexForm sheet tabs (Settings, Additional, Template, slider sheet) |

## How it works

- `Backend\PremiumStrip::render()`: `actions-rocket` icon, headline and description on two lines,
  `btn btn-primary` "Start Free Trial →" (the arrow is `aria-hidden` markup). Link = route
  `nitsan_nslicensemodule` + `trial=ns_news_slider` + `#free-section`, same frame. Returns `''` without
  ns_license, so neither placement shows anything.
- Preview: `ViewHelpers\Be\PremiumStripViewHelper` renders the strip and adds the stylesheet through
  `PageRenderer`. The preview templates declare the `nss` namespace inline because they are rendered standalone.
- Edit form: `ext_localconf.php` registers `Form\Resolver\PremiumStripFlexFormTabsContainerResolver` for node
  `flexFormTabsContainer`, priority **41** (taken: ns_revolution_slider 40, ns_news_slick 42, ns_google_map 43; duplicates make core throw). It
  matches `tt_content.pi_flexform` of the five signatures `nsnewsslider_{nivoslider,owlcarouselslider,
  royalslider,sliderjsslider,slickslider}` as CType (v14) or `list` + `list_type` (v12/v13), not inline
  children, and returns `Form\Container\PremiumStripFlexFormTabsContainer`, which prepends the strip and adds
  the stylesheet. Core only uses `flexFormTabsContainer` for FlexForms with more than one sheet (all five have
  four); a single-sheet FlexForm would hide the strip from the form.

## Strip

- Labels in `locallang.xlf`: `premium.strip.headline` "You're using the free version of NS News Slider",
  `premium.strip.description` "Unlock premium features and get more out of NS News Slider.",
  `premium.strip.trial` "Start Free Trial".
- `Resources/Public/Css/backend-premium-strip.css`: `.ns-news-slider-premium-strip` — team-wide design
  (light-blue card `#e7f2fc`, border `#8eb6e8`, 4px `#2b6cb0` left accent, 6px radius, padding 14px 18px,
  `light-dark()` for dark mode, button `#007bff` / hover `#0062cc`); inset 16px inside the FlexForm panel.
- Measured on v14.3.7: 849×67px in the edit form (883px panel); 482×119px in the Page module preview, where the
  button wraps below the text.
- ns_license's module requires system maintainer access; other users get access denied after clicking.
