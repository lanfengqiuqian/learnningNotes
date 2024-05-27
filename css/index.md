<!--
 * @Date: 2020-09-02 23:35:46
 * @LastEditors: Lq
 * @LastEditTime: 2021-02-20 18:18:56
 * @FilePath: /learnningNotes/css/index.md
-->

### 绘制三角形和梯形

```css
div {
  width: 0px;
  border-top: 100px solid teal;
  border-right: 100px solid transparent;
  border-bottom: 100px solid transparent;
  border-left: 100px solid transparent;
}
```

其中：`transparent`表示透明色，相当于 rgba(0,0,0,0)

如果是梯形的话，将`width`设置为梯形的上底，border 的 width 就是梯形的下底

原理：宽高设置为 0，通过 border 来控制，3 个边框透明，另外一个正常设置即可

2. 文本两端对齐：justify 不生效

   因为`text-align`不会处理被打断的行和最后一行，当文本只占一行时不会有效果。

   1. 使用`text-align-last`属性：但是某些浏览器不支持

   2. 在最后一行人工生成两行文本，然后将第二行隐藏

      使用伪元素是最佳解决方案

   ```css
   // 方案一
   & {
     text-align-last: justify;
   }

   // 方案二
   &::after {
     display: inline-block;
     overflow: hidden;
     content: "";
     width: 100%;
   }
   ```

### 文本超出换行和不换行（不设置默认是换行的）

```css
<!-- 超出换行 -- > div {
  word-wrap: break-word;
  word-break: break-all;
  overflow: hidden;
}

<!-- 超出不换行 -- > div {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
```

### 字体透明度继承问题

如果父级元素的透明度使用`opacity`，那么子元素的字体也会继承父元素的透明度，并且由于透明度是相乘的，所以无法使用覆盖的方式调整子元素的透明度

解决方案：

1.  父元素使用`rgba`的方式来设置透明度
2.  两个元素不使用继承关系，而是使用兄弟关系（不推荐使用）

### boxshadow

demo

```css
// x轴偏移量，y轴偏移量，阴影模糊度，阴影扩展半径，阴影颜色，设置为内阴影（如果不写默认为外阴影）
box-shadow: 1px 2px 3px 4px #ccc inset;
```

比较淡雅美观的阴影

```css
box-shadow: rgba(0, 0, 0, 0.2) 0 1px 5px 0px;
```

### 修改 input 中的 placeholder 样式（含内容样式）

```css
input::placeholder {
  // some code
}
<!-- 其他浏览器兼容 -->
/* - Chrome ≤56,
- Safari 5-10.0
- iOS Safari 4.2-10.2
- Opera 15-43
- Opera Mobile >12
- Android Browser 2.1-4.4.4
- Samsung Internet
- UC Browser for Android
- QQ Browser */
::-webkit-input-placeholder {
  color: #ccc;
  font-weight: 400;
}

/* Firefox 4-18 */
:-moz-placeholder {
  color: #ccc;
  font-weight: 400;
}

/* Firefox 19-50 */
::-moz-placeholder {
  color: #ccc;
  font-weight: 400;
}

/* - Internet Explorer 10–11
- Internet Explorer Mobile 10-11 */
:-ms-input-placeholder {
  color: #ccc !important;
  font-weight: 400 !important;
}

/* Edge (also supports ::-webkit-input-placeholder) */
::-ms-input-placeholder {
  color: #ccc;
  font-weight: 400;
}

/* CSS Working Draft */
::placeholder {
  color: #ccc;
  font-weight: 400;
}
```

### 文本超出显示`...`

```css
// 一行文本超出
overflow: hidden;
text-overflow: ellipsis;
white-space: nowrap;

// 多行文本超出
display: -webkit-box;
-webkit-box-orient: vertical;
-webkit-line-clamp: 3;
overflow: hidden;
```

### 修改滚动条样式

隐藏 div 元素的滚动条

```css
div::-webkit-scrollbar {
  display: none;
}
```

其他属性

> div::-webkit-scrollbar 滚动条整体部分  
> div::-webkit-scrollbar-thumb 滚动条里面的小方块，能向上向下移动（或往左往右移动，取决于是垂直滚动条还是水平滚动条  
> div::-webkit-scrollbar-track 滚动条的轨道（里面装有 Thumb  
> div::-webkit-scrollbar-button 滚动条的轨道的两端按钮，允许通过点击微调小方块的的位置  
> div::-webkit-scrollbar-track-piece 内层轨道，滚动条中间部分（除去
> div::-webkit-scrollbar-corner 边角，即两个滚动条的交汇处  
> div::-webkit-resizer 两个滚动条的交汇处上用于通过拖动调整元素大小的小控件注意此方案有兼容性问题，一般需要隐藏滚动条时我都是用一个色块通过定位盖上去，或者将子级元素调大，父级元素使用 overflow-hidden 截掉滚动条部分。暴力且直接。

### 设置背景图片完美填充

```css
// 方案一
margin: 0px;
background: url(images/bg.png) no-repeat;
background-size: 100% 100%;
background-attachment: fixed;

// 方案二
background: url("bg.png") no-repeat;
height: 100%;
width: 100%;
overflow: hidden;
background-size: cover; //或者background-size:100%;

// 方案三
/* 加载背景图 */
background-image: url(images/bg.jpg);
/* 背景图垂直、水平均居中 */
background-position: center center;
/* 背景图不平铺 */
background-repeat: no-repeat;
/* 当内容高度大于图片高度时，背景图像的位置相对于viewport固定 */
background-attachment: fixed;
/* 让背景图基于容器大小伸缩 */
background-size: cover;
/* 设置背景颜色，背景图加载过程中会显示背景色 */
background-color: #464646;
```

### chrome 中文界面下会默认将小于 12px 的文本强制按照 12px 显示

    [https://blog.csdn.net/qq_43687594/article/details/124479693](https://blog.csdn.net/qq_43687594/article/details/124479693)

### css 浏览器前缀

    定义：CSS 的“前缀”（即在 CSS 属性名前面添加特定的字符串）。这些前缀告诉浏览器使用的 CSS 版本，并确保网站在多个浏览器上的正确呈现

    常见浏览器前缀

    ```js
    -webkit- Chrome和Safari浏览器的私有前缀
    -moz-  Mozilla Firefox浏览器的私有前缀
    -ms-   Microsoft Internet Explorer浏览器的私有前缀
    -o-    Opera浏览器的私有前缀
    ```

    在下面的示例中，我们将展示如何在所有浏览器上实现一个渐变背景，包括使用前缀的示例代码：

    ```js
    background: linear-gradient(to bottom, #1e5799 0%, #7db9e8 100%); /* 标准语法，所有现代浏览器都支持 */
    background: -webkit-linear-gradient(top, #1e5799 0%, #7db9e8 100%); /* Chrome 和 Safari */
    background: -moz-linear-gradient(top, #1e5799 0%, #7db9e8 100%); /* Firefox */
    background: -ms-linear-gradient(top, #1e5799 0%, #7db9e8 100%); /* Internet Explorer */
    background: -o-linear-gradient(top, #1e5799 0%, #7db9e8 100%); /* Opera */
    ```

### `last-child`和`:last-of-type`

    关键点：

    1. `last-child`：父元素的最后一个子元素，且这个元素是 css 指定的元素，才可以生效

       说明：如果父元素最后一个不是指定的元素，则不生效

    2. `last-of-type`：一群同选择器的元素中的最后一个

       说明：找相同的符合条件的选择器，然后这里面的最后一个元素

    ```html
    <head>
      <meta charset="utf-8" />
      <title></title>
      <style type="text/css">
        p {
          border-bottom: 1px solid #aaaaaa;
        }
        <!-- 最后一个p元素生效 -- > .p:last-of-type {
          border-bottom-color: #f00;
        }
        <!-- 不生效 -- > .p:last-child {
          color: blue;
        }
      </style>
    </head>
    <body>
      <p class="p">我是第1个p元素的内容</p>
      <p class="p">我是第2个p元素的内容</p>
      <p class="p">我是第3个p元素的内容</p>
      <p class="p">我是最后一个p元素的内容</p>
      <div class="p">我是干扰元素</div>
    </body>
    ```

13. @media print 样式

```css
@media print {
  @page {
    /* 纵向打印 */
    // size: portrait;

    /* 横向打印 */
    size: landscape;

    /* 去掉页眉页脚*/
    margin-top: 0;
    margin-bottom: 0;
  }
  /* 告诉浏览器在渲染它时不要对框进行颜色或样式调整 */
  * {
    -webkit-print-color-adjust: exact !important;
    -moz-print-color-adjust: exact !important;
    -ms-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
  }

  /*打印不显示打印按钮*/
  .print-button-container {
    display: none !important;
  }

  /* 伪类 :first 用于匹配到文档的第一页, 首页上页边距设置为 10cm */
  @page :first {
    margin-top: 10cm;
  }

  /* 通过分别设置左页和右页不同的左右页面距，为装订边留出更多的空间 */
  /**/
  @page :left {
    margin-left: 2.5cm;
    margin-right: 2.7cm;
  }
  @page :right {
    margin-left: 2.7cm;
    margin-right: 2.5cm;
  }
}
```

### 解决 flex 两端对齐的情况下，最后一行无法对齐的情况

1.  方案一：`html`结构上，最后增加一些空元素进行占位（`最实用`）

    稍微多增加一些空元素，设置`height: 0`，这样超出一行不会占据高度，设置`width`为元素宽度

    ```html
    <div class="container">
      <div class="item"></div>
      <div class="item"></div>
      <div class="item"></div>
      <div class="item"></div>
      <div class="item"></div>
      <div class="item"></div>
      <div class="item"></div>
      <div class="item"></div>
      <div class="item"></div>
      <div class="item"></div>
      <div class="item"></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
    ```

    缺点：如果每个元素不是定宽的话不适用

2.  方案二：`css`设置`伪元素`

    ```css
    .container::after {
      content: "";
      flex: auto;
      /* 或者flex: 1 */
    }
    ```

    缺点：如果之前元素有间距的话，最后伪元素左间距为空，不美观

3.  方案三：最后一个元素设置`margin-right: auto`

    ```css
    .list:last-child {
      margin-right: auto;
    }
    ```

    缺点：效果同上

4.  抛弃 flex 布局，使用 grid 布局

    ```css
    .container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 10px;
      justify-items: center;
      align-items: center;
    }
    .item {
      height: 150px;
      width: 150px;
    }
    ```


### table设置圆角

背景

1. 如果我们`直接`对table设置`border-radius`是不会生效的
2. 因为table的默认属性`border-collapse`值为`collapse`。`border-collapse:collapse`和`border-radius`不兼容。
3. 因此，我们需要将`border-collapse`的值设置为`separate`。

方案

可以参考这个[https://juejin.cn/post/6844904175856271374](https://juejin.cn/post/6844904175856271374)