[pop]

## 文档

[中文文档](https://pnpm.io/zh/6.x/installation)
[别人的笔记](https://blog.csdn.net/it_xcr/article/details/114655778)

顶部可以切换版本，我这里看的是6

## 使用

### 安装

> npm install -g pnpm@latest-6

### 设置源

```shell
//查看源
pnpm config get registry 
//切换淘宝源
pnpm config set registry https://registry.npmmirror.com/
```

### 常用命令

```shell
pnpm install 包  // 
pnpm i 包
pnpm add 包    // -S  默认写入dependencies
pnpm add -D    // -D devDependencies
pnpm add -g    // 全局安装

pnpm up                //更新所有依赖项
pnpm upgrade 包        //更新包
pnpm upgrade 包 --global   //更新全局包
```

## 问题

### 执行pnpm命令报错

` ERR_PNPM_REGISTRIES_MISMATCH  This modules directory was created using the following registries configuration: {"default":"https://registry.npmjs.org/"}. The current configuration is {"default":"https://registry.npmmirror.com/"}. To recreate the modules directory using the new settings, run "pnpm install".`

原因：每次修改源都需要运行命令

方案

```
pnpm install -g;
pnpm install -g pnpm;
```

### 使用pnpm安装依赖报缺少`@vueuse/core`

项目的`package.json`中是不存在这个依赖项的，可能是别的对等依赖之类的安装上去的

我删除了`node_modules`安装之后，也不行

最后是使用`npm`重新安装就有这个依赖了