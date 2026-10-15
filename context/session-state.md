# ns_news_slider — Session state

## 2026-10-15 — ns_license integration + premium strip + agent context

- Branch `feature/ns-license-premium-strip` from `master` (902efa3).
- Added `nitsan/ns-license ^14.5.4` / `ns_license 14.5.4-14.9.99` (minimum stays TYPO3 12.4.37).
  Version 14.0.1 → 14.1.0.
- Premium strip with "Start Free Trial" → ns_license module `?trial=ns_news_slider#free-section` in the Page
  module previews (all ten templates) and above the FlexForm sheet tabs in the Plugin tab, team-wide wording and
  design (see `features/premium-cta.md`).
- Verified live on TYPO3 14.3.7 classic with a temporary Slick Slider element on page 1 and a temporary
  system-maintainer admin (both removed; `settings.php` restored byte-identical). PHP 8.4 and 8.1 lint clean.
- Created agent context (`AGENTS.md`, `CLAUDE.md`, `context/`, `tasks/`) and `.gitattributes`; no previous
  context existed.
- Open: ns_license 14.5.4 not yet published; v12/v13 not tested; frontend only code-read.
