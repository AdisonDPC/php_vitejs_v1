import { defineConfig, loadEnv } from 'vite';

import { viteStaticCopy } from 'vite-plugin-static-copy';
import liveReload from 'vite-plugin-live-reload';

import path from 'path';

export default defineConfig(({ command, mode }) => {

    let iAssetFile = 0, iChunkFile = 0, iEntryFile = 0;

    // Load env file based on `mode` in the current working directory.
    // Set the third parameter to '' to load all env regardless of the `VITE_` prefix.

    const 
        objEnv = loadEnv(mode, process.cwd(), ''),
        objDefine = {
            __APP_NAME__: JSON.stringify(objEnv.APP_NAME),
            __APP_ENV__: JSON.stringify(objEnv.APP_ENV),
            __APP_DEBUG__: JSON.stringify(objEnv.APP_DEBUG),
            __APP_URL__: JSON.stringify(objEnv.APP_URL),

            __VITE_ENTRY__: JSON.stringify(objEnv.VITE_ENTRY),
            __VITE_OUTDIR__: JSON.stringify(objEnv.VITE_OUTDIR),
            __VITE_SERVER_HOST__: JSON.stringify(objEnv.VITE_SERVER_HOST),
            __VITE_SERVER_PORT__: JSON.stringify(objEnv.VITE_SERVER_PORT),
            __VITE_SERVER_ORIGIN_URL__: JSON.stringify(objEnv.VITE_SERVER_ORIGIN_URL),
            __VITE_SERVER_ORIGIN_PORT__: JSON.stringify(objEnv.VITE_SERVER_ORIGIN_PORT),
            __VITE_PREVIEW_HOST__: JSON.stringify(objEnv.VITE_PREVIEW_HOST),
            __VITE_PREVIEW_PORT__: JSON.stringify(objEnv.VITE_PREVIEW_PORT),
            __VITE_SERVER_HMR_HOST__: JSON.stringify(objEnv.VITE_SERVER_HMR_HOST),
            __VITE_SERVER_HMR_PORT__: JSON.stringify(objEnv.VITE_SERVER_HMR_PORT),
            __VITE_SERVER_HMR_CLIENT_PORT__: JSON.stringify(objEnv.VITE_SERVER_HMR_CLIENT_PORT),

            __DB_CONNECTION__: JSON.stringify(objEnv.DB_CONNECTION),
            __DB_HOST__: JSON.stringify(objEnv.DB_HOST),
            __DB_PORT__: JSON.stringify(objEnv.DB_PORT),
            __DB_DATABASE__: JSON.stringify(objEnv.DB_DATABASE),
            __DB_USERNAME__: JSON.stringify(objEnv.DB_USERNAME),
            __DB_PASSWORD__: JSON.stringify(objEnv.DB_PASSWORD),
            __DB_CHARSET__: JSON.stringify(objEnv.DB_CHARSET),
            __DB_COLLATION__: JSON.stringify(objEnv.DB_COLLATION),
            __DB_PREFIX__: JSON.stringify(objEnv.DB_PREFIX),

            __DB_FILENAME_JSON__: JSON.stringify(objEnv.DB_FILENAME_JSON),
            __DB_FILENAME_TXT__: JSON.stringify(objEnv.DB_FILENAME_TXT)
        };

    const 
        objConfig = {

            // Vite config.

            server: {
                host: objEnv.VITE_SERVER_HOST,
                port: objEnv.VITE_SERVER_PORT, 
                origin: objEnv.VITE_SERVER_ORIGIN_URL + ':' + objEnv.VITE_SERVER_ORIGIN_PORT,
                // hmr: {
                //     host: objEnv.VITE_SERVER_HMR_HOST,
                //     port: objEnv.VITE_SERVER_HMR_PORT,
                //     clientPort: objEnv.VITE_SERVER_HMR_CLIENT_PORT
                // }
            },
            preview: {
                host: objEnv.VITE_SERVER_HOST,
                port: objEnv.VITE_SERVER_PORT
            },
            define: {
                global: 'window',
                ...objDefine
            },
            root: path.resolve(__dirname, 'src'),
            base: objEnv.APP_ENV === 'devel' ? '/' : '/' + objEnv.VITE_OUTDIR,
            plugins: [
                liveReload([

                    // Edit live reload paths according to your source code.

                    __dirname + '/public/**/*.php',

                ]),
                viteStaticCopy({
                    structured: false,
                    targets: [
                        {
                            src: 'template/libs',
                            dest: 'assets/template'
                        },
                        {
                            src: 'template/js',
                            dest: 'assets/template'
                        },
                        {
                            src: 'template/css',
                            dest: 'assets/template'
                        },
                        {
                            src: 'template/fonts',
                            dest: 'assets/template'
                        },
                        {
                            src: 'template/images',
                            dest: 'assets/template'
                        },
                        {
                            src: 'template/data',
                            dest: 'assets/template'
                        }
                    ]
                }),
            ],
            build: {
                manifest: true,
                assetsInlineLimit: 1024,
                outDir: path.resolve(__dirname, 'public/' + objEnv.VITE_OUTDIR),
                emptyOutDir: true,
                rollupOptions: {
                    input: path.resolve(__dirname, 'src/' + objEnv.VITE_ENTRY),
                    output: {
                        assetFileNames: (mixAssetInfo) => {

                            // To configure the asset filenames (For media files and stylesheets).
        
                            // console.log('assetFileNames', iAssetFile, mixAssetInfo);
        
                            iAssetFile++;
        
                            if (/\.(css|scss)$/.test(mixAssetInfo.name))
                                return 'assets/css/asset-[name]-' + iAssetFile + '-[hash][extname]';
                            return 'assets/img/asset-[name]-' + iAssetFile + '-[hash][extname]';
                        },
                        chunkFileNames: (mixFileInfo) => {

                            // To configure the vendor chunk filenames.
        
                            // console.log('chunkFileNames', iChunkFile, mixFileInfo);
        
                            iChunkFile++;
        
                            return 'assets/js/chunk-[name]-' + iChunkFile + '-[hash].js';
                        },
                        entryFileNames: (mixFileInfo) => {

                            // to configure the index.js filename (For project files).
        
                            // console.log('entryFileNames', iEntryFile, mixFileInfo);
        
                            iEntryFile++;
        
                            return 'assets/js/entry-[name]-' + iEntryFile + '-[hash].js';
                        }
                    },
                }
            },
            resolve: {
                alias: {
                    '@': path.resolve(__dirname, 'src'),
                }
            }
        };

    if (command === 'serve') {

        // command === 'serve'
        // dev specific config.

        return objConfig;
    }

    // command === 'build'
    // build specific config

    return objConfig;
});
