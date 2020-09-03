<!--
 * @Date: 2020-09-02 11:26:07
 * @LastEditors: Lq
 * @LastEditTime: 2020-09-02 18:50:33
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