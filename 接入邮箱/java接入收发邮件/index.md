<!--
 * @Date: 2022-06-27 15:05:14
 * @LastEditors: Lq
 * @LastEditTime: 2022-06-27 18:34:51
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