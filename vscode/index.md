<!--
 * @Date: 2020-11-03 14:22:26
 * @LastEditors: Lq
 * @LastEditTime: 2020-12-09 15:26:45
 * @FilePath: /learnningNotes/vscode/index.md
-->
### 空目录折叠问题

场景：在vscode中新建一个目录(outer)，然后在这个空目录中在新建一个目录(inner)，然后发现目录被折叠了，也就是变成了只有一层

目录树中呈现这样的形式：`outer/inner`

解决方案：

> 打开设置->搜索`compact folders`->取消勾选即可

> 关于`compact folders`描述：控制资源管理器是否应以紧凑形式呈现文件夹,在这种形式中,单个子文件夹将被压缩在组合的树元素中。例如,对Java包结构很有用。

### 快速跳转某一行

windows：`ctrl` + `g`
mac：`ctrl` + `g` 注意在这里mac的是ctrl而不是command哦

或者是`ctrl` + p，然后输入`>:`，然后输入行数

或者是`ctrl` + `shift` + p，然后输入`:`，然后在输入行数


### 展开折叠代码

1. 折叠所有函数

    > ctrl + k, ctrl + 0 (注意这里是数字0，而不是字母o哦)

2. 折叠到某一级

    > ctrl +k, ctrl + n (这里的n取值为1，2，3，4。。。等你想要折叠的级数)

3. 展开所有函数

    > ctrl + k, ctrl + j