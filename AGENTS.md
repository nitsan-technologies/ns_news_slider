# AGENTS.md — ns_news_slider (TYPO3 News Slider)

Agent router for the News Slider free extension. Load only what your task needs.

> **Principles:** `context/principles.md`
> **Session log:** `context/session-state.md`
> **Doc index:** `context/docs-map.md`

---

## Always load

| File | Why |
|---|---|
| `context/principles.md` | Guardrails, "nothing that works may break" rule |
| `context/core.md` | Identity, TYPO3/PHP/news/ns_license constraints, tooling, known issues |

---

## Task router

| Task | Load |
|---|---|
| The five slider plugins: FlexForm, TypoScript / site set, frontend assets and JS, Page module preview | `context/features/news-slider-plugins.md` |
| Premium strip / free trial / ns_license dependency | `context/features/premium-cta.md` |
| Files, classes, TypoScript structure, assets | `context/architecture.md` |
| Lint / validate / manual test | `tasks/run-quality.md` |
| Update agent context after a change | `tasks/context-update.md` |

---

## Feature status

| Feature | Status | Agent entry |
|---|---|---|
| News from EXT:news as Nivo, Owl Carousel, Royal, SlidesJS or Slick slider | Done (code-read; edit form and preview seen on v14.3.7) | `context/features/news-slider-plugins.md` |
| Premium strip in the Page module preview and the plugin options + ns_license free-trial deep link | Done (needs ns_license 14.5.4 release) | `context/features/premium-cta.md` |

---

## Quick commands

```bash
cd packages/ns_news_slider         # or typo3conf/ext/ns_news_slider in Classic mode
for f in $(find . -name "*.php" -not -path "./.git/*"); do php -l "$f"; done
composer validate --no-check-publish
for f in Resources/Private/Language/*.xlf; do xmllint --noout "$f"; done
```
