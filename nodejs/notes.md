[toc]

### 基础

#### 回顾 js

1. 为什么 javascript 可以在浏览器中被执行

   > 待执行的 js 代码 => javascript 解析引擎

   不同浏览器的 javascript 解析引擎不一样

   1. chrome => V8（性能最好）
   2. firefox => OdinMonkey（奥丁猴）
   3. safri => JSCore
   4. IE => Chakra（查克拉）

2. 为什么 javascript 可以操作 dom 和 bom

   1. 浏览器提供了 domapi、bomapi、ajaxapi
   2. 可以被 js 代码调用
   3. 然后交给解析引擎执行

3. 浏览器的 javascript 运行环境

   运行环境是指：代码正常运行所需的必要环境

   比如 chrome 浏览器运行环境：

   1. v8 引擎
      > 负责解析 javascript 代码
   2. 内置 api：dom、bom、canvas、ajax、js 内置对象等等
      > 由运行环境提供的特殊接口、只能在所属的运行环境中被调用

4. javascript 能否做后端开发

   需要在 nodejs 的运行环境中可以

#### 初识 nodejs

1. nodejs 是一个基于 chromeV8 引擎的 javascript 运行环境

2. nodejs 的 javascript 运行环境

   1. v8 引擎
   2. 内置 api：fs、path、http、js 内置对象等等

3. nodejs 可以做什么

   只是提供了基础的功能和 api，然而，基于 nodejs 的基础功能，很多强大的工具和框架如雨后春笋，层出不穷

   1. express：可以快速搭建 web 应用
   2. electron：构建跨平台的桌面应用
   3. restify：快速构建 api 接口项目
   4. 读写和操作数据哭、创建实用的命令行工具辅助前端开发

4. 学习路径

   1. 浏览器的 javascript 学习路径

      1. 基础语法
      2. 浏览器内置 api：bom、dom
      3. 第三方库：jquery、react、vue

   2. nodejs 学习路径

      1. 基础语法
      2. nodejs 内置 api：fs、path、http 等
      3. 第三方 api 模块：express、mysql 等

### 内置 api

#### fs 文件系统模块

1. 定义

   nodejs 官方提供的、用来操作文件的模块。它提供了一系列方法和属性，用来满足用户对文件的操作需求

   1. fs.readFile()方法，用来读取指定文件中的内容
   2. fs.writeFile()方法，用来向指定的文件中写入内容

2. 使用

   ```js
   const fs = require("fs");
   ```

3. fs.readFile()

   ```js
   fs.readFile(path[, options], callback);
   ```

   1. path：必须，文件路径
   2. options：指定编码格式（一般用 utf8）
   3. 回调：(err, data)，一般用 err 是否为 null 来判断是否读取成功

   ```js
   fs.readFile('./notes.md', 'utf-8', (err, data) => {
       if (err) {
           console.log('err :>> ', err);
           return "文件读取失败";
       }
       console.log('data :>> ', data);
       reurn "文件读取成功";
   })
   ```

4. fs.writeFile()

   ```js
   fs.writeFile(path, data[, options], callback);
   ```

   1. file: 指定文件路径字符串（如果不存在会自动创建）
   2. data: 写入的内容
   3. options：编码格式（一般用 utf8）
   4. callback：(err)

   ```js
   fs.writeFile("11.txt", "hello", "utf8", (err) => {
     if (err) {
       console.log("err :>> ", err);
       return "文件读取失败";
     }
     return "文件写入成功";
   });
   ```

5. fs 模块-路径动态拼接问题

   背景：在使用 fs 模块操作文件时，如果提供的操作路径是以`./`或`../`开头的相对路径时，很容易出现路径动态拼接错误的问题

   原因：代码在运行的时候，会执行`node命令时所处的目录`，动态拼接出被操作文件的完整路径

   如下代码：代码路径为`/user/local/test.js`，读取的文件在`/user/local/notes.md`，当在`/user/local`执行`node test.js`和在`/user`执行`node local/test.js`效果时是不一样的

   ```js
   fs.readFile("./notes.md", "utf-8", (err, data) => {
     if (err) {
       console.log("err :>> ", err);
       return "文件读取失败";
     }
     console.log("data :>> ", data);
     return "文件读取成功";
   });
   ```

   解决方案

   1. 使用绝对路径：可移植性差，不利于维护
   2. 使用`__dirname`表示当前文件所在的绝对目录

      ```js
      fs.writeFile(__dirname + "/11.txt", "hello", "utf8", (err) => {
        if (err) {
          console.log("err :>> ", err);
          return "文件读取失败";
        }
        return "文件写入成功";
      });
      ```

      延伸：如果想要读取上一层的文件的话，需要使用`path.join`来进行拼接

      ```js
      const path = require("path");
      const fs = require("fs");

      const filePath = path.join(__dirname, "../example.txt");
      fs.readFile(filePath, (err, data) => {
        if (err) throw err;
        console.log(data.toString());
      });
      ```

#### path 路径模块

1. 定义

   nodejs 官方提供的，用来处理路径的模块，提供了一系列的方法和属性，用来满足用户对路径的处理需求

   1. path.join()：用来将多哦哥路径片段拼接成一个完整字符串
   2. path.basename()：用来从路径字符串中，将文件名解析出来

2. 导入

   ```js
   const path = require("path");
   ```

3. path.join()

   ```js
   const pathStr = path.join("a", "/b", "c", "../", "d");
   console.log("pathStr :>> ", pathStr); // pathStr :>>  a/b/d

   const pathStr1 = path.join(__dirname, pathStr, "../f");
   console.log("pathStr1 :>> ", pathStr1); // /Users/xxx/Documents/code/learnningNotes/js/nodejs/testcode/a/b/f
   ```

   参数说明

   1. 可以有多个
   2. 如果是`../`的话会自动去掉最后一个层级
   3. `/a`和`a`拼接效果是一样的

   注意：凡是涉及到路径拼接的操作，都要使用`path.join()`方法进行处理，不要直接使用`+`进行字符串的拼接

4. path.basename()

   ```js
   const filePath = "/user/local/test.txt";
   let fullName = path.basename(filePath);
   console.log("fullName :>> ", fullName); // test.txt
   let nameWithoutExtension = path.basename(filePath, ".txt");
   console.log("nameWithoutExtension :>> ", nameWithoutExtension); // test
   ```

   参数说明

   1. 第一个为文件路径
   2. 第二个可选，为去掉的扩展名

5. path.extname()

   获取路径中的文件扩展名

   > path.extname(path)

   ```js
   const filePath = "/user/local/test.txt";
   let extname = path.extname(filePath);
   console.log("extname :>> ", extname); // .txt
   ```

6. 综合案例：将目录下的 index.html 中的 html、script、style 拆分出来，放到同级下的一个 test 目录中

   步骤分析

   1. 导入需要的模块并创建正则表达式

      ```js
      const path = require("path");
      const fs = require("fs");

      const regStyle = /<style>[\s\S]*<\/style>/;
      const regScript = /<script>[\s\S]*<\/script>/;
      ```

   2. 使用 fs 文件模块读取需要处理的 html 文件

      ```js
      fs.readFile(path.join(__dirname, "index.html"), "utf8", (err, data) => {
        if (err) console.error("读取文件失败：", err.message);

        resolveCSS(data);
        resolveJS(data);
        resolveHTML(data);
      });
      ```

   3. 自定义 resolveCSS 方法

      ```js
      function resolveCSS(data) {
        const r1 = regStyle.exec(data);
        const newCSS = r1[0].replace("<style>", "").replace("</style>", "");
        fs.writeFile(path.join(__dirname, "test/index.css"), newCSS, (err) => {
          if (err) return console.error("写入css文件失败：", err.message);
          console.log("写入css成功");
        });
      }
      ```

   4. 自定义 resolveJS 方法

      ```js
      function resolveJS(data) {
        const r1 = regScript.exec(data);
        const newJS = r1[0].replace("<script>", "").replace("</script>", "");
        fs.writeFile(path.join(__dirname, "test/index.js"), newJS, (err) => {
          if (err) return console.error("写入js文件失败：", err.message);
          console.log("写入js成功");
        });
      }
      ```

   5. 自定义 resolveHTML 方法

      ```js
      function resolveHTML(data) {
        const newHTML = data
          .replace(regStyle, '<link rel="stylesheet" href="./index.css" />')
          .replace(regScript, '<script src="./index.js"></script>');
        fs.writeFile(
          path.join(__dirname, "test/index.html"),
          newHTML,
          (err) => {
            if (err) return console.error("写入html文件失败：", err.message);
            console.log("写入html成功");
          }
        );
      }
      ```

   6. 两个注意点

      1. path.writeFile()方法只能用来写入文件，不能用来创建目录
      2. path.writeFile()方法重复调用，新的内容会覆盖旧的内容

#### http 模块

1. 什么是 http 模块

   客户端：在网络节点中，负责消费资源的电脑。  
   服务器：负责对外提供网络资源的电脑。

   http 模块就是 nodejs 提供的，用来创建 web 服务器的模块。通过 http 模块提供的`http.createServer()`方法，就能方便的把一台普通的电脑，变成一台 web 服务器，从而对外提供 web 资源服务

2. 导入

   ```js
   const http = require("http");
   ```

3. 了解 http 模块的作用

   服务器和普通电脑的区别：服务器上安装了`web服务器软件`，例如 IIS、Apache 等。通过安装这些服务器软件，就能把一台普通的电脑变成一台 web 服务器。

   在 nodejs 中，我们不需要使用 IIS、Apache 等第三方 web 服务器软件，因为我们可以基于 nodejs 提供的 http 模块，通过几行简单的代码，就能轻松的写一个服务器软件，从而对外提供 web 服务。

4. 服务器相关的概念

   1. IP 地址

      1. 就是互联网上每台计算机的唯一地址，因此 IP 地址具有唯一性。
      2. 如果把个人电脑比作一台电话，那么 IP 地址就相当于电话号码。
      3. 只有在知道对方 IP 地址的前提下，才能与对应的电脑之间进行数据通信
      4. IP 地址的格式，通常用`点分十进制`表示成`a.b.c.d`的形式
      5. 其中 a,b,c,d 都是 0-255 之间的十进制整数，例如 192.168.1.1
      6. 互联网中每台 web 服务器，都有自己的 IP 地址
      7. 在开发期间，自己的电脑既可以是一台服务器，也可以是一个客户端，为了方便测试，可以在浏览器中输入 127.0.0.1 这个 IP 地址，就能把自己的电脑当成服务器访问了

   2. 域名和域名服务器

      1. 由于 IP 地址不方便记忆，于是发明了一套字符型的地址方案，就是域名地址
      2. ip 和域名地址是一一对应的关系，这份对应关系存放在一个叫做域名服务器（DNS，Domain name server）的电脑中
      3. 使用者只需通过好记的域名访问对应的服务器即可，对应的转换工作由域名服务器实现
      4. 因此域名服务器就是提供 IP 地址和域名之间转换服务的服务器
      5. 在开发测试期间，127.0.0.1 对应的域名是 localhost，使用效果上没有任何区别

   3. 端口号

      1. 计算机的端口号，就好像是现实生活中的门牌号一样，通过门牌号，外卖小哥可以在整栋大楼的众多房间中，准确的把外卖送到你的手中
      2. 在一台电脑中，可以运行成百上千个 web 服务，每一个 web 服务都对应一个唯一的端口号，客户端发送过来的网络请求，通过端口号，可以被准确的交给对应的 web 服务进行处理
      3. 每个端口号不能同时被多个 web 服务占用
      4. 在实际应用中，url 中的 80 端口可以被省略

5. 创建最基本的 web 服务器

   1. 创建 web 服务器的基本步骤

      1. 导入 http 模块
      2. 创建 web 服务器实例
      3. 为服务器实例绑定 request 事件，监听客户端的请求
      4. 启动服务器

      ```js
      const http = require("http");

      // 创建web服务器实例
      const server = http.createServer();

      // 为服务器实例绑定request事件，监听客户端的请求
      server.on("request", (req, res) => {
        console.log("监听到了request");
        console.log("req :>> ", req);
        console.log("res :>> ", res);
      });

      // 调用服务器实例的`.listen()`方法，即可启动当前的web服务器实例
      server.listen(80, () => {
        console.log("http server running at http://127.0.0.1");
      });
      ```

   2. req 请求对象

      只要服务器接收到了客户端的请求，就会调用通过`server.on()`为服务器绑定的 request 事件处理函数

      如果想要在事件处理函数中，访问与客户端相关的数据或者属性，可以使用如下的方式

      ```js
      server.on("request", (req, res) => {
        console.log("req.url :>> ", req.url);
        console.log("req.method :>> ", req.method);
      });
      ```

   3. res 响应对象

      在服务器的 request 事件处理函数中，如果想访问与服务器相关的数据或属性，可以使用如下的方式

      res.end()方法的作用：向客户端发送指定的内容，并结束这次请求的处理过程

      ```js
      server.on("request", (req, res) => {
        res.end("Hello, world!");
      });
      ```

   4. 解决中文乱码的问题

      当调用`res.end()`向客户端发送中文内容的时候，会出现乱码的问题，此时，需要手动设置内容的编码格式

      如我返回的是`我爱宝宝`，接收到的是`鎴戠埍瀹濆疂`

      需要设置响应头`Content-Type`的值为`text/html;charset=utf-8`

      ```js
      res.setHeader("Content-Type", "text/html;charset=utf-8");
      res.end("我爱宝宝");
      ```

   5. 根据不同的 url 响应不同的 html 内容

      ```js
      server.on("request", (req, res) => {
        const url = req.url;
        let content = "<h1>404 not found</h1>";
        if (url === "/" || url === "/index.html") {
          content = "<h1>首页</h1>";
        } else if (url === "/about.html") {
          content = "<h1>关于页面</h1>";
        }
        res.setHeader("Content-Type", "text/html; charset=utf-8");
        res.end(content);
      });
      ```

   6. 案例：将上面的拆分 index.html 的几个文件返回给客户端

      ```js
      const http = require("http");
      const path = require("path");
      const fs = require("fs");

      const server = http.createServer();

      // 为服务器实例绑定request事件，监听客户端的请求
      server.on("request", (req, res) => {
        console.log("进入了request");
        const url = req.url;
        console.log("url :>> ", url);

        let content = "";
        fs.readFile(path.join(__dirname, "test", url), "utf8", (err, data) => {
          console.log("进入了readFile");
          console.log("data :>> ", data);
          if (err) {
            content = "<h1>404 not found</h1>";
          } else {
            content = data;
          }
          // res.setHeader('Content-Type', 'text/html; charset=utf-8');
          res.end(content);
        });
      });

      // 启动服务器
      // 调用服务器实例的`.listen()`方法，即可启动当前的web服务器实例
      server.listen(80, () => {
        console.log("http server running at http://127.0.0.1");
      });
      ```

### 模块化

#### 基本概念

1. 什么是模块化

   1. 是指解决一个复杂问题时，自顶向下逐层把系统划分成若干模块的过程
   2. 对于整个系统来说，模块是可组合、分解和更换的单元

2. 编程领域的模块化

   遵守固定的规则，把一个大文件拆分成独立相互依赖的多个小模块

   好处

   1. 提高了代码的复用性
   2. 提高了代码的可维护性
   3. 可以实现按需加载

3. 模块化规范

   就是对代码进行拆分和组合时，需要遵守的那些规则

   例如

   1. 使用什么语法格式来引用模块
   2. 在模块中使用什么样的语法格式向外暴露成员

   好处

   1. 降低了沟通成本
   2. 方便了各个模块之间的相互调用

#### nodejs 中的模块化

1. 分类

   1. 内置模块：nodejs 官方提供的（fs,path,http）
   2. 自定义模块：用户创建的每个 js 文件
   3. 第三方模块：第三方开发出来的模块，使用前需要先下载

2. 加载模块

   使用`require()`方法，可以加载需要的模块

   ```js
   // 加载内置模块
   const fs = require("fs");
   // 加载自定义模块（需要指定路径）（可以省略js后缀）
   const custom = require("./custom.js");
   // 加载第三方模块
   const moment = require("moment");
   ```

   注意：使用 require 方法加载其他模块时，会执行被加载模块中的代码

3. 模块作用域

   和函数作用域蕾丝，在自定义模块中定义的变量、方法等成员，只能在当前模块内访问，这种模块级别的访问限制，叫做模块作用域

   ```js
   // customer.js
   const username = "lan";
   function sayHello() {
     console.log("hello：", username);
   }

   // test.js
   const customer = require("./customer.js");
   console.log("customer", customer); // {}
   ```

   好处

   1. 防止了全局变量污染的问题

4. 向外共享模块作用域中的成员

   1. module 对象

      在每个自定义模块中都有一个 module 对象，它里面存储了和当前模块有关的信息

      ```js
      Module {
          id: '.',
          path: '/Users/feng.lan/Documents/code/learnningNotes/js/nodejs/testcode',
          exports: {},
          filename: '/Users/feng.lan/Documents/code/learnningNotes/js/nodejs/testcode/module.js',
          loaded: false,
          children: [
              Module {
                  id: '/Users/feng.lan/Documents/code/learnningNotes/js/nodejs/testcode/customer.js',
                  path: '/Users/feng.lan/Documents/code/learnningNotes/js/nodejs/testcode',
                  exports: {},
                  filename: '/Users/feng.lan/Documents/code/learnningNotes/js/nodejs/testcode/customer.js',
                  loaded: true,
                  children: [],
                  paths: [Array]
              }
          ],
          paths: [
              '/Users/feng.lan/Documents/code/learnningNotes/js/nodejs/testcode/node_modules',
              '/Users/feng.lan/Documents/code/learnningNotes/js/nodejs/node_modules',
              '/Users/feng.lan/Documents/code/learnningNotes/js/node_modules',
              '/Users/feng.lan/Documents/code/learnningNotes/node_modules',
              '/Users/feng.lan/Documents/code/node_modules',
              '/Users/feng.lan/Documents/node_modules',
              '/Users/feng.lan/node_modules',
              '/Users/node_modules',
              '/node_modules'
          ]
      }
      ```

   2. module.exports 对象

      在自定义模块中，可以使用`module.exports`对象，把模块内的成员共享出去，供外界使用

      外界使用`require()`导入自定义的模块时，得到的就是`module.exports`所指的对象

      注意：使用`require()`导入模块时，导入的结果，永远以`module.exports`指向的对象为准

      ```js
      const username = "lan";
      function sayHello() {
        console.log("hello：", username);
      }

      module.exports.nickname = "feng";
      module.exports.printName = function () {
        console.log("printName");
      };

      module.exports = {
        username,
        sayHello,
      };
      ```

   3. exports 对象

      由于 module.exports 单词写起来比较复杂，为了简化向外共享成员的代码，nodejs 提供了 exports 对象，默认情况下，exports 和 module.exports 指向同一个对象

      最终共享的结果，还是以 module.exports 指向的对象为准

   4. exports 和 module.exports 的使用误区

      ```js
      console.log(module.exports === exports); // true
      ```

      关键点：在没有重新改变引用对象的时候，两者相等，但是一旦其中一个改变引用对象之后，就以`module.exports`为准

      时刻谨记，require()模块时，得到的永远是 module.exports 指向的对象

      ```js
      module.exports.username = "lan";
      exports.age = 12;

      // 这种情况下获取到的是 {username: 'lan', age: 12}
      ```

      ```js
      module.exports.username = "lan";

      exports = {
        gender: "男",
        age: 12,
      };

      // 这种情况下获取到的是 {name: 'lan'}
      ```

      ```js
      exports.usename = "lan";

      module.exports = {
        gender: "man",
        age: 12,
      };

      // 这种情况得到的是 {gender: 'man', age: 12}
      ```

5. nodejs 中的模块化规范

   遵循 commonjs 模块化规范，规定了模块的特性和各模块之间如何相互依赖

   1. 每个模块内部，module 变量代表当前模块
   2. module 变量是一个对象，它的 exports 属性（即 module.exports）是对外的接口
   3. 加载某个模块，其实是加载该模块的 module.exports 属性，require()方法用于加载模块

#### 包

1.  什么是包

    nodejs 中的第三方模块有叫做包

2.  包的来源

    由第三方个人或者团队开发出来的，免费供所有人使用

    注意：nodejs 中的包都是免费开源的，不需要付费即可免费下载使用

3.  为什么需要包

    1. 由于 nodejs 内置模块仅提供了一些底层 api，导致基于内置模块进行项目开发时，效率很低
    2. 包是基于内置模块封装出来的，提供了更高级、更方便的 api，极大的提高了开发效率
    3. 包和内置模块之间的关系，类似 jquery 和浏览器内置 api 之间的关系

4.  在哪里下载包

    搜索：网站`https://www.npmjs.com/`，他是全球最大的包共享平台，你可以从这网站上搜索任何你需要的包

    下载：通过`https://registry.npmjs.org/`的服务器，来对外共享所有的包，我们可以从这服务器上下载自己所需要的包

5.  如何下载包

    包管理工具：npm 包管理工具（Node Package Manager），这个工具随着 nodejs 的安装包一起被安装到了用户的电脑上

6.  初次安装包之后多了哪些文件

    1. node_modules：存放所有已安装到项目中的包
    2. package-lock.json：记录 node_modules 目录下每一个包的下载信息（名字、版本号、下载地址）

7.  安装指定版本

    默认情况下，是安装最新版本的，如果需要指定版本，使用`@`

    ```js
    npm i moment@2.22.2
    ```

8.  包的语义化版本规范

    `点分十进制`的形式定义的，总共有 3 位数字，如`2.22.2`

    1. 第一位数字：大版本
    2. 第二位数字：功能版本
    3. 第三位数字：Bug 修复版本

    版本号提升规则：只要前面的版本号增长了，后面的版本号归零

9.  包管理配置文件

    npm 规定：在项目根目录中，必须提供一个叫做`package.json`的包管理配置文件，用来记录与项目有关的一些配置信息，如

    1. 项目名称、版本号、描述等
    2. 项目中用了哪些其他包
    3. 哪些包只在开发期间会用到
    4. 哪些包在开发和部署的时候都会用到

    快速创建`package.json`

    > npm init -y

    注意：上述命令，只能在`英文`目录中运行，所以项目文件夹的名称一定要使用英文命名，不要使用中文，不要出现空格

    dependencies：用来记录安装过哪些包

    devDependencies：只在项目开发阶段会用到，项目上线之后不会用到

        ```js
        npm i webpack -D

        npm install webpack --save--dev
        ```

10. npm 下载速度慢

    1.  原因：默认从国外`https://registry.npmjs.org`服务器进行下载，此时网络数据传输需要经过漫长的海底光缆

    2.  方案：淘宝 npm 镜像服务器

        淘宝在国内搭建了一个服务器，专门把国外官方服务器上的包同步到国内的服务器，然后在国内提供下包的服务，极大的提高了下包的速度

        切换 npm 的下包镜像源

            ```shell
            # 查看当前下包镜像源
            npm config get registry

            # 将下包的镜像源切换为淘宝镜像源
            npm config get registry=https://registry.npm.taobao.org/
            ```

    3.  nrm

        为了方便切换下包的镜像源，我们可以安装 nrm 这个小工具，利用 nrm 提供的终端命令，可以快速查看和切换下包的镜像源

        ```shell
        npm i nrm -g
        nrm ls
        nrm use taobao
        ```

        可能存在的报错

        ```shell
        /opt/homebrew/Cellar/nvm/0.39.1_1/versions/node/v16.18.0/lib/node_modules/nrm/cli.js:9
        const open = require('open');
                    ^

        Error [ERR_REQUIRE_ESM]: require() of ES Module /opt/homebrew/Cellar/nvm/0.39.1_1/versions/node/v16.18.0/lib/node_modules/nrm/node_modules/open/index.js from /opt/homebrew/Cellar/nvm/0.39.1_1/versions/node/v16.18.0/lib/node_modules/nrm/cli.js not supported.
        Instead change the require of index.js in /opt/homebrew/Cellar/nvm/0.39.1_1/versions/node/v16.18.0/lib/node_modules/nrm/cli.js to a dynamic import() which is available in all CommonJS modules.
            at Object.<anonymous> (/opt/homebrew/Cellar/nvm/0.39.1_1/versions/node/v16.18.0/lib/node_modules/nrm/cli.js:9:14) {
        code: 'ERR_REQUIRE_ESM'
        }
        ```

        原因是缺少相应的`open`包

        ```js
        // 这里好像要这个版本才行，我安装最新的版本也没有解决
        npm install -g nrm open@8.4.2 --save
        ```

11. 规范的包结构

    1. 包必须以单独的目录而存在
    2. 包的顶级目录下必须要包含`package.json`这个包管理配置文件
    3. `package.json`中必须包含`name`,`version`,`main`这 3 个属性，代表名字、版本号、入口

12. 开发属于自己的包

    1.  初始化 package.json

        ```js
        {
        "name": "lan-tools",
        "version": "1.0.0",
        "description": "feng.lan测试包",
        "main": "index.js",
        "scripts": {
            "test": "echo \"Error: no test specified\" && exit 1"
        },
        "keywords": ["feng", "lan"],
        "author": "feng.lan",
        "license": "ISC"
        }
        ```

    2.  在 index.js 中初始化自己的代码，并暴露对应的成员

        ```js
        function printInfo() {
          console.log("这里是feng.lan的测试函数");
        }

        function sayHello(name) {
          console.log("hello " + name);
        }

        module.exports = {
          printInfo,
          sayHello,
        };
        ```

    3.  编写包的说明文档

        包根目录中的`README.md`文件

        ```md
        ### 安装

        > npm install lan-tools

        ### 导入

        > const lanTools = require('lan-tools');

        ### 输出信息

        > lanTools.printInfo();

        ### sayHello

        > lanTools.sayHello("feng.lan");
        ```

    4.  发布包

        1.  注册 npm 账号
        2.  终端使用`npm login`命令，依次输入用户名、密码、邮箱、邮箱验证码后，即可登录成功

            存在的问题：在登录的时候需要将包仓库设置为 npm 官方源，因为登陆是根据你这个设置的，否则比如你的是淘宝源，他会提示你正在登陆淘宝源，那你注册的 npm 账号就登陆不上去

                ```shell
                npm WARN adduser `adduser` will be split into `login` and `register` in a future version. `adduser` will become an alias of `register`. `login` (currently an alias) will become its own command.
                npm notice Log in on https://registry.npm.taobao.org/
                ```

        3.  将终端切换到包的根目录之后，运行`npm publish`

    5.  删除已经发布的包

        ```shell
        npm unpublish 包名 --force
        ```

        注意

        1. 只能删除 72 小时内发布的包
        2. 不能 24 小时内不允许重复发布

#### 模块加载机制

1. 优先从缓存中进行加载

   模块在第一次加载之后会被缓存，这也意味着多次调用`require()`不会导致模块的代码被执行多次

   无论是内置模块、用户自定义模块、还是第三方模块，他们都会优先从缓存中加载，从而提高模块的加载效率

2. 内置模块的加载机制

   内置模块的加载优先级最高

   即使自定义模块有同名的`fs`模块，也是加载 nodejs 官方的`fs`模块

3. 自定义模块的加载机制

   必须要以`./`或者`../`开头的路径标志符，如果没有用`./`或者`../`，则 node 会把他当作内置模块或者第三方模块进行加载

   如果省略了文件的扩展名，则 nodejs 会按顺序分别尝试加载一下的文件

   1. 按照`确切的文件名`进行加载
   2. 补全`.js`扩展 ing 进行加载
   3. 补全`.json`扩展名进行加载
   4. 补全`.node`扩展名进行加载
   5. 加载失败，终端报错

4. 第三方模块的加载机制

   nodejs 会从当前模块的父目录开始，尝试从`/node_modules`目录中加载第三方模块

   如果没有找到对应的第三方模块，则移动到再上一层父目录中，进行加载，直到文件系统的根目录

   例如，在`/user/local/project/foo.js`中调用了`require('tools')`，则 nodejs 会按以下顺序进行查找

   1. /user/local/project/node_modules/tools
   2. /user/local/node_modules/tools
   3. /user/node_modules/tools
   4. /node_modules/tools

5. 目录作为模块

   当把目录作为模块标志符，传递给`require()`进行加载的时候，有 3 种加载方式

   1. 在被加载的目录下查找`package.json`，并寻找`main`属性，作为`require()`的入口
   2. 如果上一步没有，则寻找目录下的`index.js`文件
   3. 如果上面两步都失败了，则会在终端报错`Error: Cannot find module 'xxx'`

### express

#### 初始 express

1. 定义

   1. 官方：基于 nodejs 平台，快速、开放、极简的 web 开发框架
   2. 白话：和内置的 http 模块类似，是专门用来创建 web 服务器的
   3. 本质：就是一个 npm 上的第三方包，提供了快速创建 web 服务器的便捷方法

   官网：[https://www.expressjs.com.cn/](https://www.expressjs.com.cn/)

   4. 进一步理解

      内置的 http 内置模块用起来很复杂，开发效率低

      express 是基于内置的 http 模块进一步封装出来的，能够极大的提高开发效率

   5. experss 能做什么

      1. web 网站服务器：专门对外提供 web 网页资源的服务器
      2. api 接口服务器：专门对外提供 api 接口的服务器

2. 安装

   > npm i express`

3. 基本使用

   ```js
   // 导入express
   const express = require("express");
   // 创建web服务器
   const app = express();
   // 启动web服务器
   app.listen(80, () => {
     console.log(
       "express server running at http://127.0.0.1 and listening on 80"
     );
   });
   ```

4. 监听 get、post 请求，并返回响应内容

   ```js
   const express = require("express");

   const app = express();

   app.listen(80, () => {
     console.log(
       "express server running at http://127.0.0.1 and listening on 80"
     );
   });

   app.get("/getMethods", (req, res) => {
     console.log("getMethods");
     res.send({
       type: "get",
       name: "lan",
       age: 12,
     });
   });

   app.post("/postMethods", (req, res) => {
     console.log("postMethods");
     res.send({
       type: "post",
       name: "lan",
       age: 12,
     });
   });
   ```

5. 获取 url 的查询参数

   ```js
   app.get("/getMethods", (req, res) => {
     const params = req.query;
     res.send(params);
   });
   ```

6. 获取 url 中的动态参数

   通过`:`匹配动态参数

   例如接口`/user/:id`用来查询某个用户信息

   ```js
   app.get("/user/:id", (req, res) => {
     const params = req.params;
     res.send(params);
   });

   // 可以多个动态参数拼接
   app.get("/user/:id/:username", (req, res) => {
     const params = req.params;
     res.send(params);
   });
   ```

#### 托管静态资源

1.  express.static()

    express 提供了一个非常好用的函数，叫做`express.statis()`，通过它，我们可以非常方便的创建一个静态资源服务器，例如，通过如下代码就可以将`pulbic`目录下的图片、css 文件、js 文件对外开放访问了

        ```js
        // 目录位置相对于根目录
        app.use(express.static('public'));

        // url访问方式 public/demo.js
        // http://127.0.0.1/demo.js
        ```

2.  托管多个静态资源目录，请多次调用即可

    ```js
    app.use(express.static("public"));
    app.use(express.static("static"));
    ```

3.  挂载路径前缀

    如果希望访问静态资源之前，加上路径前缀

        ```js
        app.use('/public', express.static('public'));
        ```

    注意：`/public`的`/`不可少

#### nodemon

1. 作用

   在编写调试 nodejs 项目的时候，如果修改了项目的代码，则需要频繁的手动 close 掉，然后再重新启动，非常繁琐

   nodemon 能够监听项目文件的改动，当代吗被修改后，会自动重新启动项目

2. 安装

   ```js
   npm install -g nodemon
   ```

3. 使用

   启动命令从`node index.js`改为`nodemon index.js`

#### 路由

1. 概念

   指的是`客户端的请求`和`服务器处理函数`之间的`映射关系`

   由 3 部分组成，请求的类型、请求的 url 地址、处理函数

   ```js
   app.METHOD(PATH, HANDLER);

   app.get("/", () => console.log("get请求"));
   app.post("/", () => console.log("post请求"));
   ```

2. 路由匹配过程

   每当一个请求到达服务器以后，需要先经过路由匹配，只有匹配成功之后，才会调用对应的处理函数

   1. 按照定义的`先后顺序`进行匹配
   2. `请求类型`和`请求的url`需要`同时匹配`成功，才会调用对应的处理函数

3. 最简单的路由

   直接挂载在`app`上

   ```js
   app.get("/", () => console.log("get请求"));
   app.post("/", () => console.log("post请求"));
   ```

4. 路由模块化

   为了方便对路由进行模块化的管理，`不建议直接将路由挂载到app上`，而是`推荐将路由抽离为单独的模块`

   1. 创建路由模块对应的`./js`文件
   2. 调用`express.Router()`函数创建路由对象
   3. 向路由对象上挂载具体的路由
   4. 使用`module.exports()`向外共享路由对象
   5. 使用`app.use()`函数注册路由模块

   ```js
   // router.js
   const express = require("express");
   // 创建路由对象
   const router = express.Router();

   // 挂载路由
   router.get("/user/list", (req, res) => {
     res.send("get user list");
   });
   router.post("/user/add", (req, res) => {
     res.send("add new user");
   });

   // 向外导出路由对象
   module.exports = router;
   ```

   ```js
   const express = require("express");
   const router = require("./router.js");

   const app = express();

   // 注册路由模块，全剧中间件
   app.use(router);

   app.listen(80, () => {
     console.log(
       "express server running at http://127.0.0.1 and listening on 80"
     );
   });
   ```

5. 为路由添加前缀

   ```js
   app.use("/api", router);
   ```

#### 中间件

1.  定义

    当一个请求到达 express 服务器之后，可以连续调用多个中间件，从而对这次请求进行`预处理`

    本质上是一个`处理函数`，中间件的`格式`如下

        ```js
        app.get('/', (req, res, next) => {
            /* some code */
            next();
        })
        ```

    注意：中间件函数的形参列表，必须包含`next参数`，而路由处理参数只包含 req 和 res

2.  next 函数的作用

    是实现`多个中间件连续调用`的关键，它表示把流转关系`转交`给下一个中间件或路由

3.  定义中间件函数

    ```js
    const express = require("express");
    const router = require("./router.js");

    const app = express();

    const mw = (req, res, next) => {
      console.log("最简单的中间件");
      next();
    };

    // 全局生效的中间件
    app.use(mw);

    app.use("/api", router);

    app.listen(80, () => {
      console.log(
        "express server running at http://127.0.0.1 and listening on 80"
      );
    });
    ```

4.  全局生效的中间件

    客户端发起的`任何请求`，到达服务器之后，`都会触发`的中间件

    通过`app.use(wm)`，即可定义一个全局生效的中间件

        ```js
        app.use(mw);
        ```

    定义多个全局中间件，客户端请求到达服务器之后，会按照中间件定义的先后顺序依次进行调用

        ```js
        app.use((req, res, next) => {
            console.log('调用了第一个中间件');
            next();
        })

        app.use((req, res, next) => {
            console.log('调用了第二个中间件');
            next();
        })
        ```

    作用

    1. 多个中间件之间，共享同一份 res 和 req
    2. 基于这个特性，我们可以在上游的中间件中，统一为 req 和 res 对象添加自定义的属性或方法，供下游的中间件或者路由进行使用

5.  局部生效的中间件

    不使用`app.use()`定义的中间件

        ```js
        const mw = (req, res, next) => {
            console.log('局部生效的中间件');
            next();
        }

        // 挂载路由
        router.get('/user/list', mw, (req, res) => {
            console.log('startTime', req.startTime)
            res.send({
                txt: 'get user list',
                date: req.startTime
            });
        })
        ```

    定义多个局部中间件

        ```js

        // 方式一：使用数组
        router.get('/user/list', [mw1, mw2, mw3], (req, res) => {})
        // 方式二：多个参数
        router.get('/user/list', mw1, mw2, mw3, (req, res) => {})
        ```

6.  几个注意事项

    1. 一定要在路由之前注册中间件（错误级别中间件必须在所有路由之后）
    2. 客户端发送过来的请求，可以连续调用多个中间件进行处理
    3. 一定要在处理函数中调用`next()`
    4. 为了防止代码逻辑混乱，调用`next()`函数之后不要再写额外的代码
    5. 连续调用多个中间件时，多个中间件之间，共享 req 和 res 对象

7.  中间件的分类

    1.  应用级别的中间件

        通过`app.use()`、`app.get()`或`app.post()`，绑定到 app 实例上的中间件

    2.  路由级别的中间件

        绑定到`express.Router()`实例上的中间件

        用法和应用级别的中间件没有任何区别，只不过`应用级别是绑定到app实例上`，`路由级别是绑定到router实例上`

    3.  错误级别的中间件

        专门用来捕获项目中发生的异常错误，从而防止项目异常崩溃的问题

        格式：必须有 4 个形参（err, req, res, next）

            ```js
            const express = require('express');
            const app = express();

            const mw = (err, req, res, next) => {
                console.log('发生了错误', err.message);
                res.send({
                    code: 500,
                    msg: err.message
                })
            }

            app.use('/user/list', (req, res) => {
                throw new Error('服务器错误了');
                res.send('data');
            });

            app.use(mw);

            app.listen(80, () => {
                console.log('express server running at http://127.0.0.1 and listening on 80')
            })
            ```

        `必须要在所有路由之后`

    4.  express 内置的中间件

        从 express4.16.0 版本开始，内置了`3个`常用的中间件

        1. express.static 快速托管静态资源的内置中间件，例如 html 文件、图片等（`完全兼容`）
        2. express.json 解析 json 格式的请求提数据（`4.16.0+`）
        3. express.urlencoded 解析 URL-encoded 格式的请求提数据（`4.16.0+`）

           默认情况下，如果不配置解析表单数据的中间件，则`req.body`默认等于 undefined

           ```js
           // 配置解析application/json格式数据的内置中间件
           app.use(express.json());
           // 配置解析 application/x-www-form-urlencoded 格式数据的内置中间件
           app.use(express.urlencoded({ extended: false }));
           ```

    5.  第三方的中间件

        非 nodejs 官方内置的，而是由第三方开发出来的中间件

        比如`body-parser`这个中间件

        1. `npm install body-parser`
        2. `require`进行导入
        3. `app.use()`注册并使用

        解析 form-data 中的数据中间件

        ```js
        const multipart = require("connect-multiparty");
        const multipartMiddleware = multipart();
        app.use(multipartMiddleware);

        app.post("/api/login", (req, res) => {
          const data = req.body;
          res.send(data);
        });
        ```

8.  自定义中间件实现

    描述：手动模拟一个类似 express.urlencoded，来解析 post 提交到服务器的表单数据

    实现步骤

    1. 定义中间件
    2. 监听 req 的 data 事件

       如果数据量比较大，无法一次性发送完毕，则客户端会把数据切割后，分批发送到服务器，所以 data 事件可能会触发多次，每一次触发 data 事件时，只是完整数据的一部分，需要手动对接收到的数据进行拼接

    3. 监听 req 的 end 事件

       当请求体数据接收完毕之后，会自动触发 req 的 end 事件

    4. 使用 querystring 模块解析请求体数据

       nodejs 内置了一个`querystring`模块，专门用来`处理查询字符串`，这个模块的`parse()`函数，可以轻松把查询字符串解析成对象的格式

    5. 将解析出来的数据对象挂载为 req.body
    6. 将自定义的中间件封装为模块

       ```js
       app.use((req, res, next) => {
         console.log("进入了自定义中间件");
         let str = "";
         req.on("data", (chunk) => {
           console.log("chunk :>> ", chunk);
           str += chunk;
         });
         req.on("end", () => {
           console.log("完整数据", str);
           const data = qs.parse(str);
           console.log("data :>> ", data);
           req.body = data;
           next();
         });
       });
       ```

9.  使用 express 写接口

    1. get 接口

       ```js
       router.get("/user/list", (req, res) => {
         res.send({
           status: 200,
           data: req.query,
           msg: "GET 请求成功",
         });
       });
       ```

    2. post 接口

       ```js
       router.post("/user/add", (req, res) => {
         res.send({
           status: 200,
           data: req.body,
           msg: "POST 请求成功",
         });
       });
       ```

#### cors 跨域资源共享

1.  背景
    上面的 get 和 post 接口，`不支持跨域请求`

    解决方案主要由 2 种

    1. cors（主流的方案，推荐使用）
    2. jsonp（只支持 get）

    使用 cors 中间件

        ```js
        const cors = require('cors');
        app.use(cors());
        ```

2.  限制

    1.  在服务端进行配置，客户端浏览器无需做任何额外的配置，即可请求开启了 cors 的接口
    2.  在浏览器有兼容性，只有支持`XMLHttpRequest Level2`的浏览器才能用 cors（IE10+，Chrome4+，FireFox3.5+）

    3.  Access-Control-Allow-Origin

        ```js
        // 请求头
        Access-Control-Allow-Origin: <origin> | *

        // 实际设置
        res.setHeader('Access-Control-Allow-Origin', '*');
        ```

    4.  Access-Control-Allow-Headers

        默认情况下，cors 仅支持客户端向服务器发送如下的 9 个请求头

        1. Accept
        2. Accept-Language
        3. Content-Language
        4. DPR
        5. Downlink
        6. Save-Data
        7. Viewport-Width
        8. Width
        9. Content-Type（值仅限于 text/plain、multipart/form-data、application/x-www-form-urlencoded 三者之一）

        如果客户端向服务端发送了额外的请求头信息，则需要在服务器端，通过`Access-Control-Headers`对额外的请求头进行`声明`，否则这次请求会失败

            ```js
            // 多个请求头之间使用英文的逗号进行分割
            res.setHeader('Access-Control-Allow-Headers', 'Content-Type, X-Custom-Header');
            ```

    5.  Access-Control-Allow-Methods

        默认情况下，cors 仅支持客户端发起 get、post、head 请求

        如果客户端希望通过 put、delete 等方式请求服务器的资源，则需要在服务端，通过`Access-Control-Allow-Methods`来指明实际请求所允许使用的 http 方法

            ```js
            res.setHeader('Access-Control-Allow-Methods', 'GET POST DELETE HEAD');
            res.setHeader('Access-Control-Allow-Headers', '*');
            ```

3.  简单请求

    同时满足下面 2 个条件的请求，就是简单请求

    1. 请求方式：GET、POST、HEAD 之一
    2. http 头部信息 u 超过以下几个字段（`无自定义头部字段`）
       1. Accept
       2. Accept-Language
       3. Content-Language
       4. DPR
       5. Downlink
       6. Save-Data
       7. Viewport-Width
       8. Width
       9. Content-Type（值仅限于 text/plain、multipart/form-data、application/x-www-form-urlencoded 三者之一）

4.  预检请求

    只要符合下面任何一个条件的请求，都需要进行预检请求

    1. 请求方式为 GET、POST、HEAD`之外`的请求
    2. 请求头包含`自定义头部`字段
    3. 向服务器发送了`application/json`格式的数据

    在浏览器和服务器正式通信之前，浏览器会先发送`OPTION`请求进行预检，以获取服务器是否允许该实际请求，所以这一次的`OPTION`请求称为预检请求，`服务器成功响应预检请求之后`，才会发送真正的请求，并且携带真实数据

5.  jsonp

    概念：浏览器端通过`<script>`标签的`src`属性，请求服务器上的数据，同时，服务器返回一个函数的调用，这种请求数据的方式叫做 jsonp

    特点：

    1. jsonp 不属于真正的 ajax 请求，因为他没有使用 XMLHttpRequest 这个对象
    2. jsonp 仅支持 GET 请求，不支持 POST、PUT、DELETE 等请求

    ```js
    // 必须要cors中间件之前，配置jsonp接口
    app.get("/api/jsonp", (req, res) => {
      // 1. 获取客户端发送过来的回调函数的ing子
      const callback = req.query.callback;
      // 2. 得到要通过jsonp形式发送给客户端的数据
      const data = {
        name: "lan",
        age: 12,
      };
      // 3. 根据前两步得到的数据，拼接出一个函数调用的字符串
      const str = `${callback}(${JSON.stringify(data)})`;
      // 4. 把上一步拼接得到的字符串，响应给客户端的script标签进行解析
      res.send(str);
    });
    ```

    ```js
    function jsonpHandle() {
      $.ajax({
        url: "http://127.0.0.1/api/jsonp",
        dataType: "jsonp",
        jsonpCallback: "myCallback",
        success: function (data) {
          console.log(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        },
      });
    }
    function myCallback(data) {
      console.log("执行了myCallback", data);
    }
    ```

### 数据库与身份认证

#### 数据库基本概念

1. 定义

   用来组织、存储、管理数据的仓库

   可以对数据库的数据进行增删改查操作

2. 常见的数据库及分类

   1. MySql：适用范围最广、流行度最高（免费版 + 收费版）
   2. Oracle：收费
   3. SQL Server：收费
   4. Mongodb：免费版 + 收费版

   关系型数据库：MySql、Oracle、SQL Server

   非关系型数据库：Mongodb

3. 传统型数据库的数据组织结构

   1. 数据库
   2. 数据表
   3. 数据行
   4. 字段

   关系

   1. 实际项目开发中，一般情况下，每个项目都对应独立的数据库
   2. 不同的数据要存储到不同的表中
   3. 每个表具体存储哪些信息，由字段来决定
   4. 表中的行，代表每一条具体的数据

#### 安装并配置 MySql

1. 需要的软件

   1. MySql Server：专门用来提供数据存储和服务的软件
   2. Navicat：可视化的 MySql 管理工具

2. 安装 mysql 和 navicat

   mysql：[https://blog.csdn.net/weixin_44427181/article/details/127552892](https://blog.csdn.net/weixin_44427181/article/details/127552892)

   > mysql -uroot -p

   navicat：

   1. 下载：[https://www.jb51.net/softs/805270.html#downintro2](https://www.jb51.net/softs/805270.html#downintro2)
   2. 教程：[https://www.cnblogs.com/fdw630/p/16956894.html](https://www.cnblogs.com/fdw630/p/16956894.html)

   使用 navicat 连接数据库遇到错误

   1. 1045 - Access denied for user 'root'@'localhost' (using password: YES)

      参考：[https://zhuanlan.zhihu.com/p/158806221](https://zhuanlan.zhihu.com/p/158806221)

   2. mac 2002 - Can't connect to server on '127.0.0.1' (36)

      这个我重新启动电脑就好了。。。

3. 最基本的数据库命令

   ```js
   // 登陆数据库
   mysql -u root -p
   // 显示数据库
   show databases;
   // 创建数据库
   create database MyDB_one;
   // 设置编码
   create database MyDB_three charset utf8;
   // 查看数据库信息
   show create database MyDB_one;
   // 进入或者切换数据库
   use MyDB_one
   // 显示表
   show tables;
   // 创建表
   create table Phone_table(pid INT, name CHAR(20), price INT);
   // 增加字段
   alter table Phone_table add color CHAR(20);
   ```

4. express 中 mysql 模块安装和配置

   ```shell
   npm install mysql
   ```

   ```js
   // 1. 导入mysql模块
   const mysql = require("mysql");
   // 2. 建立与mysql数据库的连接
   const db = mysql.createPool({
     host: "127.0.0.1",
     user: "root",
     port: 3306,
     password: "feng.lan",
     database: "user",
   });

   db.query("select * from user", (err, res) => {
     if (err) return console.error("err----", err);
     console.log("res-----", res);
   });
   ```

#### mysql 常用操作

    ```js
    // 查询
    db.query('select * from user', (err, res) => {
        if (err) return console.error('err----', err.message);
        console.log('res-----', res);
    })

    const user = {
        name: '王五',
        age: 15
    }
    // 插入（按字段插入）
    const sqlStr = 'INSERT INTO user (name, age) VALUES (?, ?)';
    db.query(sqlStr, [user.name, user.age], (err, res) => {
        if (err) return console.error('err----', err.message);
        if (res.affectedRows === 1) {
            console.log('插入数据成功', res);
        }
    })
    // 插入（按行插入）需要对象的每个属性和字段一一对应
    const sqlStr1 = 'INSERT INTO user SET ?';
    db.query(sqlStr1, user, (err, res) => {
        if (err) return console.error('err----', err.message);
        if (res.affectedRows === 1) {
            console.log('插入数据成功', res);
        }
    })

    // 更新
    const user = {
        id: 1,
        name: '张三一',
        age: 1
    }
    const sqlStr = 'UPDATE user SET name = ?, age = ? WHERE id = ?';
    db.query(sqlStr, [user.name, user.age, user.id], (err, res) => {
        if (err) return console.error('err----', err.message);
        if (res.affectedRows === 1) {
            console.log('更新数据成功', res);
        }
    })
    // 快捷更新
    const sqlStr1 = 'UPDATE user SET ? WHERE id = ?';
    db.query(sqlStr1, [user, user.id], (err, res) => {
        if (err) return console.error('err----', err.message);
        if (res.affectedRows === 1) {
            console.log('更新数据成功', res);
        }
    })

    // 删除
    const sqlStr = 'DELETE FROM user WHERE id = ?';
    db.query(sqlStr, 1, (err, res) => {
        if (err) return console.error('err----', err.message);
        if (res.affectedRows === 1) {
            console.log('删除数据成功', res);
        }
    })
    ```

#### 前后端的身份认证

1. web 开发模式

   1. 服务端渲染

      服务器发送给客户端的 html 页面，是在服务器通过字符串的拼接，动态生成的

      因此客户端不需要 ajax 这样的技术额外请求页面的数据

      ```js
      app.get("/index.html", (req, res) => {
        const user = {
          name: "zhangsan",
          age: 12,
        };
        const html = `<h1>姓名：${user.name}，年龄：${user.age}</h1>`;
        res.send(html);
      });
      ```

      优点

      1. `前端耗时少`：因为服务器负责动态生成 html 内容，浏览器只要直接渲染页面即可，尤其是移动端，更省电
      2. `有利于seo`：因为服务器响应的是完整的 html 内容，所以爬虫更容易获取信息

      缺点

      1. `占用服务器资源`：如果请求较多，会对服务器造成一定的访问压力
      2. `不利于前后端分离，开发效率低`：使用服务端渲染，无法进行分工合作，尤其前端复杂度高的项目

   2. 前后端分离的 web 开发模式

      后端只负责提供 api 接口，前端使用 ajax 调用接口的开发模式

      优点

      1. `开发体验好`：前端专注 ui，后端专注 api
      2. `用户体验好`：可以轻松实现页面的局部刷新
      3. `减轻了服务端渲染的压力`：因为最终的页面都是在浏览器中生成的

      缺点

      1. `不利于SEO`：因为完整的 html 页面需要在客户端动态拼接完成，所以爬虫对无法爬取页面有效信息

         解决方案：利用 Vue、React 等前端框架的`SSR`能够很好的解决 SEO 的问题

   3. 如何选择开发模式

      比如企业级网站，主要是展示，没有复杂的交互，并且需要良好的 SEO，就需要服务端渲染

      类似后台管理项目，交互性比较强，不需要考虑 SEO，就可以使用前后端分离的开发模式

2. 身份认证

   1. 定义

      又称“身份验证”、“鉴权”，是通过一定手段，完成对用户的身份认证

   2. 为什么需要身份认证

      为了确认当前使用的用户，是该系统的用户

   3. 不同开发模式的身份认证

      1. 服务端渲染使用`Session认证机制`
      2. 前后端分离使用`JWT认证机制`

3. Session 认证机制

   1. http 协议的无状态性

      指的是客户端的`每次http请求都是独立的`，连续多个请求之间没有直接关系，`服务器不会主动保留每次http请求的状态`

   2. Cookie

      1. 是存储在用户浏览器中的一段不超过`4kb`的字符串
      2. 是 key-value 的形式
      3. 还有其他几个用户控制 cookie 有效期、安全性、适用范围的可选属性组成
      4. 不同域名的 Cookie 各自独立
      5. 每当客户端发起请求时，会`自动`把`当前域名`下的`所有未过期`的 cookie 一同发送到服务器

      总结特性：自动发送、域名独立、过期时限、4KB 限制

   3. Cookie 在身份认证中的作用

      客户端`第一次`请求服务器的时候，服务器通过`响应头`的形式，向客户端发送一个身份认证的 Cookie，客户端会自动将 Cookie 保存在浏览器中

      之后，当客户端浏览器`每次请求服务器`的时候，浏览器会自动将身份认证相关的 cookie，通过`请求头`的形式发送给服务器，服务器就可以检验客户端的身份了

   4. Cookie 不具有安全性

      由于 cookie 时存储在浏览器中的，而且浏览器也提供了读写 Cookie 的 api，因此 cookie 很容易被伪造

      因此不建议服务器将重要的隐私数据（比如用户信息、密码等），通过 cookie 的形式发送给浏览器

   5. Session 工作原理

      1. 客户端登录：提交账号密码
      2. 服务端验证账号密码，将登录成功后的用户信息存储在服务器的内存中，同时生成对应的 cookie 字符串
      3. 服务端将生成的 cookie 返回给客户端
      4. 客户端将 cookie 自动存储在当前域名下
      5. 客户端再次发起请求时，通过请求头将当前域名下所有 cookie 发送给服务器
      6. 服务器根据请求头中的 cookie，从内存中查找对应的用户信息
      7. 用户身份认证成功后，服务器将当前用户生成的特定响应内容返回给浏览器

4. 在 Express 中使用 Session 认证

   1. 安装 express-session 中间件

      ```js
      npm install express-session
      ```

   2. 向 Session 中存数据

      ```js
      const session = require("express-session");
      const express = require("express");

      const app = express();

      // 配置Session
      app.use(
        session({
          secret: "secret", // 属性值可以为任意字符串
          resave: false, // 固定写法
          saveUninitialized: true, // 固定写法
        })
      );

      // 配置解析application/json格式数据的内置中间件
      app.use(express.json());
      // 配置解析 application/x-www-form-urlencoded 格式数据的内置中间件
      app.use(express.urlencoded({ extended: false }));

      // 登陆接口
      app.post("/api/login", (req, res) => {
        console.log("res.body :>> ", res.body);
        // 判断用户信息是否正确
        if (req.body.username !== "lan" || req.body.password !== "1234") {
          return res.send({
            code: 500,
            msg: "登录失败",
          });
        }
        // 存储用户信息
        req.session.user = req.body;
        req.session.isLogin = true;

        res.send({
          code: 200,
          msg: "登陆成功",
        });
      });

      app.listen(80, () => {
        console.log(
          "express server running at http://127.0.0.1 and listening on 80"
        );
      });
      ```

   3. 从 session 中取数据

      ```js
      // 获取用户姓名接口
      app.get("/api/getUserName", (req, res) => {
        // 判断用户是否登陆
        if (!req.session.isLogin) {
          return res.send({
            code: 500,
            msg: "用户未登录",
          });
        }
        res.send({
          code: 200,
          data: req.session.user.username,
          msg: "success",
        });
      });
      ```

   4. 清空 session

      ```js
      // 退出登录接口
      app.post("/api/logout", (req, res) => {
        req.session.destroy();
        res.send({
          code: 200,
          msg: "退出登录成功",
        });
      });
      ```

5. JWT 认证机制

   1. Session 认证的局限性

      Session 认证`需要配合Cookie`才能实现，由于 Cookie 默认不支持跨域访问，所以当涉及到`前端跨域请求`后端接口的时候，`需要做很多额外配置`，才能实现 Session 认证

      1. 当前端请求后端接口不存在跨域问题的时候，推荐使用 Session 身份认证
      2. 当前端需要跨域请求后端接口时候，不推荐使用 Session 身份认证机制，推荐使用 JWT 认证机制

   2. 什么是 JWT（JSON Web Token）

      是目前最流行的跨域解决方案

   3. 工作原理

      1. 客户端登录提交账号密码
      2. 服务端验证账号密码
      3. 服务端验证通过之后，将用户信息对象经过加密之后生成 Token 字符串
      4. 服务端将生成的 Token 返回给客户端
      5. 客户端将 Token 存储到 localStorage 或者 sessionStorage
      6. 客户端再次请求的时候，通过请求头的 Authorization，将 Token 发送给服务器
      7. 服务器把 Token 字符串还原成用户的信息对象
      8. 用户身份认证成功之后，服务器针对当前用户生成的特定响应内容，返回给浏览器

      总结：用户的信息通过 Token 字符串的形式，保存在客户端浏览器中，服务端通过还原 Token 字符串的形式来认证用户的身份

   4. JWT 组成部分

      通常由 3 部分组成，3 者之间使用英文的`.`分隔

      1. `Header`（头部）：安全性相关部分
      2. `Payload`（有效荷载）：真正的用户信息部分，是用户信息加密之后的字符串
      3. `Signature`（签名）：安全性相关部分

         ```js
         // 格式
         Header.Payload.Signature

         // 示例
         Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwidXNlcm5hbWUiOiJsYW4iLCJwYXNzd29yZCI6IiIsIm5pY2tuYW1lIjpudWxsLCJlbWFpbCI6bnVsbCwidXNlcl9waWMiOiIiLCJpYXQiOjE2ODEyMTg2OTMsImV4cCI6MTY4MTI1NDY5M30.Q7Bdk1YnqqDiZuyBW-7C5eSAlCRnZZYX0YRvICAG1QI
         ```

   5. JWT 的使用方式

      1. 客户端收到服务器返回的 Token 之后，通常会将它存储在 localSotrage 或者 sessionStorage 中
      2. 之后每次客户端与服务器通信，都要带上这个 Token 字符串，从而进行身份认证
      3. 推荐的做法是把 Token 放在 http 请求头的`Authorization`字段中

      ```js
      Authorization: Bearer <token>
      ```

   6. 在 Express 中使用 JWT

      1. 安装

         ```js
         npm install jsonwebtoken express-jwt
         ```

         1. jsonwebtoken：用于`生成`JWT 字符串
         2. express-jwt：用于将 JWT 字符串`解析`还原成 JSON 对象

      2. 定义 secret 密钥

         为了保证 JWT 字符串的安全性，防止在网络传输过程中被别人破解，需要专门定一个用于`加密`和`解密`的 secret 密钥

         1. 当生成 JWT 字符串的时候，需要使用 secret 密钥对用户信息`进行加密`
         2. 当还原 JWT 字符串的时候，需要使用 secret`进行解密`

         本质就是一个字符串

      3. 定义和使用

         1. 只要配置成功了`express-jwt`这个中间件，就可以把解析出来的用户信息，挂在到`req.user`属性中
         2. `req.user`的内容，是`jwt.sign()`第一个参数存储的对象

      4. 示例代码

         ```js
         const express = require("express");
         const cors = require("cors");
         const multipart = require("connect-multiparty");

         const app = express();
         const multipartMiddleware = multipart();

         const jwt = require("jsonwebtoken");
         const expressJWT = require("express-jwt");

         app.use(cors());
         app.use(multipartMiddleware);

         // 配置解析application/json格式数据的内置中间件
         app.use(express.json());
         // 配置解析 application/x-www-form-urlencoded 格式数据的内置中间件
         app.use(express.urlencoded({ extended: false }));

         // 定义一个secre密钥
         const secretKey = "hello world";
         // expressJWT.expressjwt({ secret: secretKey })是用来解析Token的中间件
         // .unless({ path: [/^\/api\//] })用来指定哪些接口不需要访问权限
         app.use(
           expressJWT
             .expressjwt({ secret: secretKey, algorithms: ["HS256"] })
             .unless({ path: [/^\/api\//] })
         );

         // 用户登录接口
         app.post("/api/login", (req, res) => {
           const userInfo = req.body;
           // 判断用户信息是否正确
           if (userInfo.username !== "lan" || userInfo.password !== "1234") {
             return res.send({
               code: 500,
               msg: "登录失败",
             });
           }

           res.send({
             code: 200,
             // 生成JWT 3个参数分别是：用户信息对象、加密密钥、配置对象
             token: jwt.sign(
               {
                 username: userInfo.username,
               },
               secretKey,
               {
                 expiresIn: "30s",
                 algorithm: "HS256",
               }
             ),
             msg: "登陆成功",
           });
         });

         // 获取用户姓名接口
         app.get("/admin/getUserName", (req, res) => {
           res.send({
             code: 200,
             data: req.auth,
             msg: "success",
           });
         });

         app.listen(80, () => {
           console.log(
             "express server running at http://127.0.0.1 and listening on 80"
           );
         });
         ```

      5. 捕获 JWT 失败后产生的错误

         当使用`express-jwt`解析 Token 字符串时，如果客户端发送过来的 token 字符串过期或者不合法，就会报错，影响项目正常运行

         可以通过 Express 的错误中间件，捕获这个错误并进行处理

         ```js
         // 错误捕获
         app.use((err, req, res, next) => {
           if (err.name === "UnauthorizedEror") {
             return res.send({
               code: 401,
               msg: "无效的token",
             });
           }
           res.send({
             code: 500,
             msg: "未知错误",
           });
         });
         ```

### restful 风格规范

<https://apifox.com/blog/a-cup-of-tea-time-to-understand-restful-api/?utm_source=google_search&utm_medium=g&utm_campaign=15676663585&utm_content=137784982731&utm_term=&gad_source=1&gclid=Cj0KCQjwtsy1BhD7ARIsAHOi4xaxecxWz_-lm6xJr8xrhG5DKXzjnjOKq5jTtEtT1VJ6Yu7mc2fSJ6UaAnE0EALw_wcB>

1. 介绍

   `REST`，全名 `Representational State Transfer` (表现层状态转移)，他是一种设计风格，一种软件架构风格，而不是标准，只是提供了一组设计原则和约束条件。

   `RESTful` 只是转为形容詞，就像那么 `RESTful API` 就是满足 REST 风格的，以此规范设计的 API。

2. 对比

   ```js
   /**
    * 正常接口
    获取用户       GET     /getUser
    新增用户       POST    /createUser
    删除用户       DELETE  /deleteUser/1
    */

   /**
    * restful风格
    获取用户       GET     /users
    新增用户       POST    /users
    删除用户       DELETE  /users/1
    */
   ```

3. 六大原则，具体可以看文章<https://apifox.com/blog/a-cup-of-tea-time-to-understand-restful-api/?utm_source=google_search&utm_medium=g&utm_campaign=15676663585&utm_content=137784982731&utm_term=&gad_source=1&gclid=Cj0KCQjwtsy1BhD7ARIsAHOi4xaxecxWz_-lm6xJr8xrhG5DKXzjnjOKq5jTtEtT1VJ6Yu7mc2fSJ6UaAnE0EALw_wcB#restful-api>

   1. Uniform Interface（统一接口）

      在一个完全遵循 RESTful 的团队里，后端只要告诉前端`/users`这个 api，前端就应该知道

      1. 获取所有用户：`GET /users`
      2. 获取用户详情：`GET /users/${id}`
      3. 创建用户：`/POST /users`
      4. 更新用户：`PUST /users/${id}`
      5. 删除用户：`DELETE /users/${id}`

   2. Client-Server（客户端和服务端分离）
   3. Statelessness（无状态）
   4. Cacheability（可缓存）
   5. Layered System（分层）
   6. Code on Demand（可选的代码请求）

4. http 状态码

   1. 200 OK：请求成功，获得了请求的数据
   2. 201 Created：请求成功，创建了一个新的资源
   3. 204 No Content：请求成功，操作成功，但是没有返回数据
   4. 400 Bad Request：请求失败，请求格式不正确或缺少必要参数
   5. 401 Unauthorized：请求失败，认证失败或缺少授权
   6. 403 Forbidden：请求失败，请求的资源不存在
   7. 500 Internal Server Error：请求失败，服务器内部错误
