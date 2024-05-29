[pop]

## 文档

[中文文档](https://pnpm.io/zh/6.x/installation)
[别人的笔记](https://blog.csdn.net/it_xcr/article/details/114655778)

顶部可以切换版本，我这里看的是6


## 安装

> npm install -g pnpm@latest-6

## 执行pnpm命令报错

` ERR_PNPM_REGISTRIES_MISMATCH  This modules directory was created using the following registries configuration: {"default":"https://registry.npmjs.org/"}. The current configuration is {"default":"https://registry.npmmirror.com/"}. To recreate the modules directory using the new settings, run "pnpm install".`

原因：每次修改源都需要运行命令

方案

```
pnpm install -g;
pnpm install -g pnpm;
```