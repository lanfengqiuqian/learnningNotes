## 起步

### 文档

B站教程：<https://www.bilibili.com/video/BV19x4y1R7LE?spm_id_from=333.788.videopod.episodes&vd_source=2d7fdb618d5543f2c754782cef4e48f3>

中文教程：<https://docs.flutter.cn/get-started/install>

### 安装

Android Studio： <https://developer.android.com/studio?hl=zh-cn>

> 下载components很慢  
> 取消下载，然后到设置中开启代理，重新下载
> https://blog.csdn.net/wangzhongshun/article/details/104898953


> 中文汉化：https://blog.csdn.net/XianZhe_/article/details/133979104
> 但是我这边没有比较新的版本，安装不了

flutter SDK：<https://docs.flutter.cn/release/archive?tab=macos>

> flutter设置镜像源：<https://cloud.tencent.com/developer/article/1927315>

Android SDK：<https://juejin.cn/post/7154983408895000583#heading-1>


环境配置：跟随官网<>

### 开发体验

1. vscode开发flutter
2. Android Studio导入项目运行android
3. xcode导入项目运行ios

### 问题

#### 新建项目中没有`新建flutter项目`选项

<https://juejin.cn/post/7061804020708409375>

Android Studio 4.1.3安装之后不再自带flutter和dart ,需要自己手动安装。

#### running gradle task 'assembledebug'很慢

更换阿里镜像源<https://juejin.cn/post/7204285137047257148>

#### flutter无法找到sync project with gradle files按钮

先可以参考这个<https://blog.csdn.net/mqdxiaoxiao/article/details/101513081>

但是我还是没有，最后把flutter项目关了，然后打开里面的`android`目录，竟然直接就有这个按钮了

但至于flutter项目为什么没有这个按钮，我也搞不明白了

#### 运行flutter doctor提示缺少cmdline-tools

官网<https://developer.android.com/tools?hl=zh-cn#download>

#### 提示Android license status unknown

执行提示的命令`flutter doctor --android-licenses`

#### 在BottomNavigationBar中的items3个能显示，4个无法显示

问题：样式问题，其实还在，但是颜色是白色没展示出来

解决：设置`type: BottomNavigationBarType.fixed`

items在个数不同的时候颜色不一样，2个

## 教程

### 项目命名

不允许驼峰，只能下划线

### module、plugin和package的区别

`module`用于混合开发使用

`package`中只有公共的`dart`代码，三方框架

`plugin`中有原生的比如`android`或者`ios`的代码，也是三方框架


### 跨平台上，RN和Flutter的区别

RN：在原生UI的基础上，进行的包装，用的是原生各自的渲染引擎

Flutter：效率高，不依赖UI，高度统一，自己有一个渲染引擎解析Dart代码渲染界面

### andriod和ios修改app图标和启动图

<https://juejin.cn/post/6988336881834393637#heading-1>

图标工厂: <https://icon.wuruihong.com/icon?utm_source=kpkFgWcx#/ios>

### 静态资源

需要在flutter中使用静态资源，需要在`/pubspec.yaml`中加上`assets - images/`配置

### macos如何运行ios模拟器

1. 先下载xcode
2. 然后可以关闭xcode，聚焦直接搜索`simulator.app`就可以了
3. 然后flutter里面运行的时候直接可以选择模拟器

### 更新和删除依赖

> flutter pub cache clean

> flutter pub get

## 常用插件库

<https://juejin.cn/post/7308553288399355930>