<!--
 * @Date: 2020-09-09 10:28:50
 * @LastEditors: Lq
 * @LastEditTime: 2022-08-02 20:50:56
 * @FilePath: \learnningNotes\git\github.md
-->

#### 解决加载页面是样式文件加载过慢

方案：使用`DNS`域名解析加快解析速度

1. 登录[http://ipaddress.com/](http://ipaddress.com/)网站获取最近的 dns 网址

2. 搜索`assets-cdn.github.com`这个加载样式文件的`cdn`地址

3. 获取到你访问最快的`ip`

4. 修改本地电脑的`hosts`文件，修改方法参考我的这篇[文章](https://blog.csdn.net/qq_43382853/article/details/106264294?ops_request_misc=%257B%2522request%255Fid%2522%253A%2522159961941819724839807442%2522%252C%2522scm%2522%253A%252220140713.130102334.pc%255Fblog.%2522%257D&request_id=159961941819724839807442&biz_id=0&utm_medium=distribute.pc_search_result.none-task-blog-2~blog~first_rank_v2~rank_blog_default-7-106264294.pc_v2_rank_blog_default&utm_term=host&spm=1018.2118.3001.4187)

#### Git/Github/Gitlab/Gitee 之间的关系

Git：是一种版本控制系统，一个命令，一种工具，有点像 cmd（命令行工具）。  
Github：是基于 git 实现的在线代码托管的仓库，向互联网开放，企业版要收费。  
Gitlab：类似 github 的代码托管功能，一般用于在企业内部搭建 git 私服，需要自己搭建环境。  
Gitee：即码云，是 oschina 免费给企业使用的，不用自己搭建环境，可以建立自己的私有仓库。  
Git-ce：是社区版，gitlab-ee 是企业版，收费的。

适用场景

主要使用 Github 和 Gitee，其中 Github 在国外，访问比较慢，Gitee 在国内，访问比较快。

#### 版本回退 git reset 和 git revert

#### 常见提交代码的两种问题

1. `OpenSSL SSL_read: Connection was reset, errno 10054`

   原因：首先，造成这个错误很有可能是网络不稳定，连接超时导致的，如果再次尝试后依然报错，可以执行下面的命令。就是 SSL 证书的问题, 可以忽略证书继续重新执行。

   解决方案：`git config --global http.sslVerify false`

2. `Failed to connect to github.com port 443: Timed out`

   原因：有可能是网络不稳定的原因，也有可能是代理的问题

   解决方案：关闭代理重新尝试

#### git clone 的时候遭遇 fatal: early EOF fatal: index-pack failed 解决办法

原因：一般这种情况都是因为项目分支过多，导致你要下载的东西太多，从而引起这个问题

方案： 引起这个问题的根源是文件过多，所以我们可以分批次下载文件，先下载一部分，再下载剩下的

```shell
# 首先关闭 core.compression
git config --global core.compression 0

# 然后使用depth这个指令来下载最近一次提交
git clone --depth 1 url

# 然后获取完整库
git fetch --unshallow

# 最后pull一下查看状态，问题解决
git pull --all
```

### 控制台打开代理

注意：其中`7890`和`7891`为你自己的 vpn 的 http 和 socket 的端口号

```
git config --global https.proxy http://127.0.0.1:7890
git config --global https.proxy https://127.0.0.1:7890
git config --global http.proxy 'socks5://127.0.0.1:7891'
git config --global https.proxy 'socks5://127.0.0.1:7891'
```

也可以手动配置代理

在`~/.gitconfig`

```shell
[http]
    proxy = http://127.0.0.1:55681
[https]
    proxy = http://127.0.0.1:55681


# 或者这样
[http]
[http "https://github.com"]
    proxy = http://127.0.0.1:xxxx
```

参见[文章]](https://gist.github.com/why168/9b30f542ff6008d1f66297474a2844de)

### github 高级搜索

1. 过滤 stars

   > 关键字 stars:>1000  
   > 关键字 stars:>1000..2000

2. 过滤语言

   > 关键字 luanguage:编程语言  
   > 关键字 luanguage:python

3. 过滤更新时间

   > 关键字 pushed:>xxxx-xx-xx  
   > 关键字 pushed:>2019-10-01

4. 过滤仓库名中包含关键字

   > in:name 关键字

5. 过滤描述中包含关键字

   > in:description 关键字

6. 过滤 readme 中包含关键字

   > in:readme 关键字

7. 过滤仓库大小在某个范围内的项目

   > size:>5000 关键字  
   > size:5000..6000 关键字

   这里的单位是 kb，500 代表 5M

### github 访问慢解决方案

> https://mp.weixin.qq.com/s?__biz=MjM5MDA2MTI1MA==&mid=2649126312&idx=2&sn=ce2722fb69b52283ff3ccc3502a2a7b3&chksm=be585205892fdb13f1768fbca09107b2557276c29213b2ff3da7b747103eb702c3d3d2b0131e&scene=27

### ssh 密钥原理

`ssh登录`的安全性由非对称加密保证，产生密钥时，一次产生两个密钥，一个公钥，一个私钥，在 git 中国呢一般命名为`id_rsa.pub`和`id_rsa`

如何使用生成的一个私钥一个公钥进行验证呢

1. 本地生成一个密钥对，其中公钥放到远程主机，私钥保存在本地
2. 当本地主机需要登录远程主机时，本地主机向远程主机发送一个登录请求，远程收到消息后，随即生成一个字符串并用公钥加密，发回给本地，本地拿到该字符串，用存放在本地的私钥进行解密，再次发送到远程，远程对比该解密后的字符串与原字符串是否等同，如果等同则认证成功

### 从 http 连接改为 ssh 连接

有时候，http 一直无法连接上服务器，那么可以尝试改为 ssh 的方式

```shell
git remote -v;

git remote set-url origin git@github.com:xxxx.git
```

同理，ssh 不行的时候也可以尝试 http 的方式
