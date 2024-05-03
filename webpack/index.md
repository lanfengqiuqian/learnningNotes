<!--
 * @Date: 2020-08-19 19:06:25
 * @LastEditors: Lq
 * @LastEditTime: 2020-08-19 19:06:28
 * @FilePath: /learnningNotes/webpack/index.md
-->

## 基础篇

### 概念

0. webpack是什么

    是一个现代js静态模块打包器，当`webpack`处理应用程序时，会递归构建一个依赖关系图，其中包含应用程序需要的每个模块，然后将这些模块打包成一个或多个`bundle`

1. 打包工具作用

    1. 转换es6语法
    2. 转换jsx
    3. css前缀补全/预处理器
    4. 压缩混淆
    5. 图片压缩

2. 为什么选择webpack

    1. 社区生态丰富
    2. 配置灵活和插件化扩展
    3. 官方更新迭代速度快

3. 核心概念

    1. `entry`：入口
    2. `output`：输出
    3. `loader`：模块转换器，用于把模块原内容按照需求转换成新内容
    4. `插件`：扩展插件，在webpack构建流程中特定时机注入扩展逻辑来改变构建结果，或做你想要做的事情

### 初始化项目

1. 新建一个文件夹，如`webpack-demo`
2. 使用`npm init -y`初始化
3. 安装`webpack webpack-cli`

    > npm install webpack webpack-cli -D

4. 现在我用的是`webpack5`

    ```js
    "webpack": "^5.82.1",
    "webpack-cli": "^5.1.1"
    ``

5. 新建`src/index.js`

    ```js
    //index.js
    class Animal {
        constructor(name) {
            this.name = name;
        }
        getName() {
            return this.name;
        }
    }

    console.log('aaa');
    
    const dog = new Animal('dog');
    ```

6. 使用`npx webpack --mode=development`进行构建，默认是`production`模式，我们为了更清楚地查看打包后的代码，使用`development`模式
7. 可以看到项目下多了一个`dist`目录，里面有一个打包出来的文件`main.js`
8. webpack默认配置，如默认的入口文件：`./src`，默认打包到`dist/main.js`

    更多的默认配置可以查看`node_modules/webpack/lib/WebpackOptionsDefaulter.js`

9. 查看`dist/main.js`，可以看到`src/index.js`并没有被转义为低版本的代码

    比如`const`还在

    ```js
    eval("//index.js\nclass Animal {\n  constructor(name) {\n      this.name = name;\n  }\n  getName() {\n      return this.name;\n  }\n}\nconsole.log('aaa');\nconst dog = new Animal('dog');\n\n\n//# sourceURL=webpack://webpack-demo/./src/index.js?");
    ```

### 将js转义为低版本

`loader`就是用于对源代码进行转换

1. 将js代码向低版本转换，需要使用到`babel-loader`，还需要安装其他的一些相关依赖

    ```js
    npm install babel-loader -D
    npm install @babel/core @babel/preset-env @babel/plugin-transform-runtime -D
    npm install @babel/runtime @babel/runtime-corejs3
    ```

2. 根目录下，新建`webpack.config.js`

    ```js
    //webpack.config.js
    module.exports = {
        module: {
            rules: [
                {
                    test: /\.jsx?$/,
                    use: ['babel-loader'],
                    exclude: /node_modules/ //排除 node_modules 目录
                }
            ]
        }
    }
    ```

3. 根目录下新建`.babelrc`

    ```js
    {
        "presets": ["@babel/preset-env"],
        "plugins": [
            [
                "@babel/plugin-transform-runtime",
                {
                    "corejs": 3
                }
            ]
        ]
    }
    ```

4. 重新执行`npx webpack --mode=development`

    查看`dist/main.js`，可以看到已经被转为低版本了

    代码量也从开始的`几十行`变为了`几千行`

5. 在webpack中配置babel


    ```js
    //webpack.config.js
    module.exports = {
        // mode: 'development',
        module: {
            rules: [
                {
                    test: /\.jsx?$/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ["@babel/preset-env"],
                            plugins: [
                                [
                                    "@babel/plugin-transform-runtime",
                                    {
                                        "corejs": 3
                                    }
                                ]
                            ]
                        }
                    },
                    exclude: /node_modules/
                }
            ]
        }
    }
    ```

    说明

    1. `loader`需要配置在`module.rules`中，`rules`是一个数组
    2. `loader`的格式为

        ```js
        // 适用于多个loader
        {
            test: /\.jsx?$/,//匹配规则
            use: 'babel-loader'
        }

        // 适用于一个loader
        {
            test: /\.jsx?$/,
            loader: 'babel-loader',
            options: {
                //...
            }
        }
        ```
    3. `test`字段是匹配规则，针对符合规则的文件进行处理
    4. `use`字段有几种写法

        1. 一个字符串：`use: 'babel-loader'`
        2. 一个数组：`use: ['style-loader', 'css-loader']`
        3. 数组的时候，`每一项也可以是一个对象`，如果我们需要在`webpack`的配置文件中对`loader`进行配置，就需要写为一个对象，并且在对象的`options`字段中进行配置

            ```js
            rules: [
                {
                    test: /\.jsx?$/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ["@babel/preset-env"]
                        }
                    },
                    exclude: /node_modules/
                }
            ]
            ```

### mode

前面我们在进行编译的时候，都是手动指定`--mode=development`

可以将`mode`配置在`webpack.config.js`中

```js
module.exports = {
    //....
    mode: "development",
    module: {
        //...
    }
}
```

`mode`：告知`webpack`使用相应模式的内置优化

支持2个配置模式

1. `development`：将`process.env.NODE_ENV`的值设置为`development`，启用`NamedChunksPlugin`和`NamedModulesPlugin`
2. `production`：将 `process.env.NODE_ENV` 的值设置为 `production`，启用 `FlagDependencyUsagePlugin`, `FlagIncludedChunksPlugin`, `ModuleConcatenationPlugin`, `NoEmitOnErrorsPlugin`, `OccurrenceOrderPlugin`, `SideEffectsFlagPlugin` 和 `UglifyJsPlugin`


### 在浏览器中查看页面

查看页面，就需要`html`文件，有时，我们需要指定打包文件中带有`hash`，那么每次生成的`js`文件名就会不同，如果有`js`引用的话，每次修改`html`的引用太麻烦了

使用`html-webpack-plugin`插件来帮助我们完成这些事情

1. 安装

    ```js
    npm install html-webpack-plugin -D 
    ```

2. 新建`public/index.html`

    ```html
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hello</title>
    </head>
    <body>
    <h2>hello world</h2>
    </body>
    </html>
    ```

3. 修改`webpack.config.js`文件

    ```js
    //首先引入插件
    const HtmlWebpackPlugin = require('html-webpack-plugin');
    module.exports = {
        //...
        plugins: [
            //数组 放着所有的webpack插件
            new HtmlWebpackPlugin({
                template: './public/index.html',
                filename: 'index.html', //打包后的文件名
                minify: {
                    removeAttributeQuotes: false, //是否删除属性的双引号
                    collapseWhitespace: false, //是否折叠空白
                },
                // hash: true //是否加上hash，默认是 false
            })
        ]
    }
    ```

4. 运行`npx webpack`

    可以看到已经在`dist/index.html`文件中自动插入了`main.js`文件，路径也是对的

5. `html-webpack-plugin`的`config`的妙用

    有的时候，我们的脚手架，不仅仅给自己使用，也许提供给公司其他的业务使用，`html`文件的可配置性可能就很重要了

    比如：你公司有专门的部门提供M页的公共头部、公共尾部，埋点js-sdk、分享的js-sdk等，但是不是每个业务都需要这些内容

    一个功能可能对应多个`js`或者`css`文件，如果每次都是业务自行修改`public/index.html`文件，很麻烦，首先他们需要清楚每个功能引入的文件，然后才能对`index.html`进行修改

    此时我们可以增加一个配置文件，业务通过设置`true`或者`false`来选出自己需要的功能，我们在根据配置文件的内容，为每个业务生成相应的`html`文件

    1. 增加`pulbic/config.js`

        ```js
        //public/config.js 除了以下的配置之外，这里面还可以有许多其他配置，例如,pulicPath 的路径等等
        module.exports = {
            dev: {
                template: {
                    title: '你好',
                    header: false,
                    footer: false
                }
            },
            build: {
                template: {
                    title: '你好才怪',
                    header: true,
                    footer: false
                }
            }
        }
        ```

    2. 修改`public/index.html`文件

        ```html
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <% if(htmlWebpackPlugin.options.config.header) { %>
            <link rel="stylesheet" type="text/css" href="//common/css/header.css">
            <% } %>
            <title><%= (htmlWebpackPlugin.options.config.title) %></title>
        </head>

        <body>
            <h2>hello world</h2>
        </body> 
        <% if(htmlWebpackPlugin.options.config.header) { %>
        <script src="//common/header.min.js" type="text/javascript"></script> 
        <% } %>
        </html>
        ```

    3. `process.env`中默认并没有`NODE_ENV`，这里配置下我们的`package.json`的`scripts`

        为了兼容`win`和`mac`，先安装一下`cross-env`

        > npm install cross-env -D

        ```js
        {
            "scripts": {
                "dev": "cross-env NODE_ENV=development webpack",
                "build": "cross-env NODE_ENV=production webpack"
            }
        }
        ```

    4. 然后运行`npm run dev`和`npm run build`，对比下`dist/index.html`，可以看到`npm run build`生成的`index.html`文件中引入了对应的`css`和`js`，并且对应的`title`内容也一样

    虽然并不是一定要用`NODE_ENV`去判断，比如用`aaa=1`、`aaa=2`也行，但是为了规范（不挨打），还是用同一风格的比较好

6. 在浏览器实时效果

    1. 安装依赖

        ```js
        npm install webpack-dev-server -D
        ```

    2. 修改`package.json`中的`scripts`

        ```json
        "scripts": {
            "dev": "cross-env NODE_ENV=development webpack-dev-server",
            "build": "cross-env NODE_ENV=production webpack"
        },
        ```

    3. 使用`npm run dev`启动，修改代码之后能自动刷新

        注意需要用控制台中输出的地址`http://localhost:8080/`


7. `webpack-dev-server`的其他配置

    ```js
    //webpack.config.js
    module.exports = {
        //...
        devServer: {
            port: '3000', //默认是8080
            quiet: false, //默认不启用
            inline: true, //默认开启 inline 模式，如果设置为false,开启 iframe 模式
            stats: "errors-only", //终端仅打印 error
            overlay: false, //默认不启用
            clientLogLevel: "silent", //日志等级
            compress: true //是否启用 gzip 压缩
        }
    }
    ```

    1. 启用 `quiet` 后，除了初始启动信息之外的任何内容都不会被打印到控制台。这也意味着来自 `webpack` 的错误或警告在控制台不可见
        
        我是不会开启这个的，看不到错误日志，还搞个锤子
    2. `stats: "errors-only"` ， 终端中仅打印出 `error`，注意当启用了 `quiet` 或者是 `noInfo` 时，此属性不起作用。 
        
        这个属性个人觉得很有用，尤其是我们启用了 eslint 或者使用 TS进行开发的时候，太多的编译信息在终端中，会干扰到我们。

    3. 启用 `overlay` 后，当编译出错时，会在浏览器窗口全屏输出错误，默认是关闭的

    4. `clientLogLevel`: 当使用内联模式时，在浏览器的控制台将显示消息，如：在重新加载之前，在一个错误之前，或者模块热替换启用时。如果你不喜欢看这些信息，可以将其设置为 `silent` (none 即将被移除)。

### devtool

我们会发现，在`index.js`中的`console.log('aaa')`在浏览器控制台输出的位置行号不对

点进去发现代码是被编译过的，很不利于调试

`devtool`中的一些设置，可以帮助我们将编译后的代码映射回原始代码，不同的值明显影响构建和重新构建的速度

对于我而言，能够定位到源码的行即可，因此，综合构建速度在开发模式下，我设置的`devtool`的值是`cheap-module-source-map`

```js
//webpack.config.js
module.exports = {
    devtool: 'cheap-module-source-map' //开发环境下使用
}
```

生寒环境可以使用`none`或者是`source-map`，使用`source-map`最终回单独打包出一个`.map`文件，我们可以根据报错信息和此`map`文件，进行错误解析，定位到源代码

### 处理样式文件

1. 概念

    1. `webpack`不能直接处理`css`，需要借助`loader`
    2. 如果是`.css`，需要的`loader`通常是`style-loader`、`css-loader`，考虑兼容性问题，还需要`postcss-loader`
    3. 如果是`less`或者是`sass`的话，还需要`less-loader`和`sass-loader`

2. 操作

    1. 安装依赖

        > npm install style-loader less-loader css-loader postcss-loader autoprefixer less -D

    2. 修改`webpack.config.js`

        ```js
        //webpack.config.js
        module.exports = {
            //...
            module: {
                rules: [
                    {
                        test: /\.(le|c)ss$/,
                        use: ['style-loader', 'css-loader', {
                            loader: 'postcss-loader',
                            options: {
                                postcssOptions: {
                                    plugins: function () {
                                        return [
                                            require('autoprefixer')({
                                                "overrideBrowserslist": [
                                                    ">0.25%",
                                                    "not dead"
                                                ]
                                            })
                                        ]
                                    }
                                }
                            }
                        }, 'less-loader'],
                        exclude: /node_modules/
                    }
                ]
            }
        }
        ```

        配置说明

        1. `style-loader` 动态创建 style 标签，将 css 插入到 head 中.
        2. `css-loader` 负责处理 `@import` 等语句。
        3. `postcss-loader` 和 `autoprefixer`，自动生成浏览器兼容性前缀 
        
            2020了，应该没人去自己徒手去写浏览器前缀了吧
        4. `less-loader` 负责处理编译 `.less` 文件,将其转为 `css`
        5. 这里，我们在 `webpack.config.js` 写了 `autoprefixer` 需要兼容的浏览器，仅是为了方便展示。推荐大家在根目录下创建 `.browserslistrc`，将对应的规则写在此文件中，除了 `autoprefixer` 使用外，`@babel/preset-env`、`stylelint`、`eslint-plugin-conmpat` 等都可以共用

    3. 新建`src/index.less`

        ```less
        //src/index.less
        @color: red;
        body{
            background: @color;
            transition: all 2s;
        }
        ```

    4. 在入口文件引入

        ```js
        //src/index.js
        import './index.less';
        ```


    5. 启动项目`npm run dev`

        可以看到背景色变成了红色

### 图片、字体处理

1. 概念

    1. 如果在`css`中使用了本地图片，如`background: url('../images/lala.png');`，就会报错哦

        注意：`我用的webpack-5`好像没有这个问题，直接能够使用，下面的笔记是看的`webpack-4`做的
    2. 使用`url-loader`或者`file-loader`来处理本地的资源文件

2. 使用

    1. 安装

        ```js
        npm install url-loader -D
        ```

        这个时候控制台会提示，还需要安装`file-loader`（新版`npm`不会自动安装`peerDependencies`）

        ```js
        npm install file-loader -D
        ```

    2. 配置`wepack.config.js`

        ```js
        //webpack.config.js
        module.exports = {
            //...
            modules: {
                rules: [
                    {
                        test: /\.(png|jpg|gif|jpeg|webp|svg|eot|ttf|woff|woff2)$/,
                        use: [
                            {
                                loader: 'url-loader',
                                options: {
                                    limit: 10240, //10K
                                    esModule: false 
                                }
                            }
                        ],
                        exclude: /node_modules/
                    }
                ]
            }
        }
        ```

        配置说明

        1. `limit`：这里配置了`10240`，即资源小于10k的时候，将资源转化为`base64`，超过的话，将图片拷贝到`dist`目录

            将图片转为`base64`会减小网络请求次数，但是如果`base64`数据较大，会导致资源加载变慢，因此设置`limit`时，需要兼顾
            
        2. `esModule`设置为`false`，否则`<img src={require('xx.png')} />`会出现`<img src=[Module Object] />`
        3. 当资源较多时，我们希望他们能打包在一个目录下，只需要在`url-loader`的`options`中指定`outpath`


### html中使用本地图片

1. 概念

    如果在`public/index.html`中，使用本地的图片

    ```html
    <img src="./lala.png" />
    ```

    重新启动本地服务，控制台虽然不报错，但是浏览器无法加载出这张图片

    因为构建之后的相对路径找不到

    注意：`我用的webpack-5`好像没有这个问题，直接能够使用，下面的笔记是看的`webpack-4`做的

2. 操作

    1. 安装依赖

        ```js
        npm install html-withimg-loader -D
        ```

    2. 修改`webpack.config.js`

        ```js
        module.exports = {
            //...
            module: {
                rules: [
                    {
                        test: /.html$/,
                        use: 'html-withimg-loader'
                    }
                ]
            }
        }
        ```



### 入口配置

配置：`entry`

```js
//webpack.config.js
module.exports = {
    entry: './src/index.js' //webpack的默认配置
}
```

`entry`的值可以是一个`字符串`、一个`数组`、一个`对象`

1. `字符串`：就是对应的文件入口
2. `数组`：表示有`多个``主入口`，想要多个依赖文件一起注入时，会这样配置
    ```js
    entry: [
        './src/polyfills.js',
        './src/index.js'
    ]
    ```
    `polyfills.js` 文件中可能只是简单的引入了一些 `polyfill`，例如 `babel-polyfill`，`whatwg-fetch` 等，需要在最前面被引入
3. `对象`：后面解释多页配置的时候来解释


### 出口配置

配置：`output`控制`webpack`如何输出编译文件

```js
const path = require('path');
module.exports = {
    entry: './src/index.js',
    output: {
        path: path.resolve(__dirname, 'dist'), //必须是绝对路径
        filename: 'bundle.js',
        publicPath: '/' //通常是CDN地址
    }
}
```

例如，你最终编译出来的代码部署在CDN上，资源地址为`https://AAA/BBB/YourProject/XXX`，那么可以将生产的`publicPath`配置为`//AAA/BB/`

编译时，可以不配置，或者配置为`/`，可以在`config.js`中指定`publicPath`（`config.js`区分了`dev`和`build`），当然还可以区分不同的环境指定配置文件来设置，或者根据`isDev`字段来设置

除此之外，考虑`CDN缓存`的问题，我们一般会给文件名加上`hash`

```js
//webpack.config.js
module.exports = {
    output: {
        path: path.resolve(__dirname, 'dist'), //必须是绝对路径
        filename: 'bundle.[hash].js',
        publicPath: '/' //通常是CDN地址
    }
}
```

如果觉得`hash`串太长的话，还可以指定长度，如`bundle.[hash:6].js`，使用`npm run build`打包看看


### 每次打包前清空dist目录

1. 概念

    现在我们每次打包的时候，都是使用添加和覆盖文件的方式，如果不进行清理的话，会导致`dist`下的文件越来越多

    我们希望可以在打包之前删除一下`dist`目录，但是每次手动清理又很麻烦

2. 操作

    1. 安装依赖

        ```js
        npm install clean-webpack-plugin -D
        ```

    2. 修改`webpack.config.js`

        ```js
        //webpack.config.js
        const { CleanWebpackPlugin } = require('clean-webpack-plugin');

        module.exports = {
            //...
            plugins: [
                //不需要传参数喔，它可以找到 outputPath
                new CleanWebpackPlugin() 
            ]
        }
        ```

3. 如果希望dist木下某个目录不被清空

    使用`clean-webpack-plugin`的参数`cleanOnceBeforeBuildPatterns`

        ```js
        //webpack.config.js
        module.exports = {
            //...
            plugins: [
                new CleanWebpackPlugin({
                    cleanOnceBeforeBuildPatterns:['**/*', '!dll', '!dll/**'] //不删除dll目录下的文件
                })
            ]
        }
        ```


## 进阶篇

### 静态资源拷贝

注意：`我用的webpack-5`好像没有这个问题，直接能够使用，下面的笔记是看的`webpack-4`做的

1. 背景

    有时候，我们需要使用已有的`js`、`css`文件，但是`不需要webapck`编译

    例如，我们在`public/index.html`中引入了`public`目录下的`js`、`css`文件，这个时候，如果直接打包，那么构建出来之后，是找不到对应的`js`、`css`的

    ```html
    <!-- index.html -->
    <script src="./js/base.js"></script>
    ```

    这时候，我们 `npm run dev`，会发现有找不到该资源文件的报错信息。

    对于这个问题，我们可以`手动将其拷贝`至构建目录，然后在配置 `CleanWebpackPlugin` 时，注意不要清空对应的文件或文件夹即可，但是如若这个静态文件时不时的还会修改下，那么依赖于手动拷贝，是很容易出问题的。

2. 操作

    1. 安装插件

        ```js
        npm install copy-webpack-plugin -D
        ```

    2. 修改`webapck.config.js`

        ```js
        //webpack.config.js
        const CopyWebpackPlugin = require('copy-webpack-plugin');
        module.exports = {
            //...
            plugins: [
                new CopyWebpackPlugin([
                    {
                        from: 'public/js/*.js',
                        to: path.resolve(__dirname, 'dist', 'js'),
                        flatten: true,
                    },
                    //还可以继续配置其它要拷贝的文件
                ], {
                    ignore: ['other.js']
                })
            ]
        }
        ```

        `fltten` 这个参数，设置为 `true`，那么它只会拷贝文件，而不会把文件夹路径都拷贝上

        `ignore`忽略掉 `js` 目录下的 `other.js` 文件，使用 `npm run build` 构建，可以看到 `dist/js` 下不会出现 `other.js` 文件


### providePlugin

1. 作用

    类似`全局变量`，不需要`import`或`require`就可以在项目中到处使用

2. 使用

    是webpack内置的插件

    ```js
    new webpack.ProvidePlugin({
        identifier1: 'module1',
        identifier2: ['module2', 'property2']
    });
    ```

    默认寻找的路径是当前文件夹`./**`和`node_modules`，也可以指定全路径

    比如，`React`，使用的时候，需要在每个文件引入`React`，要不然立即报错，还有`jquery`、`lodash`这样的库，可能在多文件中使用，但是懒得每次都引入

    ```js
    const webpack = require('webpack');
    module.exports = {
        //...
        plugins: [
            new webpack.ProvidePlugin({
                React: 'react',
                Component: ['react', 'Component'],
                Vue: ['vue/dist/vue.esm.js', 'default'],
                $: 'jquery',
                _map: ['lodash', 'map']
            })
        ]
    }
    ```

    这样配置之后，就可以在项目中随心所欲使用`$`、`_map`、`React`

    注意，`Vue`的配置后面多了一个`default`，这是因为`vue.esm.js`中使用的是`export default`导出的，比需要指定`default`，`React`使用的是`module.exports`导出，所以不需要写`default`

3. 如果项目启动了`eslint`的话，需要修改`eslint`的配置文件

    ```js
    {
        "globals": {
            "React": true,
            "Vue": true,
            //....
        }
    }
    ```


### 抽离CSS

1. 背景

    前面提过css打包，不过，有的时候，我们会有抽离css的需求，即将css文件单独打包，这可能是因为一个js文件太大，影响加载速度，也有可能是为了缓存

2. 操作

    1. 安装`mini-css-extract-plugin`

        > npm install mini-css-extract-plugin -D

        `mini-css-extract-plugin`和`extract-text-webpack-plugin`相比

        1. 异步加载
        2. 不会重复编译（性能更好）
        3. 更容易使用
        4. 只适用于css

    2. 修改`webpack.config.js`

        ```js
        //webpack.config.js
        const MiniCssExtractPlugin = require('mini-css-extract-plugin');
        module.exports = {
            plugins: [
                new MiniCssExtractPlugin({
                    filename: 'css/[name].css'
                    //个人习惯将css文件放在单独目录下
                    //publicPath:'../'   //如果你的output的publicPath配置的是 './' 这种相对路径，那么如果将css文件放在单独目录下，记得在这里指定一下publicPath 
                })
            ],
            module: {
                rules: [
                    {
                        test: /\.(le|c)ss$/,
                        use: [
                            MiniCssExtractPlugin.loader, //替换之前的 style-loader
                            'css-loader', {
                                loader: 'postcss-loader',
                                options: {
                                    postcssOptions: {
                                        plugins: function () {
                                        return [
                                            require("autoprefixer")({
                                            overrideBrowserslist: ["defaults"],
                                            }),
                                        ];
                                        },
                                    }
                                },
                            }, 'less-loader'
                        ],
                        exclude: /node_modules/
                    }
                ]
            }
        }
        ```

        这个时候运行`npm run build`可以发现生成了`dist/css/main.csss`和`dist/css/main.css.map`

    3. `.browserlistrc`

        这样可以多个`loader`共享配置
        
        动手在根目录下新建`.browserslistrc`

        ```js
        last 2 version
        > 0.25%
        not dead
        ```

        修改`webpack.config.js`

        ```js
        //webpack.config.js
        const MiniCssExtractPlugin = require('mini-css-extract-plugin');
        module.exports = {
            //...
            plugins: [
                new MiniCssExtractPlugin({
                    filename: 'css/[name].css' 
                })
            ],
            module: {
                rules: [
                    {
                        test: /\.(c|le)ss$/,
                        use: [
                            MiniCssExtractPlugin.loader,
                            'css-loader', {
                                loader: 'postcss-loader',
                                options: {
                                    postcssOptions: {
                                        plugins: function () {
                                        return [
                                            require("autoprefixer")(),
                                        ];
                                        },
                                    }
                                },
                            }, 'less-loader'
                        ],
                        exclude: /node_modules/
                    },
                ]
            }
        }
        ```

### 将抽离出来的css文件进行压缩

使用`mini-css-extract-plugin`，`CSS`文件默认不会被压缩

如果想要压缩，需要配置`optimation`

> npm install optimize-css-assets-webpack-plugin -D

修改`webpack.config.js`

```js
//webpack.config.js
const OptimizeCssPlugin = require('optimize-css-assets-webpack-plugin');

module.exports = {
    //....
    plugins: [
        new OptimizeCssPlugin()
    ],
}
```

注意，这里将`OptimizeCssPlugin`直接配置在`plugins`里面，那么`js`和`css`都能够正常压缩

如果将配置在`optimization`，那么需要再配置一下`js`的压缩


### 按需加载

1. 背景

    很多时候我们不需要一次性加载所有的`JS`文件，而应该在不同阶段去加载所需要的代码

    `webpack`内置了强大的分割代码的功能可以实现按需加载

    比如，我们点击了某个按钮之后，才需要使用对应的js文件中的代码，需要使用`import()`语法

    ```js
    document.getElementById('btn').onclick = function() {
        import('./handle').then(fn => fn.default());
    }
    ```

2. `import()`语法，需要`@babel/plugin-syntax-dynamic-import`的插件支持

    但是当前`@babel/preset-env`预设中已经包含了`@babel/plugin-syntax-dynamic-import`，因此我们不需要单独安装和配置

    直接进行`npm run build`进行构建

    大家可以在浏览器的`source`和`network`观察，只有按钮点击之后，才会加载对应的js

3.  `webpack`遇到`import(***)`这样的语法的时候，会这样进行处理

    1. 以`***`为入口新生一个`chunk`
    2. 当代码执行到`import`所在的语句时，才会加载该`chunk`所对应的额文件


### 热更新

1. 配置`devServer`的`hot`为`true`
2. 在`plugins`中增加`new webpack.HotModuleReplacemenntPlugin()`

```js
//webpack.config.js
const webpack = require('webpack');
module.exports = {
    //....
    devServer: {
        hot: true
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin() //热更新插件
    ]
}
```

3. 这个修改代码，仍然是整个页面都会刷新，不希望整个页面刷新，还要修改入口文件

    在入口文件新增

    ```js
    if(module && module.hot) {
        module.hot.accept()
    }
    ```

### 多页应用打包

1. 背景

    有时，我们的应用不一定是一个单页应用，而是一个多页应用，那么如何使用`webpack`打包呢

    为了生成目录看起来清晰，不单独生成`map`文件

2. 修改`webpack.config.js`

    ```js
    //webpack.config.js
    const path = require('path');
    const HtmlWebpackPlugin = require('html-webpack-plugin');
    module.exports = {
        entry: {
            index: './src/index.js',
            login: './src/login.js'
        },
        output: {
            path: path.resolve(__dirname, 'dist'),
            filename: '[name].[hash:6].js'
        },
        //...
        plugins: [
            new HtmlWebpackPlugin({
                template: './public/index.html',
                filename: 'index.html' //打包后的文件名
            }),
            new HtmlWebpackPlugin({
                template: './public/login.html',
                filename: 'login.html' //打包后的文件名
            }),
        ]
    }
    ```

    如果需要配置多个`HtmlWebpackPlugin`，那么`filename`字段不可缺省，否则默认生成的都是`index.html`

    如果你希望`html`的文件名也带有`hash`，那么直接修改`filename`字段即可，`filename: 'login.[hash:6].html`

3. 生成的目录如下

    ```
    .
    ├── dist
    │   ├── 2.463ccf.js
    │   ├── assets
    │   │   └── thor_e09b5c.jpeg
    │   ├── css
    │   │   ├── index.css
    │   │   └── login.css
    │   ├── index.463ccf.js
    │   ├── index.html
    │   ├── js
    │   │   └── base.js
    │   ├── login.463ccf.js
    │   └── login.html
    ```

4. 问题

    表面上看没有问题

    但是实际上两个`html`文件中都引入了两个`js`

    ```js
    <script defer="defer" src="index.153511.js"></script>
    <script defer="defer" src="login.153511.js"></script>
    ```

    我们期望的是各引用各自的

5. `HtmlWebpackPlugin`提供了一个`chunks`参数

    可以接受一个数组，配置此参数仅会将数组中指定的`js`引入到`html`文件中

    如果需要引入多个js，但是少数几个不想引入，还可以指定`excludeChunks`参数，它接受一个数组

    ```js
    //webpack.config.js
    module.exports = {
        //...
        plugins: [
            new HtmlWebpackPlugin({
                template: './public/index.html',
                filename: 'index.html', //打包后的文件名
                chunks: ['index']
            }),
            new HtmlWebpackPlugin({
                template: './public/login.html',
                filename: 'login.html', //打包后的文件名
                chunks: ['login']
            }),
        ]
    }
    ```

### resolve配置

`resolve`配置`webpack`如何寻找模块对应的文件

`webpack`内置`JavaScript`模块化语法解析功能，默认会采用模块化标准里约定好的规则去寻找

1. modules

    配置`webpack`去哪里目录下寻找第三方模块，默认情况下，只会去`node_modules`下寻找

    如果项目中某个文件夹下的模块经常被导入，不希望写很长的路径，那么就可以通过配置`modules`来简化

    ```js
    //webpack.config.js
    module.exports = {
        //....
        resolve: {
            modules: ['./src/components', 'node_modules'] //从左到右依次查找
        }
    }
    ```

    这样配置之后，我们`import Dialog from 'dialog'`，会去寻找`./src/components/dialog`，不需要使用相对路径导入

    如果在`./src/components`
    

## 其他笔记

### loader

常用的loader

| 名称          | 概述                       |
| ------------- | -------------------------- |
| babel-loader  | 转换es6，es7等新特性的语法 |
| css-loader    | 支持.css文件的加载和解析   |
| less-loader   | 将less文件转换成css        |
| ts-loader     | 将TS转换为JS               |
| file-loader   | 进行图片、字体等的打包     |
| raw-loader    | 将文件以字符串的形式导入   |
| thread-loader | 多进程打包js和css          |

### plugin

常用的plugins

| 名称                     | 描述                                          |
| ------------------------ | --------------------------------------------- |
| CommonsChunkPlugin       | 将chunks相同的模块代码提取成公共js            |
| CleanWebpackPlugin       | 清理构建目录                                  |
| ExtractTextWebpackPlugin | 将css文件从bunld文件里提取成一个代理的css文件 |
| CopyWebpackPlugin        | 将文件或者文件夹拷贝到构建的输出目录          |
| HtmlWebpackPlugin        | 创建html文件去承载输出的bundle                |
| UglifyjsWebpackPlugin    | 压缩js                                        |
| ZipWebpackPlugin         | 将打包出的资源生成一个zip包                   |

### 热更新原理































