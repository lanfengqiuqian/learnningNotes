<!--
 * @Date: 2020-08-11 19:58:22
 * @LastEditors: Lq
 * @LastEditTime: 2022-08-09 20:15:54
 * @FilePath: \learnningNotes\markdown\note.md
-->

[toc]

### 官方文档

<https://markdown.com.cn/basic-syntax/>

### 基本用法

1. 单个回车，视为空格
2. 连续回车，才能分段
3. 行尾加两个空格，就可以段内换行
4. 注释可以使用`html`的注释
5. 也可以使用`html`的标签

### 语法规则

1. **标题**
   ```md
   #　 H1 标题 ##　 H2 标题 ###　 H3 标题 ####　 H4 标题 #####　 H5 标题 ######　 H6 标题
   ```
2. **列表**

   1. 无序列表（\*，+，-）

   ```md
   - 列表 1
   - 列表 2

   * 列表 3
   * 列表 4

   - 列表 5
   - 列表 6
   ```

   2. 有序列表（数字+点）

   ```md
   1. 文本
   2. 音乐
      1. 童话
      2. 列了都要爱
      3. 天下
   3. 电影
   ```

   3. 嵌套

   ```md
   - 列表 1
     - 子列表 1
     - 子列表 2
   - 列表 2
   ```

3. **文字格式**

   1. 粗体

   ```md
   ** 粗体 **
   ** 粗体 **
   ```

   2. 斜体

   ```md
   - 斜体 \*
     _ 斜体 _
   ```

   3. 粗斜体

   ```md
   **_ 粗斜体 _**
   **_ 粗斜体 _**
   ```

4. 链接

   ```md
   // 语法 [链接名称](链接地址 "链接title")
   [百度](http://www.baidu.com "百度一下")
   ```

5. 图片

   ```md
   // 语法 ![链接名称](链接地址 "链接title")
   ![百度](http://www.baidu.com "百度一下")
   ```

6. 引用
   ```md
   > 一级引用
   >
   > > 二级引用
   > >
   > > > 三级引用
   ```
   1. 引用换行：末尾加两个空格
   2. 引用内包含了其他语法：一定要写在引用开头处
7. 水平分割线

   ```md
   ## // 3 个以上的下面 3 种字符都生效

   ---

   ---
   ```

8. 代码块

   1. 代码行：反引号
      ```md
      `这里是一行代码`
      ```
   2. 代码段
      1. 使用 3 个反引号定义开始和结束位置（该方式可以定义语言高亮）
         ```md
         // 下面因为缩进会影响效果就这样显示了
         `js
             function() {
                 console.log('hello world');
             }
             `
         ```
      2. 使用 4 个空格或 Tab 缩进
         ```md
             第一行代码
             第二行代码
             第三行代码
         ```
   3. 支持高亮的代码块

      | 关键字（其中之一就行） | 语言        |     | 关键字              | 语言             |
      | ---------------------- | ----------- | --- | ------------------- | ---------------- |
      | c#,c-sharp,csharp      | c#          |     | coldfusion,cf       | ColdFusion       |
      | java                   | Java        |     | delphi,pascal,pas   | Delphi           |
      | php                    | PHP         |     | diff,patch          | diff&patch       |
      | js,jscript,javascript  | Javascript  |     | erl,erlang          | Erlang           |
      | css                    | CSS         |     | groovy              | Groovy           |
      | text,plain             | text        |     | jfx,javafx          | JavaFX           |
      | sql                    | SQL         |     | ruby,rails,ror,rb   | Ruby             |
      | py,python              | Python      |     | scala               | Scala            |
      | bash,shell             | Shell       |     | vb,vbnet            | Visual Basic     |
      | sass,scss              | SASS&SCSS   |     | xml,xhtml,xslt,html | XML              |
      | perl,pl,Perl           | Perl        |     | objc,obj-c          | Objective C      |
      | swift                  | swift       |     | f#,f-sharp,fsharp   | F#               |
      | go,golang              | GO          |     | r,s,splus           |
      | cpp,c                  | C           |     | matlab              | matlab           |
      | applescript            | AppleScript |     | actionscript3,as3   | ActionScript 3.0 |

9. 表格

   1. 对齐方式：使用冒号
      ```md
      |     | A     |   B   |
      | --: | :---- | :---: |
      |   a | (a,A) | (a,B) |
      |   b | (b,A) | (b,B) |
      ```
   2. 关键点：第二行的`|`中间至少要一个`-`

10. 转义字符：用于显示一些 markdown 中的特殊字符

    ```md
    \\ 反斜杠
    \` 反引号 \* 星号
    \_ 下滑线
    \+ 加号
    \- 减号
    \# 井号
    \. 点
    \~ 感叹号
    ```

11. todoList

    ```md
    - [ ] 第 1 件事
    - [x] 第 2 件事
    - [ ] 第 3 件事
    - [x] 第 4 件事
    ```

    效果如下

    - [] 第 1 件事
    - [x] 第 2 件事
    - [ ] 第 3 件事
    - [x] 第 4 件事

12. 文件头部生成目录

    在文件头部输入`[toc]`即可

    前提是你的内容中用了`标题`标记

### 将 md 文档转换为 html 页面的小工具

```shell
npm install -g i5ting_toc
i5ting_toc -f 文件路径 -o
```

```shell
-h, --help             output usage information
-V, --version          output the version number
-f, --file [filename]  default is README.md
-o, --open             open in browser
-v, --verbose          打印详细日志
```
