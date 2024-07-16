### hbuild 好用插件整理

1. 命令面板

   > https://ext.dcloud.net.cn/plugin?id=2294

   类似 vscode 的命令面板

2. 自定义快捷键

   > https://ext.dcloud.net.cn/plugin?id=3648

   hbuild 默认没有自定义快捷键的，用这个插件可以可视化定制

3. 代码智能补全

   > https://ext.dcloud.net.cn/plugin?id=15497

   类似 vscode 的 codeium

### 使用技巧

#### 修改 input 的 placeholder 样式

1. 使用`placeholder-style`直接写行内样式（`这个我没生效`）
2. 使用`placeholder-class`增加类名（`这个可以`）

   1. 只能使用`font-size、font-weight、color`这几个属性
   2. 如果`style`中有`scoped`时，需要在类名前加上`/deep/`

3. 使用原生 css 方法修改（`这个我没生效`）

#### 使用自定义导航栏

官方文档[https://uniapp.dcloud.net.cn/collocation/pages.html#customnav](https://uniapp.dcloud.net.cn/collocation/pages.html#customnav)

不同设备的状态栏高度不一致问题，原因可参考[https://juejin.cn/post/6844903810578513928](https://juejin.cn/post/6844903810578513928)

解决方案：根据[官方文档](https://uniapp.dcloud.net.cn/api/system/info.html#getsysteminfo)中的 api 获取各个地方的高度，然后进行调整

`一定要注意的是`：这里需要用`px`作为单位，因为 api 返沪的是`px`，如果用`rpx`去计算的话会有问题

#### button 中使用图片，修改 button 样式，达到仅展示图片

```css
.btn {
  padding: 0;
  border: 0;
  background-color: transparent;
  width: 108rpx;
  height: 108rpx;

  &::after {
    outline: none;
    border: none;
  }

  .img {
    width: 100%;
    height: 100%;
  }
}
```

#### uniapp 特有的生命周期导入方式

```js
import { onLoad } from "@dcloudio/uni-app";

onLoad(() => {
  console.log(11);
});
```

#### 微信小程序和 uniapp 接入快递 100 查询

没有任何开发成本，直接一键接入

> https://fuwu.weixin.qq.com/service/detail/00008caeab84c07c17dcdabf55b815

使用查询 api 的方式

> https://blog.csdn.net/qq_43382853/article/details/140470767?spm=1001.2014.3001.5501

#### 微信小程序后端域名校验

1. 本地开发模式，可以在【详情】-【本地设置】-【不校验合法域名】
2. 体验版，默认需要配置服务器域名，也可以打开【小程序右上角】-【开发调试】模式，这种情况下也不校验
3. 正式版一定要配置

### 问题

####

#### onTabItemTap 钩子函数在真机上不触发，在微信开发者工具正常触发

我看 2018 年的时候提出了[https://developers.weixin.qq.com/community/develop/doc/000646fbf9c3b0d660bae531e56800](https://developers.weixin.qq.com/community/develop/doc/000646fbf9c3b0d660bae531e56800)，但是我现在`2024`还是有这个问题

需要使用真机调试`2.0`才可以

#### 关于获取用户头像昵称的 api

参见[https://developers.weixin.qq.com/community/develop/doc/00022c683e8a80b29bed2142b56c01](https://developers.weixin.qq.com/community/develop/doc/00022c683e8a80b29bed2142b56c01)

不要再使用`getUserProfile`和`getUserInfo`接口了，而是使用`button`的`open-type`属性为`chooseAvatar`和`nickname`进行触发

#### 引入模块 module 'xxx.js' is not defined, require args

1. 检查微信开发者工具的`详情 本地设置 将js编译成es5`是否开启
2. 尝试重新打开项目（hbuildx 和微信开发者工具都重启一下）
3. 将`import和export`改为`require和module.export`

我最终是使用方法 2 好的（但是每次改动都需要重新打开微信开发者工具，很不方便）

后来又发现 2 种黑科技方式

1. 把引入的文件名首字母改为大写，（不需要修改文件名本身，只需要修改 import 语句中的路径即可）
2. 把`@`去掉，改为根目录`/`
3. 不要在项目根目录下写文件，而是放到如`config`目录种

```js
// 原先写法
import { env } from "@/env.js";

// 改写为
import { env } from "@/Env.js";

// 或者改为
import { env } from "/env.js";

// 改写为
import { env } from "/config/env.js";
// 或者
import { env } from "@/config/env.js";
```

#### picker 组件不展示

slot 需要使用内容进行占位，要不然无法点击到组件的话无法触发

#### 微信小程序背景图片不展示

小程序本身不支持使用本地图片作为背景图片

1. 放到服务器使用`http`资源的形式
2. 使用`base64`
3. 使用`<image />`

#### 控制台警告 `已经存在分包EM ad`

不影响使用，如果要关掉的话`基础库调到3.4.7`即可

【设置】-【项目设置】-【本地设置】-【调试基础库】

#### 导入 uni-ui 的 popup 组件之后，提示 Cannot read property ‘open‘ of undefined

重新打开微信开发者工具运行一下就好了

#### 使用`v-show`不生效

原因：

1. uniapp 中使用`v-show`实际上是给元素加一个`hidden`属性（`view[hidden]`），样式值为`display: none`
2. 但是如果本身对于这个元素设置了其他的`display`属性的话，会被覆盖（这里是 css 选择器权重问题）

解决方案

1. 在原先的元素外层在包裹一个不应用`display`的标签
2. 使用`v-if`

#### Error: 系统错误，错误码：80051,source size 2642KB exceed max limit 2MB

资源太大，超过`2MB`，小程序体积不能超过`2MB`

具体哪部分超过需要看`代码质量`部分
