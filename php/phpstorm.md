<!--
 * @Date: 2021-06-09 20:42:37
 * @LastEditors: Lq
 * @LastEditTime: 2021-08-26 10:34:13
 * @FilePath: \learnningNotes\php\phpstorm.md
-->
1. 本地保存文件上传至服务器

    > https://www.jianshu.com/p/c3a4de78d248

2. 解决吃内存方法

    1. 找到`JetBrains\PhpStorm 2017.1.4\bin\`目录

        `说明`：这里的`PhpStorm 2017.1.4`是指安装版本，因人而异

    2. 编辑目录下的`phpstorm.exe.vmoptions`文件

        ```
        先把内存限制调整：
        -Xms256m
        -Xmx2048m
        -XX:MaxPermSize=350m

        再设JAVA虚拟机参数：
        追加下面代码：
        -Dawt.usesystemAAFontSettings=lcd
        -Dawt.java2d.opengl=true
        ```

    3. 解释说明

            phpstorm是使用JAVA开发的。由于IDE提供源文件关键字渲染功能，我们对文件的任何编辑或移动鼠标，都会触发渲染操作。而phpstorm默认的JAVA环境并没有利用机器的硬件加速技术去实现实时渲染，因此当然会让系统卡死。而只要在JAVA环境中让系统默认使用硬件加速，就可以解决占用系统资源过大，让phpstorm卡的问题了。