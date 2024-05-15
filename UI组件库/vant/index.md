### field组件，点击之后会放大页面

会自动聚焦，然后把当前页面放大，输入之后，需要手动把页面缩小才正常（主要是出现在iphone手机上）

原因：苹果觉得点击输入框放大是一个`很好`的体验，就擅自把页面给放大了

解决方案：在根目录的`index.html`文件中增加`meta`

```js
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
```

1. inital-scale属性控制页面最初加载时的缩放等级，即当页面第一次load的时候缩放比例
2. maximum-scale属性控制用户缩放到的最大比例
3. minimum-scale属性控制允许用户缩放到的最小比例
4. user-scalable属性控制用户是否可以手动缩放

