# ns_news_slider — Core facts

## Identity

| Item | Value |
|---|---|
| Extension key | `ns_news_slider` |
| Composer name | `nitsan/ns-news-slider` |
| Title (ext_emconf) / product name | TYPO3 News Slider / News Slider |
| Namespace | `NITSAN\NsNewsSlider\` → `Classes/` |
| Version (ext_emconf) | 14.1.0 (latest tag 14.0.1) |
| Repository | https://github.com/nitsan-technologies/ns_news_slider (default branch `master`) |
| Licensing status | **Freemium** — this repo is the free version. The NITSAN Free/Freemium sheet needs a Google login; status taken from the T3Planet catalog (`isFree: false` for the premium product) |
| Premium version (T3Planet catalog) | "News Slider", €79, https://t3planet.de/en/typo3-news-slider-extension |

## Compatibility

| Source | TYPO3 | EXT:news | PHP |
|---|---|---|---|
| `ext_emconf.php` | `12.4.37-14.9.99` | `12.0.0-14.9.99` | not declared |
| `composer.json` | `^12.4.37 \|\| ^13 \|\| ^14` | `^13 \|\| ^14` | not declared |
| ns_license 14.5.4 (dependency) | `12.4.18-14.9.99` | — | not declared (TYPO3 12.4 needs 8.1+) |

- ns_license does not raise the minimum: it stays **TYPO3 12.4.37 / PHP 8.1**.
- The news ranges differ (ext_emconf allows news 12, Composer starts at 13).

## Dependencies

| Package | Constraint | Why |
|---|---|---|
| `typo3/cms-core` | see above | core |
| `georgringer/news` / `news` | see above | News records, demand, `NewsController` (all slider controllers extend it) |
| `nitsan/ns-license` / `ns_license` | `^14.5.4` / `14.5.4-14.9.99` | TYPO3 Shop module + free-trial deep link (see `features/premium-cta.md`) |

Bundled frontend libraries (no package manager): jQuery 3.6.0, Nivo Slider, Owl Carousel (+ thumbs plugin),
Royal Slider, Slick, SlidesJS, Fancybox, Font Awesome (SlidesJS types).

## Tooling

- No PHPUnit, PHPStan, CS fixer or package.json in the repo.
- CI: `.github/workflows/ter-release.yml` only (publishes tags to TER with tailor on PHP 7.4).
- `.gitattributes` export-ignores `.github/`, `AGENTS.md`, `CLAUDE.md`, `context/`, `tasks/` and itself, so they
  are not in the GitHub/Composer archive or the TER package (the TER release uploads the GitHub tag archive).
- No Crowdin config; English only: `locallang.xlf` (frontend messages, premium strip), `locallang_db.xlf`
  (plugin titles, wizard, FlexForm, preview labels).

## Conventions

- PHP: 4 spaces; the controllers in `Classes/Controller/` mostly have `declare(strict_types=1)`
  (`SliderBaseController` does not), the premium-strip classes do.
- TypoScript: 4 spaces; Fluid and XLF: tabs (the preview templates use 4 spaces).
- Backend CSS in `Resources/Public/Css/` (`backend-premium-strip.css`), frontend libraries in
  `Resources/Public/slider/` and `Resources/Public/Js/`.

## Known issues (existing, not fixed)

All code-read unless marked.

- **Category tree broken on news 14 (seen live on 14.3.7):** all five FlexForms use
  `GeorgRinger\News\TreeProvider\DatabaseTreeDataProvider` for `settings.categories`; the class does not exist
  in news 14.1.1, so opening the edit form logs a `ReflectionException` and the backend shows "Navigation
  loading error".
- **`newsOnly` has no effect on news 14:** `ext_localconf.php` registers `OverrideNewsDemand` on the legacy
  `findDemanded` hook, which news 14 no longer calls (it dispatches `ModifyDemandRepositoryEvent`). The hook
  also reads `plugin.tx_nsnewsslider_nsnewsslider.settings.newsOnly`.
- **TypoScript key mismatch:** view paths, `persistence.storagePid`, `settings < plugin.tx_news.settings` and
  `newsOnly` sit below `plugin.tx_nsnewsslider_nsnewsslider`, which is neither the extension key
  (`tx_nsnewsslider`) nor a plugin signature, so Extbase does not apply them to the five plugins; templates
  resolve from the Extbase defaults.
- **Site set constants:** `Configuration/Sets/NsNewsSlider/constants.typoscript` imports
  `Configuration/TypoScript/Constants.typoscript` (capital C); the file is `constants.typoscript`, so the import
  fails on case-sensitive file systems.
- **v14 wizard items:** `Configuration/page.tsconfig` adds wizard entries with `CType = list` +
  `list_type = …`; on v14 the plugins are CTypes and `list_type` no longer exists. Core already lists the v14
  CTypes from `registerPlugin()`.
- All five plugin actions are registered as non-cacheable.
- The Owl Carousel controller loads Open Sans from `fonts.googleapis.com` on every page with the plugin.
- Without jQuery (constant `jQuery` off and none from the site) the inline script shows a browser
  `alert('Please include Jquery library first!')`.
- README badges show v13.0.1 / TYPO3 13 and GPL-3.0; `composer.json` uses the deprecated SPDX id `GPL-2.0+`.
