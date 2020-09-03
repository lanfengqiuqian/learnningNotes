<!--
 * @Date: 2020-08-28 14:14:02
 * @LastEditors: Lq
 * @LastEditTime: 2020-09-02 11:18:36
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

    6. 网格线的名称

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