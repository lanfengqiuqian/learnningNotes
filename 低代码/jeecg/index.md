<!--
 * @Date: 2022-02-18 16:44:32
 * @LastEditors: Lq
 * @LastEditTime: 2022-06-20 15:15:12
 * @FilePath: \learnningNotes\低代码\jeecg\index.md
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

| 参数                                                              | 参数key                                     |
| ----------------------------------------------------------------- | ------------------------------------------- |
| BPM 流程对应的表单KEY                                             | BPM_FORM_KEY                                |
| 业务数据对应ID                                                    | BPM_DATA_ID                                 |
| 自定义表单数据ID                                                  | BPM_DES_DATA_ID                             |
| 自定义表单编码                                                    | BPM_DES_FORM_CODE                           |
| BPM 节点对应的表单URL                                             | (全局)	BPM_FORM_CONTENT_URL                 |
| BPM 节点对应的表单URL                                             | (全局) - 移动端	BPM_FORM_CONTENT_URL_MOBILE |
| BPM 业务标题表达式                                                | (全局)	bpm_biz_title                        |
| BPM 节点对应的表单URL                                             | (全局) - 移动端	BPM_FORM_CONTENT_URL_MOBILE |
| BPM 流转状态                                                      | bpm_status                                  |
| BPM 业务表单类型 表单类型：1:Online表单,2:自定义表单,3:自定义开发 | BPM_FORM_TYPE                               |


## 手撸表单设计器自定义组件

### 定位代码

#### 方案

1. 找官方[文档](https://www.bookstack.cn/read/jeecg-boot-2.0/1a21fd12b73aad87.md)

    但是没有对应的配置文件路径，自己重新建也不生效

2. 根据页面找源码

    1. 表单设计器详情页面：`src\views\modules\online\desform\modules\DesignFormModal.vue`

    2. 具体内容是一个iframe页面，从后端请求的一个document，路径是`http://localhost:8080//desform/index/1495588639701442561?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2NDU0MzM3ODUsInVzZXJuYW1lIjoiYWl5b25nIn0.vLS86CgRhSJo_RNe6_upJMoGz4ZNFxdJVy1GZAohGNo&messageId=yq9m7lb9i5pui187&isTemplet=false`

    3. 对应的在maven仓库：`C:/Users/aiyong/.m2/repository/org/apache/commons/commons-jexfm/1.8.45/commons-jexfm-1.8.45.jar!/templates/desform/designForm.ftl`

    4. 这个html文件加载的组件库在：`C:/Users/aiyong/.m2/repository/org/apache/commons/commons-jexfm/1.8.45/commons-jexfm-1.8.45.jar!/static/desform/lib/jm-form/JmForm.umd.js`

3. 其他方案

    尝试过：官方博客、官方论坛、github提issue、qq交流群提问、百度、google都失败了

    后来了解到，商业版的只能通过售后技术支持一对一提问才行，不能在别的公共渠道获取支持

### 开始操作

1. 尝试直接在js文件中修改文案，测试是否真的是这个文件

2. 尝试修改一个【单行文本组件】，测试是否生效

3. 尝试自己写一个最简单的【hello】组件


### 配置项

1. 增加组件的地方

    【1349】函数：

        1. 【i】基础组件
        
        2. 【a】高级组件

        3. 【o】布局组件

        4. 【l】jeecg组件

2. 字段属性配置项

    【71d5】函数：搜索这一段代码，`b = Object(v.a)(g, function()`，注意需要压缩空格


### 期间遇到的难点

1. 如何修改jar包中的文件

    1. 使用winrar打开jar包（注意是打开，不是解压）

    2. 关闭idea

    3. 找到对应的文件，然后在其他编辑器中修改

    4. 切回winrar，会提示你确定修改吗，然后确定

    5. 重新打开idea，运行项目

2. 这个js文件是经过压缩之后的，可读性很差

    使用在线美化js代码工具：`https://beautifier.io/`

    注意：代码比较多，会比较卡顿

3. 完全找不到一些关键方法的定义

    比如一段代码，有一个关键函数`i`，在源码中找不到定义

    ```javascript
    // 变量定义部分
    var r = this,
    e = r.$createElement,
    i = r._self._c || e;

    // 使用部分
    [i("el-input", {
        model: {
            value: r.data.name,
            callback: function (e) {
                r.$set(r.data, "name", e)
            },
            expression: "data.name"
        }
    }), i("div", {
        staticStyle: {
            "text-align": "right"
        }
    }, [i("el-checkbox", {
        model: {
            value: r.data.hideTitle,
            callback: function (e) {
                r.$set(r.data, "hideTitle", e)
            },
            expression: "data.hideTitle"
        }
    }, [r._v("隐藏标题")])], 1)]
    ```

    还能一直套娃。。。


### 结果

由于考虑到扩展性未知，大概率不行，放弃了这个方向


### 直接更换一套新的ui库（form-create_designier)

笔记见`../form-create-designer/index.md`

### 表单设计器库对比：jeecg和form-making

#### 默认组件方面（只需要考虑jeecg增加的）

1. 级联选择器改为了省市级联动
2. 多了markdown组件
3. 多了分隔符组件
4. 多了卡片组件
5. 自定义组件：子表、用户组件、部门组件、表字典组件

#### 组件属性方面

1. 基本上来说，并没有为单个组件额外增加过配置
   1. 下拉框增加了字典取值


2. 所有组件统一增加了几个配置
    1. JS增强
    2. 绑定key
    3. 远程取值
    4. 权限控制

#### 表单属性方面

1. 和online表单绑定
2. 启用外部链接
3. 启用打印
4. 自定义接收url
5. 启用事务
6. js增强、外部js增强
7. css增强、外部css增强

#### 实现步骤

1. 获取到搭建的表单的json和option数据

2. 弄一个页面，将拿到数据渲染成页面

3. 跟后端联调()

4. 实现自定义组件

### 备忘录

1. online表单的功能测试页面：`src\views\modules\online\cgform\auto\OnlCgformAutoList.vue`

2. 字典标签使用数据库的数据作为下拉选项

    > <j-dict-select-tag class="modalOperational" v-model="modalInfo.content" placeholder="请选择运营人员" dictCode="sys_user,realname,realname,"/>

3. online报表解析问题

    1. sql解析里面末尾不能加`;`，因为在功能测试里面的时候会自动拼接其他语句，会报错

        虽然当时在编辑页面是可以正常解析的

    2. where条件里面的变量不要使用，先用写死的，然后解析完成了再加上去

    3. 使用会话变量会报错

        解决方案：同理，先去掉，然后sql解析，然后加上去

        如果需要出现在查询的字段中，那么需要在下面的字段列表中【动态报表配置明细】中增加这个字段即可，比如【序号】一般使用会话变量加上去的

4. 控制在jeecg的模态框里面的下拉选项的层级过低，导致隐藏在下面

    ```css
    .el-select-dropdown {
        z-index: 1000 !important;
    }

    .el-picker-panel.el-date-picker.el-popper {
        z-index: 1000 !important;
    }
    ```