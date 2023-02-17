<!--
 * @Date: 2020-08-19 19:03:29
 * @LastEditors: Lq
 * @LastEditTime: 2021-05-27 10:52:26
 * @FilePath: /learnningNotes/mac/index.md
-->
1. 终端中快速删除一行命令的快捷键
    `ctrl + u`
2. 最小化当前窗口，会隐藏到程序坞的垃圾桶的左边（相当于左上角的`-`号）
    `command + m`
3. 最大化当前窗口（相当于左上角的双三角号）
    `command + ctrl + f`
4. 强制退出当前应用程序
    `command + option + esc`
5. 隐藏当前应用程序所有窗口，再次点击应用程序图标会恢复
    `command + h`
6. macOS /etc/profile默认代码
    ```
    # System-wide .profile for sh(1)
  
    if [ -x /usr/libexec/path_helper ]; then
        eval `/usr/libexec/path_helper -s`
    fi
    
    if [ "${BASH-no}" != "no" ]; then
        [ -r /etc/bashrc ] && . /etc/bashrc
    fi
    ```
7. 使修改的`/etc/profile`生效
    `source /etc/profile`

8. 无法打开xxx,因为他来自身份不明的开发者

    当安装了一个应用之后，点击图标打开显示如上，不让你打开

    解决方案：在访达的应用程序中右键打开即可打开了

9. 卸载应用程序

    进入访达的应用程序，右键移动到废纸篓

10. 复制、拷贝、替身的区别

    1. 内容不同

        1. 复制：直接生成一个相同的文件（相当于ctrl+c,ctrl+v）
        2. 拷贝：复制内容，但不生成文件（相当于ctrl+c），到另外一个目录可以进行粘贴
        3. 替身：为这个文件创建快捷方式（如果原文件删除了，那么这个快捷方式会失效）

    2. 位置不同

        1. 复制：位置直接在当前目录下
        2. 拷贝：可以手动去任何一个位置进行粘贴
        3. 替身：在电脑桌面上

    3. 数量不同

        1. 复制：复制的对象只能是一个一个的依次执行
        2. 拷贝：拷贝的对象可以多个同批执行
        3. 替身：可以多个同批执行

11. 在访达中显示隐藏的文件和目录

    ```shell
    // 显示被隐藏的
    defaults write com.apple.finder AppleShowAllFiles -boolean true ; killall Finder

    // 重新隐藏
    defaults write com.apple.finder AppleShowAllFiles -boolean false ; killall Finder
    ```

    更老的系统参见[https://www.jianshu.com/p/21347867cc35](https://www.jianshu.com/p/21347867cc35)

12. 剪切文件

    > command + c , command + option + v

13. mac 中.bash_profile 和 .zshrc 区别

    1. .bash_profile 和 .zshrc 均在～目录下

    2. .bash_profile，source ~/.bash_profile，只在当前窗口生效

    3. .zshrc ，source ~/.zshrc，永久生效；计算机每次启动自动执行source ~/.zshrc

    4. 一般会在~/.zshrc中添加source ~/.bash_profile，以确保.bash_profile中的修改永久生效。

14. 设置zsh终端不区分大小写路径提示

    背景：默认情况下，zsh终端大小写不敏感，如`cd desktop`也能到桌面，但是按`tab`没有路径提示和补全

    解决：修改`~/.zshrc`文件，如果没有则创建

        ```shell
        autoload -Uz compinit && compinit
        zstyle ':completion:*' matcher-list 'm:{[:lower:][:upper:]}={[:upper:][:lower:]}' 'm:{[:lower:][:upper:]}={[:upper:][:lower:]} l:|=* r:|=*' 'm:{[:lower:][:upper:]}={[:upper:][:lower:]} l:|=* r:|=*' 'm:{[:lower:][:upper:]}={[:upper:][:lower:]} l:|=* r:|=*'
        ```

        如果没有生效则`source .zshrc`

15. 双开应用

    > sudo /Applications/Lark.app/Contents/MacOS/Feishu

16. 触摸板四指操作忽然失灵了

    背景：息屏之后再打开，触摸板四指操作失灵，并且键盘`control + 上/下`也失灵了

    方案：打开活动监视器，找到【程序坞】，把它停止，就可以了（他会自动重启）