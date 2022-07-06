<!--
 * @Date: 2022-05-31 16:56:32
 * @LastEditors: Lq
 * @LastEditTime: 2022-07-05 18:50:59
 * @FilePath: \learnningNotes\函数计算\index.md
-->
### 函数计算冷启动优化

> https://help.aliyun.com/document_detail/140338.html

### 关于函数计算编辑器无法加载并报错

<img src="./img/ide-error.png">

尝试了重新刷新页面、删除函数并重新创建，都是不行

1. 原因

    我这次的情况是因为代码包太多或者太大了

    本身是一个puppeteer的一个项目，使用zip包上传，里面包含了node_modules

2. 方案

    使用老版编辑器能够正常打开，就是很慢，保存和部署代码需要大概5，6分钟的样子

### 设置固定ip

背景 当你使用函数计算服务访问第三方服务的时候，第三方服务出于安全考虑，要求你设置一个白名单，比如：微信小程序等。但是`函数计算服务的 IP 是动态且不可枚举的`。为了能够让函数计算服务支持设置白名单，目前有两种常用的方式：ECS + EIP + Nginx 搭建代理和 NAT + EIP，第一个访问操作起来可能比较麻烦，需要准备一台 ECS，第二种方式操作简单，费用可能会高些。

> https://help.aliyun.com/document_detail/410740.html?spm=5176.22414175.sslink.9.23541056U59cdW#section-zkc-2vo-25j

这里有一个坑，就是【允许函数访问公网】这个选项，教程上是【是】，实际上要选择【否】

否则在保存的时候会报错，设置失败