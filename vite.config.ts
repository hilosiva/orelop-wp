import path from "path";
import { viteImageOptimazer } from "@hilosiva/vite-plugin-image-optimizer";
import { vitePhpLoader } from "@hilosiva/vite-plugin-php-loader";
import { defineConfig } from "vite";
import { viteStaticCopy } from "vite-plugin-static-copy";
import vaultcss from "vite-plugin-vaultcss";

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
    vitePhpLoader({
      useWpEnv: true,
    }),
    viteImageOptimazer({
      generate: {
        preserveExt: true,
      },
    }),
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
    vaultcss(),
  ],
  build: {
    outDir: `../${dir.outDir}`,
    rollupOptions: {
      output: {
        entryFileNames: "assets/scripts/[name]-[hash].js",
        chunkFileNames: "assets/scripts/[name]-[hash].js",
        assetFileNames: ({ names }) => {
          if (/\.( gif|jpeg|jpg|png|svg|webp| )$/.test(names[0] ?? "")) {
            return "assets/images/[name]-[hash][extname]";
          }
          if (/\.css$/.test(names[0] ?? "")) {
            return "assets/styles/[name]-[hash][extname]";
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
    open: "http://localhost:8080",
    host: true,
  },

  css: {
    devSourcemap: true,
  },
});
