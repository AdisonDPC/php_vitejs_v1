<?php

/**
 * Usage:
 *
 * With defaults:
 * 
 * $cViteJS = new ToolViteJS();
 *
 * echo $cVite -> mtdInit();
 *
 * Change settings as needed:

 * $cViteJS = new ToolViteJS();
 * 
 * $cViteJS -> mtdSetEntry('admin.js') 
 *  -> mtdSetPort(3001)
 *  -> mtdSetOutDir('dist-wp-admin');
 *
 * echo $cViteJS -> mtdInit();
 * 
 */

class Tool_ViteJS {

    // Helpers here serve as example. Change to suit your needs.

    private const 
        VITE_HOST = 'http://localhost', 
        VITE_PORT = 5173,
        VITE_ENTRY = 'main.js',
        VITE_OUT_DIR = 'dist',
        VITE_BASE_URL = '',
        VITE_BASE_PATH = '.',
        VITE_ENVIRONMENT = 'devel',
        VITE_SERVER_IS_RUNNING = true;

    protected 
        $strHost, 
        $iPort,
        $strEntry,
        $strOutDir,
        $strBaseURL,
        $strBasePATH,
        $strEnvironment,
        $bServerIsRunning;

    public function __construct ($strHost = null, $iPort = null, $strEntry = null, $strOutDir = null, $strBaseURL = null, $strBasePATH = null, $strEnvironment = null, $bServerIsRunning = null) {

        $this -> strHost = $strHost ?? self::VITE_HOST;
        $this -> iPort = $iPort ?? self::VITE_PORT;
        $this -> strEntry = $strEntry ?? self::VITE_ENTRY;
        $this -> strOutDir = $strOutDir ?? self::VITE_OUT_DIR;
        $this -> strBaseURL = $strBaseURL ?? self::VITE_BASE_URL;
        $this -> strBasePATH = $strBasePATH ?? self::VITE_BASE_PATH;
        $this -> strEnvironment = $strEnvironment ?? self::VITE_ENVIRONMENT;
        $this -> bServerIsRunning = $bServerIsRunning ?? self::VITE_SERVER_IS_RUNNING;
    
    }

    public function mtdGetHost () { return $this -> strHost; }
    public function mtdGetPort () { return $this -> iPort; }
    public function mtdGetEntry () { return $this -> strEntry; }
    public function mtdGetOutDir () { return $this -> strOutDir; }
    public function mtdGetBaseURL () { return $this -> strBaseURL; }
    public function mtdGetBasePATH () { return $this -> strBasePATH; }
    public function mtdGetEnvironment () { return $this -> strEnvironment; }
    public function mtdGetServerIsRunning () { return $this -> bServerIsRunning; }

    public function mtdGetProperties () {

        return [
            'HOST' => $this -> strHost,
            'PORT' => $this -> iPort,
            'ENTRY' => $this -> strEntry,
            'OUT_DIR' => $this -> strOutDir,
            'BASE_URL' => $this -> strBaseURL,
            'BASE_PATH' => $this -> strBasePATH,
            'ENVIRONMENT' => $this -> strEnvironment,
            'SERVER_IS_RUNNING' => $this -> bServerIsRunning
        ];

    }

    public function mtdSetHost ($strHost = null) { $this -> strHost = $strHost ?? self::VITE_HOST; }
    public function mtdSetPort ($iPort = null) { $this -> iPort = $iPort ?? self::VITE_PORT; }
    public function mtdSetEntry ($strEntry = null) { $this -> strEntry = $strEntry ?? self::VITE_ENTRY; }
    public function mtdSetOutDir ($strOutDir = null) { $this -> strOutDir = $strOutDir ?? self::VITE_OUT_DIR; }
    public function mtdSetBaseURL ($strBaseURL = null) { $this -> strBaseURL = $strBaseURL ?? self::VITE_BASE_URL; }
    public function mtdSetBasePATH ($strBasePATH = null) { $this -> strBasePATH = $strBasePATH ?? self::VITE_BASE_PATH; }
    public function mtdSetEnvironment ($strEnvironment = null) { $this -> strEnvironment = $strEnvironment ?? self::VITE_ENVIRONMENT; }
    public function mtdSetServerIsRunning ($bServerIsRunning = null) { $this -> bServerIsRunning = $bServerIsRunning ?? self::VITE_SERVER_IS_RUNNING; }

    public function mtdSetProperties ($strHost = null, $iPort = null, $strEntry = null, $strOutDir = null, $strBaseURL = null, $strBasePATH = null, $bServerIsRunning = null) {

        $this -> strHost = $strHost ?? self::VITE_HOST;
        $this -> iPort = $iPort ?? self::VITE_PORT;
        $this -> strEntry = $strEntry ?? self::VITE_ENTRY;
        $this -> strOutDir =  $strOutDir ?? self::VITE_OUT_DIR;
        $this -> strBaseURL = $strBaseURL ?? self::VITE_BASE_URL;
        $this -> strBasePATH = $strBasePATH ?? self::VITE_BASE_PATH;
        $this -> strEnvironment = $strEnvironment ?? self::VITE_ENVIRONMENT;
        $this -> bServerIsRunning = $bServerIsRunning ?? self::VITE_SERVER_IS_RUNNING;
    
    }

    public function mtdIsDevelopment () { return $this -> strEnvironment === self::VITE_ENVIRONMENT; }

    public function mtdHost () {

        return $this -> strHost . ($this -> iPort ? ':' . $this -> iPort : '');

    }

    // This method is very useful for the local server.
    // If we try to access it, and by any means, didn't started Vite yet
    // it will fallback to load the production files from manifest
    // so you still navigate your site as you intended.

    protected function mtdEntryExists () {

        if (isset($this -> bServerIsRunning)) 
            return $this -> bServerIsRunning;
        
        $hHandle = curl_init($this -> mtdHost() . '/' . $this -> strEntry);
        
        curl_setopt($hHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($hHandle, CURLOPT_NOBODY, true);

        curl_exec($hHandle);

        $eError = curl_errno($hHandle);
        
        // dd(curl_getinfo($hHandle), $eError, $this -> mtdHost());
        
        curl_close($hHandle);

        return $this -> bServerIsRunning = !$eError || $eError === 60;

    }

    // Checks wheter Vite server is running. 
    // Important, only checks on dev environment.

    public function mtdIsRunning() {

        return $this -> mtdIsDevelopment() && $this -> mtdEntryExists();

    }

    public function mtdManifest () {

        $mixContent = file_get_contents($this -> strBasePATH . '/' . $this -> strOutDir  . '/.vite/manifest.json');

        return $mixContent ? json_decode($mixContent, true) : [];

    }

    public function mtdAsset ($strEntry) {

        $aManifest = $this -> mtdManifest();

        return !isset($aManifest[ $strEntry ]) ? '' : $aManifest[ $strEntry ]['file'];

    }

    public function mtdAssetURL ($strEntry) {

        $strPATH = $this -> mtdAsset($strEntry);

        return $strPATH ? $this -> strBaseURL . '/' . $this -> strOutDir . '/' . $strPATH : '';

    }

    public function mtdAssetPATH ($strEntry) {

        $strPATH = $this -> mtdAsset($strEntry);

        return $strPATH ? $this -> strBasePATH . '/' . $this -> strOutDir . '/' . $strPATH : '';

    }

    public function mtdAssets ($strEntry, $strPATH = 'assets') {

        $aPATHs = [];

        $aManifest = $this -> mtdManifest();

        if (!empty($aManifest[ $strEntry ][ $strPATH ]))
            foreach ($aManifest[ $strEntry ][ $strPATH ] as $strFile)
                $aPATHs[] = $strFile;

        return $aPATHs;

    }

    public function mtdAssetsURLs ($strEntry, $strPATH = 'assets') {

        $aPATHs = $this -> mtdAssets($strEntry, $strPATH);
        
        foreach ($aPATHs as &$strPATH)
            $strPATH = $this -> strBaseURL . '/' . $this -> strOutDir . '/' . $strPATH;

        return $aPATHs;

    }

    public function mtdAssetsPATHs ($strEntry, $strPATH = 'assets') {

        $aPATHs = $this -> mtdAssets($strEntry, $strPATH);

        foreach ($aPATHs as &$strPATH)
            $strPATH = $this -> strBasePATH . '/' . $this -> strOutDir . '/' . $strPATH;

        return $aPATHs;

    }

    public function mtdCSSURLs () {

        return $this -> mtdAssetsURLs($this -> strEntry, 'css');

    }

    public function mtdCSSPATHs () {

        return $this -> mtdAssetsPATHs($this -> strEntry, 'css');

    }

    public function mtdInlineCSS () {

        $strOut = '';

        foreach ($this -> mtdCSSPATHs() as $strPATH)
            if (file_exists($strPATH)) {
                $mixContent = file_get_contents($strPATH);

                if ($mixContent)
                    $strOut .= '<style>' . $mixContent . '</style>';
            }

        return $strOut;

    }

    public function mtdJSURL () {

        return $this -> mtdAssetURL($this -> strEntry);

    }

    public function mtdJSPATH () {

        return $this -> mtdAssetPATH($this -> strEntry);

    }

    public function mtdInlineJS () {

        $strOut = '';

        $strPATH = $this -> mtdJSPATH();

        if (file_exists($strPATH)) {
            $mixContent = file_get_contents($strPATH);

            // Don't output if empty.
            // Empty scripts may have a line break.

            if ($mixContent && $mixContent !== "\n")
                $strOut .= '<script>' . $mixContent . '</script>';
        }

        return $strOut;

    }

    public function mtdInline () {

        return $this -> mtdInlineCSS() . $this -> mtdInlineJS();

    }

    public function mtdImportsURLs ($strEntry) {

        $aURLs = [];

        $aManifest = $this -> mtdManifest();

        if (!empty($aManifest[ $strEntry ]['imports'])) 
            foreach ($aManifest[ $strEntry ]['imports'] as $strImports)
                $aURLs[] = $this -> strBaseURL . '/' . $this -> strOutDir . '/' . $aManifest[ $strImports ]['file'];

        return $aURLs;

    }

    // Helper to output the script tag.

    public function mtdJSTag () {

        $strURL = $this -> mtdIsRunning() ? $this -> mtdHost() . '/' . $this -> strEntry : $this -> mtdJSURL();

        if (!$strURL) return '';

        if ($this -> mtdIsRunning()) {
            $strHTML = '<script type="module" crossorigin src="' . $this -> mtdHost() . '/@vite/client"></script>';
            $strHTML .= '<script type="module" crossorigin src="' . $strURL . '"></script>';

            return $strHTML;
        }

        return '<script type="module" crossorigin src="' . $strURL . '"></script>';

    }

    public function mtdJSPreloadImports () {

        if ($this -> mtdIsRunning()) return '';

        $strRes = '';

        foreach ($this -> mtdImportsURLs($this -> strEntry) as $strURL)
            $strRes .= '<link rel="modulepreload" href="' . $strURL . '">';

        return $strRes;

    }

    // Helper to output style tag.

    public function mtdCSSTag () {

        // Todo pass this decision up.
        // Not needed on dev, it's inject by Vite.

        if ($this -> mtdIsRunning()) return '';

        $strTags = '';

        foreach ($this -> mtdCSSURLs() as $strURL)
            $strTags .= '<link rel="stylesheet" href="' . $strURL . '">';

        return $strTags;

    }

    public function mtdPreloadAssets ($strType) {

        if ($this -> mtdIsRunning()) return '';

        $strRes = '';

        foreach ($this -> mtdAssetsURLs($this -> strEntry) as $strURL) {

            if (!str_ends_with($strURL, '.' . $strType)) continue;

            if ($strType === 'woff2')
                $strRes .= '<link rel="preload" href="' . $strURL . '" as="font" type="font/woff2" crossorigin="anonymous">';

        }

        return $strRes;

    }

    public function mtdInit () {

        return $this -> mtdPreloadAssets('woff2') . $this -> mtdJSTag() . $this -> mtdJSPreloadImports() . $this -> mtdCSSTag();

    }

    public function mtdLegacy () {

        if ($this -> mtdIsRunning()) return '';

        $strURL = $this -> mtdAssetURL(str_replace('.js', '-legacy.js', $this -> strEntry));

        $strPolyfillURL = $this -> mtdAssetURL('vite/legacy-polyfills');

        if (!$strPolyfillURL)
            $strPolyfillURL = $this -> mtdAssetURL('../vite/legacy-polyfills');

        if (!$strURL || !$strPolyfillURL) return '';

        $strScript = '<script nomodule>!function(){var e=document,t=e.createElement("script");if(!("noModule"in t)&&"onbeforeload"in t){var n=!1;e.addEventListener("beforeload",(function(e){if(e.target===t)n=!0;else if(!e.target.hasAttribute("nomodule")||!n)return;e.preventDefault()}),!0),t.type="module",t.src=".",e.head.appendChild(t),t.remove()}}();</script>';

        $strScript .= '<script nomodule src="' . $strPolyfillURL . '"></script>';

        $strScript .= '<script nomodule id="vite-legacy-entry" data-src="' . $strURL . '">System.import(document.getElementById(\'vite-legacy-entry\').getAttribute(\'data-src\'))</script>';

        return $strScript;

    }

}
