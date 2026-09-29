# php_vitejs_v1
PHP_ViteJS_V1

## 🔧 Maintenance & Dependencies

> Last update: 2026-09-29

- **Vite config:** uses `import.meta.dirname` instead of `__dirname`, as required by Vite's native config loader.
- **Development server:** `composer serve` starts PHP's built-in server on `0.0.0.0:8000` (docroot `public/`) with 4 workers (`PHP_CLI_SERVER_WORKERS=4`), `memory_limit=256M` and `max_execution_time=60`. It is meant for development only; production uses NGiNX + PHP-FPM.
- **Change log:** see `docs/AI/history/ADPC_Conversational_Log_{EN,ES}_V1.0.0.md`.
