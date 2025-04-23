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

### 