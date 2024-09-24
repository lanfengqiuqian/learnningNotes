#### 初始命令

```
// 生成.eslintrc.js文件
eslint --init

// 自动修复错误
eslint src --fix
```

#### 几个重要的概念

1. rules：手动配置eslint的eslint的规则

    ```js
    module.exports = {
        rules: {
            'indent': 'off'
        }
    }
    ```

2. plugins：插件

    如果eslint自带的一些规则不够用，那么可以去安装一些三方的插件

    比如说`eslint-plugin-react`就会对react项目做一些定制的eslint规则，如`jsx-boolean-value`

    使用

    1. 安装：`yarn add eslint-plugin-react --dev`

    2. 加载插件

        plugins只是加载了插件，可以理解为赋予了eslint解析`jsx-boolean-value`规则的检查能力，真正开启这个规则的检查能力还是要通过rules配置（一个插件库里面往往有几十个新规则，并不是每一个规则都要开启，需要根据自己的需求来配置相关规则）

        ```js
        //	.eslintrc.js
        module.exports = {
            plugins: [
                'eslint-plugin-react'
            ],
            rules: {
                'eslint-plugin-react/jsx-boolean-value': 2
            }
        }
        ```

3. extends集成

    1. plugins和rules结合是eslint的基础能力，extends可以看作是一个集成一个个配置方案的最佳实践

    2. 虽然需要根据不同的需求、风格、规范去配置不同的eslint规则，但是相似的项目的规则一般是大同小异的，如果每一个规则都手动配置太不人性，这个时候就需要extends了

    3. extends配置的内容其实就是一份份别人配置好的`.eslintrc.js`

    ```js
    module.export = {
        extends: [
            'eslint-plugin-react/recommended'
        ]
    }
    ```

#### 其他常用属性

1. parserOptions

    允许指定校验的ecma版本以及ecma的一些特性

    ```json
    "parseOptions": {
        "ecmaVersion": 6,
        "sourceType": "module",
        "ecmaFeatures": {
            "jsx": true
        }
    }
    ```

2. parser

    指定解析器，eslint默认使用`esprima`做脚本解析
    
    在es6代码中，需要改成`babel-eslint`，它是使用频率很高的解析器，因为很多代码都使用了es6，为了兼容性考虑，基本都使用babel插件对代码进行编译

    > npm install --save babel-eslint

    > parser: "babel-eslint"

3. env

    可以预设好其他环境的全局变量，如`brower`、`node环境变量`、`es6环境变量`、`mocha环境变量`，这样的话，就能在代码中使用对应环境的变量了，如browser的`window`、node的`global`

    ```json
    "env": {
        "browser": true,
        "node": true
    }
    ```

4. global

    指定全局变量，true表示允许重写，false代表不允许重写


```js
module.exports = {
// 默认情况下，ESLint会在所有父级组件中寻找配置文件，一直到根目录。ESLint一旦发现配置文件中有 "root": true，它就会停止在父级目录中寻找。
  root: true,
// 对Babel解析器的包装使其与 ESLint 兼容。
  parser: 'babel-eslint',
  parserOptions: {
    // 代码是 ECMAScript 模块
    sourceType: 'module'
  },
  env: {
    // 预定义的全局变量，这里是浏览器环境
    browser: true,
  },
// 扩展一个流行的风格指南，即 eslint-config-standard 
// https://github.com/feross/standard/blob/master/RULES.md#javascript-standard-style
  extends: 'standard',
// required to lint *.vue files
  plugins: [
    // 此插件用来识别.html 和 .vue文件中的js代码
    'html',
    // standard风格的依赖包
    "standard",
    // standard风格的依赖包
    "promise"
  ],
// add your custom rules here
  'rules': {
    // allow paren-less arrow functions
    'arrow-parens': 0,
    // allow async-await
    'generator-star-spacing': 0,
    // allow debugger during development
    'no-debugger': process.env.NODE_ENV === 'production' ? 2 : 0
  }
}
```

#### eslint的注释

在代码间使用，设置是否启用eslint

```js
var a = 1; // eslint-disable-line 设置该行不启用

// eslint-disable-next-line 设置下行不启用
var b = 1;

/* eslint-disable */
// 设置代码段不启用
// 这是一段代码
/* eslint-disable */
```

#### 解决eslint和prettier的冲突

<https://juejin.cn/post/7156893291726782500#heading-8>

思路：关闭`eslint`的格式化功能，只需要它做好代码质量检测的功能即可

```js
// 安装依赖
yarn add eslint-config-prettier eslint-plugin-prettier -D

// .eslintrc
{
   // 其余的配置
 - "extends": ["eslint:recommended", "standard"]
 + "extends": ["eslint:recommended", "standard",  "plugin:prettier/recommended"]
  // 其余的配置
}
```

如果修改了.prettierrc的配置选项，会发现 eslint 和 prettier又冲突了，这是因为vscode插件缓存没有及时更新，重启下vscode即可。