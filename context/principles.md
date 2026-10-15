# ns_news_slider — Operating Principles

*Every change to code, context or docs must serve the goals below.*

---

## Goal 1 — Nothing that works may break

The extension declares TYPO3 v12.4.37–v14 and EXT:news 12–14 (Composer and Classic mode), see `core.md`.

- Keep every declared major working. Follow the existing version switches (`version_main >= 14` in
  `Configuration/TCA/Overrides/tt_content.php`, the `*14.html` preview templates, `enum_exists(IconSize::class)`
  in `PremiumStrip`, the constructor/`setData()` pair in the FormEngine resolver) instead of inventing new ones.
- Lowest PHP is 8.1 (TYPO3 12): no PHP 8.2+ syntax such as `readonly` classes or DNF types.
- Both configuration paths must keep working: the classic static template ("News Slider",
  `plugin.tx_nsnewsslider_*` constants) and the site set `nitsan/ns-news-slider` (`ns_newsslider.*` settings).
  A change to one usually needs the same change in the other.
- Both asset paths must keep working: every controller builds URLs differently for Composer mode
  (`getPath()` → `_assets/…`) and Classic mode (`typo3conf/ext/…`).
- Existing content elements must keep rendering: v12/v13 store the plugins as `list` + `list_type`, v14 as
  CType; the five signatures are the same (`nsnewsslider_<plugin>`).
- Prefer the smallest change that fixes the root cause. No drive-by refactors.
- Run `tasks/run-quality.md` and re-test the affected flow before claiming done.

## Goal 2 — Token-cost efficiency (agent context)

- **DRY context:** each fact lives in exactly ONE file. Reference, don't copy.
- **Load on demand:** read `context/features/<area>.md` for the task, not everything.
- **Prune as you go:** keep `context/session-state.md` short.

## Goal 3 — Accuracy and trust

- Answer from context + code, never from invented API, table or field names.
- Mark statements as verified live or code-read; conflicting facts across files = fix the source file.

---

## Guardrails (non-negotiable)

- FormEngine resolver priorities for `flexFormTabsContainer` must be unique across all installed NITSAN
  extensions (core throws on duplicates); ns_news_slider uses 41 (see `features/premium-cta.md`).
- Installing the premium version through ns_license replaces this extension's folder: never keep user data in
  files below the extension.
- Do not change ns_license or EXT:news from an ns_news_slider task; reuse ns_license's module and trial modal.
- All UI text goes into the English `Resources/Private/Language/*.xlf` files, no hard-coded labels.

---

## Apply this whenever you

- Edit `context/` or `AGENTS.md`
- Land a feature or bugfix (update the matching `context/features/*.md` + `session-state.md`)
