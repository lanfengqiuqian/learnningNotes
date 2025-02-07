## 文档

### 官方文档

<https://nuxt.com/>

### 中文文档

<https://www.nuxtjs.cn/guide/installation>

注意：我现在看的时候最新版本是`2.14.5`，但是英文文档是`3.15.4`，差距还是挺大的，一整个大版本，所以还是推荐看英文版本的

### 安装的配置解释

<https://juejin.cn/post/7212240532796997691>

## 说明

### 对vue版本的支持

`Nuxt 3`是全面支持`Vue3`，之前的版本是支持`Vue 2`

## 问题

### 安装项目报错

```shell
Error: Failed to download template from registry: Failed to download https://raw.githubusercontent.com/nuxt/starter/templates/templates/v3.json: TypeError: fetch failed
```

问题的核心在于 `nuxi` 命令尝试从 `GitHub` 下载模板文件时失败了

尝试开启代理

```shell
# 以下几种任选其一即可
npx nuxi@latest init nuxt3-demo --proxy http://127.0.0.1:7890

set https_proxy=https://127.0.0.1:7890
```

如果都不行，那么久手动去下载

先浏览器打开`https://raw.githubusercontent.com/nuxt/starter/templates/templates/v3.json`

会告诉你地址，比如我的是

```json
{
  "name": "v3",
  "defaultDir": "nuxt-app",
  "url": "https://nuxt.com",
  "tar": "https://codeload.github.com/nuxt/starter/tar.gz/refs/heads/v3"
}
```

那么就访问`https://codeload.github.com/nuxt/starter/tar.gz/refs/heads/v3`，下载之后把里面的文件打开，手动安装`node_modules`即可

### 安装完之后build的报错

```shell
PS D:\code\nuxt-demo> npm run build

> nuxt-demo@1.0.0 build
> nuxt build

i Using default Tailwind CSS file from runtime/tailwind.css nuxt:tailwindcss 17:36:22

FATAL nuxt.options._layers is not iterable 17:36:22

at installModule (/D:/code/nuxt-demo/node_modules/@nuxt/kit/dist/index.mjs:2421:32)
at async setup (/D:/code/nuxt-demo/node_modules/@nuxtjs/tailwindcss/dist/module.mjs:186:7)
at async ModuleContainer.normalizedModule (/D:/code/nuxt-demo/node_modules/@nuxt/kit/dist/index.mjs:2149:17)
at async ModuleContainer.addModule (node_modules\@nuxt\core\dist\core.js:170:20)
at async ModuleContainer.ready (node_modules\@nuxt\core\dist\core.js:34:7)
at async Nuxt._init (node_modules\@nuxt\core\dist\core.js:347:5)


FATAL nuxt.options._layers is not iterable 17:36:22

at installModule (/D:/code/nuxt-demo/node_modules/@nuxt/kit/dist/index.mjs:2421:32)
at async setup (/D:/code/nuxt-demo/node_modules/@nuxtjs/tailwindcss/dist/module.mjs:186:7)
at async ModuleContainer.normalizedModule (/D:/code/nuxt-demo/node_modules/@nuxt/kit/dist/index.mjs:2149:17)
at async ModuleContainer.addModule (node_modules\@nuxt\core\dist\core.js:170:20)
at async ModuleContainer.ready (node_modules\@nuxt\core\dist\core.js:34:7)
at async Nuxt._init (node_modules\@nuxt\core\dist\core.js:347:5)


╭─────────────────────────────────────────────────────╮
│ │
│ ✖ Nuxt Fatal Error │
│ │
│ TypeError: nuxt.options._layers is not iterable │
│ │
╰─────────────────────────────────────────────────────╯
```

这个是`@nuxtjs/tailwindcss` 模块的版本不兼容

升级 `@nuxtjs/tailwindcss` 到最新版本

> npm install --save-dev @nuxtjs/tailwindcss@^6

### pnpm dev之后运行报错

```shell
PS D:\code\nuxt3-demo> pnpm dev -o

> nuxt-app@ dev D:\code\nuxt3-demo
> nuxt dev "-o"

Nuxt 3.15.4 with Nitro 2.10.4 nuxi 11:39:03
11:39:04
➜ Local: http://localhost:3000/
➜ Network: use --host to expose

➜ DevTools: press Shift + Alt + D in the browser (v1.7.0) 11:39:06

✔ Vite client built in 94ms 11:39:10
✔ Vite server built in 494ms 11:39:10
✔ Nuxt Nitro server built in 1174 ms nitro 11:39:12
ℹ Vite client warmed up in 3ms 11:39:12
ℹ Vite server warmed up in 1092ms 11:39:13

ERROR [unhandledRejection] write ECONNABORTED 11:39:13

at afterWriteDispatched (node:internal/stream_base_commons:159:15)
at writeGeneric (node:internal/stream_base_commons:150:3)
at Socket._writeGeneric (node:net:957:11)
at Socket._write (node:net:969:8)
at writeOrBuffer (node:internal/streams/writable:572:12)
at _write (node:internal/streams/writable:501:10)
at Writable.write (node:internal/streams/writable:510:10)
at IncomingMessage.ondata (node:internal/streams/readable:1009:22)
at IncomingMessage.emit (node:events:518:28)
at addChunk (node:internal/streams/readable:561:12)
```

问题可能与网络连接或某些依赖项的下载有关

我尝试关闭终端，重新启动一下项目就可以了