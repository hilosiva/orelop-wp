import { defineConfig } from "vite";
import { viteStaticCopy } from "vite-plugin-static-copy";
import sassGlobImports from "vite-plugin-sass-glob-import";
import { viteImageOretimaizer } from "@hilosiva/vite-plugin-image-oretimaizer";
import { vitePhpOreder } from "@hilosiva/vite-plugin-php-oreder";
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
    vitePhpOreder({
      proxy: "http://localhost:8080",
    }),
    viteImageOretimaizer({
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
    target: "es2018",
    cssTarget: "safari14",
    rollupOptions: {
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
    strictPort: true,
    open: true,
    port: 3000,
    https: false,
    hmr: {
      host: "localhost",
    },
  },

  css: {
    devSourcemap: true,
  },
});
