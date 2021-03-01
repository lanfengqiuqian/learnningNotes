<!--
 * @Date: 2020-09-02 23:35:46
 * @LastEditors: Lq
 * @LastEditTime: 2021-02-20 18:18:56
 * @FilePath: /learnningNotes/css/index.md
-->
1. 绘制三角形和梯形

    ```css
    div {
      width: 0px;
      border-top: 100px solid teal;
      border-right: 100px solid transparent;
      border-bottom: 100px solid transparent;
      border-left: 100px solid transparent;
    }
    ```

    其中：`transparent`表示透明色，相当于rgba(0,0,0,0)

    如果是梯形的话，将`width`设置为梯形的上底，border的width就是梯形的下底

2. 文本两端对齐：justify不生效

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

3. 文本超出换行和不换行（不设置默认是换行的）

    ```css
    <!-- 超出换行 -->
    div {
        word-wrap: break-word;
        word-break: break-all;
        overflow: hidden;
    }

    <!-- 超出不换行 -->
    div {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    ```

4. 字体透明度继承问题

    如果父级元素的透明度使用`opacity`，那么子元素的字体也会继承父元素的透明度，并且由于透明度是相乘的，所以无法使用覆盖的方式调整子元素的透明度

    解决方案：

    1. 父元素使用`rgba`的方式来设置透明度
    2. 两个元素不使用继承关系，而是使用兄弟关系（不推荐使用）

5. boxshadow
   
   demo
   
   ```css
   // x轴偏移量，y轴偏移量，阴影模糊度，阴影扩展半径，阴影颜色，设置为内阴影（如果不写默认为外阴影）
   box-shadow:1px 2px 3px 4px #ccc inset;
   ```
   
   比较淡雅美观的阴影

    ```css
    box-shadow: rgba(0,0,0,.2) 0 1px 5px 0px;
    ```

6. 修改input中的placeholder样式（含内容样式）

    ```css
    input::-webkit-input-placeholder {
        // 样式代码
    }
    ```

7. 文本超出显示`...`

    ```css
    // 一行文本超出
    overflow: hidden;
    text-overflow:ellipsis;
    white-space: nowrap;

    // 多行文本超出
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    overflow: hidden;
    ```

8. 修改滚动条样式

    隐藏div元素的滚动条

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