import { defineConfig } from "vite";
import { viteStaticCopy } from "vite-plugin-static-copy";
import sassGlobImports from "vite-plugin-sass-glob-import";
import { ViteImageOretimaizer } from "@hilosiva/vite-plugin-image-oretimaizer";
import { VitePhpLoader } from "@hilosiva/vite-plugin-php-oreder";
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
    VitePhpLoader(),
    ViteImageOretimaizer({
      generate: {
        preserveExt: true,
      },
    }),
    sassGlobImports(),
    viteStaticCopy({
      targets: [
        {
          src: ["./style.css", "./*.txt", "./screenshot.png"],
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
