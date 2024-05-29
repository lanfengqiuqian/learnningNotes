<!--
 * @Date: 2021-06-17 20:45:23
 * @LastEditors: Lq
 * @LastEditTime: 2022-07-14 16:45:34
 * @FilePath: \learnningNotes\js\nodejs.md
-->

#### 递归创建文件夹，并将网络图片地址下载到本地创建的文件夹中

```js
// 递归创建目录
function mkdirs(dirname) {
  if (fs.existsSync(dirname)) {
    console.log("目录已存在");
  } else {
    fs.mkdir(dirname, { recursive: true }, (err) => {
      if (err) throw err;
    });
  }
}

// 将网络文件下载到本地目录中
async function downloadFileToDir(url, path, fileName) {
  let msg = "";
  try {
    mkdirs(path);
    await uploadData(url, path + fileName);
    msg = "存储文件成功";
  } catch (e) {
    msg = "存储文件失败";
    console.log("存储文件失败了", e);
  }
  return new Promise((resolve) => {
    resolve(msg);
  });
}

// 调用方式
let openInvoiceName = "景宁筑商嘻嘻嘻商务服务工作室";
let time = "2021-04-12";
let invoiceCode = "0000";
let invoiceNo = "11111";
let url =
  "http://zhushang-c-invoice.oss-cn-zhangjiakou.aliyuncs.com/hh/test.pdf";
await downloadFileToDir(
  url,
  `/Users/aiyong/Downloads/invoice/${openInvoiceName}`,
  `/${time}_${invoiceCode}_${invoiceNo}.pdf`
);
```

### mac安装nvm

> brew install nvm


### npm安装cnpm和yarn

> npm install -g cnpm --registry=https://registry.npm.taobao.org  
> npm install --global yarn

### node 升级

1. 查看当前 node 版本

   > node -v

2. 清除 npm 缓存

   > npm cache clean -f

3. n 模块是专门用来管理 nodejs 的版本，安装 n 模块

   > npm install -g n

   这里可能会报错

   > Unsupported platform for n@8.2.0: wanted {"os":"!win32","arch":"any"} (current: {"os":"win32","arch":"x64"})

   解决方案：这其实主要是因为 n 模块不适配 windows 系统，所以虽然可以安装，但是还是需要相办法安装一个“linux”环境。在运行 n 命令时提示使用 wsl2

   > npm install -g n --force

   如果是 windows 可能是需要安装一个 linux 环境，参考这个：

4. 更新升级 node 版本

   ```shell
   n stable // 把当前系统的 Node 更新成最新的 “稳定版本”
   n lts // 长期支持版
   n latest // 最新版
   n 16.13.1 // 指定安装版本
   ```

5. 升级完成查看 node 版本

   > node -v

6. 如果是需要频繁切换版本可以尝试这个：[https://blog.csdn.net/cnds123321/article/details/121257762](https://blog.csdn.net/cnds123321/article/details/121257762)

### node 切换版本值 nvm 的安装

1. 下载： https://github.com/coreybutler/nvm-windows/releases

2. 安装一直下一步就行，会自动配置到环境变量中

3. 检查是否安装完成

   > nvm -v

   如果提示找不到命令，有可能是没有配置到环境变量中

   > NVM_HOME C:\Users\aiyong\AppData\Roaming\nvm // 这个是 nvm 的安装目录  
   > NVM_SYMLINK C:\Program Files\nodejs // 这个是 nodejs 的安装目录

4. 安装 node 其他版本

   > nvm install 12.22.12

   ```shell
   Downloading node.js version 12.22.12 (64-bit)...
   Complete
   Creating C:\Users\aiyong\AppData\Roaming\nvm\temp

   Downloading npm version 6.14.16... Complete
   Installing npm v6.14.16...

   Installation complete. If you want to use this version, type

   nvm use 12.22.12
   ```

5. 切换 node 版本

   > nvm use 12.22.12

   这里有可能出现乱码并且失败

   ```shell
   exit status 5: �ܾ����ʡ�

   exit status 1: ���ļ��Ѵ���ʱ���޷��������ļ���
   ```

   解决方案：使用管理员身份重新打开一个终端再执行命令即可即可

6. 设置默认node版本

  > nvm alias default 16  
  > nvm alias default v16.18.0

### Node Sass does not yet support your current environment: Windows 64-bit with

这种情况一般是 node 版本问题，可能过高了

### npm 安装依赖时报错，和`node-sass`有关的

都可以考虑是否是 node 版本的问题

node 版本支持的 node-sass 版本如下

| NodeJS  | Supported node-sass version | Node Module |
| ------- | --------------------------- | ----------- |
| Node 17 | 7.0+                        | 102         |
| Node 16 | 6.0+                        | 93          |
| Node 15 | 5.0+, <7.0                  | 88          |
| Node 14 | 4.14+                       | 83          |
| Node 13 | 4.13+, <5.0                 | 79          |
| Node 12 | 4.12+                       | 72          |
| Node 11 | 4.10+, <5.0                 | 67          |
| Node 10 | 4.9+, <6.0                  | 64          |
| Node 8  | 4.5.3+, <5.0                | 57          |
| Node <8 | <5.0                        | <57         |

推荐使用nvm进行管理[https://blog.csdn.net/qq_40833182/article/details/120186970?spm=1001.2101.3001.6650.1&utm_medium=distribute.pc_relevant.none-task-blog-2%7Edefault%7ECTRLIST%7ERate-1-120186970-blog-121540363.pc_relevant_aa_2&depth_1-utm_source=distribute.pc_relevant.none-task-blog-2%7Edefault%7ECTRLIST%7ERate-1-120186970-blog-121540363.pc_relevant_aa_2&utm_relevant_index=2](https://blog.csdn.net/qq_40833182/article/details/120186970?spm=1001.2101.3001.6650.1&utm_medium=distribute.pc_relevant.none-task-blog-2%7Edefault%7ECTRLIST%7ERate-1-120186970-blog-121540363.pc_relevant_aa_2&depth_1-utm_source=distribute.pc_relevant.none-task-blog-2%7Edefault%7ECTRLIST%7ERate-1-120186970-blog-121540363.pc_relevant_aa_2&utm_relevant_index=2)

### 全局安装模块和卸载

> npm install -g xxx  
> npm uninstall -g xxx  
> yarn global add xxx  
> yarn global remove xxx

### 查看全局安装了什么依赖

> npm list -g --depth 0  // 用这个就可以，只查看最外层  
> npm list -g // 这个会递归

### 全局安装的模块默认位置

用户目录下的`node_modules`

> C:\Users\aiyong\node_modules

### npm查看本地安装了什么源，以及设置其他源

```shell
// 查看当前源
npm get registry
// 设置淘宝镜像源
npm config set registry http://registry.npm.taobao.org
// 设置官方源
npm config set registry http://www.npmjs.org
```

### nodejs 中 js 文件变量的引用

因为不能使用 import 和 export，只能使用基础的 require 进行导入

```js
// 被引用文件 info.js
exports.info = {
  name: "lan",
  age: 12,
};
```

```js
// 引用文件
const {
  info: { name, age },
} = require("./info.js");
console.log("name", name);
console.log("age", age);
```

### nodejs 流程的当前工作目录

> process.cwd()


### Install fail! Error: Unsupported URL Type "workspace:": workspace:*

原因：检查package.json中的项目依赖版本是否出现[workspace:]。如果使用npm i来安装，它会出现 "不支持的URL类型 "workspace:": workspace:"。

解决：使用yarn来安装，就ok！


### NPM依赖包中`~`、`^`、`*`的区别

```
~ 会匹配最近的小版本依赖包，比如~1.2.3会匹配所有1.2.x版本，但是不包括1.3.0
^ 会匹配最新的大版本依赖包，比如^1.2.3会匹配所有1.x.x的包，包括1.3.0，但是不包括2.0.0
* 这意味着安装最新版本的依赖包

推荐使用~，只会修复版本的bug，比较稳定
使用^ ，有的小版本更新后会引入新的问题导致项目不稳定
*同样有上述问题

什么符号都不加的话，就是锁定版本
```

使用yarn来管理依赖

yarn是一个与npm兼容的node包管理器。使用它安装npm包，会自动在项目目录中创建一个yarn.lock文件。该文件包含了当前项目中所安装的依赖包的版本信息。其他人在使用yarn安装项目的依赖包时就可以通过该文件创建一个完全相同的依赖环境。


### .npmrc文件

1. 作用

    可以理解为npm运行时配置文件，可以设置`package.json`中的依赖包的安装来源

2. 优先级

    电脑中有多个`.npmrc`文件，按照如下顺序读取

    1. 当前项目的配置文件`/project/.npmrc`
    2. 用户配置文件`~/.npmrc`
    3. 全局配置文件`/etc/npmrc`
    4. npm内置配置文件

    ```shell
    # 获取.npmrc用户配置文件路径
    npm config get userconfig

    # 如果想恢复默认配置，只需要将用户配置文件~/.npmrc删除即可
    ```

3. 如何设置
    ```
    # 可以使用key=value来设置
    registry=https://registry.npm.taobao.org

    # 也可以指定特殊命名空间以@test开头的包去https://npm.xx.com下载，其他的去淘宝镜像下载
    registry=https://registry.npm.taobao.org/
    @test:registry = https://npm.xx.com
    ```


### npm前加@是什么意思

比如`vue-cli`与`@vue/cli`的区别

1. `@`前缀是什么意思

  表示该软件包是范围包，类似相对路径

  ```js
  import MyTitle from '@/comopnents/my-title'
  ```

2. 为什么要用叫命名空间（或者叫做范围）

  不用的场景：假如你想发布一个包，叫做`my-title`，如果这个时候别人已经发布过了这个名字，那么你就必须改名，比如叫`mine-title`

  用的场景：假如你想发布一个包，叫做`my-title`，因为有了命名空间，实际你的名字叫做`@user/my-title`，别人即使也发布过了，但是因为是不同的命名空间，比如叫`@other/my-title`

3. 命名空间的界定

  我们在注`册npm帐户时`，`系统自动分配`给我们的。我们可以在这个匹配的命名空间内，发布我们自己的包。

  且在这个命名空间内创建发布的包不会与其他用户或组织创建的包同名的包，而不会发生冲突。

  当在package.json文件中作为从属项列出时，带作用域的程序包之前带有其作用域名称。命名空间名称是介于`@和斜线之间的所有内容`。

  ```js
    "@vue/cli-plugin-eslint": "~5.0.0",
    "@vue/cli-plugin-router": "~5.0.0",
    "@vue/cli-plugin-typescript": "~5.0.0",
    "@vue/cli-service": "~5.0.0",
    "@vue/eslint-config-prettier": "^6.0.0",
    "@vue/eslint-config-typescript": "^11.0.2",
  ```

4. 命名格式

  `@myorg/mypackage` 即： `@组织名/包名`

  `@yourname/mypackage` 即 `@你的名称/包名`


### 判断是生产环境还是开发环境

```js
// production || development
process.env.NODE_ENV
```

### npm install命令不同参数

```
npm install moduleName # 安装模块到项目目录下
 
npm install -g moduleName # -g 的意思是将模块安装到全局，具体安装到磁盘哪个位置，要看 npm config prefix 的位置。
 
npm install -save moduleName # -save 的意思是将模块安装到项目目录下，并在package文件的dependencies节点写入依赖。
 
npm install -save-dev moduleName # -save-dev 的意思是将模块安装到项目目录下，并在package文件的devDependencies节点写入依赖。
```


### nvm安装报错`Could not retrieve https://npm.taobao.org/mirrors/node/latest-v18.x/SHASUMS256.txt.`

到nvm安装目录如`setting.txt`中修改

```shell
node_mirror: https://cdn.npmmirror.com/binaries/node/
npm_mirror: https://cdn.npmmirror.com/binaries/npm/
```

### 淘宝镜像源更换

原先的淘宝镜像源`https://registry.npm.taobao.org`

> npm config set registry https://registry.npmmirror.com


### 解决 npm或pnpm : 无法加载文件 C:\Users\hp\AppData\Roaming\npm\cnpm.ps1，因为在此系统上禁止运行脚本

1. 输入命令：`set-ExecutionPolicy RemoteSigned` 然后回车
2. 选择：输入A选择全是，或者输入Y选择是 都可以的
3. 接着重新启动然后去运行就可以了