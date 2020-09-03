<!--
 * @Date: 2020-08-20 09:53:00
 * @LastEditors: Lq
 * @LastEditTime: 2020-08-20 16:08:04
 * @FilePath: /learnningNotes/html/BFC.md
-->
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


