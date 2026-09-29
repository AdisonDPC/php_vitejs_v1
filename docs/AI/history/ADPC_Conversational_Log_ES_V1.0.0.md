# ADPC Bitácora Conversacional — PHP_ViteJS_V1
**Versión:** V1.0.0  
**Fecha:** 2026-09-29  
**Idioma:** Español  
**Proyecto:** PHP_ViteJS_V1  
**Autor:** Adison Daniel Pérez Caraballo  
**Nota:** primera bitácora conversacional de este proyecto (`docs/AI` creado en esta sesión).

---

## Sesión V1.0.0 — 2026-09-27 → 2026-09-29

### Contexto

Sesión de mantenimiento multiproyecto lanzada desde el workspace de VS Code de `I_Offertator_V1` (19 proyectos). El Mac pasó de Node 25 a **Node 24 LTS** (nvm). Reglas seguidas: nunca `npm audit fix` (arreglar actualizando versiones u `overrides` concretos), solo actualizaciones dentro de la misma versión mayor, Docker sin tocar, sin instalar PHP en el Mac, `crypto-js` conservado a propósito.

**Resumen para este proyecto:** `vite.config` migrado de `__dirname` a `import.meta.dirname`; `composer serve` reforzado (4 workers, límites de memoria y tiempo); documentación AI y README actualizados.

### Solicitudes del Usuario

1. Revisar todos los proyectos con Vite y solucionar el aviso de `configLoader: 'native'` (`__dirname`), teniendo en cuenta la versión de Vite de cada uno.
2. Aplicar el script `composer serve` mejorado a todos los proyectos Slim/PHP que usan `php -S` (no a Laravel).
3. Actualizar la documentación AI y los README de cada proyecto modificado (bitácora EN + ES, nueva versión por sesión).

### Acciones del Asistente

#### Configuración de Vite

- Vite 8.3 avisa de que `__dirname` no será compatible con `configLoader: 'native'` (previsto por defecto en una futura versión mayor de Vite). Se sustituyó `__dirname` por `import.meta.dirname` en `vite.config` (**5** apariciones; Vite instalado 7.3.6).
- Verificado cargando la config con la propia Vite del proyecto antes y después del cambio: la configuración resultante (rutas, alias, entradas, carpetas de salida) es idéntica, con rutas reales y sin `undefined`. Vite 7 aún no mostraba el aviso; el cambio deja el proyecto preparado para Vite 8.
- `vite.config.js` ya tenía cambios del usuario sin commitear; solo se sustituyó `__dirname`.

#### `composer serve`

- Se midió `composer serve` (servidor integrado `php -S`) dentro del contenedor Slim: memoria estable en ~57 MB tras más de 1.600 peticiones (sin fugas) y los errores de una petición nunca tumban el servidor. Los riesgos eran que `php -S` usa el `php.ini` de CLI (`memory_limit = -1`, `max_execution_time = 0`) y un único worker, así que una petición lenta bloqueaba a todas las demás (2,7 s de espera frente a 15 ms con 4 workers).
- El script `serve` de `composer.json` queda así:

```json
"serve": [
    "Composer\\Config::disableProcessTimeout",
    "@putenv PHP_CLI_SERVER_WORKERS=4",
    "@php -d memory_limit=256M -d max_execution_time=60 -S 0.0.0.0:8000 -t public/"
]
```
- Verificado con un `composer serve` real en el contenedor: 1 proceso principal + 4 workers, y dentro de una petición PHP devuelve `memory_limit=256M`, `max_execution_time=60`, `PHP_CLI_SERVER_WORKERS=4` (el `-d memory_limit=-1` que añade Composer queda anulado porque el nuestro va después). Un bucle infinito se corta en el límite sin tumbar el servidor. `composer.lock` no se ve afectado (los scripts no forman parte de su hash).

### Verificación

| Comprobación | Resultado |
|---|---|
| `vite.config` cargado antes/después con su propia Vite | configuración resultante idéntica |
| `composer.json` | JSON válido; `serve` actualizado |

### Archivos Creados / Modificados

| Archivo | Cambio |
|---|---|
| `vite.config.js` | `__dirname` → `import.meta.dirname` |
| `composer.json` | Script `serve`: 4 workers + límites |
| `docs/AI/history/ADPC_Conversational_Log_EN_V1.0.0.md` | Bitácora de esta sesión (EN) |
| `docs/AI/history/ADPC_Conversational_Log_ES_V1.0.0.md` | Bitácora de esta sesión (ES) |
| `README.md` | Sección de mantenimiento añadida |

### Pendiente / Notas

- No se hizo ningún commit; todos los cambios quedan para que el usuario los revise.

---

### Fin de Sesión: 2026-09-29
