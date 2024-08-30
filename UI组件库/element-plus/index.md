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

不要所有列都定死`width`，留一列进行自适应
