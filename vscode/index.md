<!--
 * @Date: 2020-11-03 14:22:26
 * @LastEditors: Lq
 * @LastEditTime: 2022-08-03 17:29:17
 * @FilePath: \learnningNotes\vscode\index.md
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

4. 折叠和展开当前模块

    > 折叠  
    > ctrl + k, ctrl + [  
    > 展开  
    > ctrl + k, ctrl + ]


### 快速收起资源树

在vscode的左侧资源树的时候，如果不小心展开了node_modules的代码，要手动拉到最上面去收起是很麻烦的

鼠标聚焦到左侧的一个文件，按键盘左方向键的能收起当前目录，右方向键就能展开当前目录

### 上传文件提示 sftp upload no such file
```js
Editing the file:
~/.vscode/extensions/liximomo.sftp-1.12.9/node_modules/ssh2-streams/lib/sftp.js
change the line 388:
if (code === STATUS_CODE.OK) {
to:
if (code === STATUS_CODE.OK || code === STATUS_CODE.NO_SUCH_FILE) {
Reload vscode
It is not the most correct option but it works.
```

### 好用的vscode插件整理

1. Auto Close Tag
   
   功能：自动闭合标签

2. Bracket Pair Colorizer

    功能：代码括号匹配高亮，彩虹颜色匹配

    缺点：代码多了容易导致很卡（后来我卸载了。。。）

3. Beautify

    功能：代码格式化插件，只对于JS、JSON、CSS、Sass、HTML生效

    使用：参见[这里](https://blog.csdn.net/zwli96/article/details/86543130)

4. Chinese

    功能：编辑器汉化

5. ES7 React/Redux/GraphQL/React-Native snippets

    功能：代码快速提示，生成代码块

    使用：参见[这里](https://marketplace.visualstudio.com/items?itemName=dsznajder.es7-react-js-snippets)

6. Git Blame

    功能：能够查看某一行代码的git提交记录

7. Highlight Matching Tag

    功能：高亮匹配标签

8. indent-rainbow

    功能：代码缩进高亮彩虹色

9.  koroFileHeader

    功能：自动生成文件注释和方法注释

    使用：参见[这里](https://github.com/OBKoro1/koro1FileHeader/wiki/%E5%AE%89%E8%A3%85%E5%92%8C%E5%BF%AB%E9%80%9F%E4%B8%8A%E6%89%8B)

10. Material Icon Theme

    功能：左侧文件图标主题配置

11. One Dark Pro

    功能：代码主题风格

12. open in browser

    功能：html文件在浏览器打开

13. Path Intellisense

    功能：路径自动感知

14. Project Manager

    功能：将多个项目进行集中到左侧的菜单栏，方便打开

15. SFTP

    功能：将文件上传到服务器

    使用：参见[这里](https://blog.csdn.net/qq_43382853/article/details/104791852)

16. Tabnine

    功能：代码智能提示（很强大）

17. Vue VSCode Snippets

    功能：vue代码块插件

    使用：[常用快捷键及其配置](https://blog.csdn.net/qq_41107231/article/details/117195087)，或者[官网](https://github.com/sdras/vue-vscode-snippets)

18. eslint

    功能：检测代码格式

    使用：[保存自动格式化代码](https://blog.csdn.net/lovefengruoqing/article/details/89478355)

19. Prettier - Code formatter

    功能：格式化代码

    注意：插件市场有2个，选择那个大的，下载量多的

### 删除一行快捷键

> ctrl + shift + k;

### Tab键忽然失效

在其他的软件中tab都能正常使用，但是vscode中失效了

原因：使用了`ctrl + M`切换了`Tab`按键行为（缩进或者移动焦点）

解决：再使用`ctrl + M`切换回去就好了

### 扩大（缩小）选择

> shift + alt + →  
> shift + alt + ←

### 批量选择当前所有匹配文本

> ctrl + f2  
> ctrl + shift + L

### 选择同一列的多行文本

> alt + shift + 鼠标左键

### 打开的空的新标签页面选择编程语言

> ctrl + k  
> 然后松开ctrl 
> 然后再按m

### 切换极小地图的可见性

1. `ctrl + shift + p`打开命令面板

2. 搜索`minimap`

3. 回车确认切换

### 两个控制台切换

在打开控制台的情况下，`ctrl + PageUp/PageDown`

### 打开快捷键预览和设置

> ctrl + k, ctrl + s

### ctrl + shift +enter无效

原因：快捷键冲突，如我的和`Markdown Preview Enhanced`扩展的冲突了

检查：`ctrl + k, ctrl + s`打开快捷键预览和设置

如果需要的话改建，如果不需要删除绑定即可

### 去除空行

1. ctrl + h打开替换
2. 输入`^\s*(?=\r?$)\n`
3. 然后点击右边的`.*`符号（使用正则匹配）
4. 然后点击`全部替换`