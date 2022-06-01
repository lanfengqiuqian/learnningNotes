<!--
 * @Date: 2021-06-12 18:31:22
 * @LastEditors: Lq
 * @LastEditTime: 2022-05-27 17:14:13
 * @FilePath: \learnningNotes\windows\index.md
-->
#### windows安装puppeteer
1. 更换国内Chromium源

    > set	PUPPETEER_DOWNLOAD_HOST=https://storage.googleapis.com.cnpmjs.org

2. 安装cnpm

    > npm install -g cnpm --registry=https://registry.npm.taobao.org

3. 安装puppeteer

    > cnpm i puppeteer

4. 在当前目录创建一个`index.js`文件，测试

    ```js

    const puppeteer = require('puppeteer');
    
    (async () => {
    const browser = await puppeteer.launch({headless: false})
    const page = await browser.newPage();
    await page.goto('https://baidu.com');
    await page.screenshot({path: 'example.png'});
    
    await browser.close();
    ```

    会自动打开一个无头浏览器，程序跑完之后会在当前目录生辰一张截图

5. 删除`nodemodules`

    > npm install -g rimraf    
    > cd xxx[include node_modules folder]  
    > rimraf node_modules  

#### 查看本机的内网和外网ip

1. 内网ip

    > win+R：cmd，然后输入ipconfig  
    > 其中ipv4的那个就是内网ip了

2. 外网ip

    > 百度输入：ip查询，就能够有了  
    > 或者直接打开地址栏：www.ip138.com


#### win10使用恶意软件删除工具

> https://jingyan.baidu.com/article/4ae03de351484e7efe9e6b2f.html

### win10开始菜单栏位置

> C:\Users\aiyong\AppData\Roaming\Microsoft\Windows\Start Menu\Programs

### CHERRY键盘win键被锁住了

使用`Fn+F9`组合键

其他键盘使用`Fn+F12`组合键

### 开始菜单栏程序快捷方式存放位置

> C:\ProgramData\Microsoft\Windows\Start Menu\Programs

### 搭建了vpn之后，cmd使用代理命令

1. windows

    需要修改的只是vpn对应的端口号即可

    1. 临时修改

        ```shell
        set http_proxy=socks5://127.0.0.1:10808
        set https_proxy=socks5://127.0.0.1:10808
        ```

    2. 或者尝试这种

        ```
        git config --global https.proxy http://127.0.0.1:7890
        git config --global https.proxy https://127.0.0.1:7890
        git config --global http.proxy 'socks5://127.0.0.1:7891'
        git config --global https.proxy 'socks5://127.0.0.1:7891'
        ```

        参见[文章]](https://gist.github.com/why168/9b30f542ff6008d1f66297474a2844de)

    2. 永久修改，见[博客](https://www.jianshu.com/p/1c37903dd09d)


2. linux

    ```shell
    export ALL_PROXY=socks5://127.0.0.1:1086
    ```

3. 检测方法

    终端输入如下命令，如果有结果返回的话，说明成功了
    ```shell
    curl www.google.com
    ```

### FastStone Capture 注册码 序列号

    ```
　　name/用户名：TEAM JiOO
　　key/注册码：CPCWXRVCZW30HMKE8KQQUXW
　　USER NAME:TEAM_BRAiGHTLiNG_2007
　　CODE:XPNMF-ISDYF-LCSED-BPATU
　　RPTME-IMDHD-MIEPX-VLXAW
　　企业版序列号：
　　name：bluman
　　serial/序列号/注册码：VPISCJULXUFGDDXYAUYF

    ```

### idea激活教程：https://www.jianshu.com/p/b74eb79c5c01

### win10查看端口情况

    1. 查看所有端口使用情况

        > netstat -aon

    2. 查看某一个端口的使用情况

        > netstat -aon|findstr "8080"

        ```
        TCP    0.0.0.0:8080           0.0.0.0:0              LISTENING       35360
        TCP    192.168.2.125:57753    14.215.158.119:8080    TIME_WAIT       0    
        TCP    [::]:8080              [::]:0                 LISTENING       35360
        ```

        上面顺序依次是：【协议】、【本地地址】、【外部地址】、【状态】、【PID】

    3. 查看这个pid对应的应用程序

        > tasklist|findstr "35360"

        ```
        java.exe                     35360 Console                    1    716,960 K
        ```

        这里也可以使用【任务管理器】进行查看：在【任务管理器】-> 【详细信息】 -> 根据PID进行排序找到对应的pid，如果详细信息中没有的话，也可能在【服务】中找一下

    4. 然后，可以用taskkill语句结束进程，这里大概需要管理员权限才能正常的结束语句；

        > taskkill /f /t /im java.exe

        这个时候再看就没有该端口占用了

        > netstat -aon|findstr "8080"

### 百度搜索高级技巧

    1. filetype-专业文档搜索

        > 软件开发 filetype:pdf

    2. 精确匹配：双引号和书名号

        > "蓝枫秋千"

    3. intitle-搜索范围限定在网页标题

        > csdn博客 intitle:蓝枫秋千

    4. site-搜索范围限定在特定站点中

        > 微信公众号开发 site:www.csdn.net

    5. inurl-搜索范围限定在url链接中

        > inurl:www.csdn.net

    6. +包含特定查询词、-不包含特定查询词

        > 软件开发+Java  
        > 手机 -iphone

    7. 『』查找论坛模块

    8. 没有广告的百度搜索链接

    > https://www.baidu.com/?pu=sz%401321_480&wpo=btmfast

### windows配置wsl2

    > https://zhuanlan.zhihu.com/p/438255467


### windows商店打不开

是否挂了vpn，如果挂载了的话退出再试试

### 将7z配置到命令行可以使用

> https://www.likecs.com/show-829595.html