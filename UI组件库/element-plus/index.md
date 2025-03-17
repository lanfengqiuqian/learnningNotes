[toc]

### 修改主题色

1. 根目录创建文件，如`element-variables.scss`

   ```scss
   @forward "element-plus/theme-chalk/src/common/var.scss" with (
     $colors: (
       "primary": (
         "base": #d61b1a,
         "color": #fff,
       ),
     )
   );

   @use "element-plus/theme-chalk/src/index.scss" as *;
   ```

2. 然后在`main.ts`中引入

   ```js
   import "../element-variables.scss";
   ```

### table 右侧有一部分空白

不要所有列都定死`width`，留一列进行自适应，但是这种情况不会有滚动条了，除非超出宽度了

所以最好多设几列活动的，然后设置`min-width`


### 官方文档不稳定，经常打不开

官方网站 <https://element-plus.org/>

使用中国镜像加速站点 <https://cn.element-plus.org/zh-CN/component/overview.html>