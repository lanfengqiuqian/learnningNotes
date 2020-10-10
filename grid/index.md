<!--
 * @Date: 2020-08-28 14:14:02
 * @LastEditors: Lq
 * @LastEditTime: 2020-10-10 18:27:47
 * @FilePath: /learnningNotes/grid/index.md
-->
## CSS Grid网格布局学习笔记

### 介绍

1. 是最强大的CSS布局方案
2. 将网页分为一个个网格，可以任务组合不同的网格， 来达到不同的布局的效果。

##### 和flex布局区别
1. 都可以指定容器内部多个项目的位置。
2. flex是轴线布局，只能指定**项目**针对轴线的位置，可以看作**一维布局**
3. grid将容器分成了行和列，有点像table的单元格，可以看作**二维布局**

##### 基本概念

1. 容器和项目
    ```html
    <div class="container">
      <div class="item">
        <span>one</span>
      <div>
      <div class="item">
        <span>two</span>
      <div>
      <div class="item">
        <span>three</span>
      <div>
    </div>
    ```
     1. 容器（container）：采用网格布局的整个区域。如上面代码中类名为”container“的div就是容器。
     2. 项目（item)：容器的顶层的元素，不包括项目的子元素（如上面代码中的span元素就不是项目，只有类名为”item“的才能称之为项目）
     3. 在grid布局中，只会对于item生效，对于项目的子元素不受影响。
2. 行和列：容器中的水平的区域叫做“行”，垂直的区域叫做“列”。
3. 单元格：类似表格的单元格，行和列的相交的区域就产生了单元格。
4. 网格线：类似于表格的边框线。

#### 容器属性

1. `display`
    1. `grid`：指定一个容器采用网格布局。这种情况下容器本身是块级元素。
    2. `inline-grid`：同上，不过这种情况容器本身是行内元素。
    3. `注意`：设置为网格布局之后，项目的`float`/`display: inline-block`/`display: table-cell`/`vertical-align`/`column-*`等设置都会失效。

2. `grid-template-columns`：指定每一列的列宽。

    `grid-template-rows`：指定每一行的行高。

    属性值：可以为绝对单位，也可以是百分比
    ```css
    .container {
      display: grid;
      grid-template-columns: 100px 50px 200px; // 第1，2，3列的宽度分别为100px/50px/200px
      grid-template-rows: 100px 200px 300px; // 第1，2，3行的行高分别为100px/200px/300px
    }
    ```
    但是手动指定每一个元素的宽高非常麻烦，所以有几个函数能够调用。
    1. repeat(重复次数，重复的值)  
        ```css
        .container {
          display: grid;
          grid-template-columns: repeat(3, 100px); // 前3列元素，每一个为100px的宽
          grid-template-rows: repeat(3, 100px); // 前3行元素，每一个为100px的高
        }
        ```
        其中第二个参数也可以是一组值，代表重复的序列
        ```css
        .container {
          display: grid;
          grid-template-columns: repeat(2, 100px 200px 300px); // 重复两次，序列为100，200，300
          grid-template-rows: repeat(3, 100px 200pxg); // 重复3次，序列为100，200
        }
        ```

    2. auto-fill  

        作为`repeat`函数的第一个参数
        表示自动填充，当容器大小不固定的时候，通过指定尺寸进行自动填充，直到无法放下更多的元素.  
        `注意`：不会像flex一样自动扩张，所以右边会有一部分空隙
        
          ```css
          grid-template-columns: repeat(auto-fill, 300px);
          grid-template-rows: repeat(auto-fill, 50px);
          ```
          但是在`columns`和`rows`不指定宽高的效果并不一样：  
            1. 不指定`height`时：第一行的`rows`会生效，后面的几行的`rows`由内容决定（所以一般不用rows方向的这个属性）  
            2. 不指定`width`时：默认为`100%`，就是会优先铺满

    3. fr（fraction）

        表示比例关系，能够按照比例扩张  
        如果两列的宽度分别为`1fr`和`2fr`，就表示后面的宽度是前面的两倍
        ```css
        grid-template-columns: 1fr 3fr 2fr;
        grid-template-rows: repeat(3, 80px);
        ```
        可以和绝对单位混合使用，达到flex效果
        ```css
        .container {
          display: grid;
          grid-template-columns: 150px 1fr 2fr;
        }
        ```

    4. minmax(min, max)

        产生一个长度范围，表示长度就在这个范围之中，参数为最大值和最小值。
        ```css
        grid-template-columns: 1fr 1fr minmax(100px, 1fr);
        ```

    5. auto

        表示由浏览器自己决定长度  
        我觉得在某种程度上来说和`fr`类似，就是是每一项扩张比例相同的时候
        ```css
        grid-template-columns: 100px auto 100px;
        grid-template-columns: 100px 1fr 100px;
        ```

    6. 网格线的名称（和`grid-column`和`grid-row`结合使用）

        使用`[]`指定每一根网格线的名字，方便以后的引用。  
        `注意`：是代表网格线，所以比元素行列数多1。  
        能够允许同一根线有多个名字，比如`[fifth-line row-5]`
        ```css
        .container {
        display: grid;
        grid-template-columns: [c1] 100px [c2] 100px [c3] auto [c4];
        grid-template-rows: [r1] 100px [r2] 100px [r3] auto [r4];
        }
        ```

    7. 布局实例（常用demo）

        1. 两栏式布局

            ```css
            .container {
            display: grid;
            grid-template-columns: 70% 30%;
            }
            ```

        2. 12网格布局

            ```css
            .container {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            }
            ```

3. `grid-row-gap`：设置行间距

    `grid-column-gap`：设置列间距

    `grid-gap`：`grid-row-gap`和`grid-column-gap`的简写，如果两个值相同，则可以省略第二个值（先水平，后垂直）

    ```css
    .container {
       grid-gap: 40px 20px;
       <!-- 等价于 -->
       grid-row-gap: 40px;
       grid-column-gap: 20px;
    }
    ```

    `新标准`删除了前缀：`row-gap`/`column-gap`/`gap`

4. `grid-template-areas`：指定区域，一个区域由多个单元格组成

    指定区域后，能够将项目放到指定的区域中（和项目的`grid-area`结合使用）

    ```css
    .container {
        display: grid;
        grid-template-columns: 100px 100px 100px;
        grid-template-rows: 100px 100px 100px;
        grid-template-areas: 'a b c'
                            'd e f'
                            'g h i';
    }
    ```

5. `grid-auto-flow`：指定元素排列顺序

    `row`：即先行后列（`默认值`）  

    `columns`：先列后行  

    `row dense`：某些项目指定位置之后，剩下的项目`从行开始`自动摆放  

    `column dense`：某些项目指定位置之后，剩下的项目`从列开始`自动摆放  
    
    如图：先摆放好1和2，之后使用row/row dense/column dense的效果  

    <img src="./img/row.png" width="30%">
    <img src="./img/row-dense.png" width="30%">
    <img src="./img/column-dense.png" width="30%">


6. `justify-items`：设置单元格内容的水平位置

    `align-items`：设置单元格内容的垂直位置

    `place-items`：`align-items`和`justify-items`的简写，如果两个值相同，那么可以省略第二个（先垂直方向，后水平方向）

    ```css
    .container {
        justify-items: start | end | center | stretch;
        align-items: start | end | center | stretch;
    }
    ```
    `stretch`：拉伸，占满单元格整个宽度

7. `justify-content`：设置整个内容区域在容器中的水平位置

    `align-content`：设置整个内容区域在容器中的垂直位置

    ```css
    .container {
        justify-content: start | end | center | stretch | space-around | space-between | space-evenly;
        align-content: start | end | center | stretch | space-around | space-between | space-evenly;  
    }
    ```
    `place-content`：`justify-content`和`align-content`的简写形式，如果两个值相同，那么可以省略第二个（先垂直，后水平）

    start：容器起始位置  
    end：容器结束位置  
    center：容器内部居中  
    stretch：项目没有指定大小时，拉伸占据整个网格容器  
    space-around：每个项目的两侧的间隔相等（项目之间间隔比项目和容器的间隔大一倍）  
    space-between：项目和项目的间隔相等，容器和项目之间没有间隔  
    space-evenly：项目和项目的间隔相等，项目和容器之间的间隔也是这个距离  


8. `grid-auto-columns`和`grid-auto-rows`

    有时候，一些项目的指定位置在现有网格的外部。比如网格只有3列，但是一个项目指定在第5行，这个时候，浏览器会自动生成多余的网格，以便放置项目。

    `grid-auto-columns`和`grid-auto-rows`用于设置浏览器自动创建的多余网格的列宽和行高。他们的写法与`grid-template-columns`和`grid-template-rows`完全相同。如果不指定这两个属性，浏览器则会完全根据单元格内容的大小，来决定新增网格的列宽和行高。

    ```css
    .container {
        display: grid;
        grid-template-columns: 100px 100px 100px;
        grid-template-rows: 100px 100px 100px;
        grid-auto-rows: 50px; 
    }
    ```

9.  `grid-template`和`grid`属性

    `grid-template`是`grid-template-columns`、`grid-template-rows`、`grid-template-areas`这三个属性的合并简写形式

    `grid`是`grid-template-rows`、`grid-template-columns`、`grid-template-areas`、`grid-auto-rows`、`gird-auto-columns`、`grid-auto-flow`这六个属性的合并简写形式。

    从易读易写的角度考虑，不建议使用合并简写属性。、


#### 项目属性

1. 指定项目位置，指定项目的四个边框，分别定为在哪根网格线

    1. `grid-column-start`：左边框所在的垂直网格线（左）
    2. `grid-column-end`：右边框所在的垂直网格线（右）
    3. `grid-row-start`：上边框所在的水平网格线（上）
    4. `grid-row-end`：下边框所在的水平网格线（下）  

    示例代码如下：

    ```css
    // 将第一个项目左边框放到第二根网格线，右边框放到第四根网格线
    .container div:first-child {
    grid-column-start: 2;
    grid-column-end: 4;
    }
    ```

    属性值可以是数字，代表第几根网格线，也可以是网格线的名字，代表哪一根网格线，还可以是`span`关键字，代表左右（上下）边框之间跨域了多少个网格。

    ```css
    grid-column-start: 2;
    grid-column-start: header-start;
    // 左边框距离右边框跨越了2个网格
    grid-column-start: span 2;
    // 效果同上
    grid-column-end: span 2;
    ```

    使用这几个属性之后，如果发生了项目重叠，则使用`z-index`指定项目的重叠顺序

    合并简写属性：注意不要漏了`/`符号

    斜杠后面的可以省略，则默认跨域一个网格

    ```css
    grid-cloumn: <start-line> / <end-line>;
    grid-row: <start-line> / <end-line>;

    // demo
    grid-column: 1 3;
    grid-row: 1 2;

    // 等价于
    grid-column-start: 1;
    grid-column-end: 3; // 等价于 span 2
    grid-row-start: 1;
    grid-row-end: 2; // 等价于 span 1
    ```

2. `grid-area`：指定项目放在哪一个区域（和`grid-template-areas`结合使用）

    ```css
    .container {
        display: grid;
        grid-template-areas: 'a b c'
                            'd e f'
                            'g h i';
    }
    .item {
        grid-area: e;
    }
    ```

    还能够作用于`grid-row-start`,`grid-row-end`,`grid-column-start`,`grid-column-end`的合并简写形式，直接指定项目的位置。

    ```css
    item {
        // 上 左 下 右
        grid-area: <row-start> / <column-start> / <row-end> / <column-end>;
    }
    ```

3. 设置单元格内容的水平和垂直方向位置

    `justify-slef`：水平位置（左中右），和`justify-items`属性用法完全一致，单只作用于单个项目

    `align-self`：垂直位置（上中下），和`align-items`属性用法完全一致，但只作用于单个项目

    ```css
    .item {
        // 开始 结束 居中 拉伸（默认占满单元格宽度）
        justify-self: start | end | center | stretch;
        align-self: start | end | center | stretch;
    }
    ```

    `place-self`：`justify-slef`和`align-self`两个属性的合并简写形式，如果省略第二个值，则认为两个值相等。

    ```css
    // 垂直方向 水平方向
    place-self: <align-self> <justify-self>
    ```