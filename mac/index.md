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

17. mac安装win10虚拟机

    1. 使用virtualbox（免费）

        可参考[https://blog.csdn.net/Rockandrollman/article/details/123118778](https://blog.csdn.net/Rockandrollman/article/details/123118778)

        1. virtualbox安装包（实测7.0.6的版本还是没有安装上）

            > https://www.virtualbox.org/wiki/Downloads

            虽然在这里(https://baijiahao.baidu.com/s?id=1746816052262946739&wfr=spider&for=pc)说已经支持了，但是我没有成功

        2. win系统镜像

            > https://www.xitongzhijia.net/win10/202302/279978.html

            实测大坑，mac的m1芯片需要使用arm架构的系统镜像才行

            > https://www.macw.com/mac/3553.html?id=MzAyODgyJl8mMjcuMTg3LjIyNS4yMDU%3D

            说明可以看这里[https://aimac.top/post/2302249.html](https://aimac.top/post/2302249.html)最后一段话

        3. 安装

            1. 先一直下一步安装好virtualbox
            2. 新建虚拟机
            3. 选择下载好的镜像位置
            4. 内存4g，内核2cpu
            5. 选择创建虚拟硬盘，我选择的100GB
        
        4. 设置虚拟机

            1. 工具 -> 全局设定 -> 语言 -> 简体中文
            2. win10实例 -> 系统设置 -> 显示 -> Scale Factor 200%
            3. win10实例 -> 系统设置 -> 存储 -> 如果提示没有盘片（则创建一个，选择之前的镜像）
            4. win10实例 -> 系统设置 -> 常规 -> 共享粘贴板（双向）、拖放（双向）
            4. win10实例 -> 系统设置 -> 存储 -> 控制器：SATA -> 勾选使用主机输入输出（I/O）缓存
            4. win10实例 -> 系统设置 -> 存储 -> win10.vdi -> 勾选固态驱动器

        5. 设置主机和虚拟机间的共享文件夹，先在主机创建一个文件夹

            1. 在用户目录下的VirtualBox VMs目录下，和win10同级。
            2. 创建一个叫做datashare的目录
            3. win10实例 -> 系统设置 -> 共享文件夹 -> 设置共享文件夹路径

        6. 双击启动虚拟机，进入win10装机步骤

            1. 这里可能弹出错误：需要从命令指定启动的虚拟电脑

                ```shell
                VirtualBoxVM --startvm <name|UUID>

                # 比如我的叫做
                VirtualBoxVM --startvm win10
                ```

            2. 启动的时候开始会要几个电脑的权限，给了之后再启动

            3. 这里遇到了报错`cdboot：couldn't find bootmgr`

                1. 尝试重启软件或者重启宿主机系统
                2. 估计是镜像有问题，尝试重新从官网下载系统镜像，官网太慢考虑用这个（https://msdn.itellyou.cn/）

    2. 使用parallels desktop（需要付费，14天试用）

        1. 安装和下载

            > https://www.parallels.cn/products/desktop/welcome-trial/

            如果这个页面的下载按钮点了老没有反应，右键复制按钮下载链接新窗口打开

        2. 安装之后提示没网

            让我们为你连接到网络

            你需要连接到 Internet 才能继续设置你的设备。连接后，你将获得最新功能和安全更新。

            这种情况是没有网络，页面右上角会有一个感叹号的提示，没有安装`parallls tools`

            按`win + e`打开我的电脑，会有一个dvd驱动器，双击安装他，然后重启就好啦

    3. 使用utm

        1. 安装和下载

            > https://mac.getutm.app/

            1. 

        2. 遇到的问题

            虚拟机开机提示：`uefi interactive shell v2.2`

            原因是镜像不对，换一个镜像

        3. 注意点！！！！

            `安装的时候`当看到画面显示“Press any key to boot from CD or DVD..”，请务必及时按键盘上的任意键

            我每次没有理会这个，每次进入到设置uefi的页面，每次都以为是镜像有问题

            `安装完成以后`进入系统的时候就不要按了，否则又是进入安装系统

18. 视频格式转换器HandBrake

    > https://handbrake.fr/rotation.php?file=HandBrake-1.6.1.dmg

19. iphone和mac日历订阅

    iphone：【设置】【日历】【账户】【添加账户】【其他】【添加已订阅的日历】【将下方订阅代码粘贴】【存储】

    > https://www.shuyz.com/githubfiles/china-holiday-calender/master/holidayCal.ics

    mac：【左上角文件】【新建日历订阅】【粘贴下方代码】

    > https://www.shuyz.com/githubfiles/china-holiday-calender/master/holidayCal.ics

20. utm虚拟机

    > https://mac.getutm.app/

21. 打造好看的mac终端

    > https://developer.aliyun.com/article/1100368#slide-4

22. 安装oh-my-zsh之后出现node、npm等命令找不到

    ```
    vim ~/.zshrc
    // 在最后一行添加
    source ~/.zshrc.pre-oh-my-zsh

    // wq 保存退出重新打开终端即可
    ```

23. 禁用chrome浏览器的双指前进后退

    1. mac

        终端输入命令，回车，重启浏览器

        > defaults write com.google.Chrome AppleEnableSwipeNavigateWithScrolls -bool false

    2. windows

        chrome输入，将选项改为`disable`


        > chrome://flags/#overscroll-history-navigation

24. mds、mds_stores、mdworker 占用大量 cpu 和内存

    原因：Spotlight 中文名称为 聚焦，就是按下 Command + 空格 弹窗的那个搜索框。

        利用“聚焦”，您可以在 Mac 上查找应用、文稿及其他文件。您还可以利用“聚焦建议”来获取新闻、体育、影片、天气等信息。

    解决：禁止`聚焦`索引文件。

    > sudo mdutil -a -i off // 禁止  
    > sudo mdutil -a -i on  // 开启  


25. 聚焦无法搜索应用程序了

方式一（但是我第2步报错了）

```shell
# 关闭聚焦（spotlight）
sudo mdutil -a -i off

# 不加载控制聚焦参数的文件
sudo launchctl unload -w /System/Library/LaunchDaemons/com.apple.metadata.mds.plist
# 重新加载控制聚焦参数的文件
sudo launchctl load -w /System/Library/LaunchDaemons/com.apple.metadata.mds.plist
# 打开聚焦
sudo mdutil -a -i on
# 等一下，你的spotlight就应该能够正常搜索到软件、文件以及网页信息了！
```

方式二（最后用这种可以了）

```shell
# 关闭索引
sudo mdutil -a -i off
# 清除索引
sudo mdutil -E /
# 重新开启索引
sudo mdutil -a -i on
```