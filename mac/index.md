<!--
 * @Date: 2020-08-19 19:03:29
 * @LastEditors: Lq
 * @LastEditTime: 2020-08-19 19:04:40
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