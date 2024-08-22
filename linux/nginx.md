[toc]

### nginx 配置文件位置

1. 源码编译安装方式

   在安装目录的`conf`目录下，比如安装目录是`/etc/nginx`，那么就在`/etc/nginx/conf`

2. apt 安装或 yum 安装

   在安装目录的根路径下，通常在`/etc/nginx/nginx.conf`

3. 使用宝塔安装

   一般在`/www/server/nginx/conf/nginx.conf`

4. 使用命令查找

   > sudu find / -name nginx.conf

### nginx 配置文件说明

1. 默认的 config

   ```shell
   #user  nobody;
   worker_processes  1;

   #error_log  logs/error.log;
   #error_log  logs/error.log  notice;
   #error_log  logs/error.log  info;

   #pid        logs/nginx.pid;


   events {
       worker_connections  1024;
   }


   http {
       include       mime.types;
       default_type  application/octet-stream;

       #log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
       #                  '$status $body_bytes_sent "$http_referer" '
       #                  '"$http_user_agent" "$http_x_forwarded_for"';

       #access_log  logs/access.log  main;

       sendfile        on;
       #tcp_nopush     on;

       #keepalive_timeout  0;
       keepalive_timeout  65;

       #gzip  on;

       server {
           listen       80;
           server_name  localhost;

           #charset koi8-r;

           #access_log  logs/host.access.log  main;

           location / {
               root   html;
               index  index.html index.htm;
           }

           #error_page  404              /404.html;

           # redirect server error pages to the static page /50x.html
           #
           error_page   500 502 503 504  /50x.html;
           location = /50x.html {
               root   html;
           }

           # proxy the PHP scripts to Apache listening on 127.0.0.1:80
           #
           #location ~ \.php$ {
           #    proxy_pass   http://127.0.0.1;
           #}

           # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
           #
           #location ~ \.php$ {
           #    root           html;
           #    fastcgi_pass   127.0.0.1:9000;
           #    fastcgi_index  index.php;
           #    fastcgi_param  SCRIPT_FILENAME  /scripts$fastcgi_script_name;
           #    include        fastcgi_params;
           #}

           # deny access to .htaccess files, if Apache's document root
           # concurs with nginx's one
           #
           #location ~ /\.ht {
           #    deny  all;
           #}
       }


       # another virtual host using mix of IP-, name-, and port-based configuration
       #
       #server {
       #    listen       8000;
       #    listen       somename:8080;
       #    server_name  somename  alias  another.alias;

       #    location / {
       #        root   html;
       #        index  index.html index.htm;
       #    }
       #}


       # HTTPS server
       #
       #server {
       #    listen       443 ssl;
       #    server_name  localhost;

       #    ssl_certificate      cert.pem;
       #    ssl_certificate_key  cert.key;

       #    ssl_session_cache    shared:SSL:1m;
       #    ssl_session_timeout  5m;

       #    ssl_ciphers  HIGH:!aNULL:!MD5;
       #    ssl_prefer_server_ciphers  on;

       #    location / {
       #        root   html;
       #        index  index.html index.htm;
       #    }
       #}

   }
   ```

2. nginx 文件结构

   ```shell
   # 全局块
   # something

   # evnets块
   events {
       # something
   }

   # http块
   http {
       # http全局块
       # something

       # server块
       server {
           # location块
           location [PATTERN] {
               # something
           }

           # location块
           location [PATTERN] {
               # something
           }
       }

       # server块
       server {}
   }
   ```

   |          | 描述                                                                        |
   | -------- | --------------------------------------------------------------------------- |
   | 全局     | 影响 nginx 全局的指令                                                       |
   | events   | nginx 服务器或用户的网络连接                                                |
   | http     | 可以嵌套多个 server，配置代理，缓存，日志定义等绝大多数功能和第三方模块配置 |
   | server   | 配置虚拟主机的相关参数，可以配置多个 location                               |
   | location | 配置请求的路由，以及各种页面的处理情况                                      |

3. 配置详细说明

   ```shell
   ########### 每个指令必须有分号结束。#################
   #user administrator administrators;  #配置用户或者组，默认为nobody nobody。
   #worker_processes 2;  #允许生成的进程数，默认为1
   #pid /nginx/pid/nginx.pid;   #指定nginx进程运行文件存放地址
   error_log log/error.log debug;  #制定日志路径，级别。这个设置可以放入全局块，http块，server块，级别以此为：debug|info|notice|warn|error|crit|alert|emerg
   events {
       accept_mutex on;   #设置网路连接序列化，防止惊群现象发生，默认为on
       multi_accept on;  #设置一个进程是否同时接受多个网络连接，默认为off
       #use epoll;      #事件驱动模型，select|poll|kqueue|epoll|resig|/dev/poll|eventport
       worker_connections  1024;    #最大连接数，默认为512
   }
   http {
       include       mime.types;   #文件扩展名与文件类型映射表
       default_type  application/octet-stream; #默认文件类型，默认为text/plain
       #access_log off; #取消服务日志
       log_format myFormat '$remote_addr–$remote_user [$time_local] $request $status $body_bytes_sent $http_referer $http_user_agent $http_x_forwarded_for'; #自定义格式
       access_log log/access.log myFormat;  #combined为日志格式的默认值
       sendfile on;   #允许sendfile方式传输文件，默认为off，可以在http块，server块，location块。
       sendfile_max_chunk 100k;  #每个进程每次调用传输数量不能大于设定的值，默认为0，即不设上限。
       keepalive_timeout 65;  #连接超时时间，默认为75s，可以在http，server，location块。

       upstream mysvr {
       server 127.0.0.1:7878;
       server 192.168.10.121:3333 backup;  #热备
       }
       error_page 404 https://www.baidu.com; #错误页
       server {
           keepalive_requests 120; #单连接请求上限次数。
           listen       4545;   #监听端口
           server_name  127.0.0.1;   #监听地址
           location  ~*^.+$ {       #请求的url过滤，正则匹配，~为区分大小写，~*为不区分大小写。
           #root path;  #根目录
           #index vv.txt;  #设置默认页
           proxy_pass  http://mysvr;  #请求转向mysvr 定义的服务器列表
           deny 127.0.0.1;  #拒绝的ip
           allow 172.18.5.54; #允许的ip
           }
       }
   }
   ```

   1. `$remote_addr`与`$http_x_forwarded_for`：记录客户端的 ip 地址
   2. `$remote_user`：记录客户端用户名称
   3. `$time_local`：记录访问时间与时区
   4. `$request`：记录请求的 url 与 http 协议
   5. `$status`：记录请求状态，成功是 200
   6. `$body_bytes_sent`：记录发送给客户都安文件主体内容大小
   7. `$http_referer`：记录页面请求来源
   8. `$http_user_agent`：记录客户端浏览器的相关信息

### 设置多个配置文件

假设`nginx配置文件`路径为`/etc/nginx/nginx.conf`

1. 在`/etc/nginx`下创建`conf.d`，用来存自定义`conf`文件

2. 在`nginx.conf`的`http块`中加入`include`

   ```shell
   #修改为auto
   worker_processes  auto;

   http {
       server {
           # something
       }

       ##加入以下神秘代码
       include /etc/nginx/conf.d/*.conf;
   }
   ```

3. 然后在`conf.d`下定义`*.conf`文件

   ```shell
   server {
       listen       80;
       server_name  127.0.0.1;

       location = /test {
           default_type text/html;
           return 200  'good';
       }
   }
   ```

拿宝塔的多站点`nginx`配置文件举例

1. 宝塔有一个`根nginx配置文件`，在`/www/server/nginx/conf/nginx.conf`，他里面有一个配置项
   > include /www/server/panel/vhost/nginx/\*.conf;
2. 然后部署了多个站点的情况下，每个站点有一个`单独的nginx配置文件`，对应的就是在如下目录中有多个配置文件
   > /www/server/panel/vhost/nginx
3. 每个站点的配置文件只是配置`http中的1个server`块

### nginx 正向代理和反向代理

1.  什么是正向代理

    1. 就是我们常说的代理
    2. 隐藏了真实的客户端，服务端不知道真正的客户端是谁
    3. 客户端请求的服务都被代理服务器代替来请求

2.  正向代理的用途

    1.  可以翻墙访问国外网站
    2.  可以做缓存，加速访问资源
    3.  可以记录用户访问记录，对外隐藏用户信息

3.  什么是反向代理

    1.  隐藏了真实的服务端，客户端不知道访问的真是服务器
    2.  反向代理服务器会将请求代理到真实的服务器上去

4.  反向代理的用途

    1. 保证内网的安全，阻止 web 攻击，大型网站通常会将反向代理作为公网访问地址，真正的 web 服务器是内网
    2. 负载均衡，通过反向代理服务器来优化网站的负载
    3. 解决前端跨域问题

5.  nginx 配置方式

    正向代理：一般是在客户端配置，nginx 配置的场景不多

    反向代理

    ```
    upstream backend{
        server 172.16.0.10:8080;
        server 172.16.0.20:8080;
        server 172.16.0.30:8080;
    }

    server {
        resolver 8.8.8.8;
        resolver 114.114.114.114;
        listen 8080;
        access_log /home/lin/proxy.access.log;
        error_log /home/lin/proxy.error.log;
        location / {
            proxy_pass http://backend;
            proxy_set_header Host $http_host;
            proxy_ssl_session_reuse off;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;#记录客户端地址，多级代理服务期地址
            proxy_hide_header X-Forwarded-For;#不记录客户端地址
        }
    }
    ```

### 对于服务器上的文件，直接下载，而不是预览

在 nginx 配置文件中加上一个响应头

> add_header 'Content-Disposition' 'attachment';

具体说明可以查看这篇[文章](https://www.cnblogs.com/owenzhou/p/5325570.html)

### 常用命令

1. 重启

   > systemctl start nginx

### 项目部署问题：nginx 刷新显示 404、xftp 无法连接服务器、Nginx403 Forbidden 解决、nginx 反向代理解决前端跨域问题

> https://www.cnblogs.com/goloving/p/8995603.html
