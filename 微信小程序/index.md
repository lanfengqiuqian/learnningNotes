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

#### 小程序审核发布经验

<https://github.com/lingziyao115/miniprogram>

#### 个人小程序可以申请的服务类目

<https://developers.weixin.qq.com/miniprogram/product/material/#%E4%B8%AA%E4%BA%BA%E4%B8%BB%E4%BD%93%E5%B0%8F%E7%A8%8B%E5%BA%8F%E5%BC%80%E6%94%BE%E7%9A%84%E6%9C%8D%E5%8A%A1%E7%B1%BB%E7%9B%AE>

#### 个人小程序提审怎么绕过审核

正常来说：如果是个人开发微信小程序，在涉及音乐，视频，新闻等，都是不允许的。需要注册企业主体

<https://blog.csdn.net/weixin_48622654/article/details/130516129>

#### 服务器域名配置

<https://developers.weixin.qq.com/miniprogram/dev/framework/ability/network.html#1.%20%E6%9C%8D%E5%8A%A1%E5%99%A8%E5%9F%9F%E5%90%8D%E9%85%8D%E7%BD%AE>


#### 微信小程序webview清除缓存、微信公众号h5清除缓存、页面白屏、空白、不刷新问题

<https://blog.csdn.net/qq_35430000/article/details/121096540>

#### 如何引入三方库

可参见[https://developers.weixin.qq.com/miniprogram/dev/devtools/npm.html](https://developers.weixin.qq.com/miniprogram/dev/devtools/npm.html)

1. 初始化仓库`npm init -y`
2. `微信开发者工具中`的菜单栏：`工具 --> 构建 npm`
3. 强烈提示：安装依赖的时候一定要用`npm`，不要用`cnpm yarn pnpm`之类的，否则很有可能出问题

#### 体验版怎么清除个人授权信息

无法真正的清除，只能右上角选择管理自己授权信息，通知开发者删除

如果是开发者的话，可以在微信开发者工具进行清除，只要是同一个账号的话，那么就可以清除，并不只是清除模拟器的缓存

#### 清除缓存

以下方案由简到繁

1. 微信下拉，找到体验版小程序，长按，拖拽到底部删除（这个是清除`local storage`）

2. 如果还有文件缓存之类的，需要到`我的 => 设置 => 通用 => 存储空间 => 缓存`，选择清理，注意（有时候只选择小程序的没有生效，建议选择全部）

3. 可以尝试退出微信重新登录

4. 删除微信软件重新安装

可以参考<https://developers.weixin.qq.com/community/develop/doc/000ae8b82c09a802e24896fc652000>

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

`注意`：`使用网络图片`，需要图片链接是查看形式，而不是下载形式

比如宝塔文件`分享`功能的链接浏览器点开是`下载`，而不是查看，需要放到部署的站点上，通过站点+路径访问的图片才是查看的

#### 地图地址输入服务

直接写好了一个小程序页面，能够添加地址

<https://mp.weixin.qq.com/wxopen/plugindevdoc?appid=wx57d7ae552cbb3084&token=707308394&lang=zh_CN>

域名白名单中：小程序的填写`servicewechat.com`

咨询技术支持之后（`大概的意思就是需要收费`）

> 地址输入插件封装了很多接口，您需要将配额分配至封装的接口，才能正常调用，其中智能地址解析为高级接口，需要付费购买开通才会有配额（此付费在商业授权以外的付费），因此您这边调用失败，辛苦您看下是否需要采购开通，如需购买，请提供完整的企业名称全称。另外您如划以商业目的使用腾讯位置服务，包括但不限于对第三方用户收费、项目投标等情况，直接或间接地获得收益，则需要事先获取腾讯位置服务的商业授权许可

#### 设置小程序无法搜索出来

# 微信公众平台 => 设置 => 基本设置 => 隐私与安全 => 允许被搜索

#### 小程序订阅

<https://developers.weixin.qq.com/miniprogram/dev/framework/open-ability/subscribe-message.html#%E8%AE%A2%E9%98%85%E6%B6%88%E6%81%AF%E8%AF%AD%E9%9F%B3%E6%8F%90%E9%86%92>

> > > > > > > 5ad1851e91c71634c80a570b1a6bc046cbf0c433

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

#### 微信小程序开发版测试提示无体验者权限

需要这个用户为`开发者权限`，`体验版权限是不够的`

体验者权限看不了开发版的。开发版只能开发者权限打开

#### 判断微信分享是否成功

<https://developers.weixin.qq.com/community/develop/doc/000484599b8580887fad6c09151400>

现在`success`和`fail`回调已经不触发了，无法判断是否分享成功

#### h5 跳转微信小程序

<https://developers.weixin.qq.com/miniprogram/dev/framework/open-ability/url-scheme.html#%E6%98%8E%E6%96%87-URL-Scheme>

#### backdrop-filter 属性在微信小程序进行分享时失效

<https://developers.weixin.qq.com/community/develop/doc/000c2a70824dd0e2de883067051400>

#### 关于微信小程序打开 h5 的限制

1. 如果是跳转别的小程序首页，有 appid 就可以
2. 如果是跳转公众号文章，需要对方公众号关联你的小程序，公众号有数量限制，同一个主体最多 10 个，不同主体最多 3 个
3. 如果是跳转 h5，需要配置业务域名，也需要对方的域名服务器放一个你的校验文件
4. 小程序右上角，在默认浏览器打开 h5，是没有这个功能的，只有 h5 有这个功能

2 和 3 都需要对方配合

折中方案：写一个自己的页面，加一个按钮复制到剪切板，引导用户自己去默认浏览器打开

或者是：跳转到客服聊天界面，通过开发的方式，自动发送一个卡片链接，这里能打开微信浏览器，微信浏览器能够支持右上角默认浏览器打开


