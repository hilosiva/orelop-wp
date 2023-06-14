import { defineConfig } from "vite";
import { viteStaticCopy } from "vite-plugin-static-copy";
import sassGlobImports from "vite-plugin-sass-glob-import";
import { ViteImageOptimizer } from "vite-plugin-image-optimizer";
import path from "path";

const dir = {
  src: "src",
  publicDir: "public",
  outDir: "dist",
};

export default defineConfig({
  root: dir.src,
  base: "./",
  publicDir: `../${dir.publicDir}`,
  plugins: [
    ViteImageOptimizer({
      svg: {
        multipass: true,
        plugins: [
          {
            name: "preset-default",
            params: {
              overrides: {
                cleanupNumericValues: false,
                removeViewBox: false, // https://github.com/svg/svgo/issues/1128
              },
              cleanupIDs: {
                minify: false,
                remove: false,
              },
              convertPathData: false,
            },
          },
          "sortAttrs",
          {
            name: "addAttributesToSVGElement",
            params: {
              attributes: [{ xmlns: "http://www.w3.org/2000/svg" }],
            },
          },
        ],
      },
      png: {
        quality: 80,
      },
      jpeg: {
        mozjpeg: true,
        quality: 70,
      },
      jpg: {
        mozjpeg: true,
        quality: 70,
      },
      tiff: {
        quality: 70,
      },
      webp: {
        lossless: true,
        quality: 70,
      },
      avif: {
        quality: 70,
      },
    }),
    sassGlobImports(),
    viteStaticCopy({
      targets: [
        {
          src: "./inc/production.php",
          dest: "./",
          rename: "config.php",
        },
        {
          src: ["./**/*.php", "./style.css", , "./*.txt", "./screenshot.png", "!./inc/config.php", "!./inc/production.php"],
          dest: "./",
        },
      ],
      structured: true,
      watch: {
        reloadPageOnChange: true,
      },
    }),
  ],
  build: {
    outDir: `../${dir.outDir}`,
    emptyOutDir: true,
    manifest: true,
    target: "es2018",
    cssTarget: "safari14",
    rollupOptions: {
      input: {
        main: path.resolve(__dirname + "/src/assets/js/main.js"),
      },
      output: {
        entryFileNames: `assets/js/[name]-[hash].js`,
        chunkFileNames: `assets/js/[name]-[hash].js`,
        assetFileNames: ({ name }) => {
          if (/\.( gif|jpeg|jpg|png|svg|webp| )$/.test(name ?? "")) {
            return "assets/img/[name]-[hash][extname]";
          }
          if (/\.css$/.test(name ?? "")) {
            return "assets/css/[name]-[hash][extname]";
          }
          if (/\.js$/.test(name ?? "")) {
            return "assets/js/[name]-[hash][extname]";
          }
          return "assets/[name]-[hash][extname]";
        },
      },
    },
    assetsInlineLimit: 0,
    write: true,
  },

  resolve: {
    alias: {
      "@": path.resolve(__dirname, "src"),
    },
  },

  server: {
    cors: true,
    strictPort: true,
    open: true,
    port: 3000,
    https: false,
    hmr: {
      host: "localhost",
    },
    proxy: {
      "^(?!/(assets|@vite|@fs)/|/[^/]+\\.(gif|jpeg|jpg|png|svg|webp|txt|pdf|mp4|webm|mov|htaccess)$)": {
        target: "http://localhost:8080",
        changeOrigin: true,
        ws: true,
      },
    },
  },

  preview: {
    proxy: {
      "/": {
        target: "http://localhost:8080",
        changeOrigin: true,
        ws: true,
      },
    },
  },
  css: {
    devSourcemap: true,
  },
});
