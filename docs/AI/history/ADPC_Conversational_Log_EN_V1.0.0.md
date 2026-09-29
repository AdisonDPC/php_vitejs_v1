# ADPC Conversational Log — PHP_ViteJS_V1
**Version:** V1.0.0  
**Date:** 2026-09-29  
**Language:** English  
**Project:** PHP_ViteJS_V1  
**Author:** Adison Daniel Pérez Caraballo  
**Note:** first conversational log of this project (`docs/AI` created in this session).

---

## Session V1.0.0 — 2026-09-27 → 2026-09-29

### Context

Multi-project maintenance session run from the `I_Offertator_V1` VS Code workspace (19 projects). The Mac moved from Node 25 to **Node 24 LTS** (nvm). Rules followed: never `npm audit fix` (fix by updating versions or targeted `overrides`), only same-major updates, Docker untouched, no PHP installed on the Mac, `crypto-js` kept on purpose.

**Summary for this project:** `vite.config` migrated from `__dirname` to `import.meta.dirname`; `composer serve` hardened (4 workers, memory and time limits); AI docs and README updated.

### User Requests

1. Review every project that uses Vite and fix the `configLoader: 'native'` warning (`__dirname`), taking into account each project's Vite version.
2. Apply the hardened `composer serve` script to every Slim/PHP project that uses `php -S` (not to Laravel).
3. Update the AI docs and READMEs of every modified project (conversational log EN + ES, new version per session).

### Assistant Actions

#### Vite configuration

- Vite 8.3 warns that `__dirname` will not be supported by `configLoader: 'native'` (planned default in a future Vite major). `__dirname` was replaced by `import.meta.dirname` in `vite.config` (**5** occurrences; installed Vite 7.3.6).
- Verified by loading the config with the project's own Vite before and after the change: the resolved configuration (paths, aliases, inputs, output folders) is identical, with real paths and no `undefined`. Vite 7 did not show the warning yet; the change prepares the project for Vite 8.
- `vite.config.js` already had uncommitted changes by the user; only `__dirname` was replaced.

#### `composer serve`

- `composer serve` (built-in `php -S`) was measured inside the Slim container: memory stable at ~57 MB after 1,600+ requests (no leak) and request errors never kill the server. The risks were that `php -S` uses the CLI `php.ini` (`memory_limit = -1`, `max_execution_time = 0`) and a single worker, so one slow request blocked all the others (2.7 s wait vs 15 ms with 4 workers).
- The `serve` script in `composer.json` now reads:

```json
"serve": [
    "Composer\\Config::disableProcessTimeout",
    "@putenv PHP_CLI_SERVER_WORKERS=4",
    "@php -d memory_limit=256M -d max_execution_time=60 -S 0.0.0.0:8000 -t public/"
]
```
- Verified with a real `composer serve` in the container: 1 master + 4 workers, and inside a request PHP reports `memory_limit=256M`, `max_execution_time=60`, `PHP_CLI_SERVER_WORKERS=4` (Composer's own `-d memory_limit=-1` is overridden because ours comes later). An infinite loop is cut at the limit without killing the server. `composer.lock` is not affected (scripts are not part of its hash).

### Verification

| Check | Result |
|---|---|
| `vite.config` loaded before/after with its own Vite | identical resolved configuration |
| `composer.json` | valid JSON; `serve` updated |

### Files Created / Modified

| File | Change |
|---|---|
| `vite.config.js` | `__dirname` → `import.meta.dirname` |
| `composer.json` | Script `serve`: 4 workers + limits |
| `docs/AI/history/ADPC_Conversational_Log_EN_V1.0.0.md` | This session log (EN) |
| `docs/AI/history/ADPC_Conversational_Log_ES_V1.0.0.md` | This session log (ES) |
| `README.md` | Maintenance section added |

### Pending / Notes

- Nothing was committed; all changes are left for the user to review.

---

### End of Session: 2026-09-29
