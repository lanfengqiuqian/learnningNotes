<!--
 * @Date: 2021-11-25 20:27:01
 * @LastEditors: Lq
 * @LastEditTime: 2021-12-07 20:36:22
 * @FilePath: \learnningNotes\bash\index.md
-->
## 简介

1. Bash是Unix系统和Linux系统的一种Shell（命令行环境），是目前绝大多数Linux发行版的默认Shell。

2. Shell是什么，多种含义

    1. 是一个程序，提供一个与用户对话的环境。这个环境只有一个命令提示符，让用户从键盘输入命令，所以又被成为命令行环境。

    2. 是一个命令解释器，解释用户输入的命令。支持变量、条件判断、循环操作等语法，所以用户可以用Shell命令写出各种小程序，又称为脚本。这些脚本都通过Shell的解释执行，而不通过编译。

3. shell的种类

    只要是能够给用户提供命令行环境的程序，都可以看做是Shell。

    1. Bourne Shell（sh）
    2. Bourne Again Sell（bash）
    3. C Shell（csh）
    4. TENEX C Shell（tcsh）
    5. Korn Shell（ksh）
    6. Z Shell（zsh）
    7. Friendly Interactive Shell（fish）

    Bash是目前最常用的Shell。

    ```shell
    <!-- 查看当前运行的shell -->
    echo $SHELL;

    <!-- 查看当前Linux系统安装的所有Shell -->
    cat /etc/shells;

    <!-- 查看bash版本 -->
    bash --version;
    ```

4. 命令行提示符

    ```shell
    [user@hostname] $
    ```

    解释：

    1. user：用户名
    2. hostname：主机名
    3. $：用户提示符，如果是root的话是`#`


## 基本语法

1. echo命令

    1. 作用：输出一行文本，如果要输出多行文本，就需要放到引号里面

    2. 参数：

        1. -n：取消文本末尾的回车符号
        2. -e：会解析引号里面的特殊字符，如换行符`\n`

2. 命令格式

        ```shell
        <!-- command是命令，后面的是多个参数 -->
        command [arg1 ... [argN]];
        ```

        有些参数有长短两种形式，手写一般用短形式，如果写到代码和脚本中使用长形式提高可读性。

        ```shell
        <!-- 短形式，只有一个连字符 -->
        ls -r;

        <!-- 长形式，有两个连字符 -->
        ls --reverse;
        ```

3. 空格

    Bash使用空格（或者Tab）区分不同的参数

4. 分号

    分号是命令的结束符，一行可以放置多个命令，上一个命令执行完毕后，在执行第二个命令。

    注意：不管第一个命令执行成功或者失败，第二个命令都会紧接着执行。

5. 命令的组合符&&和||

    ```shell
    <!-- 如果command1执行成功，则运行command2 -->
    command1 && command2;

    <!-- 如果command1执行失败，则运行command2 -->
    command1 || command2;
    ```

6. type命令

    用来判断命令的来源：是内置命令还是外部程序

    ```shell
    <!-- echo是一个内部命令 -->
    $ type echo;
    echo is a shell builtin

    <!-- mysql是一个外部程序，位置在/usr/bin/mysql -->
    $ type mysql
    mysql is /usr/bin/mysql

    <!-- 查看一个命令的所有定义 -->
    $ type -a echo
    echo is a shell builtin
    echo is /usr/bin/echo

    <!-- 查看命令的类型：包括别名（alias）、关键词（keyword）、函数（function）、内置命令（builtin）、文件（file） -->
    $ type -t bash
    file
    $ type -t if
    keyword
    ```

7. 快捷键

    1. `Ctrl + L`：清除屏幕并将当前行移动到页面顶部
    2. `Ctrl + C`：终止当前正在执行的命令
    3. `Shift + PageUp`：向上滚动
    4. `Shift + PageDown`：向下滚动
    5. `Ctrl + U`：从光标位置删除到行首
    6. `Ctrl + K`：从光标位置
    7. `Ctrl + D`：关闭Shell会话
    8. `Tab`：代码补全

## Bash模式扩展

1. 简介

    1. Shell接收到用户输入的命令之后，会根据空格将用户的输入，拆分成一个一个词元。
    2. 然后Shell会扩展词元里面的特殊字符，扩展完成后才会调用相应的命令。
    3. 这种特殊字符的扩展，称为模式扩展。
    4. 其中有些用到的通配符，又称为通配符扩展
    5. Bash允许用户关闭扩展

        ```shell
        <!-- 关闭扩展 -->
        set -o noglob;
        <!-- 或者 -->
        set -f;

        <!-- 打开扩展 -->
        set +o noglob;
        set +f;
        ```

2. 波浪线扩展

    波浪线`~`会自动扩展为当前用户的主目录

    ```shell
    echo ~;
    /home/user;

    <!-- 进入当前用户的一个子目录 -->
    cd ~/dir;
    ```

3. `?`字符扩展

    `?`字符表示文件路径中的任意一个单个字符，不包括空字符。如果要匹配多个字符，就需要多个`?`连用。

    比如`data???`匹配`data`后面跟着3个字符的文件名

    ```shell
    ls ?.txt;
    a.txt b.txt
    ```

    `?`字符属于文件名扩展，只有文件缺失存在的前提下，才会发生扩展，如果文件不存在，扩展就不会发生。echo就会原样输出`?.txt`

    ```shell
    <!-- 当前目录有a.txt文件 -->
    echo ?.txt;
    a.txt

    <!-- 当前目录没有txt文件 -->
    echo ?.txt;
    ?.txt
    ```

4. `*`字符扩展

    `*`字符代表文件路径里面的任意数量的任意字符，包括0个字符。

    ```shell
    ls *.txt;
    a.txt b.txt abc.txt
    ```

    注意，`*`不会匹配隐藏文件，如果要匹配隐藏文件，需要写成`.*`

    ```echo
    <!-- 显示所有隐藏文件 -->
    echo .*;

    <!-- 匹配隐藏文件，排除.和..这两个特殊的隐藏文件，可以与方括号扩展结合使用 -->
    echo .[!.]*
    ```

    `*`字符属于文件名扩展，只有文件确实存在的前提下才会扩展，如果文件不存在，就会原样输出。

5. 方括号扩展

    方括号扩展的形式是`[...]`，只有文件缺失存在的情况下才会扩展。如果文件不存在，就会原样输出。括号中的任意一个字符，比如[abc]可以匹配a/b/c中的任意一个。

    ```shell
    ls [ab].txt;
    a.txt b.txt

    <!-- 如果不存在 -->
    ls [ab].txt;
    ls: 无法访问'[ab].txt': 没有那个文件或目录
    ```

    还有2种变体形式，`[^...]`和`[!...]`，表示不能匹配方括号里面的字符。


6. `[start-end]`扩展

    方括号扩展有一种简写形式`[start-end]`，表示一个连续的匹配范围。

    比如`[a-c]`表示`[abc]`，`[0-9]`表示`[0123456789]`

    常用例子

    ```
    [a-z] 所有小写字母
    [a-zA-Z] 所有大写字母和小写字母
    [a-zA-Z0-9] 所有大写字母、小写字母和数字
    [abc]* 所有以a、b、c字符之一开头的文件名
    program.[co] 文件program.c和文件program.o
    [!a-z] 所有非小写字母
    ```

7. 大括号扩展

    大括号扩展表示分别扩展大括号里面的所有制，各个值之间使用逗号分隔。比如`{1,2,3}`扩展成`1 2 3`

    ```shell
    echo {1,2,3};
    1 2 3

    echo d{a,b,c}g
    dag dbg dcg
    ```

    注意，大括号内部的逗号前后不能有空格，否则大括号扩展会失效。

    ```shell
    echo {1, 2};
    {1, 2   }
    ```

    大括号可以嵌套使用

    ```shell
    echo {j{p,pe}g,png};

    jpg jpeg png
    ```

    大括号不是文件名扩展，所以他总是会扩展的，这个和方括号扩展完全不同，如果匹配的文件不存在，方括号就不会扩展。

8. `{start..end}`扩展

    表示一个连续扩展序列，比如，`{a..z}`可以扩展成26个小写英文字母

    注意这里是两个`.`，而不是3个

    常用的用途为新建一系列目录

    ```shell
    <!-- 新建36个子目录，年份-月份 -->
    mkdir {2007..2009}-{01..12};
    ```

    另一个用途，进行for循环使用

    ```shell
    for i in {1..4}
    do
        echo $i
    done;
    ```

    还有一个形式，可以使用第二个双点号（`{start..end..step`）来指定扩展的步长

    ```shell
    echo {0..8..2};
    0 2 4 6 8
    ```

    多个简写形式连用，会有循环处理的效果

    ```shell
    echo {a..c}{1..3}
    a1 a2 a3 b1 b2 b3 c1 c2 c3
    ```

9. 变量扩展

    将美元符号`$`开头的词元视为变量，将其扩展成变量值。

    变量除了可以放在美元符号后面，也可以放在`${}`里面

    ```shell
    echo $SHELL;
    echo ${SHELL};
    ```

    `${!string*}`或者`${!string@}`返回所有匹配给定字符串`string`的变量名

    ```shell
    <!-- 匹配所有以S开头的变量名 -->
    echo ${!S*};
    SECONDS SHELL SHELLOPTS SHLVL SSH_AGENT_PID SSH_AUTH_SOCK
    ```

10. 子命令扩展

    `$(...)`可以扩展成另一个命令的运行结果，该命令的所有输出都会作为返回值。

    ```shell
    echo $(date);
    Thu Dec 2 19:38:38 CST 2021
    ```

    `$(...)`可以进行嵌套

    ```shell
    echo $(ls $(pwd));
    ```

11. 算术扩展

    `$((...))`可以扩展为整数运算的结果

    ```shell
    echo $((2 + 2));
    4
    ```

12. 字符类

    字符类也属于文件名扩展，如果没有匹配文件名，字符类就会原样输出

    `[[:class:]]`表示一个字符类，扩展成某一特定字符之中的一个。常用的字符类如下

    1. `[[:alnum:]]`：匹配任意英文字母和数字
    2. `[[:alpha:]]`：匹配任意英文字母
    3. `[[:blank:]]`：匹配空格和Tab键
    4. `[[:cntrl:]]`：ASCII码0-31的不可打印字符
    5. `[[:digit:]]`：匹配任意数字0-9
    6. `[[:graph:]]`：A-Z、a-z、0-9和标点符号
    7. `[[:lower:]]`：匹配任意小写字母a-z
    8. `[[:print:]]`：ASCII码32-127的可打印字符
    9. `[[:punct:]]`：标点符号（除了A-Z、a-z、0-9的可打印字符）
    10. `[[:space:]]`：空格、Tab、LF（10）、VT（11）、FF（12）、CR（13）
    11. `[[:upper::]]`：匹配任意大写字母A-Z
    12. `[[:xdigit:]]`：16进制字符（A-F、a-f、0-9）

    可以在第一个方括号后面机上感叹号`!`，表示取反。

    ```shell
    <!-- 输出所有大写字母开头的文件名 -->
    echo [[:upper:]]*

    <!-- 输出所有非数字 -->
    echo [![:digit:]]*
    ```

13. 使用注意点

    通配符的一些注意点

    1. 先解释，再执行

        Bash接收到命令以后，发现里面有通配符，会进行通配符扩展，然后再执行命令。

        ```shell
        ls a*.txt
        ab.txt
        ```

        执行过程是，先将`a*.txt`扩展成`ab.txt`，然后再执行`ls ab.txt`

    2. 文件扩展名不匹配时，会原样输出

        ```shell
        <!-- 不存在以a开头的文件名 -->
        echo a.*;
        a.*
        ```

    3. 只适用于单层路径

        所有文件名扩展只匹配单层路径，不能跨目录匹配，即无法匹配子目录里面的文件。

        如果要匹配子目录里面的文件，可以如下

        ```shell
        ls */*.txt;
        ```

        Bash4.0新增了一个`globstar`参数，允许`**`匹配零个或多个子目录

    4. 文件名可以使用通配符

        Bash允许文件名使用通配符，即文件名包括特殊字符。这种情况下引用文件名，需要把文件名放在单引号或双引号里面。

        ```shell
        touch 'fo*';
        ls;
        fo*;
        ```

14. 量词语法

    量词语法用来控制模式匹配的次数。它只有在Bash的`extglob`参数打开的情况下才能使用，不过一般是默认打开的。

    ```shell
    <!-- 查看extglob是否打开 -->
    shopt extglob;
    extglob         off

    <!-- 打开extglob -->
    shopt -s extglob;
    ```

    量词语法一共有5个

    1. `?(pattern-list)`：匹配零个或一个模式
    2. `*(pattern-list)`：匹配零个或多个模式
    3. `+(pattern-list)`：匹配一个或多个模式
    4. `@(pattern-list)`：匹配一个模式
    5. `!(pattern-list)`：匹配给定模式以外的任何内容

    ```shell
    <!-- 匹配0个或1个 -->
    ls abc?(.)txt;
    abctxt abc.txt

    <!-- 匹配一个或多个.txt或者.php后缀名 -->
    ls abc+(.txt|.php);
    abc.txt abc.txt.txt abc.php
    ```

    量词语法也属于文件名扩展，如果不存在可匹配的文件，就会原样输出。


15. shopt命令

    `shopt`命令可以调整Bash的行为。他有好几个参数跟通配符扩展有关

    ```shell
    <!-- 打开某个参数 -->
    shopt -s [optionname];

    <!-- 关闭某个参数 -->
    shopt -u [optionname];

    <!-- 查询某个参数是关闭还是打开 -->
    shopt [optionname]
    ```

    1. dotglob参数

        可以让扩展结果包括隐藏文件，即`.`开头的文件

    2. nullglob参数

        可以让通配符不匹配任何文件名时返回空字符串

    3. failglob参数

        可以让通配符不匹配任何文件名时，Bash会直接报错，而不是让各个命令去处理

    4. extglob参数

        是Bash支持ksh的一些扩展语法，默认是打开的

    5. nocaseglob参数

        可以让通配符扩展不区分大小写

    6. globstar

        可以使得`**`匹配零个或多个子目录，该参数默认是关闭的

        ```shell
        <!-- 假设有如下文件结构，要如何使用通配符才能将他们全部显示出来 -->
        a.txt
        sub1/b.txt
        sub1/sub2/c.txt

        <!-- 标准解法 -->
        ls *.txt */*.txt */*/*.txt

        <!-- 使用globstar解法 -->
        shopt -s globstar
        ls **/*.txt
        ```

## 引号和转移

Bash只有一种数据类型，就是字符串。不管用户输入什么数据，Bash都视为字符串。因此，字符串相关的引号和转义，对Bash来说就非常重要。

1. 转义

    某些字符在Bash里面有特殊含义，比如`$`、`&`、`*`

    如果想要原样输出这些特殊字符，就必须在前面加上反斜杠，使其变成普通字符。这样就叫做“转义”。

    ```shell
    <!-- 无结果 -->
    echo $date;

    <!-- 输出$date -->
    echo \$date;
    ```

    反斜杠本身也是特殊字符，如果想要原样输出，就需要对他进行自身转义

    ```shell
    echo \\;
    ```

    反斜杠除了用于转义，还可用与表示一些不可打印字符

    1. `\a`：响铃
    2. `\b`：退格
    3. `\n`：换行
    4. `\r`：回车
    5. `\t`：制表符

    如果想在命令行使用这些不可打印的字符，可以把他们放在引号里面，然后使用`echo`命令的`-e`参数

    ```shell
    echo a\tb;
    atb
    
    echo -e "a\tb";
    a   b
    ```