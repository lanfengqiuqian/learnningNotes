<!--
 * @Date: 2020-11-03 14:22:26
 * @LastEditors: Lq
 * @LastEditTime: 2022-08-03 17:29:17
 * @FilePath: \learnningNotes\vscode\index.md
-->

### 空目录折叠问题

场景：在 vscode 中新建一个目录(outer)，然后在这个空目录中在新建一个目录(inner)，然后发现目录被折叠了，也就是变成了只有一层

目录树中呈现这样的形式：`outer/inner`

解决方案：

> 打开设置->搜索`compact folders`->取消勾选即可

> 关于`compact folders`描述：控制资源管理器是否应以紧凑形式呈现文件夹,在这种形式中,单个子文件夹将被压缩在组合的树元素中。例如,对 Java 包结构很有用。

### 快速跳转某一行

windows：`ctrl` + `g`
mac：`ctrl` + `g` 注意在这里 mac 的是 ctrl 而不是 command 哦

或者是`ctrl` + p，然后输入`>:`，然后输入行数

或者是`ctrl` + `shift` + p，然后输入`:`，然后在输入行数

### 展开折叠代码

1. 折叠所有函数

   > ctrl + k, ctrl + 0 (注意这里是数字 0，而不是字母 o 哦)

2. 折叠到某一级

   > ctrl +k, ctrl + n (这里的 n 取值为 1，2，3，4。。。等你想要折叠的级数)

3. 展开所有函数

   > ctrl + k, ctrl + j

4. 折叠和展开当前模块

   > 折叠  
   > ctrl + k, ctrl + [
   >
   > > 展开
   > > ctrl + k, ctrl + ]

### 快速收起资源树

在 vscode 的左侧资源树的时候，如果不小心展开了 node_modules 的代码，要手动拉到最上面去收起是很麻烦的

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

### 好用的 vscode 插件整理

直接查看我最新的博客<https://lanfengqiuqian.blog.csdn.net/article/details/141421595>

1. ~~Auto Close Tag（已经内置）~~

   功能：自动闭合标签

   设置搜索：`auto closing tags`

2. ~~Bracket Pair Colorizer 和 Bracket Pair Colorizer 2(vscode 内置了)~~

   功能：代码括号匹配高亮，彩虹颜色匹配

   缺点：代码多了容易导致很卡（后来我卸载了。。。），现在发现已经集成到 vscode 中了

   设置搜索：`Bracket Pair Colorization`

   `one dark pro`默认只有 3 种括号颜色，我这里修改了一下自用

   ```json
    "workbench.colorCustomizations": {
        "[One Dark Pro]": {
            "editorBracketHighlight.foreground1": "#FFD580",
            "editorBracketPairGuide.activeBackground1": "#FFD58040",
            "editorBracketHighlight.foreground2": "#C581D6",
            "editorBracketPairGuide.activeBackground2": "#C581D640",
            "editorBracketHighlight.foreground3": "#87CEFA",
            "editorBracketPairGuide.activeBackground3": "#87CEFA40",
            "editorBracketHighlight.foreground4": "#98FB98",
            "editorBracketPairGuide.activeBackground4": "#98FB9840",
            "editorBracketHighlight.foreground5": "#F0E68C",
            "editorBracketPairGuide.activeBackground5": "#F0E680B2",
            "editorBracketHighlight.foreground6": "#B0C4DE",
            "editorBracketPairGuide.activeBackground6": "#B0C4DE40",
            "editorBracketHighlight.unexpectedBracket.foreground": "#FF6347"
        }
    }
   ```

3. Beautify

   功能：代码格式化插件，只对于 JS、JSON、CSS、Sass、HTML 生效

   使用：参见[这里](https://blog.csdn.net/zwli96/article/details/86543130)

4. Chinese

   功能：编辑器汉化

5. ES7 React/Redux/GraphQL/React-Native snippets

   功能：代码快速提示，生成代码块

   使用：参见[这里](https://marketplace.visualstudio.com/items?itemName=dsznajder.es7-react-js-snippets)

6. Git Blame

   功能：能够查看某一行代码的 git 提交记录

7. Highlight Matching Tag

   功能：高亮匹配标签

8. ~~indent-rainbow (已经内置)~~

   功能：代码缩进高亮彩虹色

   设置搜索：`Bracket pairs`

9. koroFileHeader

   功能：自动生成文件注释和方法注释

   使用：参见[这里](https://github.com/OBKoro1/koro1FileHeader/wiki/%E5%AE%89%E8%A3%85%E5%92%8C%E5%BF%AB%E9%80%9F%E4%B8%8A%E6%89%8B)

10. Material Icon Theme

    功能：左侧文件图标主题配置

11. One Dark Pro

    功能：代码主题风格

12. open in browser

    功能：html 文件在浏览器打开

13. ~~Path Intellisense(vscode 内置)~~

    功能：路径自动感知

14. Project Manager

    功能：将多个项目进行集中到左侧的菜单栏，方便打开

15. SFTP

    功能：将文件上传到服务器

    使用：参见[这里](https://blog.csdn.net/qq_43382853/article/details/104791852)

16. Tabnine

    功能：代码智能提示（很强大）

    > 免费版只有 35%的功能，收费版，每月 10 美元

    > 我后来选择 Codeium 了，免费

17. Vue VSCode Snippets

    功能：vue 代码块插件

    使用：[常用快捷键及其配置](https://blog.csdn.net/qq_41107231/article/details/117195087)，或者[官网](https://github.com/sdras/vue-vscode-snippets)

18. eslint

    功能：检测代码格式

    使用：[保存自动格式化代码](https://blog.csdn.net/lovefengruoqing/article/details/89478355)

19. Prettier - Code formatter

    功能：格式化代码

    注意：插件市场有 2 个，选择那个大的，下载量多的

20. sync setting

    功能：同步配置（现在这个内置了，而且插件的那个非常占用 cpu，不推荐）

    如何同步：直接 vscode 登录账号，就可以同步了

21. DotENV

    功能：env 文件高亮

22. codesnap

    功能：选中代码，生成漂亮的截图（公众号之类的图片都是这个）

    使用：command + shift + p，然后搜索 codesnap，然后选择代码

23. Draw.io Integration

    功能：在 vscode 中绘制流程图

    使用：创建`.dio`、`.png`、`.svg`结尾的文件并打开

24. code runner

    功能：vscode 中运行 js 文件（也可以运行其他语言）

25. CamelCase

    功能：下划线转驼峰

26. Tailwind CSS IntelliSense

    功能：tailwind 提示插件

27. Tailwind Docs

    功能：tailwind 文档插件

    使用：`ctrl + shift + p`打开搜索某一个属性的使用，可以快捷搜索比如`td flex`

28. chinese lorem

    您只需键入 jw 即可在 HTML 文件中生成默认的 128 个简体中文字符。 也可以通过键入 jw <字符数>来定义要生成多少个字符。 例如：jw66 生成 66 个字符。 输入触发词汇后按 tab 或者 enter 即可产生所需数量的词汇

29. lorem ipsum

    拓展中心搜索该插件名称并安装。Ctrl+Shift+P 调出控制台。

30. insert numbers

    同时给多行文本插入序号，可以设定开始序号和步长：

    `ctrl+alt+n`：`%d:start:step`

31. Color Highlight

    显示代码中的颜色

### 删除一行快捷键

> ctrl + shift + k;

### Tab 键忽然失效

在其他的软件中 tab 都能正常使用，但是 vscode 中失效了

原因：使用了`ctrl + M`切换了`Tab`按键行为（缩进或者移动焦点）

解决：再使用`ctrl + M`切换回去就好了

### vue 文件中写 style 没有代码提示了

安装`Vue - Official`插件即可

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
> 然后松开 ctrl
> 然后再按 m

### 切换极小地图的可见性

1. `ctrl + shift + p`打开命令面板

2. 搜索`minimap`

3. 回车确认切换

### 两个控制台切换

在打开控制台的情况下，`ctrl + PageUp/PageDown`

### 打开快捷键预览和设置

> ctrl + k, ctrl + s

### ctrl + shift +enter 无效

原因：快捷键冲突，如我的和`Markdown Preview Enhanced`扩展的冲突了

检查：`ctrl + k, ctrl + s`打开快捷键预览和设置

如果需要的话改建，如果不需要删除绑定即可

### 去除空行

1. ctrl + h 打开替换
2. 输入`^\s*(?=\r?$)\n`
3. 然后点击右边的`.*`符号（使用正则匹配）
4. 然后点击`全部替换`

### code helper 占用大量 cpu 和内存

一般是插件的问题，尝试禁用所有插件，然后重启 vscode，然后进行排查

    比如我的是由于`setting sync`这个插件导致的

还可以尝试`setting.json`中加入如下配置

```json
    "search.followSymlinks": false,
    "files.exclude": {
       "**/.git": true,
       "**/.svn": true,
       "**/.hg": true,
       "**/CVS": true,
       "**/.DS_Store": true,
       "**/tmp": true,
       "**/node_modules": true,
       "**/bower_components": true,
       "**/dist": true
     },
     "files.watcherExclude": {
       "**/.git/objects/**": true,
       "**/.git/subtree-cache/**": true,
       "**/node_modules/**": true,
       "**/tmp/**": true,
       "**/bower_components/**": true,
       "**/dist/**": true
    }
```

### vscode 的一些文件或者目录左侧资源树不显示

原因：被 vscode 的设置忽略排除了

操作：打开`setting json`，查看`files.exclude`

附常用 json 配置说明

```json
// 通过将设置放入设置文件中来覆盖设置。
{
  //-------- 编辑器配置 --------

  // 控制字体系列。
  "editor.fontFamily": "Consolas, 'Courier New', monospace",

  // 控制字体大小。
  "editor.fontSize": 14,

  // 控制行高。
  "editor.lineHeight": 0,

  // 控制行号的可见性
  "editor.lineNumbers": true,

  // 控制字形边距的可见性
  "editor.glyphMargin": false,

  // 显示垂直标尺的列
  "editor.rulers": [],

  // 执行文字相关的导航或操作时将用作文字分隔符的字符
  "editor.wordSeparators": "`~!@#$%^&*()-=+[{]}\\|;:'\",.<>/?",

  // 一个制表符等于的空格数。
  "editor.tabSize": 4,

  // 按 "Tab" 时插入空格。
  "editor.insertSpaces": true,

  // 当打开文件时，将基于文件内容检测 "editor.tabSize" 和 "editor.insertSpaces"。
  "editor.detectIndentation": true,

  // 控制选取范围是否有圆角
  "editor.roundedSelection": true,

  // 控制编辑器是否可以滚动到最后一行之后
  "editor.scrollBeyondLastLine": true,

  // 控制在多少个字符后编辑器会自动换到下一行。将其设置为 0 则将打开视区宽度换行(自动换行)。将其设置为 -1 则将强制编辑器始终不换行。
  "editor.wrappingColumn": 300,

  // 控制换行的行的缩进。可以是"none"、 "same" 或 "indent"。
  "editor.wrappingIndent": "same",

  // 要对鼠标滚轮滚动事件的 "deltaX" 和 "deltaY" 使用的乘数
  "editor.mouseWheelScrollSensitivity": 1,

  // 控制键入时是否应显示快速建议
  "editor.quickSuggestions": true,

  // 控制延迟多少毫秒后将显示快速建议
  "editor.quickSuggestionsDelay": 10,

  // 控制编辑器是否应该在左括号后自动插入右括号
  "editor.autoClosingBrackets": true,

  // 控制编辑器是否应在键入后自动设置行的格式
  "editor.formatOnType": false,

  // 控制键入触发器字符时是否应自动显示建议
  "editor.suggestOnTriggerCharacters": true,

  // 控制除了 "Tab" 以外，是否还应在 "Enter" 时接受建议。帮助避免“插入新行”或“接受建议”之间的歧义。
  "editor.acceptSuggestionOnEnter": true,

  // 控制编辑器是否应突出显示选项的近似匹配
  "editor.selectionHighlight": true,

  // 控制可在概述标尺同一位置显示的效果数量
  "editor.overviewRulerLanes": 3,

  // 控制光标闪烁动画，接受的值为'blink'、'visible' 和 'hidden'
  "editor.cursorBlinking": "blink",

  // 控制光标样式，接受的值为 'block' 和 'line'
  "editor.cursorStyle": "line",

  // 启用字体连字
  "editor.fontLigatures": false,

  // 控制光标是否应隐藏在概述标尺中。
  "editor.hideCursorInOverviewRuler": false,

  // 控制编辑器是否应呈现空白字符
  "editor.renderWhitespace": false,

  // 控制编辑器是否显示支持它的模式的参考信息
  "editor.referenceInfos": true,

  // 控制编辑器是否启用代码折叠功能
  "editor.folding": true,

  // 在制表位后插入和删除空格
  "editor.useTabStops": true,

  // 删除尾随自动插入的空格
  "editor.trimAutoWhitespace": true,

  // Keep peek editors open even when double clicking their content or when hitting Escape.
  "editor.stablePeek": false,

  // 控制 Diff 编辑器以并排或内联形式显示差异
  "diffEditor.renderSideBySide": true,

  // 控制差异编辑器是否将对前导空格或尾随空格的更改显示为差异
  "diffEditor.ignoreTrimWhitespace": true,

  //-------- 窗口配置 --------

  // 启用后，将在新窗口中打开文件，而不是重复使用现有实例。
  "window.openFilesInNewWindow": true,

  // 控制重启后重新打开文件夹的方式。选择“none”表示永不重新打开文件夹，选择“one”表示重新打开最后使用的一个文件夹，或选择“all”表示打开上次会话的所有文件夹。
  "window.reopenFolders": "one",

  // 调整窗口的缩放级别。原始大小是 0，每次递增(例如 1)或递减(例如 -1)表示放大或缩小 20%。也可以输入小数以便以更精细的粒度调整缩放级别。
  "window.zoomLevel": 0,

  //-------- 文件配置 --------

  // 配置 glob 模式以排除文件和文件夹。
  "files.exclude": {
    "**/.git": true,
    "**/.svn": true,
    "**/.DS_Store": true
  },

  // 配置语言的文件关联(如: "*.extension": "html")。这些关联的优先级高于已安装语言的默认关联。
  "files.associations": {},

  // 读取和编写文件时将使用的默认字符集编码。
  "files.encoding": "utf8",

  // 默认行尾字符。
  "files.eol": "\r\n",

  // 启用后，将在保存文件时剪裁尾随空格。
  "files.trimTrailingWhitespace": false,

  // 控制已更新文件的自动保存。接受的值:“off”、“afterDelay”、“onFocusChange”。如果设置为“afterDelay”，则可在 "files.autoSaveDelay" 中配置延迟。
  "files.autoSave": "off",

  // 控制延迟(以秒为单位)，在该延迟后将自动保存更新后的文件。仅在 "files.autoSave" 设置为“afterDelay”时适用。
  "files.autoSaveDelay": 1000,

  // 配置文件路径的 glob 模式以从文件监视排除。更改此设置要求重启。如果在启动时遇到 Code 消耗大量 CPU 时间，则可以排除大型文件夹以减少初始加载。
  "files.watcherExclude": {
    "**/.git/objects/**": true
  },

  //-------- Emmet 配置 --------

  // 启用后，按 TAB 键时，将展开 Emmet 缩写。
  "emmet.triggerExpansionOnTab": true,

  //-------- 文件资源管理器配置 --------

  // 在滚动条出现之前将显示的最大工作文件数目。
  "explorer.workingFiles.maxVisible": 9,

  // 控制工作文件部分的高度是否应动态适应元素数量。
  "explorer.workingFiles.dynamicHeight": true,

  // 控制资源管理器是否应在打开文件时自动显示它们。
  "explorer.autoReveal": true,

  //-------- HTTP 配置 --------

  // 要使用的代理设置。如果尚未设置，则将从 http_proxy 和 https_proxy 环境变量获取
  "http.proxy": "",

  // 是否应根据提供的 CA 列表验证代理服务器证书。
  "http.proxyStrictSSL": true,

  //-------- 搜索配置 --------

  // 配置 glob 模式以在搜索中排除文件和文件夹。从 files.exclude 设置中继承所有 glob 模式。
  "search.exclude": {
    "**/node_modules": true,
    "**/bower_components": true
  },

  //-------- 更新配置 --------

  // 配置从中接收更新的更新频道。更改后需要重启。
  "update.channel": "default",

  //-------- GIT 配置 --------

  // 是否启用了 GIT
  "git.enabled": true,

  // 可执行 GIT 的路径
  "git.path": null,

  // 是否启用了自动提取。
  "git.autofetch": true,

  //-------- 标记预览配置 --------

  // 标记预览中供使用的 CSS 样式表的 URL 或本地路径列表。
  "markdown.styles": [],

  //-------- JSON configuration --------

  // Associate schemas to JSON files in the current project
  "json.schemas": [],

  //-------- 遥测配置 --------

  // 启用要发送给 Microsoft 的使用情况数据和错误。
  "telemetry.enableTelemetry": true,

  //-------- 遥测配置 --------

  // 启用要发送给 Microsoft 的故障报表。
  // 此选项需重启才可生效。
  "telemetry.enableCrashReporter": true,

  //-------- CSS 配置 --------

  // 控制 CSS 验证和问题严重性。

  // 启用或禁用所有验证
  "css.validate": true,

  // 使用供应商特定前缀时，确保同时包括所有其他供应商特定属性
  "css.lint.compatibleVendorPrefixes": "ignore",

  // 使用供应商特定前缀时，还应包括标准属性
  "css.lint.vendorPrefix": "warning",

  // 不要使用重复的样式定义
  "css.lint.duplicateProperties": "ignore",

  // 不要使用空规则集
  "css.lint.emptyRules": "warning",

  // Import 语句不会并行加载
  "css.lint.importStatement": "ignore",

  // 使用边距或边框时，不要使用宽度或高度
  "css.lint.boxModel": "ignore",

  // 已知通配选择符 (*) 慢
  "css.lint.universalSelector": "ignore",

  // 零不需要单位
  "css.lint.zeroUnits": "ignore",

  // @font-face 规则必须定义 "src" 和 "font-family" 属性
  "css.lint.fontFaceProperties": "warning",

  // 十六进制颜色必须由三个或六个十六进制数字组成
  "css.lint.hexColorLength": "error",

  // 参数数量无效
  "css.lint.argumentsInColorFunction": "error",

  // 未知的属性。
  "css.lint.unknownProperties": "warning",

  // 仅当支持 IE7 及更低版本时，才需要 IE hack
  "css.lint.ieHack": "ignore",

  // 未知的供应商特定属性。
  "css.lint.unknownVendorSpecificProperties": "ignore",

  // 因显示而忽略属性。例如，使用 "display: inline"时，宽度、高度、上边距、下边距和 float 属性将不起作用
  "css.lint.propertyIgnoredDueToDisplay": "warning",

  // 避免使用 !important。它表明整个 CSS 的特异性已经失去控制且需要重构。
  "css.lint.important": "ignore",

  // 避免使用“float”。浮动会带来脆弱的 CSS，如果布局的某一方面更改，将很容易破坏 CSS。
  "css.lint.float": "ignore",

  // 选择器不应包含 ID，因为这些规则与 HTML 的耦合过于紧密。
  "css.lint.idSelector": "ignore",

  //-------- HTML 配置 --------

  // 每行最大字符数(0 = 禁用)。
  "html.format.wrapLineLength": 120,

  // 标记列表，以逗号分隔，不应重设格式。"null" 默认为所有内联标记。
  "html.format.unformatted": "a, abbr, acronym, b, bdo, big, br, button, cite, code, dfn, em, i, img, input, kbd, label, map, object, q, samp, script, select, small, span, strong, sub, sup, textarea, tt, var",

  // 缩进 <head> 和 <body> 部分。
  "html.format.indentInnerHtml": false,

  // 是否要保留元素前面的现有换行符。仅适用于元素前，不适用于标记内或文本。
  "html.format.preserveNewLines": true,

  // 要保留在一个区块中的换行符的最大数量。对于无限制使用 "null"。
  "html.format.maxPreserveNewLines": null,

  // 格式和缩进 {{#foo}} 和 {{/foo}}。
  "html.format.indentHandlebars": false,

  // 以新行结束。
  "html.format.endWithNewline": false,

  // 标记列表，以逗号分隔，其前应有额外新行。"null" 默认为“标头、正文、/html”。
  "html.format.extraLiners": "head, body, /html",

  //-------- LESS 配置 --------

  // 控制 LESS 验证和问题严重性。

  // 启用或禁用所有验证
  "less.validate": true,

  // 使用供应商特定前缀时，确保同时包括所有其他供应商特定属性
  "less.lint.compatibleVendorPrefixes": "ignore",

  // 使用供应商特定前缀时，还应包括标准属性
  "less.lint.vendorPrefix": "warning",

  // 不要使用重复的样式定义
  "less.lint.duplicateProperties": "ignore",

  // 不要使用空规则集
  "less.lint.emptyRules": "warning",

  // Import 语句不会并行加载
  "less.lint.importStatement": "ignore",

  // 使用边距或边框时，不要使用宽度或高度
  "less.lint.boxModel": "ignore",

  // 已知通配选择符 (*) 慢
  "less.lint.universalSelector": "ignore",

  // 零不需要单位
  "less.lint.zeroUnits": "ignore",

  // @font-face 规则必须定义 "src" 和 "font-family" 属性
  "less.lint.fontFaceProperties": "warning",

  // 十六进制颜色必须由三个或六个十六进制数字组成
  "less.lint.hexColorLength": "error",

  // 参数数量无效
  "less.lint.argumentsInColorFunction": "error",

  // 未知的属性。
  "less.lint.unknownProperties": "warning",

  // 仅当支持 IE7 及更低版本时，才需要 IE hack
  "less.lint.ieHack": "ignore",

  // 未知的供应商特定属性。
  "less.lint.unknownVendorSpecificProperties": "ignore",

  // 因显示而忽略属性。例如，使用 "display: inline"时，宽度、高度、上边距、下边距和 float 属性将不起作用
  "less.lint.propertyIgnoredDueToDisplay": "warning",

  // 避免使用 !important。它表明整个 CSS 的特异性已经失去控制且需要重构。
  "less.lint.important": "ignore",

  // 避免使用“float”。浮动会带来脆弱的 CSS，如果布局的某一方面更改，将很容易破坏 CSS。
  "less.lint.float": "ignore",

  // 选择器不应包含 ID，因为这些规则与 HTML 的耦合过于紧密。
  "less.lint.idSelector": "ignore",

  //-------- Sass 配置 --------

  // 控制 Sass 验证和问题严重性。

  // 启用或禁用所有验证
  "sass.validate": true,

  // 使用供应商特定前缀时，确保同时包括所有其他供应商特定属性
  "sass.lint.compatibleVendorPrefixes": "ignore",

  // 使用供应商特定前缀时，还应包括标准属性
  "sass.lint.vendorPrefix": "warning",

  // 不要使用重复的样式定义
  "sass.lint.duplicateProperties": "ignore",

  // 不要使用空规则集
  "sass.lint.emptyRules": "warning",

  // Import 语句不会并行加载
  "sass.lint.importStatement": "ignore",

  // 使用边距或边框时，不要使用宽度或高度
  "sass.lint.boxModel": "ignore",

  // 已知通配选择符 (*) 慢
  "sass.lint.universalSelector": "ignore",

  // 零不需要单位
  "sass.lint.zeroUnits": "ignore",

  // @font-face 规则必须定义 "src" 和 "font-family" 属性
  "sass.lint.fontFaceProperties": "warning",

  // 十六进制颜色必须由三个或六个十六进制数字组成
  "sass.lint.hexColorLength": "error",

  // 参数数量无效
  "sass.lint.argumentsInColorFunction": "error",

  // 未知的属性。
  "sass.lint.unknownProperties": "warning",

  // 仅当支持 IE7 及更低版本时，才需要 IE hack
  "sass.lint.ieHack": "ignore",

  // 未知的供应商特定属性。
  "sass.lint.unknownVendorSpecificProperties": "ignore",

  // 因显示而忽略属性。例如，使用 "display: inline"时，宽度、高度、上边距、下边距和 float 属性将不起作用
  "sass.lint.propertyIgnoredDueToDisplay": "warning",

  // 避免使用 !important。它表明整个 CSS 的特异性已经失去控制且需要重构。
  "sass.lint.important": "ignore",

  // 避免使用“float”。浮动会带来脆弱的 CSS，如果布局的某一方面更改，将很容易破坏 CSS。
  "sass.lint.float": "ignore",

  // 选择器不应包含 ID，因为这些规则与 HTML 的耦合过于紧密。
  "sass.lint.idSelector": "ignore",

  //-------- Integrated terminal configuration --------

  // The path of the shell that the terminal uses on Linux.
  "terminal.integrated.shell.linux": "sh",

  // The path of the shell that the terminal uses on OS X.
  "terminal.integrated.shell.osx": "sh",

  // The path of the shell that the terminal uses on Windows.
  "terminal.integrated.shell.windows": "C:\\Windows\\system32\\cmd.exe",

  // The font family used by the terminal (CSS font-family format).
  "terminal.integrated.fontFamily": "Menlo, Monaco, Consolas, \"Droid Sans Mono\", \"Courier New\", monospace, \"Droid Sans Fallback\"",

  //-------- 外部终端配置 --------

  // Customizes which terminal to run on Windows.
  "terminal.external.windowsExec": "cmd",

  // Customizes which terminal to run on Linux.
  "terminal.external.linuxExec": "xterm",

  //-------- TypeScript 配置 --------

  // 指定包含要使用的 tsserver 和 lib*.d.ts 文件的文件夹路径。
  "typescript.tsdk": null,

  // 完成函数的参数签名。
  "typescript.useCodeSnippetsOnMethodSuggest": false,

  // 启用/禁用 TypeScript 验证
  "typescript.validate.enable": true,

  // 启用对发送到 TS 服务器的消息进行跟踪
  "typescript.tsserver.trace": "off",

  // 定义逗号分隔符后面的空格处理
  "typescript.format.insertSpaceAfterCommaDelimiter": true,

  // 在 For 语句中，定义分号之后的空格处理
  "typescript.format.insertSpaceAfterSemicolonInForStatements": true,

  // 定义二进制运算符后面的空格处理
  "typescript.format.insertSpaceBeforeAndAfterBinaryOperators": true,

  // 定义控制流语句中的关键字之后的空格处理
  "typescript.format.insertSpaceAfterKeywordsInControlFlowStatements": true,

  // 定义匿名函数的函数关键字之后的空格处理
  "typescript.format.insertSpaceAfterFunctionKeywordForAnonymousFunctions": true,

  // 定义非空圆括号的左括号之后和右括号之前的空格处理。
  "typescript.format.insertSpaceAfterOpeningAndBeforeClosingNonemptyParenthesis": false,

  // 定义非空方括号的左括号之后和右括号之前的空格处理。
  "typescript.format.insertSpaceAfterOpeningAndBeforeClosingNonemptyBrackets": false,

  // 定义左大括号是否针对函数而放置在新的一行
  "typescript.format.placeOpenBraceOnNewLineForFunctions": false,

  // 定义左大括号是否针对控制块而放置在新的一行
  "typescript.format.placeOpenBraceOnNewLineForControlBlocks": false,

  // 启用/禁用 JavaScript 验证
  "javascript.validate.enable": true,

  // 定义逗号分隔符后面的空格处理
  "javascript.format.insertSpaceAfterCommaDelimiter": true,

  // 在 For 语句中，定义分号之后的空格处理
  "javascript.format.insertSpaceAfterSemicolonInForStatements": true,

  // 定义二进制运算符后面的空格处理
  "javascript.format.insertSpaceBeforeAndAfterBinaryOperators": true,

  // 定义控制流语句中的关键字之后的空格处理
  "javascript.format.insertSpaceAfterKeywordsInControlFlowStatements": true,

  // 定义匿名函数的函数关键字之后的空格处理
  "javascript.format.insertSpaceAfterFunctionKeywordForAnonymousFunctions": true,

  // 定义非空圆括号的左括号之后和右括号之前的空格处理。
  "javascript.format.insertSpaceAfterOpeningAndBeforeClosingNonemptyParenthesis": false,

  // 定义非空方括号的左括号之后和右括号之前的空格处理。
  "javascript.format.insertSpaceAfterOpeningAndBeforeClosingNonemptyBrackets": false,

  // 定义左大括号是否针对函数而放置在新的一行
  "javascript.format.placeOpenBraceOnNewLineForFunctions": false,

  // 定义左大括号是否针对控制块而放置在新的一行
  "javascript.format.placeOpenBraceOnNewLineForControlBlocks": false,

  //-------- PHP 配置选项 --------

  // 不管 php 验证是否已启用。
  "php.validate.enable": true,

  // 指向可执行的 php。
  "php.validate.executablePath": null,

  // 不管 linter 是在 save 还是在 type 上运行。
  "php.validate.run": "onSave",

  // 启用基于字的建议。
  "editor.wordBasedSuggestions": true
}
```

### vscode 中运行 js 文件

code runner 插件

### 自动填充随机文本字符串

关键字：`lorem`

但 Vscode 自带的 lorem 仅支持 `HTML` 文件，不支持其它格式的文件，比如 `Markdown` 等。

1. chinese lorem

   您只需键入 jw 即可在 HTML 文件中生成默认的 128 个简体中文字符。 也可以通过键入 jw <字符数>来定义要生成多少个字符。 例如：jw66 生成 66 个字符。 输入触发词汇后按 tab 或者 enter 即可产生所需数量的词汇

2. lorem ipsum

   拓展中心搜索该插件名称并安装。Ctrl+Shift+P 调出控制台。

### `LF`文件和`CRLF`类型

1. crlf 和 lf 介绍

   由于历史原因，`windows`下和`linux下`的文本文件的`换行符`不一致。

   1. Windows 在换行的时候，同时使用了回车符 CR(carriage-return character)和换行符 LF(linefeed character)
   2. 而 Mac 和 Linux 系统，仅仅使用了换行符 LF
   3. 老版本的 Mac 系统使用的是回车符 CR

   因此，文本文件在不同系统下创建和使用时就会出现不兼容的问题

2. 会导致的问题

   1. prettier 报警告`Delete `␍`eslintprettier/prettier`
   2. 如果做了`pre-commit`的话会导致无法提交

3. 解决方案

   1. 针对单个文件：vscode 编辑器右下角`选择行尾序列`，切换为`LF`
   2. 针对 vscode 编辑器：
      1. 搜索`end of line`：将设置改为`lf`
      2. 搜索`eol`：将设置改为`lf`
   3. 针对项目：
      1. `prettierrc.json`文件增加属性`endOfLine: 'lf'`

### windows 上的一些快捷键冲突

`ctrl+.`: 代码建议修复

和 windows 的`中英文标点切换`冲突了,把输入法中这一项去掉就行

`ctrl+shift+f`: 代码格式化

和 windows 的`中文繁简体切换`冲突了

### 对于单个工作区的单独设置

1. 图形化界面，打开设置之后，分为`用户`和`工作区`两个选项卡
2. 工作区配置，在工作区`根目录`下创建`.vscode/settings.json`中进行编辑

### 模糊搜索

可以参考[https://blog.csdn.net/qq_37539693/article/details/125356318](https://blog.csdn.net/qq_37539693/article/details/125356318)

使用下面的符号代表任意内容

> (.\*?)

但是如果有换行符的话，需要使用下面的方式

> ([\s\S]\*?)
>
> <div id="tpaWorker_43">([\s\S]*?)</div>

有时候这样也匹配不到，需要在最后的 div 标签之后增加一个回车进行搜索

### 终端中使用命令行打开文件或目录

1. 使用`shift + command + p`打开命令面板
2. 搜索`install code command in PATH`，并执行
3. 然后终端输入`code 文件名`打开文件，输入`code .`打开目录

### 保存格式化设置只针对修改的内容

在进行多人协作的时候，如果代码格式化的方式不一样的话，经常会出现格式化了自己没有修改的部分

`设置 => Format On Save Mode => 选择modificationsIfAvailable`

### 为某个工作区进行单独的 vscode 设置

创建`/.vscode/settings.json`文件，里面就是当前工作区的设置

或者是设置中修改配置的时候顶部 tab 有`用户`和`工作区`分栏，选择`工作区即可`

### markdown直接粘贴图片

<https://juejin.cn/post/7244809769794289721#heading-3>

现在默认都支持了

我唯一做的修改就是保存图片到当前目录的`images`下，而不是直接同级，看起来不舒服

```json
// settings.json中设置
"markdown.copyFiles.destination": {
    "**/*": "images/"
}
```

### 调试代码

用vue项目举例

1. 启动项目
2. `ctrl + shift + D`打开调试插件
3. 如果没有配置`launch.json`，那么按照他的提示点击创建，渲染`web chrome`
4. 默认是`8080`端口，如果端口不对，改为你需要的即可
5. 然后点击插件上面的绿色小三角
6. 这个时候会自动给你启动一个chrome浏览器
7. 然后在项目里面代码行数的左侧单击增加断点

其他配置可以参考

<https://code.visualstudio.com/docs/editor/debugging#_launch-configurations>