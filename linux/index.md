<!--
 * @Date: 2020-10-13 15:59:51
 * @LastEditors: Lq
 * @LastEditTime: 2021-05-07 15:46:48
 * @FilePath: /learnningNotes/linux/index.md
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