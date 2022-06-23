<!--
 * @Date: 2020-10-13 15:59:51
 * @LastEditors: Lq
 * @LastEditTime: 2022-06-21 21:26:37
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