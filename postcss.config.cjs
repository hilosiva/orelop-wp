module.exports = {
  plugins: [
    require("postcss-nesting"),
    require("autoprefixer")({
      grid: "autoplace", // IE11対応
    }),
    require("css-declaration-sorter")({
      order: "smacss", // alphabetical/ smacss / concentric-css
    }),
    require("css-mqpacker")({
      sort: true, // スマホファーストに並び替え
    }),
  ],
};
