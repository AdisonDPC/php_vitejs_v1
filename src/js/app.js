import '@/js/bootstrap';

import.meta.glob(
    [
        '@/favicon/**/*.{png,svg,ico}',
        '@/image/static/**/*.{png,svg,jpg,jpeg,webp,ico}'
    ],
    { eager: true }
);

import '@/css/app.css'
import '@/sass/app.scss'
import javascriptLogo from '@/image/dynamic/javascript.svg'
import viteLogo from '@/image/dynamic/vite.svg'
import { setupCounter } from '@/js/counter.js'

document.querySelector('#app').innerHTML = `
  <div>
    <a href="https://vitejs.dev" target="_blank">
      <img src="${viteLogo}" class="logo" alt="Vite logo" />
    </a>
    <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript" target="_blank">
      <img src="${javascriptLogo}" class="logo vanilla" alt="JavaScript logo" />
    </a>
    <h1>Hello Vite in PHP!</h1>
    <div class="card">
      <button id="counter" type="button"></button>
    </div>
    <p class="read-the-docs">
      Click on the Vite logo to learn more
    </p>
  </div>
`

setupCounter(document.querySelector('#counter'))

console.log(__APP_NAME__);
console.log(__APP_ENV__);
console.log(__APP_DEBUG__);
console.log(__APP_URL__);

console.log(__VITE_ENTRY__);
console.log(__VITE_OUTDIR__);
console.log(__VITE_SERVER_HOST__);
console.log(__VITE_SERVER_PORT__);
console.log(__VITE_SERVER_ORIGIN_URL__);
console.log(__VITE_SERVER_ORIGIN_PORT__);
console.log(__VITE_PREVIEW_HOST__);
console.log(__VITE_PREVIEW_PORT__);
console.log(__VITE_SERVER_HMR_HOST__);
console.log(__VITE_SERVER_HMR_PORT__);
console.log(__VITE_SERVER_HMR_CLIENT_PORT__);

console.log(__DB_CONNECTION__);
console.log(__DB_HOST__);
console.log(__DB_PORT__);
console.log(__DB_DATABASE__);
console.log(__DB_USERNAME__);
console.log(__DB_PASSWORD__);
console.log(__DB_CHARSET__);
console.log(__DB_COLLATION__);
console.log(__DB_PREFIX__);

console.log(__DB_FILENAME_JSON__);
console.log(__DB_FILENAME_TXT__);
