<!--
 * @Date: 2022-06-27 15:05:14
 * @LastEditors: Lq
 * @LastEditTime: 2022-07-06 17:53:58
 * @FilePath: \learnningNotes\接入邮箱\java接入收发邮件\index.md
-->
## 参考文章

1. [基于JavaMail的Java邮件发送：简单邮件发送](https://blog.csdn.net/xietansheng/article/details/51673073)

2. [基于JavaMail的Java邮件发送：复杂邮件发送](https://blog.csdn.net/xietansheng/article/details/51722660)

3. [用java读取邮箱邮件](https://www.csdn.net/tags/OtDaYgzsNjQwMzItYmxvZwO0O0OO0O0O.html)


## 补充说明

1. iphone手机绑定qq邮箱及开启SMTP服务验证

    见：`../../一些软件小技巧/软件小技巧.md`

2. qq邮箱的SMTP服务器

　  QQ邮箱 POP3 和 SMTP 服务器地址设置如下：

　　邮箱：qq.com    

　　POP3服务器（端口995）：pop.qq.com  

　　SMTP服务器（端口465或587）：  smtp.qq.com    

    附：[常用邮箱的服务器(SMTP/POP3)地址和端口总结](https://www.likecs.com/show-160503.html)

3. 报错：Couldn't connect to host, port: smtp.gmail.com, 25; timeout -1

    示例中的代码开启的端口为`465`，用于`qq邮箱`，如果是其他的邮箱需要对应的修改一下

    如`gmail`为：587

    这里有一个大坑：就是我本地是使用`465`才成功的，使用`587`一直连接不上（再来一个参考意见，使用`25`也可以试试，不过我没连上）

4. 在本地测试无任何问题，但是上传到阿里云服务器(Centos 7)上就报错

    报错：`Couldn't connect to host, port: smtp.163.com, 25; timeout -1;`

    原因：`阿里云出于安全考虑默认禁用25端口导致发邮件失败`

    解决：参考[https://blog.csdn.net/qq_38680405/article/details/123919728](https://blog.csdn.net/qq_38680405/article/details/123919728)

5. 使用google邮箱的时候，更改端口之后还是连接不上

    1. 端口使用`465`，而不是`587`（被注释掉的一段代码）

    2. 额外增加一个属性设置（这个我并没有用到，不过看到有这么写的，作为参考）

        > props.setProperty("mail.smtp.socketFactory.auth", "true");

    ```java
    final String smtpPort = "465";
    props.setProperty("mail.smtp.port", smtpPort);
    props.setProperty("mail.smtp.socketFactory.class", "javax.net.ssl.SSLSocketFactory");
    props.setProperty("mail.smtp.socketFactory.fallback", "false");
    props.setProperty("mail.smtp.socketFactory.auth", "true");
    props.setProperty("mail.smtp.socketFactory.port", smtpPort);
    ```

6. 记录一下，我在使用google邮箱向163邮箱发送邮件的时候有延迟

    第一次延迟大概5分钟，第二次延迟大概4分钟

    表现如下

        1. 接口调用成功，这里设置的是立刻发送
        2. 在手机和网页版邮箱刷新都没有新邮件
        3. 过了几分钟，能收到新邮件通知了
        4. 并且收件箱上面显示的发件时间是几分钟之前

    但是换成qq邮箱给qq邮箱发送的时候就没有延迟了，其他的情况未测试

7. 简单发送文本的content也是可以支持html标签的，所以如果你能够把页面上面的富文本转化为html标签的话，也是可以支持的

    如，我这边有一个富文本组件，输出出来的结果就是`<p></p>`包裹的其他标签

    ```
    "<p>123412</p><p>sdfas</p><p>asdfas2341</p><p><s>sdfax</s></p><p><em>cvzx</em></p><p><strong>cvx</strong></p><p><br></p>"
    ```

    把这个作为content传递给接口是可以发送的

    然后接下来测试了图片，包含大图片（5.88MB），输出出来的长度大概为8百多万的字符串，也是可以发送的，但是就比较慢了

      1. 接口很慢，但是可以成功（8.48秒）
      2. 网页版qq邮箱查看收件箱也很慢（3-4秒吧）
      3.  进入了收件箱之后显示图片也很慢（也大概3-4秒）


    ```html
    <p>123412</p>
    <p>sdfas</p>
    <p><a href=\"http://baidu.com\" rel=\"noopener noreferrer\" target=\"_blank\">asdfas2341</a></p>
    <p><s>sdfax</s></p>
    <p><em>cvzx</em></p>
    <p><strong>cvx</strong></p>
    <pre class=\"ql-syntax\" spellcheck=\"false\">hello world\nfasdfsa\n</pre>
    <p>2342sfsdsf</p>
    <p><img src=\"data:image/jpeg;base64,xxx" /></p>
    ```

8. 对于复杂邮件中的路径说明

    ```java
        MimeBodyPart image = new MimeBodyPart();
        DataHandler dh = new DataHandler(new FileDataSource("./tmp/xxx.jpeg")); // 读取本地文件
        image.setDataHandler(dh);		            // 将图片数据添加到“节点”
        image.setContentID("image_fairy_tail");	    // 为“节点”设置一个唯一编号（在文本“节点”将引用该ID）
    ```

    其中这里的路径是相对于项目的根目录的，博客中的没有加相对路径，就是指在根目录下面，如果不是在根目录可以加上相对路径

10. 读取邮件的地方有一个路径需要改动一下

    > saveAttachment(msg, "c:\\mailtmp\\"+msg.getSubject() + "_"); //保存附件

    这个地方如果你的电脑没有路径`c:\\mailtmp`的话会报错，需要改一下

11. 读取的数量不对

    一般来说，邮箱默认设置的是收取最近30天的邮件，如果需要读取全部的，需要在设置里面修改（不是代码限制的）