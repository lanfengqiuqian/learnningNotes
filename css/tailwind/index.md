[官方文档](https://tailwindcss.com/)
[中文文档](https://www.tailwindcss.cn/docs/guides/vite)

## 起步

### 安装和使用

以 vite 项目为例（其他框架或者方式参考文档）

1. 安装插件以及初始化配置文件

   > npm install -D tailwindcss postcss autoprefixer
   > npx tailwindcss init -p

2. 配置模板文件`tailwind.config.js`（修改`content`属性即可）

   ```js
   /** @type {import('tailwindcss').Config} */
   export default {
     content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx,vue}"],
     theme: {
       extend: {},
     },
     plugins: [],
   };
   ```

3. 添加到全局 css 文件`./src/index.css`

   ```js
   @tailwind base;
   @tailwind components;
   @tailwind utilities;
   ```

在 html 文件中使用 cdn

```html
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <h1 class="text-3xl font-bold underline">Hello world!</h1>
  </body>
</html>
```

## 技巧

### 编辑器插件推荐

1. Tailwind CSS IntelliSense

   功能：代码提示

2. Tailwind Docs

   功能：文档查询

### Tailwind CSS IntelliSense 没有提示

1. 使用 cdn 引入的 html 文件中

先创建`tailwind.config.js`配置文件，配置项可以为空

```js
export default {
  theme: {
    extend: {
      //
    },
  },
};
```

然后引入到 html 文件中

```js
<script type="module">
  import cfg from "./tailwind.config.js"; tailwind.config = cfg;
</script>
```

2. 工程项目中不生效

在`vscode`的`user setting json`中增加即可

```js
"editor.quickSuggestions": { "strings": true },
```

### 自定义样式优先级

在一个元素上多个类名定义了同一个样式时，取决于 css 的顺序，而不是 class 的顺序

```js
.btn {
  background: blue;
  /* ... */
}

.bg-black {
  background: black;
}

// 这里两个按钮都是黑色，因为bg-black是后定义的
<button class="btn bg-black">...</button>
<button class="bg-black btn">...</button>
```

### 在某一个层级设置自定义类名

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer components {
  .my-custom-style {
    /* ... */
  }
}
```

规则

`base`: 用于重置规则或应用于纯 HTML 元素的默认样式等内容。
`components`: 用于您希望能够使用实用程序覆盖的基于类的样式。
`utilities`: 适用于小型、单一用途的类，应始终优先于任何其他样式。

### 定义一个类名，继承多个 tailwind 类名

参见 `https://www.tailwindcss.cn/docs/adding-custom-styles#using-css-and-layer`

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer components {
  .select2-dropdown {
    @apply rounded-b-lg shadow-md;
  }
  .select2-search {
    @apply border border-gray-300 rounded;
  }
  .select2-results__group {
    @apply text-lg font-bold text-gray-900;
  }
  /* ... */
}
```

### 负值

写在类名最前面，如`-m-8`表示`margin: -8rem`

### 任意

1. 使用任意 style

```css
class="[--scroll-offset:56px]"
```

2. 使用任意属性值

```css
class="text-[22px] lg:top-[34px]"
```

3. 有空格的情况：`使用下划线替换`

```css
class="grid grid-cols-[1fr_500px_2fr]"
```

4. 有下划线的情况：直接使用即可

```css
class="bg-[url('/what_a_rush.png')]"
```

5. 下划线和空格都有：`使用反斜杠显式转义`

```css
class="before:content-['hello\_world']"
```

### 设置import

在类名前面加`!`即可

```css
clsss="!h-[330px]"
```

### 行夹，用于限定字体行数

<https://tailwind.nodejs.cn/docs/line-clamp>


```css
/* line-clamp-1 */

.text {
  overflow: hidden;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 1;
}
```

### 设置单行文本溢出显示省略号

```css
css="truncate"
```

### 设置rgba

需要注意的是：括号里面不要带空格

```html
<div class="bg-[rgba(185,221,253,0.15)] p-4">
这是一个带有 rgba 背景色的元素
</div>
```

## 问题

### Tailwind CSS IntelliSense 没有提示

1. 使用 cdn 引入的 html 文件中

先创建`tailwind.config.js`配置文件，配置项可以为空

```js
export default {
  theme: {
    extend: {
      //
    },
  },
};
```

然后引入到 html 文件中

```js
<script type="module">
  import cfg from "./tailwind.config.js"; tailwind.config = cfg;
</script>
```

2. 工程项目中不生效

在`vscode`的`user setting json`中增加即可

```js
"editor.quickSuggestions": { "strings": true },
```

### 安装之后报错 `npm error could not determine executable to run`

执行`npx tailwindcss init`命令报错

```shell
PS D:\code\ai> npx tailwindcss init
npm error could not determine executable to run
npm error A complete log of this run can be found in: C:\Users\25776\AppData\Roaming\nvm\node_cache\_logs\2025-03-25T06_28_57_957Z-debug-0.log
```

1. ​错误原因
此错误通常由 ​Tailwind CSS 版本不兼容 导致。具体表现为：

​版本冲突：您可能安装了 ​Tailwind CSS v4.x，而 npx tailwindcss init -p 命令在 v4 中已被移除。
​配置方法差异：v4 的配置方式与 v3 不同，若仍使用旧版命令会触发此错误

2. 解决方案

  1. 方案一：卸载重装v3

    ```shell
    # ​卸载当前版本：
    npm uninstall tailwindcss

    # ​安装 v3 版本及依赖
    npm install -D tailwindcss@3 postcss autoprefixer

    # 重新初始化配置文件：
    npx tailwindcss init -p
    ```

  
  2. 方案二：升级成v4

    ```shell
    # 安装 v4 及适配插件：
    npm install tailwindcss @tailwindcss/vite2

    # ​创建配置文件：
    npx tailwindcss init

    # 修改 CSS 文件：新建或修改 src/assets/tailwind.css，添加：
    @tailwind base;
    @tailwind components;
    @tailwind utilities;

    # 在入口文件中引入​（如 main.ts 或 main.js）：
    import './assets/tailwind.css';

    # 配置构建工具​（如 Vite）：
    // vite.config.ts
    import { defineConfig } from 'vite'
    import tailwindcss from '@tailwindcss/vite'

    export default defineConfig({
      plugins: [tailwindcss()],
    })
    ```