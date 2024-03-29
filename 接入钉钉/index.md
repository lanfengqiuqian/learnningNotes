<!--
 * @Date: 2020-09-02 11:26:07
 * @LastEditors: Lq
 * @LastEditTime: 2020-09-25 19:50:59
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

5. 某些接口需要使用`post`请求，并且传输json数据  

    ```php
    /**
     * @Author: Lq
     * @description: 调用钉钉发送消息接口
     * @param userid_list 接收者的id_list
     * @param dept_id_list (可不传，若传不能为空)接收者的部门id列表
     * @param content 消息内容
     * @param access_token token
     */    
    public function sendMessageToDingDing() {      
      $userid_list = isset($_REQUEST['userid_list']) ? $_REQUEST['userid_list'] : null;
      $dept_id_list = isset($_REQUEST['dept_id_list']) ? $_REQUEST['dept_id_list'] : null;
      $content = isset($_REQUEST['msg']) ? $_REQUEST['msg'] : null;
      $access_token = isset($_REQUEST['access_token']) ? $_REQUEST['access_token'] : null;
      $msg["msgtype"] = "text";
      $msg["text"]["content"] = $content;

      // 这个接口需要使用post请求
      $url = "https://oapi.dingtalk.com/topapi/message/corpconversation/asyncsend_v2?access_token=".$access_token;
      $data["agent_id"] = "xxxx";
      $data["userid_list"] = $userid_list;
      $data["msg"] = $msg;
      // 如果部门id列表不为空的话需要加上
      if(!empty($dept_id_list)) {
        $data["dept_id_list"] = $dept_id_list;
      }

      // 将数据转成json
      $data = json_encode($data);

      $curl = curl_init(); 
      curl_setopt($curl, CURLOPT_POST, 1); 
      curl_setopt($curl, CURLOPT_URL, $url); 
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; curlarset=utf-8',
        'Content-Length: ' . strlen($data)
    ));
      $html = curl_exec($curl); 
      $res = json_decode($html);
      curl_close($curl); 
      return json($res);
      
      
      $data = http_build_query($data);
      $opts = array(
        "http" => array(
          "method" => "POST",
          "header" => "Content-type:application/json",
          "content" => json($data)
        )
      );
      $context = stream_context_create($opts);
      $html = file_get_contents($url, false, $context);
      $html = json_decode($html);
      return json($html);
    }
    ```

6. 使用工作通知推送不需要调用前端api发起会话获取一个会话id，但是发送普通消息需要。

7. 支持的`markdown`语法的字符串不支持换行，如果需要换行的话请使用换行符`\n`

8. 【PHP错误】Cannot pass parameter 2 by reference  

    这个错误的意思是不能按引用传递第2个参数，出现这个错误的原因是bind_param()方法里的除表示数据类型的第一个参数外，均需要用变量，而不能用直接量,因为其它参数都是按引用传递的




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


### 钉钉审批流

#### 流程

1. 审批管理后台进行配置审批模板

    登录OA管理后台 => 工作台 => 审批 => 自定义模板（选择经典模板）

    基础设置 => 表单设计 => 流程设计 => 高级设置

2. 在模板编辑页面的（url地址栏中的processCode参数）拿到`process_code`，并给开发人员

3. 用户发起审批，填写好模板中的值（如审批人，审批人操作记录等数据）

4. 审批回调，审批人进行了某些操作可以使用自定义的回调地址来执行自己系统的某些操作


#### 名词解释

1. process_code：审批管理模板的唯一编码，在`审批模板编辑页面`的`url地址栏`中获取（processCode），服务端开发时需要用到

    如：PROC-9C9B66D6-6F9B-4C22-97B7-E1D22BA8E5CC

2. 审批模板和审批实例的关系

    审批模板：创建好审批模板相当于创建了一个对象，模板中的组件相当于对象中的属性名  
    审批实例：用户发起的一个审批，就相当于为这个对象创建了一个实例，填写好的表单的值相当于对象中的属性值

3. 审批回调：需要先注册回调（应该是在oa管理后台能够配置）

    当审批呗通过或拒绝时，会执行注册号的回调  
    服务端接收到了回调会给审批发起人发送一条工作通知

    官方解密库[地址](https://github.com/injekt/openapi-demo-php/tree/master/corp)  
    解密案例[地址](https://github.com/injekt/openapi-demo-php/blob/master/isv/receive.php)

