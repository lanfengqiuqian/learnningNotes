<!--
 * @Date: 2020-10-13 15:59:51
 * @LastEditors: Lq
 * @LastEditTime: 2022-07-06 13:21:06
 * @FilePath: \learnningNotes\linux\index.md
-->

1. 查看 php 装了哪些扩展

   > // 前提是 php 命令已经配置到环境变量中  
   > php -m  
   > // 注意 php 安装位置和版本
   > /www/server/php/72/bin/php -m |grep -i mcrypt

2. 对于服务器上的文件，直接下载，而不是预览

   在 nginx 配置文件中加上一个响应头

   > add_header 'Content-Disposition' 'attachment';

   具体说明可以查看这篇[文章](https://www.cnblogs.com/owenzhou/p/5325570.html)

3. 查看内网 ip 和外网 ip

   > 内网 ip  
   > ifconfig  
   > 外网 ip（第一个命令不好用就使用第二个）
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

   一般来说是各种日志文件占用的内存非常大：比如 mysql 的日志、tp6 框架的日志、各种缓存文件等

5. 查看系统版本

   > lsb_release -a

6. 查看进程、端口或服务

   > 查看进程或服务是否存在  
   > ps -aux ｜ grep xxx  
   > 查看单个服务运行状态（需要 chkconfig 配置工具）  
   > chkconfig --list 服务名  
   > .查看所有服务的运行状态（需要 chkconfig 配置工具）  
   > chkconfig –list  
   > 查看端口占用情况
   > lsof -i:port

   service 命令

   > service xxx status 查看服务状态  
   > service xxx stop 停止服务  
   > service xxx start 启动服务  
   > service xxx restart 重启服务

7. 查看端口占用情况，并杀死进程

   > 查看所有的端口号服务：netstat -ntulp  
   > 查看某个端口号被占用情况：netstat -ntulp | grep xxxx（端口号）  
   > sudo kill -9 xxxx（PID）

   > 在 Linux 下查看所有 java 进程命令：ps -ef | grep java  
   > 停止所有 java 进程命令：pkill - 9 java  
   > 停止特定 java 进程命令：kill -9 java 进程序号

8. 查看磁盘某个目录空间大小

   > 如果不加目录名则是根目录  
   > df -h [目录名]

   > du 查看文件系统的磁盘使用量（常用）  
   > 选项与参数：  
   > -a ：列出所有的文件与目录容量，因为默认仅统计目录底下的文件量而已。  
   > -h ：以人们较易读的容量格式 (G/M) 显示；  
   > -s ：列出总量而已，而不列出每个各别的目录占用容量；  
   > -S ：不包括子目录下的总计，与 -s 有点差别。  
   > -k ：以 KBytes 列出容量显示；  
   > -m ：以 MBytes 列出容量显示；  
   > 如 du -sh /usr

9. 使用 ssh 命令连接服务器的时候保持不断开

   1. 配置参数方式

      > ssh -o ServerAliveInterval=30 root@xxx

   2. 配置客户端和服务器方式

   > https://einverne.github.io/post/2017/05/ssh-keep-alive.html

10. 安装压缩解压缩软件

    > // centos  
    > yum install -y unzip zip

    > // Unbutu 和 Debian  
    > apt install unzip

    > unzip 文件名.zip  
    > zip 文件名.zip 文件夹名称或文件名称  
    > // 查看文件内容而不解压缩  
    > unzip -l zipped_file.zip

11. 等同于--follow=descriptor，根据文件描述符进行追踪，当文件改名或被删除，追踪停止

    > tail -f 文件名

12. 模糊查询某一个文件位置

    > find / -name redis-server

13. 重启 nginx

    > systemctl start nginx

14. 重启 redis

    1. 找到`redis-server`位置：`find / -name redis-server`

    2. 执行命令`./redis-serve`

15. 查看服务器系统状况，类似 window 的资源管理器

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

          > 12:20:20 up 2 days, 18:04, 1 user, load average: 0.02, 0.04, 0.05

          | 内容                           | 含义                                                                                 |
          | ------------------------------ | ------------------------------------------------------------------------------------ |
          | 12:20:20                       | 当前时间                                                                             |
          | up 2 days, 18:04,              | 系统运行时间                                                                         |
          | 1 user                         | 当前登录用户数                                                                       |
          | load average: 0.02, 0.04, 0.05 | 系统负载，即任务队列的平均长度，3 个数值分别是 1 分钟、5 分钟、15 分钟到现在的平均值 |

       2. 第二、三行为进程和 CPU 的信息，当有多个 CPU 时，这些内容可能会超过两行

          > Tasks: 100 total, 1 running, 99 sleeping, 0 stopped, 0 zombie

          | 内容     | 含义             |
          | -------- | ---------------- |
          | total    | 进程总数         |
          | running  | 正在运行的进程数 |
          | sleeping | 睡眠的进程数     |
          | stopped  | 停止的进程数     |
          | zombie   | 僵尸进程数       |

          > %Cpu(s): 0.2 us, 0.3 sy, 0.0 ni, 99.5 id, 0.0 wa, 0.0 hi, 0.0 si, 0.0 st

          | 内容 | 含义                                                                         |
          | ---- | ---------------------------------------------------------------------------- |
          | us   | 用户空间占用 CPU 百分比                                                      |
          | sy   | 内核空间占用 CPU 百分比                                                      |
          | ni   | 用户进程空间内改变过优先级的进程占用 CPU 百分比                              |
          | id   | 空闲 CPU 百分比                                                              |
          | wa   | 等待输入输出的 CPU 时间百分比                                                |
          | hi   | 硬中断占用 CPU 的百分比                                                      |
          | si   | 软中断占用 CPU 百分比                                                        |
          | st   | 当 hypervisor 服务另一个虚拟处理器的时候，虚拟 CPU 等待实际 CPU 的时间百分比 |

       3. 最后两行为内存信息

          > KiB Mem : 7732980 total, 4762000 free, 1306760 used, 1664220 buff/cache

          | 内容       | 含义                 |
          | ---------- | -------------------- |
          | total      | 总容量               |
          | free       | 空闲的内存总量       |
          | used       | 使用的物理内存容量   |
          | buff/cache | 用作内核缓存的内存量 |

          > KiB Swap: 0 total, 0 free, 0 used. 6162896 avail Mem

          | 内容  | 含义               |
          | ----- | ------------------ |
          | total | 总容量             |
          | free  | 空闲的内存总量     |
          | used  | 使用的物理内存容量 |

    2. 进程信息区

       ```
       PID USER      PR  NI    VIRT    RES    SHR S  %CPU %MEM     TIME+ COMMAND
       1912 root      20   0 6008360   1.1g  15380 S   1.7 14.3  71:16.53 java
       1108 root      10 -10  140020  17772  11600 S   1.3  0.2  62:54.03 AliYunDun
       565 root      20   0   17852   1836   1388 S   0.3  0.0   0:40.39 assist_daemon
       ```

       | 内容    | 含义                                                         |
       | ------- | ------------------------------------------------------------ | ----------------------- |
       | PID     | 进程 ID                                                      |
       | PPID    | 父进程 id                                                    |
       | USER    | 进程所有者的用户名                                           |
       | RUSER   | real user name                                               |
       | UID     | 进程所有者的用户 id                                          |
       | GROUP   | 进程所有者的组名                                             |
       | TTY     | 启动进程的终端名                                             |
       | PR      | 优先级                                                       |
       | NI      | nice 值，负值表示高优先级，正值表示低优先级                  |
       | P       | 最后使用的 CPU                                               | 仅在多 CPU 环境下有意义 |
       | %CPU    | 上次更新到现在的 CPU 时间占用百分比                          |
       | I TIME  | 进程使用 CPU 时间总计，单位秒                                |
       | TIME +  | 进程时间的 CPU 时间总计，单位 1/100 秒                       |
       | %MEM    | 进程使用的物理内存百分比                                     |
       | VIRT    | 进程使用的虚拟内存总量，单位 kb，VIRT=SWAP+RES               |
       | SWAP    | 进程使用的虚拟内存中，被换出的大小，单位 kb                  |
       | RES     | 进程使用的、未被换出的物理内存带下，单位 kb。RES=CODE+DATA   |
       | CODE    | 可执行代码以外的部分（数据段+栈）占用的物理内存大小，单位 kb |
       | SHR     | 共享的内存大小，单位 kb                                      |
       | nFLT    | 页面错误页数                                                 |
       | nDRT    | 最后一次写入到现在，被修改过的页面数                         |
       | S       | 进程状态                                                     |
       | D=      | 不可中断的睡眠状态                                           |
       | R=      | 运行                                                         |
       | S=      | 睡眠                                                         |
       | T=      | 跟踪/停止                                                    |
       | Z=      | 僵尸进程                                                     |
       | COMMAND | 命令名/命令行                                                |
       | WCHAN   | 若该进程在睡眠，则显示睡眠中的系统函数名                     |
       | Flags   | 任务标志，参考 sched h                                       |

    更详细的说明见[https://blog.csdn.net/Luckiers/article/details/123909819](https://blog.csdn.net/Luckiers/article/details/123909819)

16. ipconfig 和 ifconfig 的区别

    1. ipconfig

       用于 windows 系统，显示当前`TCP/IP`配置的设置值。这些信息一般用来检验人工配置的`TCP/IP`设置是否正确

       ```
       ipconfig 显示信息
       ipconfig /all 显示详细信息
       ipconfig /renew 更新所有适配器
       ```

    2. ifconfig

       linux 中对应的程序是 ifconfig，它用于查看、配置、启用或禁用位于内核中的网络接口，在系统引导时它被用来设置必要的网络接口参数。可以用这个工具来临时配置网卡的 ip 地址、掩码、广播地址、网关等。

       ```
       ifconfig 查看网络接口状态（当前激活的网络接口情况）
       ifconfig -a 查看主机所有网络接口情况
       ifconfig eth0 查看某个（eth0）端口状态
       ```

17. curl

    参见[https://www.ruanyifeng.com/blog/2019/09/curl-reference.html](https://www.ruanyifeng.com/blog/2019/09/curl-reference.html)

    1. 介绍

       是常用的命令行工具，用来请求 Web 服务器，它的名字就是客户端（client）的 URL 工具的意思

    2. 使用

       1. 不带参数的时候，发出的就是 GET 请求

          > curl https://www.baidu.com

       2. 带参数

          列举常用的参数

          1. -d

             > curl -d'login=emma＆password=123'-X POST https://google.com/login  
             > curl -d 'login=emma' -d 'password=123' -X POST https://google.com/login

             1. 用于发送 POST 请求的数据体
             2. 使用-d 参数之后，HTTP 请求会自动加上标头`Content-Type : application/x-www-form-urlencoded`，并且会自动将请求转为 POST 方法，因此可以省略`-X POST`
             3. -d 参数还可以读取本地文本文件的数据，向服务器发送
                > curl -d '@data.txt' https://google.com/login

          2. -F

             > curl -F 'file=@photo.png' https://google.com/profile

             1. 用来向服务器上传二进制文件
             2. 会给 HTTP 请求加上标头`Content-Type: multipart/form-data`，然后将文件`photo.png`作为`file`字段上传
             3. -F 参数还可以指定 MIME 类型
                > curl -F 'file=@photo.png;type=image/png' https://google.com/profile

          3. -G

             > curl -G -d 'q=kitties' -d 'count=20' https://google.com/search

             1. 用来构造 URL 的查询字符串
             2. 上面的命令会发出一个 GET 请求，实际请求的 URL 为`https://google.com/search?q=kitties&count=20`，如果省略-G 会发出一个 POST 请求
             3. 如果需要 URL 编码，可以结合`--data--urlencode`
                > curl -G --data-urlencode 'comment=hello world' https://www.example.com
             4. -X

                > curl -X POST https://www.example.com

                1. 指定 HTTP 请求的方法

18. 生成目录树

```bash
.
├── README.md
├── auto-imports.d.ts
├── commitlint.config.js
├── components.d.ts
├── index.html
├── node_modules
│   ├── @ampproject
├── package-lock.json
├── package.json
├── public
│   └── favicon.ico
├── src
│   ├── App.vue
│   ├── api
│   ├── assets
│   ├── auto-imports.d.ts
│   ├── components
│   ├── components.d.ts
│   ├── constant
│   ├── env.d.ts
│   ├── hooks
│   ├── locale
│   ├── main.ts
│   ├── router
│   ├── store
│   ├── styles
│   ├── utils
│   └── views
├── tsconfig.json
├── tsconfig.node.json
├── vite.config.ts
└── yarn.lock

389 directories, 17 files
```

    1. tree命令 安装

        ```bash
        # mac
        brew install tree

        # linux
        yum install tree
        ```

    2. 常用命令

        ```bash
        # 将层级输出为一个文件
        tree --gitignore -d > directories.txt

        # 指定遍历层级
        tree -L 2

        # 然后我们看下当前目录下的 README.md 文件
        tree -L 2 >README.md

        # 只显示文件夹
        tree -d

        # 显示项目的层级，n表示层级数，如：显示项目3层目录 tree -L 3
        tree -L n

        # 用于过滤不想想是的文件或者文件夹
        tree -I node_modules
        ```

19. 安装 docker

> https://blog.csdn.net/weixin_43977692/article/details/127492590

20. 项目部署问题：nginx 刷新显示 404、xftp 无法连接服务器、Nginx403 Forbidden 解决、nginx 反向代理解决前端跨域问题

> https://www.cnblogs.com/goloving/p/8995603.html

21. 安装宝塔

```shell
// 执行命令
yum install -y wget && wget -O install.sh https://download.bt.cn/install/install_6.0.sh && sh install.sh ed8484bec

// 有一个确认步骤，输入【y即可】，等待几分钟

// 完成之后会有提示
========================面板账户登录信息==========================

 【云服务器】请在安全组放行 33466 端口
 外网面板地址: https://xxxx:33466/90e71d1c
 内网面板地址: https://xxxx:33466/90e71d1c
 username: xxx
 password: xxx

 浏览器访问以下链接，添加宝塔客服
 https://www.bt.cn/new/wechat_customer
==================================================================
```

注意：`【云服务器】请在安全组放行 33466 端口`

详细可见[https://www.bt.cn/bbs/thread-114414-1-1.html](https://www.bt.cn/bbs/thread-114414-1-1.html)
