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
