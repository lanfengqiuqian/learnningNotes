<!--
 * @Date: 2020-09-02 23:35:46
 * @LastEditors: Lq
 * @LastEditTime: 2020-11-20 14:55:03
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