<!--
 * @Date: 2020-10-13 15:59:51
 * @LastEditors: Lq
 * @LastEditTime: 2022-07-04 14:27:39
 * @FilePath: \learnningNotes\linux\index.md
-->
1. 查看php装了哪些扩展

    > // 前提是php命令已经配置到环境变量中  
    > php -m   
    > // 注意php安装位置和版本
    > /www/server/php/72/bin/php -m |grep -i mcrypt  

2. 对于服务器上的文件，直接下载，而不是预览

    在nginx配置文件中加上一个响应头

    > add_header 'Content-Disposition' 'attachment';

    具体说明可以查看这篇[文章](https://www.cnblogs.com/owenzhou/p/5325570.html)

3. 查看内网ip和外网ip

    > 内网ip  
    > ifconfig  
    > 外网ip（第一个命令不好用就使用第二个）
    > curl ifconfig.me  
    > curl cip.cc

    ```shell
    命令行查询(详细):
    UNIX/Linux:#curl cip.cc
    Windows:>telnet cip.cc
    >ftp cip.cc
    命令行查询(纯ip):
    UNIX/Linux:#curl ip.cip.cc
    ```

4. 查看服务器磁盘使用情况

    ```shell
    // 查看服务器磁盘使用情况
    df -h

    // 查看当前目录各个子目录和文件所占大小
    du -sh *

    // 其他命令
    df -hl 查看磁盘剩余空间
    df -h 查看每个根路径的分区大小
    du -sh [目录名] 返回该目录的大小
    du -sm [文件夹] 返回该文件夹总M数
    ```

    一般来说是各种日志文件占用的内存非常大：比如mysql的日志、tp6框架的日志、各种缓存文件等

5. 查看系统版本

    > lsb_release -a

6. 查看进程、端口或服务

    > 查看进程或服务是否存在  
    > ps -aux ｜ grep xxx   
    > 查看单个服务运行状态（需要chkconfig配置工具）  
    > chkconfig   --list   服务名  
    > .查看所有服务的运行状态（需要chkconfig配置工具）   
    > chkconfig –list   
    > 查看端口占用情况

    service命令

    > service xxx status  查看服务状态   
    > service xxx stop 停止服务   
    > service xxx start 启动服务   
    > service xxx restart 重启服务   

7. 查看端口占用情况，并杀死进程

    > 查看所有的端口号服务：netstat -ntulp   
    > 查看某个端口号被占用情况：netstat -ntulp | grep xxxx（端口号）   
    > sudo kill -9 xxxx（PID）

    > 在Linux下查看所有java进程命令：ps -ef | grep java   
    > 停止所有java进程命令：pkill - 9 java   
    > 停止特定java进程命令：kill -9 java进程序号   

8. 查看磁盘某个目录空间大小

    > 如果不加目录名则是根目录  
    > df -h [目录名]

    > du 查看文件系统的磁盘使用量（常用）  
    > 选项与参数：  
    > -a  ：列出所有的文件与目录容量，因为默认仅统计目录底下的文件量而已。   
    > -h  ：以人们较易读的容量格式 (G/M) 显示；   
    > -s  ：列出总量而已，而不列出每个各别的目录占用容量；   
    > -S  ：不包括子目录下的总计，与 -s 有点差别。   
    > -k  ：以 KBytes 列出容量显示；   
    > -m  ：以 MBytes 列出容量显示；  
    > 如du -sh /usr  

9. 使用ssh命令连接服务器的时候保持不断开

    1. 配置参数方式
    > ssh -o ServerAliveInterval=30 root@xxx

    2. 配置客户端和服务器方式

    > https://einverne.github.io/post/2017/05/ssh-keep-alive.html

10. 安装压缩解压缩软件

    > // centos   
    > yum install -y unzip zip

    > // Unbutu和Debian   
    > apt install unzip


    > unzip 文件名.zip   
    > zip 文件名.zip 文件夹名称或文件名称   
    > // 查看文件内容而不解压缩   
    > unzip -l zipped_file.zip

11. 等同于--follow=descriptor，根据文件描述符进行追踪，当文件改名或被删除，追踪停止 

    > tail -f 文件名

12. 模糊查询某一个文件位置

    > find / -name redis-server

13. 重启nginx

    > systemctl start nginx

14. 重启redis

    1. 找到`redis-server`位置：`find / -name redis-server`

    2. 执行命令`./redis-serve`

15. 查看服务器系统状况，类似window的资源管理器

    > top

    ```bash
    top - 12:20:20 up 2 days, 18:04,  1 user,  load average: 0.02, 0.04, 0.05
    Tasks: 100 total,   1 running,  99 sleeping,   0 stopped,   0 zombie
    %Cpu(s):  0.2 us,  0.3 sy,  0.0 ni, 99.5 id,  0.0 wa,  0.0 hi,  0.0 si,  0.0 st
    KiB Mem :  7732980 total,  4762000 free,  1306760 used,  1664220 buff/cache
    KiB Swap:        0 total,        0 free,        0 used.  6162896 avail Mem
    ```

    说明

    1. 前五行是系统整体的信息

        1. 第一行是任务队列信息，同`uptime`命令的执行结果

            > 12:20:20 up 2 days, 18:04,  1 user,  load average: 0.02, 0.04, 0.05

            |内容|含义|
            |-|-|
            |12:20:20|当前时间|
            |up 2 days, 18:04,|系统运行时间|
            |1 user|当前登录用户数|
            |load average: 0.02, 0.04, 0.05|系统负载，即任务队列的平均长度，3个数值分别是1分钟、5分钟、15分钟到现在的平均值|

        2. 第二、三行为进程和CPU的信息，当有多个CPU时，这些内容可能会超过两行

            > Tasks: 100 total,   1 running,  99 sleeping,   0 stopped,   0 zombie

            |内容|含义|
            |-|-|
            |total|进程总数|
            |running|正在运行的进程数|
            |sleeping|睡眠的进程数|
            |stopped|停止的进程数|
            |zombie|僵尸进程数|

            > %Cpu(s):  0.2 us,  0.3 sy,  0.0 ni, 99.5 id,  0.0 wa,  0.0 hi,  0.0 si,  0.0 st

            |内容|含义|
            |-|-|
            |us|用户空间占用CPU百分比|
            |sy|内核空间占用CPU百分比|
            |ni|用户进程空间内改变过优先级的进程占用CPU百分比|
            |id|空闲CPU百分比|
            |wa|等待输入输出的CPU时间百分比|
            |hi|硬中断占用CPU的百分比|
            |si|软中断占用CPU百分比|
            |st|当hypervisor服务另一个虚拟处理器的时候，虚拟CPU等待实际CPU的时间百分比|

        3. 最后两行为内存信息

            > KiB Mem :  7732980 total,  4762000 free,  1306760 used,  1664220 buff/cache

            |内容|含义|
            |-|-|
            |total|总容量|
            |free|空闲的内存总量|
            |used|使用的物理内存容量|
            |buff/cache|用作内核缓存的内存量|

            > KiB Swap:        0 total,        0 free,        0 used.  6162896 avail Mem

            |内容|含义|
            |-|-|
            |total|总容量|
            |free|空闲的内存总量|
            |used|使用的物理内存容量|
            

    2. 进程信息区

        ```
        PID USER      PR  NI    VIRT    RES    SHR S  %CPU %MEM     TIME+ COMMAND
        1912 root      20   0 6008360   1.1g  15380 S   1.7 14.3  71:16.53 java
        1108 root      10 -10  140020  17772  11600 S   1.3  0.2  62:54.03 AliYunDun
        565 root      20   0   17852   1836   1388 S   0.3  0.0   0:40.39 assist_daemon
        ```

        |内容|含义|
        |-|-|
        |PID|进程ID|
        |PPID|父进程id|
        |USER|进程所有者的用户名|
        |RUSER|real user name|
        |UID|进程所有者的用户id|
        |GROUP|进程所有者的组名|
        |TTY|启动进程的终端名|
        |PR|优先级|
        |NI|nice值，负值表示高优先级，正值表示低优先级|
        |P|最后使用的CPU|仅在多CPU环境下有意义|
        |%CPU|上次更新到现在的CPU时间占用百分比|
        |I TIME|进程使用CPU时间总计，单位秒|
        |TIME +|进程时间的CPU时间总计，单位1/100秒|
        |%MEM|进程使用的物理内存百分比|
        |VIRT|进程使用的虚拟内存总量，单位kb，VIRT=SWAP+RES|
        |SWAP|进程使用的虚拟内存中，被换出的大小，单位kb|
        |RES|进程使用的、未被换出的物理内存带下，单位kb。RES=CODE+DATA|
        |CODE|可执行代码以外的部分（数据段+栈）占用的物理内存大小，单位kb|
        |SHR|共享的内存大小，单位kb|
        |nFLT|页面错误页数|
        |nDRT|最后一次写入到现在，被修改过的页面数|
        |S|进程状态|
        |D=|不可中断的睡眠状态|
        |R=|运行|
        |S=|睡眠|
        |T=|跟踪/停止|
        |Z=|僵尸进程|
        |COMMAND|命令名/命令行|
        |WCHAN|若该进程在睡眠，则显示睡眠中的系统函数名|
        |Flags|任务标志，参考sched h|


    更详细的说明见[https://blog.csdn.net/Luckiers/article/details/123909819](https://blog.csdn.net/Luckiers/article/details/123909819)