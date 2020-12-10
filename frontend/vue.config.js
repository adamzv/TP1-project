const TerserPlugin = require("terser-webpack-plugin");

module.exports = {
  pluginOptions: {
    i18n: {
      locale: "sk",
      fallbackLocale: "en",
      localeDir: "locales",
      enableInSFC: false
    }
  },
  configureWebpack: {
    plugins: [
      new TerserPlugin({
        terserOptions: {
          ecma: undefined,
          warnings: false,
          parse: {},
          compress: { drop_console: true },
          mangle: true, // Note `mangle.properties` is `false` by default.
          module: false,
          output: { comments: false },
          toplevel: false,
          nameCache: null,
          ie8: false,
          keep_classnames: undefined,
          keep_fnames: false,
          safari10: false
        }
      })
    ]
  }
};
