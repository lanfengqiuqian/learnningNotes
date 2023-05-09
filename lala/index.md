## 前期准备

### 购买服务器

腾讯云，99/年

这个时候输入ip访问是访问不到的

#### 重制密码

    然后就可以使用这个密码登录了

### 远程连接工具transmit

> 破解版：http://yunpan.imacso.com/f/160721-729278381-50837d

### 下载nginx

> yum install nginx

这里出现报错

```shell
已加载插件：fastestmirror, langpacks
Repository epel is listed more than once in the configuration
Determining fastest mirrors
epel                                                     | 4.7 kB     00:00     
extras                                                   | 2.9 kB     00:00     
os                                                       | 3.6 kB     00:00     
updates                                                  | 2.9 kB     00:00     
(1/5): epel/7/x86_64/group_gz                              |  99 kB   00:00     
(2/5): epel/7/x86_64/updateinfo                            | 1.0 MB   00:00     
(3/5): extras/7/x86_64/primary_db                          | 249 kB   00:00     
(4/5): epel/7/x86_64/primary_db                            | 7.0 MB   00:00     
(5/5): updates/7/x86_64/primary_db                         |  19 MB   00:01     
没有可用软件包 nginx。
错误：无须任何处理
```

原因：nginx位于第三方的yum源里面，而不在centos官方yum源里面

说明：很多软件包在yum里面没有的，解决的方法，就是使用epel源,也就是安装epel-release软件包。EPEL (Extra Packages for Enterprise Linux)是基于Fedora的一个项目，为“红帽系”的操作系统提供额外的软件包，适用于RHEL、CentOS等系统。可以在下面的网址上找到对应的系统版本，架构的软件包

安装`epel`
> sudo yum install epel-release

更新（时间比较长）
> yum update

重新试一下
> yum install -y nginx

还是报错
```
已加载插件：fastestmirror, langpacks
Repository epel is listed more than once in the configuration
Loading mirror speeds from cached hostfile
```

参考[https://blog.csdn.net/CCESARE/article/details/113919036](https://blog.csdn.net/CCESARE/article/details/113919036)

实际上上面的方案也无效

使用压缩包安装

```shell
# 下载
wget http://nginx.org/download/nginx-1.10.1.tar.gz

# 复制到安装目录
cp nginx-1.10.1.tar.gz /usr/local/

# 切换到目录并解压
cd /usr/local
tar -zxvf nginx-1.10.1.tar.gz

# 进行configure配置
cd nginx-1.10.1 
./configure --prefix=/usr/local/nginx

# 编译安装
make && make install

# 启动nginx
systemctl start nginx.service
```

启动的时候报错了

> Failed to start nginx.service: Unit not found.

错误的原因就是没有添加nginx服务，所以启动失败

解决方法就是：在/root/etc/init.d/目录下新建文件，文件名为nginx；或者用命令在根目录下执"行:# vim /etc/init.d/nginx (注意vim旁边有一个空格)，随后插入代码

```
#!/bin/sh

# nginx - this script starts and stops the nginx daemin

#

# chkconfig:   - 85 15

# description:  Nginx is an HTTP(S) server, HTTP(S) reverse \

#               proxy and IMAP/POP3 proxy server

# processname: nginx

# config:      /usr/local/nginx/conf/nginx.conf

# pidfile:     /usr/local/nginx/logs/nginx.pid

# Source function library.

. /etc/rc.d/init.d/functions

# Source networking configuration.

. /etc/sysconfig/network

# Check that networking is up.

[ "$NETWORKING" = "no" ] && exit 0

nginx="/usr/local/nginx/sbin/nginx"

prog=$(basename $nginx)

NGINX_CONF_FILE="/usr/local/nginx/conf/nginx.conf"

lockfile=/var/lock/subsys/nginx

start() {

[ -x $nginx ] || exit 5

[ -f $NGINX_CONF_FILE ] || exit 6

echo -n $"Starting $prog: "

daemon $nginx -c $NGINX_CONF_FILE

retval=$?

echo

[ $retval -eq 0 ] && touch $lockfile

return $retval

}

stop() {

echo -n $"Stopping $prog: "

killproc $prog -QUIT

retval=$?

echo

[ $retval -eq 0 ] && rm -f $lockfile

return $retval

}

restart() {

configtest || return $?

stop

start

}

reload() {

configtest || return $?

echo -n $"Reloading $prog: "

killproc $nginx -HUP

RETVAL=$?

echo

}

force_reload() {

restart

}

configtest() {

$nginx -t -c $NGINX_CONF_FILE

}

rh_status() {

status $prog

}

rh_status_q() {

rh_status >/dev/null 2>&1

}

case "$1" in

start)

rh_status_q && exit 0

$1

;;

stop)

rh_status_q || exit 0

$1

;;

restart|configtest)

$1

;;

reload)

rh_status_q || exit 7

$1

;;

force-reload)

force_reload

;;

status)

rh_status

;;

condrestart|try-restart)

rh_status_q || exit 0

;;

*)

echo $"Usage: $0 {start|stop|status|restart|condrestart|try-restart|reload|force-reload|configtest}"

exit 2

esac
```

然后执行

```
cd /etc/init.d
chmod 755 /etc/init.d/nginx
chkconfig --add nginx
```

### 然后使用ip访问

如果看到nginx则说明成功了

### nginx命令找不到

```shell
vim /etc/profile

// 下面加到文件末尾
# 指向你的nginx的安装位置的 sbin 目录

PATH=$PATH:/usr/local/nginx/sbin

// 重新加载环境
source /etc/profile
```

### 设置index

```shell
vi /usr/local/nginx/conf/nginx.conf

// 修改location
location / {
    root   /usr/local/nginx/html/dist;
    index  index.html index.htm;
}
```

### 安装宝塔面板

可见[https://www.bt.cn/new/download.html](https://www.bt.cn/new/download.html)

centos命令
> yum install -y wget && wget -O install.sh https://download.bt.cn/install/install_6.0.sh && sh install.sh ed8484bec

运行了命令之后会在控制台输出登陆地址和账号密码

```shell
==================================================================
Congratulations! Installed successfully!
==================================================================
外网面板地址: https://xxxx:8888/xxxxxxx
内网面板地址: https://xxx:8888/xxxx
username: xxx
password: xxxx
If you cannot access the panel,
release the following panel port [8888] in the security group
若无法访问面板，请检查防火墙/安全组是否有放行面板[8888]端口
因已开启面板自签证书，访问面板会提示不匹配证书，请参考以下链接配置证书
https://www.bt.cn/bbs/thread-105443-1-1.html
==================================================================
```

如果忘了的话，可以输入下面命令重新获取

> sudo /etc/init.d/bt default

如果访问不通：需要去对应的开启安全组和防火墙

```shell
类型：自定义
来源：0.0.0.0/0
协议端口：TCP:8888
策略：允许
```

首次登陆宝塔命令面板可能会提示密码错误

1. 尝试换一个浏览器，不要用chrome
2. 尝试清除缓存

然后登陆上之后会提示绑定宝塔账号

1. 这里注意绑定的是宝塔官网的账号，没有的话需要去注册，不是你安装宝塔之后的账号
2. 登陆注册地址：https://www.bt.cn/login.html


### 安装php并执行php文件

1. linux系统

    ```shell
    # 安装php
    sudo apt-get update
    sudo apt-get install php

    # 配置 Nginx：在 Nginx 的配置文件中添加 PHP 处理模块。在 Ubuntu 中，Nginx 的配置文件通常位于 /etc/nginx/sites-available/default。在该文件中，可以添加以下代码段：这个代码段表示将以 .php 结尾的请求转发给 PHP 处理模块，并将处理结果返回给客户端。
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # 启动 PHP-FPM：PHP-FPM 是 PHP 的 FastCGI 进程管理器，可以将 PHP 脚本处理请求的过程与 Nginx 的请求处理过程分离开来，从而提高性能。在 Ubuntu 中，可以使用以下命令启动 PHP-FPM：
    sudo systemctl start php7.4-fpm

    # 测试 PHP：在 /usr/local/nginx/html 目录下创建一个 PHP 文件，并在文件中添加以下代码：
    <?php
        phpinfo();
    ?>

    # 然后在浏览器中输入 http://yourdomain.com/yourfile.php 访问该文件，如果页面显示了 PHP 的相关信息，则表示 PHP 已经成功安装并运行。
    ```

2. centos系统

    ```shell
    # 安装php
    sudo apt-get update
    sudo apt-get install php

    # 配置 Nginx：在 Nginx 的配置文件中添加 PHP 处理模块。在 Ubuntu 中，Nginx 的配置文件通常位于 /etc/nginx/sites-available/default。在该文件中，可以添加以下代码段：这个代码段表示将以 .php 结尾的请求转发给 PHP 处理模块，并将处理结果返回给客户端。
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # 启动 PHP-FPM：PHP-FPM 是 PHP 的 FastCGI 进程管理器，可以将 PHP 脚本处理请求的过程与 Nginx 的请求处理过程分离开来，从而提高性能。在 Ubuntu 中，可以使用以下命令启动 PHP-FPM：
    sudo systemctl start php7.4-fpm

    # 测试 PHP：在 /usr/local/nginx/html 目录下创建一个 PHP 文件，并在文件中添加以下代码：
    <?php
        phpinfo();
    ?>

    # 然后在浏览器中输入 http://yourdomain.com/yourfile.php 访问该文件，如果页面显示了 PHP 的相关信息，则表示 PHP 已经成功安装并运行。
    ```


### centos7安装环境和项目部署

    1. git

        > yum install git

    2. nvm

        > curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash

        可以参考[http://www.manongjc.com/detail/60-vqiarrjnlsqfboo.html](http://www.manongjc.com/detail/60-vqiarrjnlsqfboo.html)

    3. node

        > nvm install 16

    4. 项目

        > git config --global user.username    
        > git config --global user.email   
        > git clone xxxx

    5. yarn

        > npm install -g yarn

    6. pm2

        ```js
        // 这里我使用npm进行pm2的全局安装
        npm install -g pm2

        // 安装完成后可以使用  -v 参数 查看pm2的版本 检测是否安装成功
        pm2 -v

        
        ```
    
    7. 这个时候在服务器可以访问通接口了应该

        ```js
        curl http://127.0.0.1:3007/my/userinfo
        ```

        如果在postman或者浏览器掉不通服务器的话，是没有开启防火墙的问题

        ```js
        http://106.52.249.188:3007/my/userinfo
        ```

        去对应的腾讯云或者阿里云，你的服务商开启，`但是我的在上面开启了没有生效，最后还是去宝塔【安全】->【系统防火墙】开启才生效的`

### 公众号接入chatgpt

> https://github.com/husanr/wechat_gpt_laf