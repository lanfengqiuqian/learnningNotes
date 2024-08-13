[toc]

### 相关文档（地址）

#### 下载资源

[微信开发者工具](https://developers.weixin.qq.com/miniprogram/dev/devtools/download.html)

[HBuilderX](https://www.dcloud.io/hbuilderx.html)

[vscode 官网](https://code.visualstudio.com/)
windows 可以直接用微软商店下载，挺快的
[vscode 下载太慢解决方案](https://blog.csdn.net/zoecxy/article/details/124391379)

#### 技术文档

[微信开放平台](https://mp.weixin.qq.com/)

[开发文档](https://developers.weixin.qq.com/miniprogram/dev/framework/)

选择原生微信小程序还是如 Taro、uni-app 等框架的思考

1. [https://juejin.cn/post/7216635998951931960](https://juejin.cn/post/7216635998951931960)
2. [https://ant-move.github.io/blog/article/framework.html#%E5%8E%9F%E7%94%9F%E5%B0%8F%E7%A8%8B%E5%BA%8F%E7%9A%84%E4%BC%98%E5%8A%BF](https://ant-move.github.io/blog/article/framework.html#%E5%8E%9F%E7%94%9F%E5%B0%8F%E7%A8%8B%E5%BA%8F%E7%9A%84%E4%BC%98%E5%8A%BF)

#### UI 库

[weui(官方的)](https://github.com/Tencent/weui-wxss/)

[vantui](https://vant-ui.github.io/vant-weapp/#/home)

[arco design mobile](https://arco.design/mobile/react/arco-design/pc/#/)

[其他 UI 库汇总](https://developers.weixin.qq.com/community/develop/article/doc/000ecc775a86807f7ba9b7dc956c13)

### 准备工作

#### 到[微信开放平台](https://mp.weixin.qq.com/)注册账号

1. 一个邮箱注册一个账号，一个账号只能绑定一个小程序
2. 一个微信号（身份证号、手机号）可以绑定 5 个小程序

#### 获取 appid

#### 将相关开发者和运营加入到成员列表中

只有自己一个人可忽略

#### vscode 开发需要的插件

1. WXML - Language Service

   1. 一键创建小程序组件
   2. 标签名与属性自动补全
   3. 根据组件已有的属性，自动筛选出对应支持的属性集合
   4. 属性值自动补全
   5. 点击模板文件中的函数或属性跳转到 js/ts 定义的地方（纯 wxml 或 pug 文件才支持，vue 文件不完全支持）
   6. 样式名自动补全（纯 wxml 或 pug 文件才支持，vue 文件不完全支持）
   7. 在 vue 模板文件中也能自动补全，同时支持 pug 语言
   8. 支持 link（纯 wxml 或 pug 文件才支持，vue 文件不支持）
   9. 自定义组件自动补全（纯 wxml 文件才支持，vue 或 pug 文件不支持）
   10. 模板文件中 js 变量高亮（纯 wxml 或 pug 文件才支持，vue 文件不支持）
   11. 内置 snippets
   12. 支持 emmet 写法
   13. wxml 格式化

### 笔记

#### 如何引入三方库

可参见[https://developers.weixin.qq.com/miniprogram/dev/devtools/npm.html](https://developers.weixin.qq.com/miniprogram/dev/devtools/npm.html)

1. 初始化仓库`npm init -y`
2. `微信开发者工具中`的菜单栏：`工具 --> 构建 npm`
3. 强烈提示：安装依赖的时候一定要用`npm`，不要用`cnpm yarn pnpm`之类的，否则很有可能出问题

#### 省市区选择的源数据

小程序使用默认的时候是不需要自己造数据的，内置了数据，但是比如自己的后台管理系统需要的话，那么就需要源数据了

这个是`2023-7-14`的数据

> https://img.bazhuay.com/1689320190143_615.json

如何一直使用最新的可以参考

> https://developers.weixin.qq.com/community/develop/article/doc/0002ca873b076037a33be090656413

#### style 中使用 background-image 不支持使用本地图片

会报错：`[渲染层网络层错误] pages/index/index.wxss 中的本地资源图片无法通过 WXSS 获取，可以使用网络图片，或者 base64，或者使用<image/>标签`

1. 使用`image`组件，在布局下面盖一层图片，缺点（布局结构可读性不高）
2. 将图片转为`base64`，缺点

| 方式                                  | 缺点                                                 |
| ------------------------------------- | ---------------------------------------------------- |
| 使用 image 组件，在布局下面盖一层图片 | 布局结构可读性不高                                   |
| 使用 base64                           | 内容太长，影响阅读                                   |
| 使用行内样式，最简单                  | 代码不够优雅，（后来验证模拟器可以，但是真机不可以） |
| 使用网络图片，最推荐                  | 需要放到服务器上                                     |

### 遇到的一些问题

#### `构建npm`时：`NPM package not found. Please confirm npm packages which need to build are belong to minigrogramRoot directory. Or you may edit project.config.json's packNpmManually and packNpmRelationList`

原因：需要在`project.config.json`中增加如下配置

具体原理可以看官方文档[https://developers.weixin.qq.com/miniprogram/dev/devtools/npm.html#%E5%8E%9F%E7%90%86%E4%BB%8B%E7%BB%8D](https://developers.weixin.qq.com/miniprogram/dev/devtools/npm.html#%E5%8E%9F%E7%90%86%E4%BB%8B%E7%BB%8D)

```json
"setting": {
   "packNpmManually": true,
   "packNpmRelationList": [
      {
         "packageJsonPath": "./package.json",
         "miniprogramNpmDistDir": "./"
      }
   ]
}
```

这里一定要注意 2 点

1.  需要写到`setting`属性中，官方文档没有提这一点，很多博客也没有提
2.  `miniprogramNpmDistDir`的属性值，如果比较新的开发者工具的话使用`./`，如果比较老的使用`./miniprogram/`
3.  修改完配置之后需要`重新启动`微信开发者工具

#### `构建npm`时，`xxx/node_modules/@babel/runtime/index.js: Npm package entry file not found`

原因：`@/babel/runtime`这个包没有入口文件`index.js`，`package.json`也没有`main`字段指定

`@babel/runtime` 包的 package.json 中没有 main 字段通常不会造成问题，因为这个包主要作为一个辅助运行时依赖，用于包含一些编译时插件生成的帮助函数。微信小程序构建工具可能需要明确的入口文件，但通常情况下，@babel/runtime 包的设计不需要 main 字段。

但是微信开发者工具这边会报错，可以如下解决

把这个包下面的`regenerator/index.js`移动到外层，充当入口文件，或者手动增加`main`字段来指定

#### ios 真机调试打开页面空白

对比：安卓手机正常，体验版正常，直接预览正常

解决：使用`真机调试1.0`，不要使用默认的`真机调试2.0`

更新：后来发现了解决方案，需要把`uniapp`的`manifest.json`中`微信小程序配置`的`es6转es5`和`上传代码自动压缩`打开就可以了

#### 小程序 input 组件 type="nickname"获取微信昵称，v-model 绑定值为空

微信小程序设计如此

需要使用`@change`来手动设置
