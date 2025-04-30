## 文档和教程

### 演示地址

<https://shopxo.net/experience.html>

### 官方文档

<https://doc.shopxo.net/>

包含

1. 开发文档
2. 插件开发文档
3. api接口文档
4. 使用文档

### git仓库

<https://gitee.com/zongzhige/shopxo#https://gitee.com/link?target=https%3A%2F%2Fgithub.com%2Fgongfuxiang%2Fshopxo>

### 小程序源码

<https://ext.dcloud.net.cn/plugin?id=6380>

### uniapp打包教程

<https://doc.shopxo.net/article/1/293727233598554112.html>

但是里面有一些过时的东西，需要自己判断

### 页面配置地址

<https://doc.shopxo.net/article/1/261485983218794496.html>

### 问答社区

<https://store.shopxo.net/>

## 做替换的地方

### 小程序

#### App.vue里面的请求和资源地址

request_url和static_url

#### 全局搜索ShopXo

不要全局直接替换，每个都要过一下，不影响的不要换，插件类的也不要换

#### 全局直接替换

`https://d1.shopxo.vip`地址替换

## 技巧

## 遇到的问题

### APP不存在，AK有误请检查再重试

后台系统下面配置好地图密钥

### 和微信授权、个人信息有关的，提示appid missing

后台系统 -> 手机 -> 微信小程序 -> 配置appid和appsecret

### 下单的时候提示【请选择支付方式】

后台系统 -> 网站 —> 支付方式

### 微信小程序，运行->微信小程序->上传时 提示 代码质量 主包大小 应小于1.5M 未通过

使用hbuildx的发行功能，不要使用运行的方式去上传代码

### 应用未启用xxxx

这个是需要去后台的应用商店下载对应的应用，并启用

### 应用商店账户密码错误

报错：`商店返回[应用商店账户密码错误]`

1. 后台首页左上角绑定正确的商店账户密码，就是绑定您当前提问的账户密码。
2. 绑定后 后台右上角点击扫把按钮清除缓存，然后刷新页面即可

### 会员等级插件小程序不生效

小程序需要使用增强版，普通版不支持小程序端

<https://store.shopxo.net/ask-index-detail-109.html>

### 控制台报错：caniuse-lite

```
[error] ​Browserslist: caniuse-lite is outdated. Please run:
  npx update-browserslist-db@latest
```

不用管，不影响运行和发布

### 有时候后台修改不生效

比如【新用户立减】插件，修改之后小程序还是之前的

需要后台右上角点击清除缓存才能生效

### 修改后台密码

进入数据库修改 `s_admin` 表中 `username` 等于 `admin` 的用户以下两个字段的值、恢复默认密码为 `shopxo`
`login_pwd`： 40568d2c86822710f49175907b9d981e
`login_salt`： 783497

### 微信支付需要填写哪些信息

商户号必须填写的。
密钥必须填写(`注意需要使用APIv2的方式`)。
证书是需要做退款操作就必须填写。
公众号 pc+h5的时候需要。
小程序，做小程序的时候需要。
开放平台appid 是做app支付才需要的。

### 到支付页面，提示请选择支付方式

后台需要安装支付方式：【网站】【支付方式】

并且启用和对用户开放

### 支付提交提示【签名错误】

一般是后台设置的不对

api安全密钥设置错误，使用v2
