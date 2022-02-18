<!--
 * @Date: 2022-02-18 16:44:32
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-18 17:41:14
 * @FilePath: \learnningNotes\jeecg\index.md
-->
### 起步资料

产品官网：

[www.jeecg.com](http://www.jeecg.com/)

产品介绍：

[http://www.jeecg.com/vip](http://www.jeecg.com/vip)

开源版本：

[https://github.com/zhangdaiscott/jeecg-boot](https://github.com/zhangdaiscott/jeecg-boot)

产品演示：

[http://boot.jeecg.com](http://boot.jeecg.com/)

PPT链接：

[https://pan.baidu.com/s/130wAOi7oop-ei_qDJDW9LA](https://pan.baidu.com/s/130wAOi7oop-ei_qDJDW9LA)

提取码：hnst

演示视频：

[https://www.bilibili.com/video/BV1Nk4y1o7Qc](https://www.bilibili.com/video/BV1Nk4y1o7Qc)

商业版本文档

[https://www.kancloud.cn/zhangdaiscott/jeecgboot_business?token=JeM4FdrAQJ](https://www.kancloud.cn/zhangdaiscott/jeecgboot_business?token=JeM4FdrAQJ)


### 流程设计相关小技巧

#### 网关

1. 介绍：就是流程分支条件判断

2. 分类

    1. 同步网关：会同时开始多个任务，不需要写条件，写了也无效

        注意：如果是需要同步开始多个，然后多个执行完了之后汇总到一个节点，那么还需要使用同步网关进行收口

    2. 分支网关：有且只会有两条分支，执行必须且只会执行其中的一条
    
        注意：建议判断条件只写一个，另一个自动判断

    3. 包含网关：也称为万能网关，因为可以用这个写出任何网关效果来

        关键点：每一个分支的判断条件需要写好

        建议：开口之后，如果是有需要的话，最好也要收口

#### 脚本任务

1. 介绍：和任务节点同级，可以在上面执行JavaScript脚本

2. 案例

    1. 常用与存取流程变量

    2. 删除流程变量

#### 服务节点

1. 介绍：和任务节点同级，不需要任何人审批，但是可以执行一些业务逻辑代码

2. 案例

    1. 某一个节点完成之后，执行一个方法，写业务逻辑

####  自定义流程表达式

1. 介绍：后端写的类似接口的函数，在【流程设计-流程表达式】中添加后，能够在流程中直接进行调用

2. 使用案例

    1. 作为任务的办理人：注意这里的话接口输出的是系统用户的账号，而不是id

    2. 作为流程网关的判断条件

    3. 获取会签的人员：返回的是用户账号数组

#### 主子流程设计

1. 介绍：当一个流程中需要将接入另外一个流程的时候，可以使用子流程接入

2. 注意：主流程和子流程的流程变量不是共享的，需要使用传入和传出参数的方式来获取才行

#### 会签

1. 介绍：某一个流程任务节点需要多个人进行审批的情况

2. 并行审批和顺序审批

    并行：会同时发给多个人  
    顺序：第一个人审批完了才会发给下一个人

3. 手工选择下一步会签人：如果填写的流程表达式无法解析出用户id的话，会提示在流程审批的时候需要手动指定下一步会签人员，元素名和人员配置的人是同一个名称即可

4. 元素名：遍历会签人员输出的单个账号名，可将改账号名用于任务处理人


#### 流程监听

1. 介绍：用于流程或节点发起、流转、结束的时候，做一些什么事情

2. 案例：

    1. 存自定义的流程变量

    2. 手动指定下一个任务审批

    3. 判断是否直接结束流程

    4. 做一些业务的数据操作

#### 流程变量


1. 常用的流程变量

|参数 |	参数key | 
| -|-|
|BPM 流程对应的表单KEY |	BPM_FORM_KEY |
|业务数据对应ID |	BPM_DATA_ID | 
|自定义表单数据ID |	BPM_DES_DATA_ID | 
|自定义表单编码 |	BPM_DES_FORM_CODE | 
|BPM 节点对应的表单URL |(全局)	BPM_FORM_CONTENT_URL |
|BPM 节点对应的表单URL |(全局) - 移动端	BPM_FORM_CONTENT_URL_MOBILE |
|BPM 业务标题表达式 |(全局)	bpm_biz_title |
|BPM 节点对应的表单URL |(全局) - 移动端	BPM_FORM_CONTENT_URL_MOBILE |
|BPM 流转状态 |	bpm_status |
|BPM 业务表单类型 表单类型：1:Online表单,2:自定义表单,3:自定义开发 |BPM_FORM_TYPE|