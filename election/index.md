## 工具、库资源整合

<https://github.com/electron-modules/awesome-electron?tab=readme-ov-file>

## 简介

### Electron 是什么

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

5. 编写导入的 index.html 文件

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

### 在 app 中有一些约定的责任交给开发者们

1. 使用`进程`全局的`platform`属性来为某些操作系统运行代码

2. 关闭所有窗口时退出应用（Windows & Linux）

3. 在 Windows 和 Linux 上，关闭所有窗口通常会完全退出一个应用程序

   为了实现这一点，你需要监听`app`模块的`window-all-closed`事件。如果用户不是在 macOS（darwin）上运行程序，则调用`app.quit()`

   ```js
   app.on("window-all-closed", () => {
     if (process.platform !== "darwin") app.quit();
   });
   ```

4. 如果没有窗口打开则打开一个窗口（macOS）

   当 Windows 和 Linux 应用在没有窗口打开时退出了，macOS 应用通常在及时没有打开任何窗口的情况下也能继续运行，并且在没有窗口可用的情况下激活应用时会打开新的窗口

   为了实现这一特性，监听`app`模块的`activate`事件，如果没有任何浏览器窗口是打开的，则需要`createWindow()`方法

   因为窗口无法在`ready`事件前创建，你应当在你的应用初始化后仅监听`activate`事件，通过在您现有的`whenReady`回调中附上你的事件监听器来完成这个操作

### 通过预加载脚本从渲染器访问 Nodejs

将`Electron`版本号和他的依赖项显示到 web 页面上

现在主进程通过 Node 的全局`process`对象访问这个信息是微不足道的。然后你不能直接在主进程中编辑 dom，因为他无法访问`渲染器文档上下文`，他们存在于完全不同的进程。

这是将`预加载`脚本连接到渲染器时派上用场的地方。预加载脚本在渲染器进程加载之前加载，并有全访问 2 个渲染器全局和 nodejs 环境

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

对于与您的网页内容的任何交互，您想要将脚本添加到您的渲染器进程中，由于渲染器运行在正常 web 环境中，因此你可以在`index.html`文件关闭`</body>`之前添加一个`<script>`标签，来包括您想要的任意脚本

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

1. Electron 的主进程是一个拥有者完全操作系统访问权限的 NodeJs 环境
2. 除了`Electron模组`之外，你也可以访问`Nodejs内置模块`和所有通过`npm`安装的包
3. 由于安全原因，渲染进程默认跑在网页页面上，而并非 Nodejs 里
4. 为了将 Electron 的不同类型的进程桥接在一起，我们需要使用被称为`预加载`的特殊脚本

#### 使用预加载脚本来增强渲染器

`BrowserWindow`的预加载脚本运行在具有`HTML DOM`和`Nodejs、Electron API`的有限子集访问权限的环境中

### electron 中的流程

#### 流程模型

Electron 继承了来自 Chromium 的多进程架构，这使得此框架在架构上费城类似于一个现代网页浏览器

1. 为什么不是一个单一的进程

   浏览器是一个极其复杂的应用程序。除了显示网页内容的主要能力之外，他们还有许多次要的职责，例如管理众多窗口和加载第三方扩展

   在早期，浏览器通常使用单个进程来处理所有这些功能。虽然这种模式意味着您打开的每个标签页的开销比较小，但也同时意味着一个网页的崩溃或无响应会影响到整个浏览器

2. 多进程模型

   为了解决这个问题，chrome 团队决定让每个标签页在自己进程中渲染，从而限制了一个网页上的有误或者恶意代码导致整个应用程序崩溃。然后用单个浏览器进程控制这些标签页进程，以及整个应用程序的生命周期。

   Electron 应用程序的结构非常相似。作为开发者，你将控制两种类型的进程：`主进程`和`渲染进程`

3. 主进程

   每个 Electron 应用都有一个单一的主进程，作为应用程序的入口

   主进程在`Nodejs`环境中运行，这意味着它具有`require`模块和使用所有`Nodejs API`的能力

   主进程的主要目的是使用`BrowserWindow`模块创建和管理应用程序窗口

   `BrowserWindow`类的每个实例创建一个应用程序窗口，且在单独的渲染器进程中加载一个网页。您可以从主进程用`window`的`webContent`对象与网页内容进行交互

   > 注意：由于渲染器进程也是为`web embeds`而创建的，例如`BrowserView`模块。嵌入式网页内容也可访问`webContents`对象

   由于`BrowserWindow`模块是一个`EventEmitter`，所以您也可以为各种用户事件（例如最小化、最大化窗口）添加处理程序

   当一个`BrowserWindow`实例被销毁时，与其相应的渲染器进程也会被终止

4. 应用程序生命周期

   主进程还能通过`Electron`的`app`模块来控制您的应用生命周期。这个模块提供了大量事件和方法，可用于添加自定义应用程序行为（例如以编程方式退出应用程序、修改应用程序停靠栏或显示“关于”面板）

5. 原生 API

   为了使 Electron 的功能不仅仅限于对网页内容的封装，主进程也添加了自定义的 API 来与用户的作业系统进行交互。Electron 有着多种控制原生桌面功能开发的模块，例如菜单、对话框以及托盘图标。

6. 渲染器进程

   每个 Electron 应用都会为每个打开的`BrowserWindow`生成一个单独的渲染器进程。

   恰如其名，渲染器负责`渲染`网页内容。所以实际上，运行于渲染器进程中的代码使需遵照网页标准的。

   因此，一个浏览器窗口中所有的用户界面和应用功能，都应与您在网页开发上使用相同的工具和规范来进行撰写。

   此外，也意味着渲染器无权直接访问`require`或其他`Nodejs API`。为了在渲染器中直接包含`NPM`模块，您必须使用与在`web`开发时相同的打包工具，例如`webpack`或`parcel`

   > 警告：为了方便开发，可以用完整的 Nodejs 环境生成渲染器进程。在历史上，这是默认的，但由于安全原因，这一功能已被禁用

   此刻，您或许会好奇：既然这些特性都只能由主进程访问，那渲染器进程用户界面怎样才能与 Nodejs 和 Electron 的原生桌面功能进行交互。而事实上，确实没有直接导入 Electron 内容脚本的方法。

7. Preload 脚本

   预加载脚本包含了哪些执行与渲染器进程中，且优先于网页内容开始加载的代码。这些脚本虽运行于渲染器的环境中，却因能访问`Nodejs API`而拥有了更多的权限

   可以在`BrowserWindow`构造方法中的`webPreferences`选项里被附加到主进程

   ```js
   const { BrowserWindow } = require("electron");
   // ...
   const win = new BrowserWindow({
     webPreferences: {
       preload: "path/to/preload.js",
     },
   });
   // ...
   ```

   因为预加载脚本与浏览器共享同一个全局`Window`接口，并且可以访问`Nodejs API`，所以它通过在全局暴露任意 API 来增强渲染器，以便你的网页内容使用

   虽然预加载脚本预期所附着的渲染器共享着一个全局`window`对象，但您并不

#### 进程间通信（IPC）

进程间通信 (IPC) 是在 Electron 中构建功能丰富的桌面应用程序的关键部分之一。 由于主进程和渲染器进程在 Electron 的进程模型具有不同的职责，因此 IPC 是执行许多常见任务的唯一方法，例如从 UI 调用原生 API 或从原生菜单触发 Web 内容的更改。

1. IPC 通道

   在 Electron 中，进程使用`ipcMain`和`ipcRenderer`模块，通过开发人员定义的“通道”传递消息来进行通信。这些通道是`任意`和`双向`（您可以在两个模块中使用相同的通道名称）

2. 了解上下文隔离进程

   1. 模式 1：渲染器进程到主进程（单向）

      要将单向 IPC 消息从渲染器发送到主进程，您可以使用`ipcRenderer.send`API 发送消息，然后使用`ipcMain.on`API 接收

      通常使用此模式从 Web 内容调用主进程 API。

      示例：修改窗口标题

      1. 在`main.js`中使用`ipcMain.on`监听事件，
      2. 在`preload.js`中暴露`ipcRenderer.send`API，挂载到`exposeInMainWorld`上
      3. 在`renderder.js`中调用`window.xxx`

   2. 模式 2：渲染器进程到主进程（双向）

      双向 IPC 的一个常见应用是从渲染器进程代码调用主进程模块并等待结果

      这可以通过将`ipcRenderer.invoke`与`ipcMain.handle`搭配使用来完成

      示例：从渲染器打开一个原生的文件对话框，并返回所选文件的路径

      在住进程中，创建一个`handleFileOpen()`函数，它调用`dialog.showOpenDialog()`，然后返回用户选择的路径。每当渲染器进程通过`dialog:openFile`通道发送`ipcRenderer.invoke`消息时，此函数被用作一个回调。然后返回值作为一个`Promise`被返回到最初的`ipcRenderer.invoke`调用

      > 关于通道名称
      >
      > IPC 通道名称上的`dialog:`前缀对代码没有影响。它仅用作命名空间以帮助提高代码的可读性

      1. 在`main.js`中使用`ipcMain.handle`监听事件，
      2. 在`preload.js`中暴露`ipcRenderer.invoke`API，挂载到`exposeInMainWorld`上
      3. 在`renderder.js`中调用`window.xxx`

   3. 模式 3：主进程到渲染器进程（单向）

      将消息从主进程发送到渲染器进程，需要指定是哪一个渲染器接收消息。消息需要通过其`WebContents`实例发送到渲染器进程。此`WebContents`实例包含一个`send`方法，其使用方式与`ipcRenderer.send`相同

      示例：构建一个由原生操作系统菜单控制的数字计算器

      1. 在`main.js`中，使用`Menu`模块在主进程中构建一个自定义菜单，该模块使用`webContents.send`API将IPC消息从主进程发送到目标渲染器
      2. 在`preload.js`中暴露`onUpdateCounter`方法
      3. 在`renderer.js`中调用`window.electronAPI.onUpdateCounter`获取到值

   4. 模式4：渲染器进程到渲染器进程

      没有直接的方法可以使用`ipcMain`和`ipcRenderer`模块在Electron中的渲染器进程之间发送消息

      为此，您可以有两种选择

      1. 将主进程作为渲染器之间的消息代理。这需要将消息从一个渲染器发送到主进程，然后主进程将消息发送到另一个渲染器
      2. 从主进程讲一个`MessagePort`传递到两个渲染器，这将允许在初始设置后渲染器之间直接进行通信

3. 对象序列化

   Electron的IPC实现使用HTML标准的`结构化克隆算法`来序列化进程之间传递的对象，这意味着只有某些类型的对象可以通过IPC通道传递

   特别是DOM对象（例如`Element、Location和DOMMatrix`），Nodejs中由C++类支持的对象（例如`process.env、Stream的一些成员`）和Electron中由C++类支持的对象（例如`WebContents、BrowserWindow和WebFrame`）无法使用结构化克隆序列化

#### 进程沙盒化

Chromium的一个关键安全特性是，进程可以在沙盒中执行。沙盒通过限制对大多数系统资源的访问来减少恶意代码可能造成的伤害。沙盒化的进程只能自由使用CPU周期和内存。为了执行需要额外权限的操作，沙盒处的进程通过专用通信渠道将任务下发给更大权限的进程。

在Chromium中，沙盒化应用于主进程以外的大多数进程。其中包括渲染器进程，以及功能性进程，如音频服务、GPU服务和网络服务。

从Electron20开始，渲染进程默认启用了沙盒，无需进一步配置。

1. Electron中的沙盒行为

   在Electron中沙盒进程大部分的表现都与Chromium差不多，但因为介面是Nodejs的关系，Electron有一些额外的概念需要考虑

   1. 渲染器进程

      当Electron中的渲染进程被沙盒化时，他们的行为与常规Chrome渲染器一样，一个沙盒化的渲染器不会有一个Nodejs环境

      因此，在沙盒中，渲染进程只能透过进程间通讯（IPC）委派任务给主进程的方式，来执行需要权限的任务（例如文件系统交互、对系统进行更改或生成子进程）

   2. Preload脚本

      为了让渲染进程能与主进程通信，附属于沙盒化的渲染进程的preload脚本中仍可使用一部分以Polyfill（用以为旧浏览器提供他没有原生支持的较新的功能）形式实现的Nodejs API。有一个与Node中类似的`require`函数提供了出来，但只能载入Electron和Node内置模块的一个子集

      1. electron（以下是渲染进程的模块：`contextBridge`,`crashReporter`,`ipRenderer`,`nativeImage`,`webFrame`,`webUtils`）
      2. events
      3. timers
      4. url

      Nodejs中的import方法也是被支持的

      1. events
      2. timers
      3. url

      此外，以下Nodejs基础对象也填充到了preload脚本的全局上下文中

      1. Buffer
      2. process
      3. clearImmediate
      4. setImmediate

      require函数只是一个功能有限的Polyfill实现，并不支持把preload脚本拆成多个文件然后作为`CommonJS模块`来加载。若需要拆分preload脚本的代码，可以使用webpack或Parcel等打包工具

      注意，因为preload脚本的运行环境本质上比沙盒化渲染进程拥有更高的权限，除非开启了`contextIsolation`，否则高特权的API仍有可能泄露给渲染进程中不信任的代码

2. 配置沙盒

   对于大多数应用程序来说，沙盒是最佳选择。在与某些 沙盒不兼容的使用情况下（例如，在渲染器中使用原生的Nodejs模块时），可以禁用特定进程的沙盒。但这会带来安全风险，特别是当未受信任的代码或内容存在于未沙盒化的进程中时

   1. 为单个进程禁用沙盒

      在Electron中，可通过在`BrowserWindow`构造函数中使用`sandbox: false`选项来针对每个进程禁用渲染器沙盒

      ```js
      app.whenReady().then(() => {
         const win = new BrowserWindow({
            webPreferences: {
               sandbox: false
            }
         })
         win.loadURL('https://google.com');
      })
      ```

      在渲染器中启用`nodeIntegration`时，沙盒也会被禁用。可以通过在`BrowserWindow`构造函数中添加`nodeIntegration: true`标志来实现

   2. 全局启用沙盒

      你也可以调用`app.enableSandbox`API来强制沙盒化所有渲染器。注意，此API必须在应用的`ready`事件之前调用

      ```js
      app.enableSandbox();
      app.whenReady().then(() => {
         // 因为调用了app.enableSanbox()，所以任何sandbox: false的调用都会被覆盖
         const win = new BrowserWindow();
         win.loadURL('https://google.com');
      })
      ```

   3. 禁用Chromium的沙盒（仅测试）

      你也可以指定`--no-sandbox`命令行参数来完全禁用Chromium的沙盒功能，这会使沙盒对所有进程失效（包括工具进程）。我们强烈建议你只针对测试用途开启测标志，并且永远不会用于生产环境。

      注意：`sandbox: true`选项也会同时禁用渲染进程中的Nodejs环境

3. 渲染不可信任内容的注意事项

   尽管已经有一些成功案例（例如`Breaker浏览器`），但在Electron中渲染不受信任的内容仍有未知的风险。我们的目标是尽可能达到与Chrome中沙盒内容化的内容一样的安全性，但由于一些现实因素还没法做到

   1. 我们不想Chromium团队那样在产品安全方面有专属的资源与专业知识。虽然已经尽可能的继承Chromium的一切，并且尽快响应安全问题，但缺少Chromium可调动的那些资源，我们做不到和他一样安全
   2. Chrome的一些安全特性（例如安全浏览和证书透明度）依赖于中心化授权和专属服务器，这些都超出了Electron项目的目标。因此我们在Electron中禁用了他们，同时也损失了他们带来的安全性
   3. Chromium只有一个，但基于Electron构建的应用却成千上万，并且千差万别。这些差异带来了太多的可能性，很难再各种特殊应用场景下都保证平台的安全
   4. 我们没法向终端用户直接推送安全更新，只能靠应用供应商更新依赖Electron版本，来让更新覆盖到用户

   虽然我们尽可能会将Chromium的安全修复应用到老版本的Electron中，但没法保证每一个修复都能一直过去。为了保证安全，最好的办法还是始终使用最新的稳定版Electron

#### Electron中的消息端口

`[MessagePort][]`是一个允许在不同上下文之间传递消息的Web功能。就像`window.postMessage`，但是在不同的通道上。此文档的目标是描述Electron如何扩展`Channel Messaging model`，并举例说明如何在应用中使用`MessagePorts`

1. 主进程中的MessagePorts

   在渲染器中，`MessagePort`类的行为与他在web上的行为完全一样。但是主进程不是网页（他没有Blink集成），因此他没有`MessagePort`或`MessageChannel`类。为了在主进程中处理`MessagePorts`并与之交互，Electron添加了两个新类：`[MessagePortMain][]`和`[MessageChannelMain][]`。这些行为类似于渲染器中的`analogous`类

   `MessagePort`对象可以在渲染器或主进程中创建，并使用`[ipRenderer.postMessage][]`和`[WebContents.postMessage][]`方法互相传递。请注意，通常的IPC方法，例如`send`和`invoke`不能用来传输`MessagePort`，只有`postMessage`方法可以传输`MessagePort`

   通过主进程传递`MessagePort`，就可以连接两个可能无法通信的页面（例如，由于同源限制）

2. 扩展：close事件

   Electron在`MessagePort`添加了一个在`Web`上不存在的功能，以使`MessagePort`更加好用。这个功能就是`close`事件，在通道另一端关闭时就会触发该事件。端口也可以通过对垃圾回收而隐式关闭

   在渲染进程中，你可以通过将事件分配给`port.onclose`或调用`port.addEventListener('close', ...)`来监听`close`事件。在主进程中，你可以通过调用`port.on('close', ...)`来监听`close`事件

3. 实例使用

   1. 在两个渲染进程之间建立`MessageChannel`

      主进程设置一个`MessageChannel`，然后将每个端口发送给不同的渲染进程。这样可以让渲染进程彼此之间发送消息，而无需使用主进程作为中转

   2. Worker进程

      应用程序有一个作为隐藏窗口存在的`Worker`进程。你希望应用程序能够直接与`Worker`进程通信，而不需要通用主进程进行中继，以避免性能开销

   3. 回复流

      Electron内置IPC方法只支持两种模式：即发即弃（`send`）、请求-响应（`invoke`）。使用`MessageChannels`，你可以实现一个`响应流`，其中耽搁请求可以返回一串数据

   4. 直接在上下文隔离页面的主进程和主世界之间进行通信

      当`[context isolation][]`已启用。IPC消息从主进程发送到渲染器是发送到隔离的世界，而不是发送到主世界。有时候你不希望通过隔离的世界，而是直接向主世界发送消息。

### 一些示例

#### 主题切换

<https://www.electronjs.org/zh/docs/latest/tutorial/dark-mode>

`nativeTheme`可以获取系统主题

#### 设备访问

<https://www.electronjs.org/zh/docs/latest/tutorial/devices>

1. Web Bluetooth：蓝牙设备

2. WebHID：HID设备，例如键盘和游戏机

3. Web Serial API：串口设备，例如USB或蓝牙

4. WebUSB API：USB设备

#### 应用程序内购

<https://www.electronjs.org/zh/docs/latest/tutorial/in-app-purchases>

准备工作

1. 付费应用协议

   需要在`iTunes Connect`签署付费应用协议，并设置您的银行和税务信息

2. 创建您的应用内购买

   需要在`iTunes Connect`中配置您的应用内购买，并包含名称、定价和说明等先洗信息，一突出显示您的应用内购买的功能

3. 变更CFBundleldentifier

   若要在`Electron`开发阶段对应用内购买功能进行测试，您必须在在`node_modules/electron/dist/Electron.app/Contents/Info.plist`路径下修改`CFBunleIdentifier`。您必须使用通过`iTunes Connect`创建的应用的`bundle indentifier`来替换掉`com.github.electron`

#### 键盘快捷键

<https://www.electronjs.org/zh/docs/latest/tutorial/keyboard-shortcuts>

1. 本地快捷键

   应用键盘快捷键仅在应用被聚焦时出发。为了配置本地快捷键，你需要在创建`Menu`模块中的`MenuItem`时指定`accelerator`属性

2. 全局快捷键

   要配置全局快捷键，您需要使用`globalShortcon`模块来检测键盘事件，即使应用程序没有获得焦点

3. 在浏览器窗口内的快捷方式

   1. 使用`web APIs`

      如果您想要在`BrowserWindow`中处理键盘快捷键，你可以在渲染进程中使用`addEventListener() API`来监听`keyup`和`keydown`DOM事件

   2. 拦截主进程中的事件

      在调度页面中的`keydown`和`keyup`事件之前，会发出`before-input-event`事件。她可以用于捕获和处理在菜单不可见的自定义快捷方式

   3. 使用第三方库

      如果你不想手动进行快捷键解析，可以使用一些库来进行高级的按键检测。例如`mousetrap`。


#### 深度链接（Deep Links）

<https://www.electronjs.org/zh/docs/latest/tutorial/launch-app-from-url-in-another-app>

配置Electron应用为`特定协议`的默认处理器。

如何设置您的应用以拦截并处理任意特定协议的URL的点击事件。


#### 桌面快捷启动

<https://www.electronjs.org/zh/docs/latest/tutorial/linux-desktop-actions>

如要创建快捷方式，您需要为添加到快捷菜单的条目提供`Name`和`Exec`属性。`Unity`将在用户点击快捷菜单项后zhixing`Exec`字段定义的命令。

#### Dock

<https://www.electronjs.org/zh/docs/latest/tutorial/macos-dock>

Electron有API来配置`macOS Dock`中的应用程序图标。可以使用APi来创建一个自定义的Dock菜单想，这个API是macOS独占的，但是Electron也会默认使用应用的Dock图标来实现一些可以跨平台的功能，例如`最近文件`和`应用程序进度`

一个自定义的Dock项也普遍适用于那些用户不愿意为之打开整个应用窗口的任务添加快捷方式

要设置您的自定义 dock 菜单，您需要使用 `app.dock.setmenu` API，它仅在 macOS 上可用。


#### 多线程

<https://www.electronjs.org/zh/docs/latest/tutorial/multithreading>

通过`Web Workers`，可以实现用操作系统级别的线程来跑Javascript

1. 多线程的Nodejs

   可以在Electron的Web Workers里使用Nodejs的特性。要用的话，需要把`webPerferences`中`nodeIntegrationInWorker`选项设置为`true`

   `nodeIntegrationInWorker`可以独立于`nodeIntegration`使用，但`sandbox`不能设置为`true`

   注意：此选项在`SharedWorkers`或`Service Workers`中不可用，因为沙盒策略不兼容

2. 可用的API

   Web Workers支持Nodejs的所有哦内置模块

### 开发

#### 辅助功能

1. ASAR Archives

   `ASAR`（Atom Shell Archive Format（`Atom外壳存档格式`））是一种简单的扩展存档格式，他的工作原理是`tar`将所有文件连接在一起而不进行压缩，同时具有随机访问支持

   特征：

   1. 支持随机访问
   2. 使用JSON存储文件信息
   3. 编写解析器非常容易

   提起asar，就应该提起`resources`目录。这个目录是`asar`的主战场，里面会有个`electron.asar`的文件，这个是系统自带的。而如果您的打包命令里面没有指定`asar`参数的话，你的默认代码目录就会是个`app文件夹`，而不是`app.asar`。

   当然你可以使用`asar`命令，把app目录打包成`app.asar`文件，然后删除app目录。但是这样你最终的文件可能无法正常运行。所以还是需要在打包的时候就指定好参数`--asar`，这样就可以生成一个`app.asar`文件了



















## 小技巧

### 打开调试控制台

> cmd + option + I
>
> ctrl + shift + I

## Electron模板

阮一峰推荐：<https://github.com/ruanyf/weekly/issues/4043>

electron-egg：<https://www.kaka996.com/pages/8ef798/#%E4%BD%BF%E7%94%A8%E5%9C%BA%E6%99%AF>

electron-vite-template: <https://github.com/umbrella22/electron-vite-template>

electron-vite-vue: <https://github.com/electron-vite/electron-vite-vue>
> 文档 https://cn.electron-vite.org/guide/introduction

| 特性 | electron-egg | electron-vite-vue | vite-electron-builder | electron-vite-template |
|------|--------------|-------------------|----------------------|----------------------|
| GitHub Stars | 3.8k | 3.1k | 2.1k | 1.2k |
| 最近更新时间 | 2024年3月 | 2024年3月 | 2024年3月 | 2023年12月 |
| 前端框架 | Vue 3/2, React, Angular 都支持 | Vue 3 | Vue 3 | Vue 3 |
| 后端框架 | 基于 Egg.js | 无 | 无 | 无 |
| TypeScript | ✅ | ✅ | ✅ | ✅ |
| 热重载 | ✅ | ✅ | ✅ | ✅ |
| 打包工具 | electron-builder | electron-builder | electron-builder | electron-builder |
| 自动更新 | ✅ | ❌ | ✅ | ✅ |
| 数据库支持 | ✅ (SQLite3) | ❌ | ❌ | ❌ |


## 遇到的问题

### Refused to load the image 'https://xxx.png' because it violates the following Content Security Policy directive: "img-src 'self' data:".

在`index.html`头部设置

```html
<meta 
   http-equiv="Content-Security-Policy" 
   content="default-src 'self' 'unsafe-inline' 'unsafe-eval'; img-src 'self' data: https: http:; media-src 'self' https: http:; connect-src 'self' https: http:;"
>
```