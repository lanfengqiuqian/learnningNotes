## 文档

<https://fex-team.github.io/ueditor/>

## 常见问题

<https://github.com/haochuan9421/vue-ueditor-wrap/blob/master/docs/faq.md>

## vue3中使用推荐这个

<https://github.com/HaoChuan9421/vue-ueditor-wrap?tab=readme-ov-file#installation>

### 小技巧

#### 编辑器宽度自适应

1. 打开`/ueditor/ueditor.config.js`

2. 找到`initialFrameWidth`属性,默认值是1000.即是`initialFrameWidth: 1000`

3. 把值更改为`'100%'` , 即是`initialFrameWidth: '100%'`

4. 但是更建议在业务文件中修改`config`属性，即`editorConfig.initialFrameWidth = '100%'`


#### 下载的编辑器版本


### 问题

#### 后端配置项没有正常加载，上传插件不能正常使用！

修改`editorConfig.serverUrl`属性，默认情况下是去服务端请求配置，这里可以改为本地配置

如`serverUrl: '/uEditor/php/config.json'`

#### 上传图片方案

1. 自己重新写一个上传按钮和弹窗

    <https://juejin.cn/post/6844903941478547463>