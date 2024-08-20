### 官方文档

<https://docs.halo.run/>

### 主题

1. 应用市场：https://www.halo.run/store/apps
2. Awesome Halo：https://github.com/halo-sigs/awesome-halo

### 小技巧

#### 宝塔可以在 dokcer 商店直接安装

注意：这里安装的版本是`1.x`的，所以如果不是特殊需求，还是从官网安装`2.x`的版本

如果用这种方式的话可以看<https://bbs.halo.run/d/1833-%E4%BD%BF%E7%94%A8-docker--%E5%AE%9D%E5%A1%94%E9%9D%A2%E6%9D%BF%E9%83%A8%E7%BD%B2-halo-%E5%8D%9A%E5%AE%A2>这个博客

#### 版本升级

官方文档<https://docs.halo.run/getting-started/migrate-from-1.x>

我这里是没有其他的配置和数据的，所以直接重新安装就可以

#### 新增自定义模板

<https://www.cnblogs.com/lybaobei/p/17946499>

#### 主题开发

<https://docs.halo.run/developer-guide/theme/prepare#%E5%88%9B%E5%BB%BA%E7%AC%AC%E4%B8%80%E4%B8%AA%E9%A1%B5%E9%9D%A2%E6%A8%A1%E6%9D%BF>

#### 将`http:ip:port`改为`https://域名`访问

1. 通过宝塔面板安装和配置 Nginx 反向代理

   1. 安装 Nginx
      如果你还没有安装 Nginx，可以通过宝塔面板的“软件管理”中安装 Nginx。

   2. 添加站点
      在宝塔面板中，点击“网站” > “添加站点”，输入你的域名 yourdomain.com，并选择使用 Nginx 作为服务器类型。你可以暂时不用开启 SSL，稍后再配置。

   3. 配置反向代理
      添加站点后，点击该站点进入站点设置，然后点击“反向代理”。在反向代理设置中，填写以下内容：

      目标 URL：填写 http://127.0.0.1:8090，即指向你 Halo 容器运行的本地地址和端口。
      发送域名：默认填写即可。
      保存设置后，Nginx 会将所有对 https://yourdomain.com 的请求转发到 http://127.0.0.1:8090。

   4. 开启 SSL
      回到站点设置，点击“SSL”选项卡，然后点击“申请证书”，选择 Let's Encrypt，输入你的域名 yourdomain.com，然后点击“申请”。宝塔会自动为你配置 HTTPS。

2. 通过宝塔配置防火墙
   确保服务器防火墙允许通过 443 端口的流量。在宝塔面板中，点击“安全” > “防火墙”，确保 443 端口已经开放。

3. 重启 Nginx
   在宝塔面板中点击“Nginx” > “重启”，以确保新的配置生效。

4. 测试访问
   现在，你应该可以通过 https://yourdomain.com 直接访问你的 Halo 应用，而无需指定端口号。

5. 配置自动续期（可选）
   如果使用 Let's Encrypt 证书，确保宝塔的自动续期功能是开启的，这样你的 SSL 证书可以自动续期，不会过期。

通过以上步骤，您就可以实现通过 HTTPS 域名直接访问部署在 Docker 容器中的 Halo 项目，并且无需在 URL 中指定端口号。

### 问题

#### 执行 docker-compose up -d 命令进行安装的时候拉取镜像一直失败

> error pulling image configuration: download failed after attempts=6: dial tcp 199.59.148.206:443: i/o timeout

一共 2 个包，一个是`halo`，一个是`halodb`

偶尔这个失败，偶尔那个失败

原因是

> https://bbs.halo.run/d/5606-docker-%E6%8B%89%E5%8F%96%E4%B8%8D%E5%88%B0halo%E9%95%9C%E5%83%8F/5

1. 多尝试几次
2. 开启终端代理
3. 更换镜像源（我最后是这种方式解决的）

   > https://bbs.fit2cloud.com/t/topic/5886

#### 部署之后上传其他主题一直失败

尝试了对 nginx 上传文件的大小扩容也失败

最后是因为版本的问题，`1.x`的版本是不行的，需要`2.x`以上的版本

官方在<https://docs.halo.run/getting-started/migrate-from-1.x>中说明了`Halo 2.0 不兼容 1.x 的主题，建议在升级前先查询你正在使用的主题是否已经支持 2.0。你可以访问 halo-sigs/awesome-halo 或 应用市场 查阅目前支持的主题`

#### 端口被占用

`Error response from daemon: driver failed programming external connectivity on endpoint halo-halo-1 (1f2a3d3b4bd45a5eb6214626510116deea97943604e008a89f55bb7c8a9cc130): Error starting userland proxy: listen tcp4 0.0.0.0:8090: bind: address already in use`

使用`lsof -i:port`查看端口占用情况，选择更换端口或者停止该端口的服务

比如我的是被 nginx 占用了，但是 ngxin 无法停止，那么就只能更换端口

#### 前台样式丢失

<https://docs.halo.run/user-guide/faq/#%E5%89%8D%E5%8F%B0%E6%A0%B7%E5%BC%8F%E4%B8%A2%E5%A4%B1%E5%A6%82%E4%BD%95%E8%A7%A3%E5%86%B3>

1. 后台设置的 `博客地址` 与`实际访问地址`不一致。也可能是开启了 `https` 之后，无法正常加载 `http` 资源，将 `博客地址` 改为 `https` 协议即可。
2. `Nginx` 配置了`静态资源缓存`，但没有设置 `proxy_pass`，参考如下：

```shell
location ~ .*\.(gif|jpg|jpeg|png|bmp|swf|flv|mp4|ico)$ {
  proxy_pass http://halo;
  expires 30d;
  access_log off;
}
```

注意`http://halo`是你的实际地址，比如我的是`http://localhost:8090`
