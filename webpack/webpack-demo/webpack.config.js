const path = require("path");
const HtmlWebpackPlugin = require("html-webpack-plugin");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
// const OptimizeCssPlugin = require('optimize-css-assets-webpack-plugin');
const webpack = require("webpack");

const isDev = process.env.NODE_ENV === "development";
const config = require("./public/config")[isDev ? "dev" : "build"];

module.exports = {
  mode: "development",
  devtool: "cheap-module-source-map", //开发环境下使用
  devServer: {
    hot: true,
  },
  entry: {
    index: "./src/index.js",
    login: "./src/login.js",
  },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "[name].[hash:6].js",
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env"],
            plugins: [
              [
                "@babel/plugin-transform-runtime",
                {
                  corejs: 3,
                },
              ],
            ],
          },
        },
        exclude: /node_modules/,
      },
      {
        test: /\.(le|c)ss$/,
        use: [
          "style-loader",
          "css-loader",
          {
            loader: "postcss-loader",
            options: {
              postcssOptions: {
                plugins: function () {
                  return [
                    require("autoprefixer")({
                      overrideBrowserslist: [">0.25%", "not dead"],
                    }),
                  ];
                },
              },
            },
          },
          "less-loader",
        ],
        exclude: /node_modules/,
      },
      {
        test: /\.(png|jpg|gif|jpeg|webp|svg|eot|ttf|woff|woff2)$/,
        use: [
          {
            loader: "url-loader",
            options: {
              limit: 10240, //10K
              esModule: false,
              outputPath: "assets",
            },
          },
        ],
        exclude: /node_modules/,
      },
      {
        test: /.html$/,
        use: "html-withimg-loader",
      },
      {
        test: /\.(le|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader, //替换之前的 style-loader
          "css-loader",
          {
            loader: "postcss-loader",
            options: {
              postcssOptions: {
                plugins: function () {
                  return [require("autoprefixer")()];
                },
              },
            },
          },
          "less-loader",
        ],
        exclude: /node_modules/,
      },
    ],
  },
  plugins: [
    // new webpack.ProvidePlugin({
    //   $: "jquery",
    // }),
    //数组 放着所有的webpack插件
    new HtmlWebpackPlugin({
      template: "./public/index.html",
      config: config.template,
      filename: "index.html", //打包后的文件名
      minify: {
        removeAttributeQuotes: false, //是否删除属性的双引号
        collapseWhitespace: false, //是否折叠空白
      },
      chunks: ['index']
      // hash: true //是否加上hash，默认是 false
    }),
    new HtmlWebpackPlugin({
      template: "./public/login.html",
      config: config.template,
      filename: "login.html", //打包后的文件名
      minify: {
        removeAttributeQuotes: false, //是否删除属性的双引号
        collapseWhitespace: false, //是否折叠空白
      },
      chunks: ['login']
      // hash: true //是否加上hash，默认是 false
    }),
    //不需要传参数喔，它可以找到 outputPath
    new CleanWebpackPlugin(),
    new MiniCssExtractPlugin({
      //   filename: "css/[name].css",
      filename: "css/[name].[contenthash].css",
      chunkFilename: "css/[id].[chunkhash].css",
    }),
    new webpack.HotModuleReplacementPlugin(), //热更新插件
  ],
  optimization: {
    minimize: true,
  },
};
