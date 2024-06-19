## 相关文档

[官方文档]()
[中文文档](https://www.expressjs.com.cn/)

## 起步

### 安装和启动

```shell
// 创建项目并初始化
mkdir myapp
cd myapp
npm init

npm install express --save
```

hello world 的 demo

使用`node app.js`启动项目，然后访问`localhost:3000`即可

```js
// app.js（如果你的package.json的入口文件是index.js的话改为index.js）
const express = require("express");
const app = express();
const port = 3000;

app.get("/", (req, res) => {
  res.send("Hello World!");
});

app.listen(port, () => {
  console.log(`Example app listening on port ${port}`);
});
```

### Express 应用程序生成器

通过应用生成器工具 `express-generator` 可以快速创建一个应用的骨架。

```shell
# 如果只是作为api不做视图引擎的话使用--no-view 参数
npx express-generator

npm install

# windows启动命令
set DEBUG=myapp:* & npm start
# windows的powershell启动命令
$env:DEBUG='myapp:*'; npm start
```

然后浏览器访问`localhost:3000`就可以看到返回的 html 了

第一个 demo 可以参考[https://juejin.cn/post/6960311946390290469#heading-3](https://juejin.cn/post/6960311946390290469#heading-3)

## mysql

### windows 安装 mysql

> https://blog.csdn.net/qq_39327650/article/details/134088833

#### starting the server 步骤一直失败

> https://blog.csdn.net/qq_52183856/article/details/123792012

`windwos服务` => `mysql` => `编辑` => `登录`

## 技巧

### 实现跨域

1. 中间件`cors`

```js
npm install cors --save-dev

const cors = require('cors');
app.use(cors());
```

2. 手动实现

```js
app.use((req, res, next) => {
  res.header("Access-Control-Allow-Origin", "*");
  res.header(
    "Access-Control-Allow-Headers",
    "Authorization,X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method"
  );
  res.header(
    "Access-Control-Allow-Methods",
    "GET, POST, OPTIONS, PATCH, PUT, DELETE"
  );
  res.header("Allow", "GET, POST, PATCH, OPTIONS, PUT, DELETE");
  next();
});
```

### 文件上传

可以参考[https://lanfengqiuqian.blog.csdn.net/article/details/139601385](https://lanfengqiuqian.blog.csdn.net/article/details/139601385)

### nodemon 和 pm2

#### 开发环境使用 nodemon

nodemon 可以自动检测到目录中的文件更改时通过重新启动应用程序来调试基于`nodejs`的应用程序

> npm install -g nodemon
> node mon server.js

#### 生产环境使用 pm2

[官方文档](https://pm2.keymetrics.io/docs/usage/quick-start/)

pm2 是一个带有负载均衡功能的 node 应用的进程管理器

```shell
$ pm2 stop all                  # 停止所有的应用程序
$ pm2 stop 0                    # 停止 id为 0的指定应用程序
$ pm2 restart all               # 杀死并重新启动所有进程
$ pm2 reload all                # 实现0秒的停机重新加载。重载 cluster mode下的所有进程
$ pm2 delete all                # 关闭并删除所有应用
$ pm2 delete 0                  # 删除指定应用 id 0

$ pm2 kill                      # 杀死pm2管理的所有进程

$ pm2 ls                        # 列表 PM2 启动的所有的应用程序
$ pm2 start app.js              # 启动项目
```

### 隔一段时间会报错：Cannot enqueue Query after fatal error.

看上去是数据库的问题，因为接口还是可以调通的，尝试重启后端服务器其实可以生效，但是肯定不能自己经常手动重启后端服务

原因：因为太久没有活跃，数据库断开连接了

解决：

1. 连接配置中增加`useConnectionPooling: true`

```js
let dbconfig = {
  host: "db_host",
  user: "db_user",
  password: "db_pass",
  database: "db_name",
  useConnectionPooling: true,
  debug: true,
};
```

2. 如果上面那个方案还是不生效的话，可以尝试

```js
process.on("uncaughtException", function (err) {
  if (err.code == "PROTOCOL_CONNECTION_LOST") {
    mysql.restart();
  }
});
```

适用于还有另一个报错的情况，`Error: Connection lost The server closed the connection`

### 记录日志

1.  介绍一下`morgan`和`winston`的区别

    1. morgan 的作用
       morgan 是一个 HTTP 请求日志中间件，专门用于记录 Express 应用的 HTTP 请求日志。它简单易用，提供多种预定义的日志格式，能够自动记录每个 HTTP 请求的详细信息，如请求方法、URL、响应时间等。

    使用 morgan 的原因：

        1. 专注于 HTTP 请求日志：morgan 专门用于记录 HTTP 请求日志，能够自动记录和格式化 HTTP 请求信息。
        2. 易于集成：morgan 是 Express 的中间件，集成非常方便。
        3. 标准化输出：morgan 提供的多种日志格式（如 combined, common, dev 等）标准化了日志输出，使其易于阅读和分析。

    2. winston 的作用
       winston 是一个通用的日志库，支持灵活的配置和多种传输方式（如控制台输出、文件存储、HTTP 传输等）。它适用于记录应用程序的各种日志，包括信息日志、错误日志、调试日志等。

    使用 winston 的原因

    1. 通用日志记录：winston 适用于记录各种类型的日志，不限于 HTTP 请求日志。
    2. 灵活配置：winston 支持自定义格式、不同级别的日志、多个传输方式等，灵活性很高。
    3. 日志管理：通过配置 DailyRotateFile 等插件，winston 可以实现日志文件的自动轮换、压缩和删除，便于日志管理。

    选择

    1. `morgan`：专注于 HTTP 请求日志，简单易用，适合作为 Express 中间件记录请求日志
    2. `winston`: 提供灵活的日志记录和管理功能，适用于记录应用程序的各种日志

2.  代码示例

```js
const express = require("express");
const morgan = require("morgan");
const path = require("path");
const fsExtra = require("fs-extra");
const winston = require("winston");
const DailyRotateFile = require("winston-daily-rotate-file");

const app = express();

// 日志目录路径
const logDirectory = path.join(__dirname, "logs");

// 确保日志目录存在
fsExtra.ensureDirSync(logDirectory);

// 配置 winston
const logger = winston.createLogger({
  level: "info",
  format: winston.format.combine(
    winston.format.timestamp(),
    winston.format.json()
  ),
  transports: [
    new winston.transports.Console(),
    new DailyRotateFile({
      filename: path.join(logDirectory, "application-%DATE%.log"),
      datePattern: "YYYY-MM-DD",
      zippedArchive: true,
      maxSize: "20m",
      maxFiles: "14d",
    }),
  ],
});

// 使用 morgan 记录 HTTP 请求到日志文件，并重定向到 winston
app.use(
  morgan("combined", {
    stream: {
      write: (message) => logger.info(message.trim()),
    },
  })
);

// 示例路由
app.get("/", (req, res) => {
  res.send("Hello, world!");
});

// 启动服务器
const port = 3000;
app.listen(port, () => {
  logger.info(`Server is running on port ${port}`);
});
```

注意：如果记录 http 请求的话，需要把日志部分的注册放到路由拦截之前
