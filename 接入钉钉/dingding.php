<?php
/*
 * @Date: 2020-09-08 11:15:18
 * @LastEditors: Lq
 * @LastEditTime: 2020-09-29 17:55:29
 * @FilePath: /learnningNotes/接入钉钉/dingding.php
 */

namespace app\api\controller;
use app\BaseController;
use think\facade\Db;

require_once "../extend/crypto/DingtalkCrypt.php";

class DingDing extends BaseController {
  
    /**
     * @Author: Lq
     * @description: 钉钉接入后台管理系统
     */    
    public function authCrm() {
      $url = "https://oapi.dingtalk.com/gettoken?corpid=ding2wvl6lwmgczvzjpp&corpsecret=VqJi1Goz0ZRSvuU7Qd3P9AxXCShIN1Lcy7riHgTvMNp6j5E6tj1n9d60hmZhesb2";
        $html = file_get_contents($url);
        $html = json_decode($html);
        if(isset($html->access_token)){
            $access_token = $html->access_token;
            $url = "https://oapi.dingtalk.com/get_jsapi_ticket?access_token=".$access_token;
            $html = file_get_contents($url);
            $html = json_decode($html);
            if(isset($html->ticket)){
                $ticket = $html->ticket;
            }
            $url = "http://prebin.zhushang.net/zhushang.html?ticket={$ticket}&access_token={$access_token}";
			header("Location: {$url}");
			
        }
    }

    /**
     * @Author: Lq
     * @description: 校验权限
     */    
    public function checkAction(){
      $res = Array();
      $url = isset($_REQUEST['url']) ? $_REQUEST['url'] : null;
      $ticket = isset($_REQUEST['ticket']) ? $_REQUEST['ticket'] : null;
      $timeStamp = time();
      $nonceStr = "0123456789";
  
      $res["signature"] = $this->get_front_sign($ticket, $nonceStr, $timeStamp, $url);
      $res["nonceStr"] = $nonceStr;
      $res["timeStamp"] = $timeStamp;
      return json($res);
    }

    /**
     * @Author: Lq
     * @description: 向企业群发送消息
     * @param access_token token
     * @param name 群名称
     * @param owner 群主
     * @param useridlist 成员id列表
     */    
    public function sendMessageToGroup() {
      
      // 目前没有调用该接口的权限，需要申请，然后还需要申请为开发者去查询群会话id
      // 相关文档链接
      // http://www.sandbean.com/jyfx/87.html https://ding-doc.dingtalk.com/doc#/serverapi2/isu6nk
      
      $access_token = $this->gettoken();
      $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
      $owner = isset($_REQUEST['owner']) ? $_REQUEST['owner'] : null;
      $useridlist = isset($_REQUEST['useridlist']) ? $_REQUEST['useridlist'] : null;
      $useridlist = [1572670779268169,15776780379089900];

      // 创建会话
      $url = "https://oapi.dingtalk.com/chat/create?access_token={$access_token}";
      $data = array(
        "access_token" => $access_token,
        "name" => $name,
        "owner" => $owner,
        "useridlist" => $useridlist
      );
      $curl = curl_init(); 
      curl_setopt($curl, CURLOPT_POST, 1); 
      curl_setopt($curl, CURLOPT_URL, $url); 
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data)); 
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; curlarset=utf-8',
        'Content-Length: ' . strlen(json_encode($data))
    ));
      $html = curl_exec($curl); 
      $res = json_decode($html);
      curl_close($curl); 
      return json($res);
    }

    /**
     * @Author: Lq
     * @description: 调用钉钉发送消息接口
     * @param userid_list 接收者的id_list
     * @param dept_id_list (可不传，若传不能为空)接收者的部门id列表
     * @param content 消息内容
     * @param access_token token
     * @param type 消息模板类型
     */    
    public function sendMessageToDingDing() {      
      $userid_list = isset($_REQUEST['userid_list']) ? $_REQUEST['userid_list'] : null;
      $dept_id_list = isset($_REQUEST['dept_id_list']) ? $_REQUEST['dept_id_list'] : null;
      $content = isset($_REQUEST['msg']) ? $_REQUEST['msg'] : null;
      $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
      $access_token = isset($_REQUEST['access_token']) ? $_REQUEST['access_token'] : null;
      $msg["msgtype"] = "text";
      $msg["text"]["content"] = $content;

      // 测试链接消息
      // $msgLink["msgtype"] = "link";
      // $msgLink["link"]["messageUrl"] = "http://oss.zhushang.net/1599546933643501.jpeg";
      // $msgLink["link"]["picUrl"] = "@lALOACZwe2Rk";
      // $msgLink["link"]["title"] = "给佳佳测试用的";
      // $msgLink["link"]["text"] = "海豹突击队的产品经理怎么辣么好看";

      // 测试oa消息
      // $msgLink = array(
      //   "msgtype" => "oa",
      //   "oa" => array(
      //     "message_url" => "http://oss.zhushang.net/1599546933643501.jpeg",
      //     "head" => array(
      //       "bgcolor" => "FFBBBBBB",
      //       "text" => "佳佳真好看"
      //     ),
      //     "body" => array(
      //       "title" => "请论述佳佳有多么的好看",
      //       "form" => [
      //         array(
      //           "key" => "姓名",
      //           "value" => "李佳佳"
      //         ),
      //         array(
      //           "key" => "年龄",
      //           "value" => "18"
      //         ),
      //         array(
      //           "key" => "身高",
      //           "value" => "170"
      //         ),
      //         array(
      //           "key" => "胸围",
      //           "value" => "36D"
      //         )
      //       ],
      //       "rich" => array(
      //         "num" => "999",
      //         "unit" => "元/人"
      //       ),
      //       "content" => "如果觉得佳佳好看请扣1，非常好看请扣2，特别特别好看请扣3!",
      //       "image" => "@lADOADmaWMzazQKA",
      //       "file_count" => "3",
      //       "author" => "卑微小开发"
      //     ),
      //   )
      // );

      // 测试markdown格式
      // $msgLink = array(
      //   "msgtype" => "markdown",
      //   "markdown" => array(
      //     "title" => "佳佳招亲公告",
      //     "text" => "\n# 身份介绍\n1. 筑商业务部第一产品经理  \n2. 海豹突击队业务一把手  \n3. 肤白貌美气质佳  \n 4. 艰苦奋斗好青年  \n \n# 择偶标准  \n1. 优先是帅气的小哥哥  \n  2. 拒绝是抠脚大汉  \n 3. 收入不能比小姐姐低  \n  ### 福利说明  \n  想看小姐姐照片吗，请[点击](https://image.baidu.com/search/detail?ct=503316480&z=&tn=baiduimagedetail&ipn=d&word=%E5%88%98%E4%BA%A6%E8%8F%B2&step_word=&ie=utf-8&in=&cl=2&lm=-1&st=-1&hd=&latest=&copyright=&cs=1216501660,2812582666&os=2346146760,1715963121&pn=7&rn=1&di=133430&ln=30&fr=&fmq=1599549078898_R&ic=&s=undefined&se=&sme=&tab=0&width=&height=&face=undefined&is=0,0&istype=2&ist=&jit=&bdtype=0&pi=0&gsm=0&objurl=http%3A%2F%2Fhbimg.b0.upaiyun.com%2Fb0fb6031db6a7c587275b2b93929bb770f507eef2a9e1-EsjH0u_fw658&rpstart=0&rpnum=0&adpicid=0)查看"
      //   )
      // );

      // 测试卡片消息(整体跳转)
      // $msgLink = array(
      //   "msgtype" => "action_card",
      //   "action_card" => array(
      //     "title" => "佳佳比武招亲大赛",
      //     "markdown" => "\n# 身份介绍",
      //     "single_title" => "查看详情",
      //     "single_url" => "https://image.baidu.com"
      //   )
      // );

      // 测试卡片消息（独立跳转）
      $msgLink = array(
          "msgtype" => "action_card",
          "action_card" => array(
            "title" => "艰难的抉择",
            "markdown" => "\n  ## 人生总是要面对各种艰难的抉择  \n  ### 真的好痛苦  \n  ### 灵魂拷问  \n  小姐姐最喜欢你的哪个小开发？",
            "btn_orientation" => "1",
            "btn_json_list" => [
              array(
                "title" => "兰兰",
                "action_url" => "https://www.baidu.com"
              ),
              array(
                "title" => "强强",
                "action_url" => "https://www.taobao.com",
              ),
            ]
          )
        );

      // 这个接口需要使用post请求
      $url = "https://oapi.dingtalk.com/topapi/message/corpconversation/asyncsend_v2?access_token=".$access_token;
      $data["agent_id"] = "868751031";
      $data["userid_list"] = $userid_list;
      $data["msg"] = $msgLink;
      // $data["msg"] = $msg;
      // 如果部门id列表不为空的话需要加上
      if(!empty($dept_id_list)) {
        $data["dept_id_list"] = $dept_id_list;
      }

      $curl = curl_init(); 
      curl_setopt($curl, CURLOPT_POST, 1); 
      curl_setopt($curl, CURLOPT_URL, $url); 
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data)); 
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; curlarset=utf-8',
        'Content-Length: ' . strlen(json_encode($data))
    ));
      $html = curl_exec($curl); 
      $res = json_decode($html);
      curl_close($curl); 
      return json($res);
    }
  
  	/**
     * 获取前端签名
     * @param string $ticket jsapi_ticket
     * @param string $nonceStr 随机字符串 DINGTALK_NONCE_STR
     * @param string $timeStamp 当前时间戳
     * @param string $url 当前页面URL
     * @return string 签名字符串
     */
    private static function get_front_sign($ticket, $nonceStr, $timeStamp, $url) {
      $to_sign = 'jsapi_ticket=' . $ticket .
          '&noncestr=' . $nonceStr .
          '&timestamp=' . $timeStamp .
          '&url=' . $url;
      return sha1($to_sign);
    }

    /**
     * @Author: Lq
     * @description: 获取当前用户的姓名和部门
     * @param code 当前用户授权码
     * @param access_token 授权令牌
     */    
    public function getZSInfo(){
      /**
       * 整理一下大概思路
       * 1. 获取筑商业务部的所有子部门id
       * 2. 获取当前用户信息（userId）
       * 3. 通过userId获取当前用户的信息（所属部门）
       * 4. 判断所属部门是否是筑商业务部或者是其子部门
       */
      
      $code = isset($_REQUEST['code']) ? $_REQUEST['code'] : null;
      $access_token = isset($_REQUEST['access_token']) ? $_REQUEST['access_token'] : null;

      // 获取部门信息详情：102613174是筑商业务部，243270134是海豹突击队，298235666是筑商销售队部，329022531是筑商服务团队
      // $partUrl = "https://oapi.dingtalk.com/department/get?access_token=".$access_token."&id=329022531";
      // $html = file_get_contents($partUrl);
      // $html = json_decode($html);
      // return json($html);
      

      /**
       * 一下注释api不要删除
       * 用于以后需求变更使用
       */
      
      // 获取子部门信息详情：102613174是筑商业务部
      // 为什么子部门不写死，担心以后筑商业务部会开启新的部门，所以手动查询比较好
      $partUrl = "https://oapi.dingtalk.com/department/list_ids?access_token=".$access_token."&id=102613174";
      $html = file_get_contents($partUrl);
      $html = json_decode($html);
      // 获取子部门id
      $departmentIds = $html->sub_dept_id_list;
      // 这里还需要查询销售下面的子部门
      $saleUrl = "https://oapi.dingtalk.com/department/list_ids?access_token=".$access_token."&id=298235666";
      $html = file_get_contents($saleUrl);
      $html = json_decode($html);
      // 将销售的子部门放到ids中
      $departmentIds = array_merge($departmentIds, $html->sub_dept_id_list);
      // 将筑商业务部放到ids中
      array_push($departmentIds, 102613174);

      // 获取部门用户userId列表
      // $partUrl = "https://oapi.dingtalk.com/user/getDeptMember?access_token=".$access_token."&deptId=243270134";
      // 获取部门所有姓名和userId
      // $partUrl = "https://oapi.dingtalk.com/user/simplelist?access_token=".$access_token."&department_id=243270134";
      // 获取部门所有用户信息
      // $partUrl = "https://oapi.dingtalk.com/user/listbypage?access_token=".$access_token."&department_id=243270134&offset=0&size=100";
      // $html = file_get_contents($partUrl);
      // $html = json_decode($html);

      
      // 获取当前用户姓名和userId
      $url = "https://oapi.dingtalk.com/user/getuserinfo?access_token=".$access_token."&code=".$code;
      $html = file_get_contents($url);
      $html = json_decode($html);
      $userid = $html->userid;
      
      // 获取当前用户详细信息
      $url = "https://oapi.dingtalk.com/user/get?access_token=".$access_token."&userid=".$userid;
      $html = file_get_contents($url);
      $html = json_decode($html);
      // 获取到所属部门，考虑有多个的情况
      $currentPartIds = $html->department;
      // 遍历判断是否有其中一个部门在筑商部门的ids中
      // 声明一个boolean，初始值为false，如果有在筑商业务部ids中，就给他置为true
      $isExist = false;
      foreach($currentPartIds as $key => $value) {
        $index = array_search($value, $departmentIds);
        // 由于在的话返回的是位置数字，不在的话返回false，所以判断数字就行
        if(is_numeric($index)) {
          $isExist = true;
        }
      }
      $result["data"] = $html;
      $result["isExist"] = $isExist;
      return json($result);
    }  


    // 获取token
    public function getToken() {
      // corpid就是AppKey：ding93szeploslhbwofx 
      // corpsecret就是AppSecret
      
      $url = "https://oapi.dingtalk.com/gettoken?corpid=ding93szeploslhbwofx&corpsecret=O91HpYWpdIrSglzwD3EnvyxPPebK9txtHQDl26E7MIdw-80DZDpozZyJtvbl7Nd6";
      //$url = "https://oapi.dingtalk.com/gettoken?appkey=ding93szeploslhbwofx&appsecret=O91HpYWpdIrSglzwD3EnvyxPPebK9txtHQDl26E7MIdw-80DZDpozZyJtvbl7Nd6";
      $html = file_get_contents($url);
      $html = json_decode($html);
      return $html->access_token;
  }
  
  // 发起审批
  public function startExamine() {
    // 发起人手机号
    $tel = isset($_REQUEST['tel']) ? $_REQUEST['tel'] : 15623901618;
    // 发起人id
    $userId = isset($_REQUEST['userId']) ? $_REQUEST['userId'] : 15776780379089900;
    // 发起人部门id，如果-1表示为跟部门,目前是海豹突击队
    $dept_id = isset($_REQUEST['deptId']) ? $_REQUEST['deptId'] : 243270134;
    // 审批流模板流程码：PROC-95070216-3BE4-4D01-B75B-8A2E026FEFEA正常结算单 PROC-8A4017BD-CD39-4DCE-BFEC-10E77FF5CE1A异常结算单
    $process_code = isset($_REQUEST['processCode']) ? $_REQUEST['processCode'] : null;
    $access_token = $this->getToken();

    // 结算单id
    $settleNo = isset($_REQUEST['settleNo']) ? $_REQUEST['settleNo'] : '';
    // 区域
    $area = isset($_REQUEST['area']) ? $_REQUEST['area'] : '';
    // 提交时间
    $submitTime = date('Y-m-d H:i');
    // 任务基本信息
    $baseInfo = isset($_REQUEST['baseInfo']) ? $_REQUEST['baseInfo'] : '';
    // 任务金额
    $money = isset($_REQUEST['money']) ? $_REQUEST['money'] : '';

    if(empty($process_code) || empty($access_token) || empty($settleNo) || empty($area) || empty($baseInfo) || empty($money)) {
      return json("缺失参数");
    }
    
    $url = "https://oapi.dingtalk.com/topapi/processinstance/create?access_token=".$access_token;
    $data["originator_user_id"] = $userId;
    $data["dept_id"] = $dept_id;
    $data["process_code"] = $process_code;
    $data["form_component_values"] = [array(
      "name" => "结算单号",
      "value" => $settleNo
    ), array(
      "name" => "区域",
      "value" => $area
    ), array(
      "name" => "结算提交时间",
      "value" => $submitTime
    ), array(
      "name" => "任务基本信息",
      "value" => $baseInfo
    ), array(
      "name" => "应结算金额（元）",
      "value" => $money
    )];
    
    
    $curl = curl_init(); 
    curl_setopt($curl, CURLOPT_POST, 1); 
    curl_setopt($curl, CURLOPT_URL, $url); 
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data)); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json; curlarset=utf-8',
      'Content-Length: ' . strlen(json_encode($data))
  ));
    $html = curl_exec($curl); 
    $res = json_decode($html);
    curl_close($curl); 
    return json($res);
  }   

	// 取消审批
	public function cancelExamine() {
	    $access_token = $this->getToken();
	    $process_instance_id = isset($_REQUEST['processInstanceId']) ? $_REQUEST['processInstanceId'] : null;
	    // 是否通过系统直接终止，false的话需要指定终止人
	    $is_system = isset($_REQUEST['isSystem']) ? $_REQUEST['isSystem'] : true;
	    $remark = isset($_REQUEST['remark']) ? $_REQUEST['remark'] : null;
	    $operating_userid = isset($_REQUEST['operatingUserid']) ? $_REQUEST['operatingUserid'] : null;
	    
	    $data["request"] = array(
	        "is_system" => $is_system,
	        "remark" => $remark,
	        "process_instance_id" => $process_instance_id
	    );
	
	    $url = "https://oapi.dingtalk.com/topapi/process/instance/terminate?access_token=$access_token";
	    $curl = curl_init(); 
	    curl_setopt($curl, CURLOPT_POST, 2); 
	    curl_setopt($curl, CURLOPT_URL, $url); 
	    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data)); 
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json; curlarset=utf-8',
	    'Content-Length: ' . strlen(json_encode($data))
	    ));
	    $html = curl_exec($curl); 
	    $res = json_decode($html);
	    curl_close($curl); 
      return json($res);
	}


  // 根据手机号获取用户id
  public function getUserId() {
      // 获取用户id
      $tel = isset($_REQUEST['tel']) ? $_REQUEST['tel'] : null;
      $access_token = $this->getToken();
      $url = "https://oapi.dingtalk.com/user/get_by_mobile?access_token=".$access_token."&mobile=".$tel;
      $html = file_get_contents($url);
      $html = json_decode($html);
      return json($html);
  }
  
  // 回调方法
  public function dingCallback() {
  //      $signature = isset($_REQUEST['signature']) ? $_REQUEST['signature'] : null;
  //      $timestamp = isset($_REQUEST['timestamp']) ? $_REQUEST['timestamp'] : null;
  //      $nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : null;
  //      $msg = "success";
  //      $kong = "";

  //      $res = "success";
  //      $encryptMsg = "";
        
		// $url = "http://123.56.175.2:88/public/index.php/dingCallback?timestamp=$timestamp&nonce=$nonce";
		// $curl = curl_init(); 
		// curl_setopt($curl, CURLOPT_POST, 2); 
		// curl_setopt($curl, CURLOPT_URL, $url); 
		// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($msg)); 
		// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		// 'Content-Type: application/json; curlarset=utf-8',
		// 'Content-Length: ' . strlen(json_encode($msg))
		// ));
		// $html = curl_exec($curl); 
		// $res = json_decode($html);
		// curl_close($curl); 

		// return json($res);
		
        
      $signature = isset($_REQUEST['signature']) ? $_REQUEST['signature'] : null;
      $timestamp = isset($_REQUEST['timestamp']) ? $_REQUEST['timestamp'] : null;
      $nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : null;
      $msg = "success";
      $kong = "";
      
      // encrypt特殊获取方式
      $postdata = file_get_contents("php://input");
      $postList = json_decode($postdata,true);
      $encrypt = $postList['encrypt'];
      
      // 第三个参数一定是企业id(如dingb967b625a491f4dfee0f45d8e4f7c288) ，不是AppKey(ding93szeploslhbwofx)
      $crypt = new \DingtalkCrypt("zhangbin", "jingningzhushangkejigufenyouxiangongsi20299", "ding29230cebaff9eb11");
      // 注册回调加密
       //$encryData = $crypt->EncryptMsg($msg, $timestamp, $nonce, $kong);
      // 业务回调解密
      $encryData = $crypt->DecryptMsg($signature, $timestamp, $nonce, $encrypt, $kong);
      
      if($encryData['ErrorCode'] != 0){
          $data = $encryData['data'];
          return json($res);
      }else{
          $data = $encryData['data'];
          $data = json_decode($data);
          
          $sql = "UPDATE `zhu_b_task_cycle` SET `task_name` = ? WHERE id = 999";
          $res = Db::query($sql, [json_encode($data)]);
          
          // 进行回调类型的判断
          switch ($data->EventType) {
              case 'bpms_instance_change':
                  // 审批开始或结束
                  $details = $this->getExamineDetails($data->processInstanceId);
                  // 将数据传给处理函数，审批开始或结束好像不需要获取数据
                  $this->dealWithHandle($data, $details);
                  
                  break;
              case 'bpms_task_change':
                  // 审批转交
                  // 获取审批详情
                  $details = $this->getExamineDetails($data->processInstanceId);
                  
                  // 将数据传给处理函数
                  $this->dealWithHandle($data, $details);

                  break;
              default:
                  // code...
                  break;
          }
      } 
      
  }
  
  // 处理回调操作数据库方法
  public function dealWithHandle($data, $details) {
      // 此次审批时间
      $time = property_exists($data, "finishTime") ? $data->finishTime : '';
      // 审批人id或发起审批人id
      $userId = property_exists($data, "staffId") ? $data->staffId : '';
      $userName = $this->getUserDetails($userId);
      // 审批结果：agree/audit/refuse
      $result = property_exists($data, "result") ? $data->result : '';
      // 审批流程类型：我们只需要是finish的类型
      $type = property_exists($data, "type") ? $data->type : '';
      // 评论
      $remark = property_exists($data, "remark") ? $data->remark : '';
      // 模板id：根据模板id来确定是异常的结算单还是正常的结算单
      $processCode = property_exists($data, "processCode") ? $data->processCode : '';
      // 审批实例id
      $processInstanceId = property_exists($data, "processInstanceId") ? $data->processInstanceId : '';
      // 结算单id
      $settleNo = $details->process_instance->form_component_values[0]->value;
      // 审批开始的url,用于判断是不是审批发起
      $beginUrl = property_exists($data, "url") ? $data->url : '';
      
      // 只需要完成的数据
      if($type == 'finish' && empty($beginUrl)) {
          // 判断是正常的结算单还是异常的结算单
          // PROC-D2D92EC2-29BF-49D6-B08C-79944F7D7B17表示正常，PROC-D73CDA1E-A7B1-43CD-856B-0C3CE814981C为异常
          if($processCode == 'PROC-95070216-3BE4-4D01-B75B-8A2E026FEFEA') {
              // 根据不同的人来确定审批流的步骤
              // 运营专员(1927594855670666 兰强)->一级风控(2016380055-950117904 张彬)->二级风控(190851381823604032 葛中魁 320318352126078770 李佳荷)->运营专员(1927594855670666 兰强)
            	// 运营
				// 王陈露 18857121191 西安    15974508502478020
				// 连晓彦 18695867788 郑州（其他）  1596180846458536
				// 胡朝阳 15511600646 石家庄  15907461863187580
				// 一级风控
				// 杨玥 18502829495 15792486784949576
				// 二级风控
				// 李松 18682962006 15746529818818377
				// 康乐 18602197097 386130498658
              $myData["isAnormal"] = "zhengchang";
              if($userId == '2016380055779340') {
                  // 正常结算单的一级风控通过了
                  // 需要存储的数据有：此次审核通过时间，也是审核完成时间
                  $time = date('Y-m-d H:i:s', substr($time, 0, 10));
                  $myData["time"] = $time;
                  
                  $url = "http://prebin.zhushang.net/zhu_pro_lq/public/index.php/api/dingdingApprovalNormal?settleOrder=$settleNo&type=2&time=$time&name=$userName&msg=$remark";
                  $curl = curl_init(); 
                  curl_setopt($curl, CURLOPT_POST, 2); 
                  curl_setopt($curl, CURLOPT_URL, $url); 
                  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($myData)); 
                  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json; curlarset=utf-8',
                  'Content-Length: ' . strlen(json_encode($myData))
                  ));
                  $html = curl_exec($curl); 
                  $res = json_decode($html);
                  curl_close($curl); 
              } else if ($userId == '15750266665258822' || $userId == '15680033728872878') {
                  // 正常结算单二级风控通过了
                  // 需要存储的数据有审核通过时间
                  $time = date('Y-m-d H:i:s', substr($time, 0, 10));
                  $myData["time"] = $time;

                  $url = "http://prebin.zhushang.net/zhu_pro_lq/public/index.php/api/dingdingApprovalNormal?settleOrder=$settleNo&type=3&time=$time&name=$userName&msg=$remark";
                  $curl = curl_init(); 
                  curl_setopt($curl, CURLOPT_POST, 1); 
                  curl_setopt($curl, CURLOPT_URL, $url); 
                  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($myData)); 
                  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json; curlarset=utf-8',
                  'Content-Length: ' . strlen(json_encode($myData))
                  ));
                  $html = curl_exec($curl); 
                  $res = json_decode($html);
                  curl_close($curl); 
                  
              } else {
                  // 正常结算单的运营专员通过了
                  // 需要存储的数据有：结算凭证，审批开始时间，运营通过时间
                  $src = $details->process_instance->form_component_values[6]->value;
                  $time = $data->finishTime;
                  $time = date('Y-m-d H:i:s', substr($time, 0, 10));
                  $myData["time"] = $time;
                  
                  $url = "http://prebin.zhushang.net/zhu_pro_lq/public/index.php/api/dingdingApprovalNormal?settleOrder=$settleNo&type=1&time=$time&name=$userName&msg=$remark&approvalSettlementVoucherUrl=$src";
                  $curl = curl_init(); 
                  curl_setopt($curl, CURLOPT_POST, 1); 
                  curl_setopt($curl, CURLOPT_URL, $url); 
                  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($myData)); 
                  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json; curlarset=utf-8',
                  'Content-Length: ' . strlen(json_encode($myData))
                  ));
                  $html = curl_exec($curl); 
                  $res = json_decode($html);
                  curl_close($curl); 
              }
          } else {
              // 根据不同的人来确定审批流的步骤
              // 运营专员(1927594855670666 兰强)->一级风控(2016380055-950117904 张彬)->二级风控(190851381823604032 葛中魁 320318352126078770 李佳荷)->运营专员(1927594855670666 兰强)
            	// 运营
				// 王陈露 18857121191 西安    15974508502478020
				// 连晓彦 18695867788 郑州（其他）  1596180846458536
				// 胡朝阳 15511600646 石家庄  15907461863187580
				// 一级风控
				// 杨玥 18502829495 15792486784949576
				// 二级风控
				// 李松 18682962006 15746529818818377
				// 康乐 18602197097 386130498658
              $myData["isAnormal"] = "yichang";
              if($userId == '2016380055779340') {
                  // 异常结算单的一级风控通过了
                  // 需要存储的数据有：此次审核通过时间，也是审核完成时间
                  $time = date('Y-m-d H:i:s', substr($time, 0, 10));
                  $myData["time"] = $time;

                  $url = "http://prebin.zhushang.net/zhu_pro_lq/public/index.php/api/dingdingApprovalAbnormal?settleOrder=$settleNo&type=2&time=$time&name=$userName&msg=$remark";
                  $curl = curl_init(); 
                  curl_setopt($curl, CURLOPT_POST, 1); 
                  curl_setopt($curl, CURLOPT_URL, $url); 
                  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($myData)); 
                  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json; curlarset=utf-8',
                  'Content-Length: ' . strlen(json_encode($myData))
                  ));
                  $html = curl_exec($curl); 
                  $res = json_decode($html);
                  curl_close($curl); 
              } else if ($userId == '15750266665258822' || $userId == '15680033728872878') {
                  // 异常结算单二级风控通过了
                  // 需要存储的数据有审核通过时间
                  $time = date('Y-m-d H:i:s', substr($time, 0, 10));
                  $myData["time"] = $time;
                  $url = "http://prebin.zhushang.net/zhu_pro_lq/public/index.php/api/dingdingApprovalAbnormal?settleOrder=$settleNo&type=3&time=$time&name=$userName&msg=$remark";
                  $curl = curl_init(); 
                  curl_setopt($curl, CURLOPT_POST, 1); 
                  curl_setopt($curl, CURLOPT_URL, $url); 
                  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($myData)); 
                  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json; curlarset=utf-8',
                  'Content-Length: ' . strlen(json_encode($myData))
                  ));
                  $html = curl_exec($curl); 
                  $res = json_decode($html);
                  curl_close($curl); 
              } else {
                  // 异常结算单的运营专员通过了
                  // 需要存储的数据有：结算凭证，审批开始时间，运营通过时间
                  
                  // 根据操作列表的长度来确定是第一次操作还是第四次操作
                  $length = sizeof($details->process_instance->tasks);
                  
                  $time = $data->finishTime;
                  $time = date('Y-m-d H:i:s', substr($time, 0, 10));
                  $src = $details->process_instance->form_component_values[6]->value;
                  if($length > 3) {
                      // 说明是第四次操作
                      $myData["time"] = $time;
                      
                      $url = "http://prebin.zhushang.net/zhu_pro_lq/public/index.php/api/dingdingApprovalAbnormal?settleOrder=$settleNo&type=4&time=$time&name=$userName&msg=$remark&approvalSettlementVoucherUrl=$src";
                      $curl = curl_init(); 
                      curl_setopt($curl, CURLOPT_POST, 1); 
                      curl_setopt($curl, CURLOPT_URL, $url); 
                      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($myData)); 
                      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                      'Content-Type: application/json; curlarset=utf-8',
                      'Content-Length: ' . strlen(json_encode($myData))
                      ));
                      $html = curl_exec($curl); 
                      $res = json_decode($html);
                      curl_close($curl); 
                  } else {
                      // 说明是第一次操作
                      // 需要存储的数据：审批流开始时间，结算凭证，此次审批通过时间
                      $beginTime = property_exists($data, "createTime") ? $data->createTime : '';
                      $beginTime = date('Y-m-d H:i:s', substr($beginTime, 0, 10));
                      $myData["time"] = $time;
                      
                      $url = "http://prebin.zhushang.net/zhu_pro_lq/public/index.php/api/dingdingApprovalAbnormal?settleOrder=$settleNo&type=1&time=$time&name=$userName&msg=$remark";
                      $curl = curl_init(); 
                      curl_setopt($curl, CURLOPT_POST, 1); 
                      curl_setopt($curl, CURLOPT_URL, $url); 
                      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($myData)); 
                      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                      'Content-Type: application/json; curlarset=utf-8',
                      'Content-Length: ' . strlen(json_encode($myData))
                      ));
                      $html = curl_exec($curl); 
                      $res = json_decode($html);
                      curl_close($curl); 
                  }
              }
          }
          
          // 判断是不是驳回的
          if($result == 'refuse') {
              $myData["time"] = $time;
              $url = "http://prebin.zhushang.net/zhu_pro_lq/public/index.php/api/rejectDingdingApprove?settleOrder=$settleNo&name=$userName&msg=$remark";
              $curl = curl_init(); 
              curl_setopt($curl, CURLOPT_POST, 2); 
              curl_setopt($curl, CURLOPT_URL, $url); 
              curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($myData)); 
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($curl, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json; curlarset=utf-8',
              'Content-Length: ' . strlen(json_encode($myData))
              ));
              $html = curl_exec($curl); 
              $res = json_decode($html);
              curl_close($curl); 
          }
      } else if ($type == 'start' && $userName == '李佳荷' && !empty($beginUrl)) {
          $myData["approvalId"] = $processInstanceId;
          
          $url = "http://prebin.zhushang.net/zhu_pro_lq/public/index.php/api/approvalBeginInfo?approvalId=$processInstanceId&approvalDetails=".json_encode($details)."&settleOrder=$settleNo";
          $curl = curl_init(); 
          curl_setopt($curl, CURLOPT_POST, 1); 
          curl_setopt($curl, CURLOPT_URL, $url); 
          curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($myData)); 
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json; curlarset=utf-8',
          'Content-Length: ' . strlen(json_encode($myData))
          ));
          $html = curl_exec($curl); 
          $res = json_decode($html);
          curl_close($curl); 
      } else if ($type == 'finish' && !empty($beginUrl)) {
          // 说明正常结束了
          
      }

  }
 

  // 注册回调
  public function registDing() {
      $access_token = $this->getToken();
      
      $url = "https://oapi.dingtalk.com/call_back/register_call_back?access_token="."56aa5b067da934dbb1b9d26adb00efab";
      $data["call_back_tag"] = ["bpms_task_change", "bpms_instance_change"];
      
      $data["token"] = "zhangbin";
      $data["aes_key"] = "jingningzhushangkejigufenyouxiangongsi20299";
      //$data["url"] = "https://get.zhushang.net/zhu_pro/public/index.php/dingCallback"; 兰强 20200928
      $data["url"] = "https://get.zhushang.net/zhu_pro/public/index.php/api/dingCallback";
      
    
      $curl = curl_init(); 
      curl_setopt($curl, CURLOPT_POST, 1); 
      curl_setopt($curl, CURLOPT_URL, $url); 
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data)); 
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json; curlarset=utf-8',
      'Content-Length: ' . strlen(json_encode($data))
      ));
      $html = curl_exec($curl); 
      $res = json_decode($html);
      curl_close($curl); 
      return json($res);
  }
  
  // 获取审批详情
  public function getExamineDetails($process_instance_id='') {
      $access_token = $this->getToken();;
      $url = "https://oapi.dingtalk.com/topapi/processinstance/get?access_token=".$access_token;
      $data["process_instance_id"] = $process_instance_id;
      $curl = curl_init(); 
      curl_setopt($curl, CURLOPT_POST, 1); 
      curl_setopt($curl, CURLOPT_URL, $url); 
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data)); 
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json; curlarset=utf-8',
      'Content-Length: ' . strlen(json_encode($data))
      ));
      $html = curl_exec($curl); 
      $res = json_decode($html);
      curl_close($curl); 
      return $res;
  }
  
  // 根据用户id获取姓名
  public function getUserDetails($userId) {
      $access_token = $this->getToken();
      $url = "https://oapi.dingtalk.com/user/get?access_token=".$access_token."&userid=".$userId;
      $html = file_get_contents($url);
      $html = json_decode($html);
      return $html->name;
  }
}
