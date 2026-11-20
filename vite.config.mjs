import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig(({ command }) => {
  const isBuild = command === "build";

  return {
    base: isBuild ? "/wp-content/themes/samarinda_hill/dist/" : "/",
    server: {
      port: 3000,
      cors: true,
      origin: "http://localhost:3000",
    },
    build: {
      manifest: true,
      outDir: "dist",
      rollupOptions: {
        input: ["src/js/app.js", "src/css/app.css", "src/css/editor-style.css"],
      },
    },
    plugins: [tailwindcss()],
  };
});
