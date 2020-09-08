<!--
 * @Date: 2020-09-02 11:26:07
 * @LastEditors: Lq
 * @LastEditTime: 2020-09-07 18:32:19
 * @FilePath: /learnningNotes/接入钉钉/index.md
-->
### 一些小坑

1. corpid参数不同地方意义不一样

    `https://oapi.dingtalk.com/gettoken`：代表AppKey  
    
    `DingTalkPC.config()`：代表公司id   

    `DingTalkPC.runtime.permission.requestAuthCode`：代表公司id

2. `DingTalkPC.runtime.permission.requestAuthCode`中的成功回调返回的`code`只能够使用1次


3. 跳转到内置浏览器使用：`window.location.href`

    跳转到外部浏览器使用：`DingTalkPC.biz.util.openLink()`

4. 请求的ip需要加入到白名单中

    如果是本地直接调用钉钉的接口的话，加入白名单的是本地的ip

    如果是使用服务器的接口进行调用的话，需要将服务器的ip加入到白名单中

#### 服务端API和前端API

1. 服务端API：是一个钉钉的接口，封装之后能够在我们的服务器进行调用（需要配置白名单）
2. 前端API：是一个钉钉对象中的一些方法，比如弹窗什么的，在前端引入钉钉对象之后进行调用

#### 引入钉钉对象的2种方式

1. 浏览器script标签：使用cdn的方式  

    `<script src="https://g.alicdn.com/dingding/dingtalk-jsapi/2.10.3/dingtalk.open.js"></script>`

    然后就能够使用全局对象：`dd`或者`DingTalkPC`

2. 安装模块：使用npm安装钉钉模块

    > npm install dingtalk-jsapi --save
    > import * as dd from 'dingtalk-jsapi'; // 此方式为整体加载，也可按需进行加载