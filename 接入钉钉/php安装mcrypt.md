### 基本安装

1. 下载`3种`压缩包：注意的是mcrypt软件依赖libmcrypt和mhash两个库。  

    1. Libmcrypt(libmcrypt-2.5.8.tar.gz)：[点击进入下载](http://sourceforge.net/project/showfiles.php?group_id=87941&package_id=91774&release_id=487459)

    2. mcrypt(mcrypt-2.6.8.tar.gz)：[点击进入下载](http://sourceforge.net/project/showfiles.php?group_id=87941&package_id=91948&release_id=642101)

    3. mhash(mhash-0.9.9.9.tar.gz)：[点击进入下载](http://sourceforge.net/project/showfiles.php?group_id=4286&package_id=4300&release_id=645636)

2. 解压并安装3种压缩包

    1. 安装`Libmcrypt`  

        > tar -zxvf libmcrypt-2.5.8.tar.gz  
        > cd libmcrypt-2.5.8   
        > ./configure  
        > make
        > make install  
        > service php-fpm.service restart   // 重启php-fpm

        说明：libmcript默认安装在/usr/local 

    2. 安装`mhash`

        > tar -zxvf mhash-0.9.9.9.tar.gz  
        > cd mhash-0.9.9.9  
        > ./configure  
        > make  
        > make install  

    3. 安装`mcrypt`

        > tar -zxvf mcrypt-2.6.8.tar.gz  
        > cd mcrypt-2.6.8  
        > LD_LIBRARY_PATH=/usr/local/lib ./configure  // 注意这里和之前不一样
        > make  
        > make install  

        说明：由于在配置Mcrypt时，会找不到libmcrypt的链接库，导致无法编译，因为Libmcrypt的链接库在/usr/local/lib文件夹下。因此，在配置mcrypt时要加入LD_LIBRARY_PATH=/usr/local/lib导入链接库

3. 写配置文件

    > 这里需要注意你的php版本，如我的是72的，就写72  
    > echo "extension = mcrypt.so" >> /www/server/php/72/etc/php.ini

4. 重启php

    > systemctl reload php-fpm.service

5. 检测是否安装好

    > 这里也要注意php版本
    > /www/server/php/73/bin/php -m |grep -i mcrypt

    > [root@ixxxxxxxxxx ~]# /www/server/php/72/bin/php -m |grep -i mcrypt  
    > mcrypt // 上面命令输出了红色的这个就说明安装完成了

6. 删除多余的压缩包和解压包


### 踩坑过程

1. 无法加载动态库，检测安装报错如下

    > PHP Warning:  PHP Startup: Unable to load dynamic library 'mcrpt.so' (tried: /usr/local/php/lib/php/extensions/no-debug-non-zts-20180731/mcrpt.so (libmcrpt.so.5: cannot open shared object file: No such file or directory), /usr/local/php/lib/php/extensions/no-debug-non-zts-20180731/mcrpt.so.so (/usr/local/php/lib/php/extensions/no-debug-non-zts-20180731/mcrpt.so.so: cannot open shared object file: No such file or directory)) in Unknown on line 0

    去寻找这个文件会发现有这个：`/usr/local/php/lib/php/extensions/no-debug-non-zts-20180731/mcrpt.so`存在

    解决方式：每种方式都是不一样的思路，都有可能解决问题，一种不行多试几种
    
    1. 编辑`/etc/ld.so.conf`文件把库文件目录加上

    ```
    vim /etc/ld.so.conf
    include ld.so.conf.d/*.conf  # 默认只有这一行
    /usr/lib64
    /usr/lib
    /usr/local/lib
    /usr/local/lib64
    ```

    2. 在需要安装的插件中进行`make`编译的时候，首先进行`make clean`清除之前的make信息。再次进行`make && make install`即可通过。


2. 运行`make && make install`安装命令后，进行`make test`测试报错如下

        ```
        +-----------------------------------------------------------+
        |                       ! ERROR !                           |
        | The test-suite requires that proc_open() is available.    |
        | Please check if you disabled it in php.ini.               |
        +-----------------------------------------------------------+
        make: *** [test] Error 1
        ```

    原因：需要开启`proc_open`这个禁用函数

    解决方案

    > 1.通过该命令找到php.ini配置文件位置  
    > whereis php   
    > 2.打开配置文件  
    > vim /usr/local/php/etc/php.ini  
    > 3.搜索disable_function，然后去掉`popen`、`exec`、`proc_open`、`shell_exec`、`proc_get_status`这几个函数  
    > 4.重启php  
    > systemctl reload php-fpm.service 


### 一些传送门

1. PHP7.2中AES加密解密方法mcrypt_module_open()替换方案：[地址](https://blog.csdn.net/ligaofeng/article/details/80244013)

2. 为什么建议使用php7以下：[地址](https://zhuanlan.zhihu.com/p/38541917)

3. PHP7.0下钉钉回调接口注册demo：[地址](https://www.sibida.net/article/63399)