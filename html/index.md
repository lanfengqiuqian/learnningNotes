<!--
 * @Date: 2020-12-16 14:29:13
 * @LastEditors: Lq
 * @LastEditTime: 2021-02-03 17:21:12
 * @FilePath: /learnningNotes/html/index.md
-->
1. 伪类和伪元素

    **伪元素**
   1. 特性和定义
      1. 用来`创建`一些不存在dom树中的元素，不会改变文档的内容。
      2. 会被用户直接看到，不可选中和复制。
      3. 仅仅是在在css渲染层中加入。
      4. 建议使用`::`来表示伪元素。

   2. 种类
       1. `::after`：在元素之前插入元素或内容
       2. `::before`：在元素之后插入元素或内容
       3. `::first-line`：在文本的第一行改变样式（注意没有content属性）
       4. `::after-letter`：在文本的第一个字符改变样式（注意没有content属性）

   3. 注意：`::after`和`::before`这两个伪类有特有的属性`content`，而且必须指定该属性。而且content的值可以调用3个方法。
       > attr()：调用当前元素的属性，如显示a标签的链接、图片的提示文字等  
       > content: attr(href);  
       >  
       > url()：用于引入媒体文件，如图片等  
       > content: attr(./img.png);  
       >   
       > counter()：调用计数器，可以不用列表实现序号。  
       > 注意：加一和输出不要放到同一个选择器中。  
       > h1{counter-increment: chapter; // 将计数器进行加一}  
       > h1::before{content: counter(chapter); // 输出计数器结果}  


    **伪类**

   4. 定义：表示已经存在的元素，处于某一种状态，但是通过dom树又无法表示这种状态，就可以通过伪类来为其添加样式。建议使用`:`来表示伪元素。

   5. 种类
       1. 状态相关
           > :link 未被访问过的链接  
           > :visited 访问过的链接  
           > :active 链接被激活的时候，也就是按下鼠标未松开时
           > :focus 获取焦点的元素  
           > :hover 鼠标悬停在元素上
       2. 结构相关
           > :not(p) 选择不是p标签的  
           > :first-child/:last-child/:nth-child/:nth-last-child  
           > :target 选择当前活动状态的锚点  
       3. 表单对象相关
           > :input 匹配所有input/textarea/select/button元素  
           > :text 单行文本框  
           > :password 密码框  
           > :radio 单选按钮  
           > :checkbox 复选框  
           > :submit 提交按钮  
           > :reset 重置按钮  
           > :button 所有按钮  
           > :file 文件域名  
           > :hidden 所有不可见元素  
       4. 表单属性相关
           > :enable 匹配所有可用元素  
           > :disabled 匹配所有不可用元素  
           > :checked 匹配所有被选中元素（不包括select中的option）  
           > :select 匹配所有选中的option元素  
       5. 属性选择器
           > [attribute] 匹配包含给定属性的元素
           > [attribute=value] [attribute!=value] 匹配等于（不等于）给定属性的值的元素  
           > [attribute^=value] [attribute$=value] 匹配以特定值开头（结尾）的元素
           > [attribute*=value] 匹配包含”value“的元素
           > [selector1] [selector2] [selector3] 符合选择器


    **伪类和伪元素的区别**

    ||伪元素|伪类|
    |-|-|-|
    |表示|建议`::`|建议`:`|
    |操作对象|不存在的dom元素|存在的dom元素的状态|


2. BFC

    #### BFC定义
    1. `Block formating context`：翻译为”块级格式化上下文“。
    2. 是一个独立的渲染区域，BFC内部的元素布局不影响外部，外部的元素布局也不影响内BFC内部的元素。
    3. 在一个BFC中，行盒和块盒（一行中所有的内联元素组成）都会沿着父元素的边框进行排列。


    #### Box定义
    1. css布局的对象和基本单位，简单说，就是一个页面由许多的Box组成。
    2. 元素的自身类型（块元素、行内元素）和display属性能够影响Box的类型。
    

    #### Formating Context定义
    1. 是页面中的一块渲染区域，决定了里面的子元素如何定位，以及和其他元素的关系和相互作用。
    2. 常见的有：BFC/IFC

    #### 布局规则
    1. 内部的Box会在`垂直`方向上，一个接一个的放置。
    2. Box垂直方向上的距离由margin决定。同一个BFC内的相邻的Box的margin会发生重叠。（外边距合并特性）
    3. 计算BFC的高度时，浮动元素也参与计算。
    4. 页面上隔离的独立的容器，容器里面的子元素不会影响到外面的元素，反之也如此。


    #### 创建BFC的条件（满足其一即可）
    1. 浮动
    2. 相对定位或粘滞定位
    3. display的值是inline-block、table-cell、flex、table-caption或者inline-flex（常用的就flex）
    4. overflow的值不是visible（常用hidden）


    #### BFC的作用
    1. 避免外边距合并。

        > 相邻两个div，一个设置mrgin-bottom,一个设置maring-top  
        > 给其中一个块元素设置`overflow: hidden;`

    2. 清除浮动（高度塌陷问题）

        > 子元素浮动，父元素失去支撑，height为0  
        > 给父元素设置overflow: hidden;


3. 文本超出长度隐藏，显示3个点

    单行文本超出隐藏：需要手动指定`width`
    ```css
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    ```

    多行文本超出隐藏：需手动指定`width`和`height`
    ```css
    text-overflow: -o-ellipsis-lastline;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3; //行数需设置
    line-clamp: 3;
    -webkit-box-orient: vertical;
    ```

4. 响应式布局和自适应布局

    ||响应式|自适应|
    |-|-|-|
    |代码|一套|多套|
    |流行程度|主流|相对较少|
    |实现方式|媒体查询，伸缩布局|多端多套代码|

5. 服务端渲染：SSR

    1. 定义：将组件或者页面通过服务器生成html字符串，在发送到浏览器，最后将静态标记混合为客户端上完全交互的应用程序。
    2. 优缺点

        1. 优点：

            1. 更有利于SEO（搜索引擎优化），一般是推广类的网站需要（如新闻、博客类网站）
            2. 更有利于首屏渲染，可以让用户更快的看到页面的内容，对于大型单页应用，打包之后体积非常大，客户端加载时间较长，首页加载有一个很长的额白屏等待时间

        2. 缺点

            1. 服务器压力较大，特别是在高并发的情况下会大量占用服务器端的CPU资源
            2. 开发条件受限制，服务端渲染只会执行到`componentDidMount`之前的生命周期狗子，因此项目引入的第三方库不能在其他生命周期使用，对于库的选择产生了很大的限制
            3. 学习成本相对较高，除了对于webpack、react熟悉之外，还要掌握node、koa2等相关技术，项目构建、部署过程更加复杂

6. 重排和重绘

    重排：当DOM的变化引发了元素`几何属性`的变化，比如改变元素宽高、元素位置等，导致浏览器不得不重新计算元素的几何属性，并重新构建渲染树。

    重绘：完成重排后，要将重新构建的渲染书渲染到屏幕上，这个过程就是重绘。

    简单的说，重排负责元素的几何属性更新，重绘负责元素的样式更新。重排必定带来重绘，重绘未必带来 重排。比如改变元素的背景，不涉及元素的几何属性，这个只发生重绘。

    元素几何属性：
    
    1. 添加或删除可见的DOM元素
    2. 元素位置改变
    3. 元素本身尺寸发生改变
    4. 内容改变
    5. 页面渲染器初始化
    6. 浏览器窗口大小发生改变

    如何进行性能优化，参见这篇[文章](https://www.cnblogs.com/soyxiaobi/p/9963019.html)