<!--
 * @Date: 2022-04-19 17:18:27
 * @LastEditors: Lq
 * @LastEditTime: 2022-07-01 11:16:29
 * @FilePath: \learnningNotes\wyn\index.md
-->
## 文档

1. [视频教程](https://help.grapecity.com.cn/pages/viewpage.action?pageId=67970905)

2. [5.0帮助文档](https://help.grapecity.com.cn/pages/viewpage.action?pageId=62062846)

3. [不同版本的文档目录](https://help.grapecity.com.cn/spacedirectory/view.action)

4. [npm集成的文档](https://wyn.grapecity.com/docs/dev-docs/Report-Viewer-API)



## 技巧或者小坑

1. 使用npm安装的方式除了文档中说的下载压缩包再使用npm安装之外，也可以直接使用npm进行安装

    > npm install @grapecity/wyn-integration --save   
    > yarn add @grapecity/wyn-integration

2. 对于npm安装之后的引用文档中没有过多的介绍，在`node_modules`的`readme.md`中反而多一些，并且还有一个react版本的demo

3. 修改系统配置里面的【允许跨域资源共享的地址】这个地方有一定的时效性，大概半分钟左右

4. 修改预览的宽度满屏

    全局的属性设置 => 预览报表 => 大小自适应 => 符合宽度

5. 预览去除顶部的分页缩放等工具栏

    在保存的时候工具栏设置取消所有勾选，但是最后在页面上还会有一个【参数】的按钮

6. 创建的报表，生成的表格自带分页，一页只显示一条数据

    原因是：创建报表的时候需要选择【空白RDL报表】，不能选择【空白页面报表】

7. 使用npm集成的方式，除了配置跨域之外，还需要配置请求头（大概有半分钟的时效性）

    如：

    > 认证服务地址：http://localhost:51980  
    > 允许跨域资源共享的地址: http://localhost:3000  
    > 允许跨域的请求头（注意这里不能有空的空格和换行符）
    > location
    > content-disposition

8. 隐藏默认的查询面板

    在工作台把所有的参数组件进行隐藏之后，页面还是会有一个空行的展示，只能通过css的方式进行隐藏

    ```css
    <style scoped>
    #wyn-root>>>.gcv-header-container{
        display: none;
    }
    </style>
    ```

9. 关于并发数，文档参考（https://help.grapecity.com.cn/pages/viewpage.action?pageId=62087635）

    试用版本只有一个并发数，所以很容易超出并发限制

    我项目中遇到一个情况：就是在一个页面中能够正常加载进来，但是另外一个页面就是死活不行，但是控制台和其他地方都没有报错，最后发现是超出并发数量了

    超出了怎么办？

    因为超出了并发的话，后台系统也是登录不上去的（即使是admin）

    方案一：直接使用并发管理的地址，输入admin后能够进去，然后关闭多余的并发。注意：此方法不适合试用版，因为就只有一个并发，断开连接之后就登录不上了

    方案二：重启wyn服务，在系统的服务里面找到【Wynservice】，然后重启这个服务。如windows打开任务管理器 => 服务 => Wynservice重启

10. linux服务器安装

    > https://help.grapecity.com.cn/pages/viewpage.action?pageId=62063250

    1. 缺失dotnet的sdk

        在执行了安装脚本之后，开始会安装dotnet的运行时环境和sdk，我这边sdk安装失败了，后面的步骤都是正常的，不仔细看日志还是没有发现这一点的

        那么自己重新进行手动安装，两种方案

        1. 直接执行`yum`安装命令



11. 安装目录在`/opt/wyn`

12. 记得需要销毁wyn组件，否则页面会越来越卡顿

    ```js
      try {
        // 销毁wyn组件
        this.reportViewer.destroy();
      } catch (e) {
        // 这里如果之前没有数据创建dom节点失败会报错
        console.log("销毁wyn失败，这里是正常的情况", e);
      }
    ```

    比如以下场景

    1. 页面销毁的时候

    2. 每次都需要重新创建一个新的wyn组件，但是之前的不需要使用的情况下

13. 一个页面使用多个wyn组件（我的是vue项目）

    1. 一个文件中直接嵌入2个wyn组件，需要注意`div`的`id`不要重复

        ```html
        <div id="wyn-root"></div>
        <h2>++++++++++++++++++++++++++++++++++++++++++++</h2>
        <div id="wyn-root-pro"></div>

        WynIntegration.createReportViewer(
            {
            baseUrl: "xxx",
            reportId: "xxx",
            token: "xxx",
            reportParameters: reportParameters,
            disableFocusTimer: true,
            hideSearch: true,
            hideToolbar: true,
            },
            "#wyn-root"
        ).then((ins) => {
            this.reportViewer = ins;
            // 这里设置1.5s后模拟的loading消失
        });
        WynIntegration.createReportViewer(
            {
            baseUrl: "xxx",
            reportId: "xxx",
            token: "xxx",
            reportParameters: reportParameters,
            disableFocusTimer: true,
            hideSearch: true,
            hideToolbar: true,
            },
            "#wyn-root-pro"
        ).then((ins) => {
            this.reportViewer = ins;
            // 这里设置1.5s后模拟的loading消失
        });
        ```

        1. 不行，只会生效一个

        2. 换成多个文件各使用一个然后引用到同一个文件中也是不行的

14. 目前已知有一个bug

    就是如果复制一个报表的话，里面的图如果是折线图，里面的图表需要重新拉一个，然后重新拉字段，然后再选择图表类型为折线图