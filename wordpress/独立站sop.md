## 企业认证条件准备

### 荧光云企业认证

入口：https://console.ygcloud.com/login

1. 企业名称
2. 统一社会信用代码
3. 对公账户开户行
4. 对公账号
5. 还需要客户配合打款认证

### 阿里云企业认证

入口：https://account.aliyun.com/register/qr_register.htm?spm=5176.29677750.J_4VYgf18xNlTAyFFbOuOQe.d_register_0.1e6c154afyGNVH&oauth_callback=https%3A%2F%2Fwww.aliyun.com%2F%3Fspm%3D5176.12940851-2.0.0.53235455LYEGj4

2种认证方式任选其一

1. 法定代表人扫脸（支付宝）认证即可

2. 法定代表人支付宝认证（需要营业执照副本拍照件）

## 支付方式的企业认证

我看了vivaia设置了paypal、信用卡、支付宝



### paypal

注册入口：https://www.paypal.com/c2/webapps/mpp/account-selection

1. 企业所有者信息（需与营业执照上的法定代表人信息一致）
2. 营业执照扫描件
3. 法定代表人身份证明

注册教程：https://www.paypal.com/c2/webapps/mpp/how-to-guides/sign-up-business-account

paypal里面包含了信用卡，我在插件里面配置一下就可以

### 支付宝的方式是接入stripe

stripe注册入口：https://dashboard.stripe.com/register

教程<https://zhuanlan.zhihu.com/p/571874542>

注意：这个需要香港的公司和银行，这个可以先注册一个万里汇账号来获得香港公司和银行

万里汇注册入口：https://www.worldfirst.com.cn/cn/?default_source=WF-1v00003367aY&referral_id=WF-1v00003367aY

教程：<https://zhuanlan.zhihu.com/p/472888843?utm_id=0>

## 购买域名和服务器

荧光云服务器：

数据中心：阿联酋迪拜
主机配置：8核心16G 
系统盘：50G SSD
带宽：20M
云硬盘：250GB

一年费用：11060 元；

并发数：
受20M带宽限制，按网页100kb响应，则每1秒，可支持25用户同时访问。每分钟可达1500用户。

## 配置DNS


## 搭建宝塔

> yum install -y wget && wget -O install.sh https://download.bt.cn/install/install_6.0.sh && sh install.sh 12f2c1d72

## docker创建wp（验证这个方式不好修改php配置）===建议不用

1. 登录宝塔需要绑定宝塔账号
2. 然后极速安装环境：选择`docker + nginx`
3. 软件商店中搜索wordpress，然后安装
4. 软件商店已安装应用找到wordpress，然后点击`安装应用`（这里如果域名已经解析好了可以配置域名）
5. 安装完成会弹出登录地址，也可以回到这个地方看端口根据ip+端口访问

## 手动安装

1. 软件商店安装php（推荐8.0）
2. 软件商店安装mysql（土建8.0）
3. 网站=>添加站点=>一键部署=>wordpress
4. 配置域名，部署好了之后配置ssl证书

<https://www.bt.cn/bbs/thread-134067-1-1.html>

## 配置wp

### 首次打开站点

配置基础信息+账号密码

删除页面和评论中的demo数据

### 设置-常规

1. 标题
2. 副标题
3. 图标
4. 成员资格：设置任何人都能注册
5. 站点语言：设置英语
6. 日期格式：d/m/Y
7. 一周开始时间：周日

### 设置-链接

修改为【文章名】的方式，有利于seo

### 设置前台英文后台中文

右上角个人账户设置语言为中文

左侧导航栏的设置中选择语言为英语

### 安装主题

Blocksy

然后会提示安装子主题Blocksy Companion，同样安装即可

### 安装电子商店插件

WooCommerce

### 设置物流

### 关税

### 运费设置

### 设置邮件

应用到的地方

1. 用户注册
2. 订单通知
3. 物流通知
4. 活动消息通知

默认情况下wp的发送邮件会是失败的，需要配置一下

<https://www.wp-diary.com/how-to-fix-wordpress-not-sending-email-issue.html>

### 设置聊天机器人

TiDio插件

可以帮客户创建好：邮箱+密码

需要再设置 => 固定链接 中修改【产品固定链接】的形式，建议第三个【添加商店和分类目录地址】

教程：<https://redpanday.com/tidio-%E8%B6%85%E7%AE%80%E5%8D%95%E4%BD%BF%E7%94%A8%E6%95%99%E7%A8%8B-wordpress/>

与WhatApp集成：<https://help.tidio.com/hc/en-us/articles/9392748807580-Integration-with-WhatsApp>

其他的聊天机器人推荐

<https://www.miaoroom.com/course/wordpress-skill/9-best-wordpress-live-chat-customer-service-plugins-for-2023.html>

### 返回顶部按钮

插件：wpfront-scroll-top

调整样式：启用、偏移x27，偏移y1120、修改图片

## 调整整体布局

###