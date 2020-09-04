<!--
 * @Date: 2020-09-02 23:35:46
 * @LastEditors: Lq
 * @LastEditTime: 2020-09-02 23:39:04
 * @FilePath: \learnningNotes\css\index.md
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