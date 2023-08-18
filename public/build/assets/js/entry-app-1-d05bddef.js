(function(){const t=document.createElement("link").relList;if(t&&t.supports&&t.supports("modulepreload"))return;for(const o of document.querySelectorAll('link[rel="modulepreload"]'))l(o);new MutationObserver(o=>{for(const e of o)if(e.type==="childList")for(const c of e.addedNodes)c.tagName==="LINK"&&c.rel==="modulepreload"&&l(c)}).observe(document,{childList:!0,subtree:!0});function s(o){const e={};return o.integrity&&(e.integrity=o.integrity),o.referrerPolicy&&(e.referrerPolicy=o.referrerPolicy),o.crossOrigin==="use-credentials"?e.credentials="include":o.crossOrigin==="anonymous"?e.credentials="omit":e.credentials="same-origin",e}function l(o){if(o.ep)return;o.ep=!0;const e=s(o);fetch(o.href,e)}})();const n="/build/assets/img/asset-javascript-4-8dac5379.svg",i="/build/assets/img/asset-vite-1-4a748afd.svg";function a(r){let t=0;const s=l=>{t=l,r.innerHTML=`count is ${t}`};r.addEventListener("click",()=>s(t+1)),s(0)}document.querySelector("#app").innerHTML=`
  <div>
    <a href="https://vitejs.dev" target="_blank">
      <img src="${i}" class="logo" alt="Vite logo" />
    </a>
    <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript" target="_blank">
      <img src="${n}" class="logo vanilla" alt="JavaScript logo" />
    </a>
    <h1>Hello Vite in PHP!</h1>
    <div class="card">
      <button id="counter" type="button"></button>
    </div>
    <p class="read-the-docs">
      Click on the Vite logo to learn more
    </p>
  </div>
`;a(document.querySelector("#counter"));console.log("PHP ViteJS V1");console.log("prod");console.log("true");console.log("http://php.devel.docker.com");console.log("0.0.0.0");console.log("3000");console.log("http://php.devel.docker.com");console.log("8109");console.log("0.0.0.0");console.log("3000");console.log("mysql");console.log("192.168.1.253");console.log("6627");console.log("DB_SLM_TEST_V1");console.log("adpcuser");console.log("_bQWL3839");console.log("");console.log("");console.log("");console.log("pokemons.json");console.log("phrases.json");
