## 简介

### Electron是什么

1. 是一个使用`Javascript`、`Html`、`Css`构建桌面应用程序的框架
2. 嵌入`Chromium`和`Node.js`到二进制的`Electron`允许您保持一个`Javascript`代码库，并创建在`Windows`上运行的跨平台应用
3. 不需要本地开发的经验

### 基本要求

1. 需要安装`Nodejs`

    ```
    node -v
    npm -v
    ```

2. 注意

    因为`Electron`将`Node.js`嵌入到其二进制文件中，您应用运行时的`Nodejs`版本与您系统中的`Nodejs`版本无关

## 创建您的应用程序

1. 使用脚手架创建

    ```js
    mkdir my-electron-app && cd my-electron-app
    pnpm init
    ```

    需要注意几条规则

    1. `entry point`应为`main.js`
    2. `author`与`description`可为任意值，但是对于`应用打包`是必填项
2. 安装依赖

    ```
    pnpm install --save-dev electron
    ```

    安装依赖很久没反应或者提示超时，一般是网络问题，重新找一个镜像源

    > pnpm config set ELECTRON_MIRROR https://npmmirror.com/mirrors/electron/

    `Error: Electron failed to install correctly, please delete node_modules/electron and try installing again`

    这个报错是因为安装依赖的时候，`electron`没有安装完成，进入到`node_modules/electron`目录，然后手动执行`node install.js`

    这里也有可能超时，打开这个`install.js`文件，然后按照<https://www.cnblogs.com/Wei-notes/p/18046843>手动设置一个镜像源，可以直接用上面那个

3. 增加启动命令和启动文件

    在`package.json`中设置如下

    ```json
    {
        "name": "electron-start",
        "version": "1.0.0",
        "description": "",
        // 注意设置启动文件名称
        "main": "main.js",
        "scripts": {
            "test": "echo \"Error: no test specified\" && exit 1",
            // 启动命令
            "start": "electron ."
        },
        "keywords": [],
        "author": "",
        "license": "ISC",
        "devDependencies": {
            "electron": "^33.2.0"
        }
    }
    ```

    这个时候启动的话，会报提示没有`main.js`文件

4. 编写启动文件

    ```js
    // app模块，控制应用程序的事件生命周期
    // BrowserWindow模块，创建和管理应用程序窗口
    // 因为主进程运行Nodejs，所以需要使用CommonJs的方式导入
    const { app, BrowserWindow } = require("electron");

    const createWindow = () => {
        const win = new BrowserWindow({
            width: 800,
            height: 600,
        });

        win.loadFile("index.html");
    };

    // 只有在app模块的ready事件被歘之后才能创建浏览器窗口
    // 可以通过使用app.whenReady()来监听此事件
    app.whenReady().then(() => {
        createWindow();
    });
    ```

5. 编写导入的index.html文件

    ```html
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>第一个应用</title>
        </head>
        <body>
            <h1>Hello World!</h1>
            We are using Node.js <span id="node-version"></span>, Chromium
            <span id="chrome-version"></span>, and Electron
            <span id="electron-version"></span>.
        </body>
    </html>


    ```

6. 启动

    ```js
    pnpm start
    ```

    这个时候会自动启动一个`Electron`应用程序


### 管理窗口生命周期

### 在app中有一些约定的责任交给开发者们

1. 使用`进程`全局的`platform`属性来为某些操作系统运行代码

2. 关闭所有窗口时退出应用（Windows & Linux）

3. 在Windows和Linux上，关闭所有窗口通常会完全退出一个应用程序

    为了实现这一点，你需要监听`app`模块的`window-all-closed`事件。如果用户不是在macOS（darwin）上运行程序，则调用`app.quit()`

    ```js
    app.on('window-all-closed', () => {
        if (process.platform !== 'darwin') app.quit();
    })
    ```

4. 如果没有窗口打开则打开一个窗口（macOS）

    当Windows和Linux应用在没有窗口打开时退出了，macOS应用通常在及时没有打开任何窗口的情况下也能继续运行，并且在没有窗口可用的情况下激活应用时会打开新的窗口

    为了实现这一特性，监听`app`模块的`activate`事件，如果没有任何浏览器窗口是打开的，则需要`createWindow()`方法

    因为窗口无法在`ready`事件前创建，你应当在你的应用初始化后仅监听`activate`事件，通过在您现有的`whenReady`回调中附上你的事件监听器来完成这个操作

### 通过预加载脚本从渲染器访问Nodejs

将`Electron`版本号和他的依赖项显示到web页面上

现在主进程通过Node的全局`process`对象访问这个信息是微不足道的。然后你不能直接在主进程中编辑dom，因为他无法访问`渲染器文档上下文`，他们存在于完全不同的进程。

这是将`预加载`脚本连接到渲染器时派上用场的地方。预加载脚本在渲染器进程加载之前加载，并有全访问2个渲染器全局和nodejs环境

创建名为`preload.js`的新脚本如下

```js
window.addEventListener("DOMContentLoaded", () => {
  const replaceText = (selector, text) => {
    const el = document.getElementById(selector);
    if (el) {
      el.innerText = text;
    }
  };

  for (const dependency of ["chrome", "node", "electron"]) {
    replaceText(`${dependency}-version`, process.versions[dependency]);
  }
});
```

### 额外：将功能添加到您的网页内容

此刻，您可能想知道如何为您的应用程序添加更多功能

对于与您的网页内容的任何交互，您想要将脚本添加到您的渲染器进程中，由于渲染器运行在正常web环境中，因此你可以在`index.html`文件关闭`</body>`之前添加一个`<script>`标签，来包括您想要的任意脚本

```html
<script src="./renderer.js"></script>
```

`render.js`中包含的代码可以在接下来使用与前端开发相同的`JSAPI`和工具。例如，使用`webpack`打包并最小化你的代码，或者使用`React`来管理您的用户界面

### 打包并分发您的应用程序

最快捷的打包方式是使用`Electron Forge`

1. 添加`description`到`package.json`文件中，空白无效
2. 将`Electron Forge`添加到您应用的开发依赖中，并使用`import`命令设置`Forge`的脚手架

    ```js
    npm install --save-dev @electron-forge/cli
    npx electron-forge import
    ```

3. 使用`Forge`的`make`命令来创建可分发的应用程序

    ```js
    npm run make
    ```

4. `Electron-forge`会创建`out`文件夹，您的软件包将在哪里找到


### 使用预加载脚本

#### 什么是预加载脚本

1. Electron的主进程是一个拥有者完全操作系统访问权限的NodeJs环境
2. 除了`Electron模组`之外，你也可以访问`Nodejs内置模块`和所有通过`npm`安装的包
3. 由于安全原因，渲染进程默认跑在网页页面上，而并非Nodejs里
4. 为了将Electron的不同类型的进程桥接在一起，我们需要使用被称为`预加载`的特殊脚本

#### 使用预加载脚本来增强渲染器

`BrowserWindow`的预加载脚本运行在具有`HTML DOM`和`Nodejs、Electron API`的有限子集访问权限的环境中

## electron中的流程

#### 流程模型

Electron继承了来自Chromium的多进程架构，这使得此框架在架构上费城类似于一个现代网页浏览器

1. 为什么不是一个单一的进程

    浏览器是一个极其复杂的应用程序。除了显示网页内容的主要能力之外，他们还有许多次要的职责，例如管理众多窗口和加载第三方扩展

    在早期，浏览器通常使用单个进程来处理所有这些功能。虽然这种模式意味着您打开的每个标签页的开销比较小，但也同时意味着一个网页的崩溃或无响应会影响到整个浏览器

2. 多进程模型

    为了解决这个问题，chrome团队决定让每个标签页在自己进程中渲染，从而限制了一个网页上的有误或者恶意代码导致整个应用程序崩溃。然后用单个浏览器进程控制这些标签页进程，以及整个应用程序的生命周期。

    Electron应用程序的结构非常相似。作为开发者，你将控制两种类型的进程：`主进程`和`渲染进程`

3. 主进程

    每个Electron应用都有一个单一的主进程，作为应用程序的入口

    主进程在`Nodejs`环境中运行，这意味着它具有`require`模块和使用所有`Nodejs API`的能力

    主进程的主要目的是使用`BrowserWindow`模块创建和管理应用程序窗口

    `BrowserWindow`类的每个实例创建一个应用程序窗口，且在单独的渲染器进程中加载一个网页。您可以从主进程用`window`的`webContent`对象与网页内容进行交互

    > 注意：由于渲染器进程也是为`web embeds`而创建的，例如`BrowserView`模块。嵌入式网页内容也可访问`webContents`对象

    由于`BrowserWindow`模块是一个`EventEmitter`，所以您也可以为各种用户事件（例如最小化、最大化窗口）添加处理程序

    当一个`BrowserWindow`实例被销毁时，与其相应的渲染器进程也会被终止

4. 应用程序生命周期

    主进程还能通过`Electron`的`app`模块来控制您的应用生命周期。这个模块提供了大量事件和方法，可用于添加自定义应用程序行为（例如以编程方式退出应用程序、修改应用程序停靠栏或显示“关于”面板）

5. 原生API

    为了使Electron的功能不仅仅限于对网页内容的封装，主进程也添加了自定义的API来与用户的作业系统进行交互。Electron有着多种控制原生桌面功能开发的模块，例如菜单、对话框以及托盘图标。

6. 渲染器进程

    每个Electron应用都会为每个打开的`BrowserWindow`生成一个单独的渲染器进程。

    恰如其名，渲染器负责`渲染`网页内容。所以实际上，运行于渲染器进程中的代码使需遵照网页标准的。

    因此，一个浏览器窗口中所有的用户界面和应用功能，都应与您在网页开发上使用相同的工具和规范来进行撰写。

    此外，也意味着渲染器无权直接访问`require`或其他`Nodejs API`。为了在渲染器中直接包含`NPM`模块，您必须使用与在`web`开发时相同的打包工具，例如`webpack`或`parcel`

    > 警告：为了方便开发，可以用完整的Nodejs环境生成渲染器进程。在历史上，这是默认的，但由于安全原因，这一功能已被禁用

    此刻，您或许会好奇：既然这些特性都只能由主进程访问，那渲染器进程用户界面怎样才能与Nodejs和Electron的原生桌面功能进行交互。而事实上，确实没有直接导入Electron内容脚本的方法。

7. Preload脚本

    预加载脚本包含了哪些执行与渲染器进程中，且优先于网页内容开始加载的代码。这些脚本虽运行于渲染器的环境中，却因能访问`Nodejs API`而拥有了更多的权限

    可以在`BrowserWindow`构造方法中的`webPreferences`选项里被附加到主进程

    ```js
    const { BrowserWindow } = require('electron')
    // ...
    const win = new BrowserWindow({
        webPreferences: {
            preload: 'path/to/preload.js'
        }
    })
    // ...
    ```

    因为预加载脚本与浏览器共享同一个全局`Window`接口，并且可以访问`Nodejs API`，所以它通过在全局暴露任意API来增强渲染器，以便你的网页内容使用

    虽然预加载脚本预期所附着的渲染器共享着一个全局`window`对象，但您并不