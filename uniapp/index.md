#### 修改 input 的 placeholder 样式

1. 使用`placeholder-style`直接写行内样式（`这个我没生效`）
2. 使用`placeholder-class`增加类名（`这个可以`）

   1. 只能使用`font-size、font-weight、color`这几个属性
   2. 如果`style`中有`scoped`时，需要在类名前加上`/deep/`

3. 使用原生 css 方法修改（`这个我没生效`）

#### 使用自定义导航栏

官方文档[https://uniapp.dcloud.net.cn/collocation/pages.html#customnav](https://uniapp.dcloud.net.cn/collocation/pages.html#customnav)


#### 运行报错：uni-app编译器下载失败

尝试通过管理员身份运行程序

如果还是不行的话，查看日志：`【帮助】 => 查看运行日志`