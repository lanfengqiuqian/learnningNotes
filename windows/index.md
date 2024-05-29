<!--
 * @Date: 2021-06-12 18:31:22
 * @LastEditors: Lq
 * @LastEditTime: 2022-08-22 16:12:03
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

3. 命令行查询外网ip

    ```shell
    命令行查询(详细):
    UNIX/Linux:#curl cip.cc
    Windows:>telnet cip.cc
    >ftp cip.cc
    命令行查询(纯ip):
    UNIX/Linux/Windows:#curl ip.cip.cc
    ```


#### win10使用恶意软件删除工具

> https://jingyan.baidu.com/article/4ae03de351484e7efe9e6b2f.html

### win10开始菜单栏位置

> C:\Users\aiyong\AppData\Roaming\Microsoft\Windows\Start Menu\Programs

### CHERRY键盘win键被锁住了

使用`Fn+F9`组合键

其他键盘使用`Fn+F12`组合键

达尔优A87：`Fn + win`组合键

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

        ```
        export http_proxy=http://127.0.0.1:7890;
        export https_proxy=http://127.0.0.1:7890;
        ```


2. linux

    ```shell
    export ALL_PROXY=socks5://127.0.0.1:1086
    ```

3. 检测方法

    终端输入如下命令，如果有结果返回的话，说明成功了
    ```shell
    curl www.google.com
    ```


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

### 运行的软件忽然不显示窗口了

描述：一个软件是在运行的，但是点击任务栏图标或者`alt + tab`选中它都出不来

解决方案：是用上面描述中的方法，让这个软件处于选中的状态，然后使用`alt + 空格`，然后会弹出一个`窗口设置选项`，选择最大化，就能够出来了

原因：一般是因为笔记本外接了显示器导致的，如果上述办法无法解决，可以尝试先拔掉外接的显示器，解决之后再使用

### 删除文件权限问题

1. 提示需要管理员权限，进行授权即可

    有时候管理员授权弹窗不会直接弹出来，在任务栏的地方看一下有没有一个授权的程序在闪，打开授权即可

2. 在管理员授权的情况下，有需要当前用户的授权

    这是因为上面是使用管理员的身份执行，如果这个文件或者目录是当前用户的，有可能会弹出这个

    解决方案：如果是删除的话，将这个文件夹移动到当前用户目录下面，然后在删除

3. 提示文件已经在另一个程序中打开了，但是找不到在哪

    1. `ctrl + shift + esc`打开资源管理器（如果是简略信息版，需要切换到详细信息版）

    2. 点击性能选项，在最下方的`简略信息`右边有一个`打开资源管理器`的功能

    3. 默认是`概述`的选项，切换到`CPU`选项

    4. 第3栏有一个`关联的句柄`搜索，搜索你要操作的文件名或者目录名即可

    5. 然后找到进行，将他们结束即可

    <img src="./img/删除文件-结束进程.png" />

### 查找端口号并结束进程

    1. netstat -aon|findstr "8080" 查找暂用端口的进程ID
    
    2. taskkill /pid 21248 杀掉进程ID, 不行就加-f

### 进入休眠模式快捷键Win

win + x 进入快捷方式菜单列表 => u > x

说明：win + l是锁定计算机，但是不会进入休眠模式

### Memory Compression内存压缩占用内存多


### 修改hosts文件之后如何生效

> ipconfig/displaydns // 查看dns  
> ipconfig/flushdns // 刷新dns  


### 系统镜像下载

1. 稳定且快

    > https://www.xitongzhijia.net/win10/202302/279978.html

2. 官方地址

    > https://www.microsoft.com/zh-cn/software-download/windows10ISO

3. 有迅雷的话可以考虑这个

    > https://msdn.itellyou.cn/


### 连接耳机之后，选择播放设备有两个选项

1. stereo=立体声（音质好，只能听歌）
2. hands-free=免提（音质差，可用麦克风）


### 设置搜索功能不包括edge搜索

1. 说明（`系统设置中的不可行`）

    Windows 11 带有一个官方选项，可以在“开始”菜单中关闭网络搜索。它不是“设置”应用程序中的一个选项。虽然在“设置”应用程序中有一个管理云内容搜索的选项，但它不会影响 Windows 11 开始菜单中的 Internet 搜索，但可能会返回 Microsoft 帐户的内容，例如 OneDrive。

    只需关闭页面上的选项并运行搜索；您会注意到 Bing 网络搜索的结果仍然包括在内。

2. 操作

    类型：官方选项在`组策略编辑器和注册表`中可用。组策略编辑器仅在 Windows 11 的`专业版和企业版`中可用。`家庭用户`需要在`注册表`中进行更改以摆脱开始菜单中的“搜索网络”。

    组策略编辑器可参考：[https://www.yundongfang.com/Yun97209.html](https://www.yundongfang.com/Yun97209.html)

        缺点：
        
           1. 不是立即生效，需要重启。
           2. 有可能不生效，这时候还是需要使用注册表的方式
           3. 操作步骤也更多

    建议直接使用`注册表`方式：


    1. 选择开始，键入 `regedit.exe` 并选择注册表编辑器以启动它。接受显示的 UAC 提示。
    2. 导航到 `Computer\HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Search`
    3. 右键单击“`搜索`”并选择“`新建`”>“`双字（32 位）值`”。
    4. 将值命名为 `BingSearchEnabled`。
    5. 双击新的 `Dword` 并将数据设置为 `0`。

### 查看某个命令所在的位置

`Get-Command xxx`，如

> Get-Command pnpm

### 测试ip+端口是否通畅

> telnet xxx.xxx.xxx port

如果能够打开一个空白窗口说明通畅

以下几种报错

1. 提示“‘telnet’ 不是内部或外部命令，也不是可运行的程序 或批处理文件” 信息

    windows的话需要启用Telnet客户端

    1. 在控制面板中找到 `程序和功能`
    2. 打开 `启用或关闭windows功能`
    3. 勾选 `Telnet 客户端`，点确定，稍等片刻完成该功能启用。


2. 正在连接xxx.xxx.xxx...无法打开到主机的连接。 在端口 23: 连接失败
   
    原因：格式不对，必须是`ip port`，端口不能少，而且链接不是用冒号，而是用空格

3. 正在连接xxx.xxx.xxx...无法打开到主机的连接。 在端口 81: 连接失败

    原因：这种说明服务器没有打开`81`端口