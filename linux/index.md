<!--
 * @Date: 2020-10-13 15:59:51
 * @LastEditors: Lq
 * @LastEditTime: 2021-07-08 20:27:14
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