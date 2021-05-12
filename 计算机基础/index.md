<!--
 * @Date: 2021-05-10 18:01:26
 * @LastEditors: Lq
 * @LastEditTime: 2021-05-12 19:04:05
 * @FilePath: /learnningNotes/计算机基础/index.md
-->
#### MIME
 1. 定义：一种媒体类型（Multipurpose Internet Mail Extensions），是一种标准，用来表示文档、文件或者字节流的性质和格式。也就是告诉浏览器这个文件的类型，目的和文案扩展名类似，但是更加的具体和重要。

     `说明：`浏览器通常使用MIME类型来去定如何处理URL（network总的请求和资源），因此Web服务器在响应头添加正确的MIME类型非常重要。如果配置不正确，浏览器可能会曲解文件内容，网站将无法正常工作，并且下载的文件也会被错误处理。

 2. 语法（构造方式）

     语法：`type/subtype`（大类型/小类型）
     结构：非常简单，有类型和子类型2个字符串中间使用`/`分隔组成。对于大小写不敏感，但是传统写法都是小写。

 3. 大类别

     |类型|描述|示例|
     |-|-|-|
     |text|普通文本，人类可读|text/plain,text/html,text/javascript|
     |image|图像，不包括视频，但是动态图（比如gif）也是用image类型|image/gif,image/jpeg|
     |audio|音频|audio/midi,audio/mpeg|
     |video|视频|video/webm,video/ogg|
     |application|二进制数据|application/octet-stream,application/pkcs12|
     |multipart|复合文件类型|multipart/byteranges|

 4. 重要的MIME类型

     1. application/octet-stream

         应用程序文件的默认值，意思是“未知的应用程序文件”，浏览器一般不会自动执行或询问执行。浏览器会像对待设置了HTTP头“Content-Disposition”值为“attachment”的文件一样来对待这类文件。

     2. text/plain

         文本文件的默认值。即使他意味着位置的文本文件，但是浏览器也是认为可以直接展示的。

     3. text/css

         在网页中要被解析为CSS的任何CSS文件必须指定MIME为text/css。通常，服务器不识别以`.css`为后缀的文件的MIME类型，而是将其以MIME为`text/plain`或`application/octet-stream`来发送给浏览器：在这种情况下，大多数浏览器不识别为CSS文件，直接忽略掉。所以必须要为CSS文件提供正确的MIME类型。

     4. text/html

         所有的html内容都应该使用这种类型。XHTML的其他MIME类型（如application/xml+html）现在基本不再使用

     5. javascript type

         application/javascript  
         application/ecmascript

     6. 图片类型

         只有一小部分的图片类型是被管饭支持的，web安全的，可随时在web页面中使用的

         1. image/gif GIF图片（无损压缩方面被PNG替代）
         2. image/jpeg JPEG图片
         3. image/png PNG图片
         4. image/svg+xml SVG图片（矢量图）

     7. multipart/form-data（重要）

         此类型可用于html表单从浏览器发送信息给服务器。作为多部分文档格式，它由边界线（一个由`-`字符开始的字符串）划分出不同部分组成。每一部分有自己的实体，以及自己的HTTP请求头、Content-Disposition和Content-Type用于文件上传领域。

         如下所示的表单

         ```html
         <form action="http://localhost:8000/" method="post" enctype="multipart/form-data">
             <input type="text" name="myTextField">
             <input type="checkbox" name="myCheckBox">Check</input>
             <input type="file" name="myFile">
             <button>Send the file</button>
         </form>
         ```

         会发送下面的代码

         ```
         POST / HTTP/1.1
         Host: localhost:8000
         User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:50.0) Gecko/20100101 Firefox/50.0
         Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
         Accept-Language: en-US,en;q=0.5
         Accept-Encoding: gzip, deflate
         Connection: keep-alive
         Upgrade-Insecure-Requests: 1
         Content-Type: multipart/form-data; boundary=---------------------------8721656041911415653955004498
         Content-Length: 465

         -----------------------------8721656041911415653955004498
         Content-Disposition: form-data; name="myTextField"

         Test
         -----------------------------8721656041911415653955004498
         Content-Disposition: form-data; name="myCheckBox"

         on
         -----------------------------8721656041911415653955004498
         Content-Disposition: form-data; name="myFile"; filename="test.txt"
         Content-Type: text/plain

         Simple file.
         -----------------------------8721656041911415653955004498--
         ```

    8. multipart/byteranges

         此类型用于把部分的响应报文发送回浏览器。当发送状态码206的时候，之处这个文件由若干部分组成，每一个都有其请求范围。就像很多其他的类型Content-Type使用分隔符来制定分界线，每一个不同的部分都有Content-Type这样的HTTP头来说明文件的时机类型，以及Content-Range来说明其范围。

         ```
         HTTP/1.1 206 Partial Content
         Accept-Ranges: bytes
         Content-Type: multipart/byteranges; boundary=3d6b6a416f9b5
         Content-Length: 385

         --3d6b6a416f9b5
         Content-Type: text/html
         Content-Range: bytes 100-200/1270

         eta http-equiv="Content-type" content="text/html; charset=utf-8" />
             <meta name="vieport" content
         --3d6b6a416f9b5
         Content-Type: text/html
         Content-Range: bytes 300-400/1270

         -color: #f0f0f2;
                 margin: 0;
                 padding: 0;
                 font-family: "Open Sans", "Helvetica
         --3d6b6a416f9b5--

         ```

*******************

#### HTTP报头

1. HTTP协议工作流程

    1. 建立连接：客户机和服务器建立连接。单击一个超链接，HTTP协议开始工作。
    2. 发送请求：建立连接之后，客户机发送一个请求给服务器。格式为`统一资源标识符URL+协议版本号+MIME信息（包括请求修饰符、客户机信息和可能的内容）`。
    3. 响应：服务器接收到请求之后返回响应信息。格式为`状态行（包括信息的协议版本号，状态码）+MIME信息（包括服务器信息、实体信息和可能的内容）`。
    4. 断开连接

2. 报头

    HTTP消息报头包括普通包头、请求报头、响应报头、实体报头。报头域的组成形式如下  
    > 报头头属性名: 报头属性值

    如下所示

    ```
    // 公共头部
    Request URL: xxxx
    Request Method: GET
    Status Code: 200 
    Remote Address: 180.163.151.166:443
    Referrer Policy: origin-when-cross-origin

    // 响应报头
    access-control-allow-origin: *
    alt-svc: h3-29=":443"; ma=2592000,h3-T051=":443"; ma=2592000,h3-Q050=":443"; ma=2592000,h3-Q046=":443"; ma=2592000,h3-Q043=":443"; ma=2592000,quic=":443"; ma=2592000; v="46,43"
    cache-control: private
    content-length: 0
    content-type: image/gif
    cross-origin-resource-policy: cross-origin
    date: Mon, 10 May 2021 10:10:34 GMT
    expires: Mon, 10 May 2021 10:10:34 GMT
    p3p: policyref="https://googleads.g.doubleclick.net/pagead/gcn_p3p_.xml", CP="CURa ADMa DEVa TAIo PSAo PSDo OUR IND UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"
    server: cafe
    set-cookie: test_cookie=CheckForPermission; expires=Mon, 10-May-2021 10:25:34 GMT; path=/; domain=.doubleclick.net; Secure; HttpOnly; SameSite=none
    timing-allow-origin: *
    x-content-type-options: nosniff
    x-xss-protection: 0

    // 请求报头
    :authority: securepubads.g.doubleclick.net
    :method: GET
    :path: /pcs/view?xai=AKAOjsu9P_VsKDYyyVl3nltL_dhfY79x9K1qWfLqej5kf64EasipjWri1sz-gXxlyXkSLouK1SB8NnzpRU2hZyVjWeKUC-HLYQi_I38LUNLy51MuYrYzHVX39eRoYfiTU7ylJu32IqQ2_78_mNiJJjbLM9XBRZ86J5p2YDnpMsV8jfWQysOrOYtC-vLsCK93qhBpIFUsE3xKLtSe1FpzCb6PN2Y09FpUzwKGu_NKHPM98Il_t-PyQ2VKfb4oB4SnUCtbgga5UJzEWv_EeBWnS1u69P4k&sig=Cg0ArKJSzFH1OtDYWZvsEAE&adurl=
    :scheme: https
    accept: */*
    accept-encoding: gzip, deflate, br
    accept-language: zh-CN,zh;q=0.9
    cache-control: no-cache
    pragma: no-cache
    referer: https://www.cnblogs.com/
    sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="90", "Google Chrome";v="90"
    sec-ch-ua-mobile: ?0
    sec-fetch-dest: empty
    sec-fetch-mode: no-cors
    sec-fetch-site: cross-site
    user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36
    ```

    下面介绍一下常见的报头属性

    1. 公共头部

        |字段|说明|
        |-|-|
        |Remote Address|请求的远程地址|
        |Request URL|请求的域名|
        |Request Method|请求的方式：GET/POST|

    2. 请求头

        |字段|说明|
        |-|-|
        |Accept|表示浏览器支持的MIME类型|
        |Accept-Encoding|浏览器支持的压缩类型|
        |Accept-Language|浏览器支持的语言类型，优先支持靠前的类型|
        |Cache-Control|指定请求和响应应该遵循的缓存机制|
        |Connection|浏览器与服务器进行长连接通信的时候对于长连接如何进行处理：close/keep-alive|
        |Cookie|向服务器发送的cookie，这些cookie是之前服务器发送给浏览器的|
        |Host|请求的服务器URL|
        |Referer|该页面的来源URL|
        |User-Agent|用户客户端的一些必要信息|

    3. 响应头

        |字段|说明|
        |-|-|
        |Cache-Control|告诉浏览器或者其他客户，什么环境可以安全的缓存文档|
        |Connection|当客户端和服务器通信的时候对于长连接如何进行处理|
        |Content-Encoding|数据在传输过程中使用的压缩编码方式|
        |Content-Type|数据的类型|
        |Date|数据从服务器发送的时间|
        |Expires|应该在什么时候认为文档已过期，从而不再缓存他|
        |Server|服务器名字，servlet一般不设置这个值，而是由Web服务器自己设置|
        |Set-Cookie|设置和页面关联的cookie|
        |Transfer-Encoding|数据传输的方式|

    4. 自定义报头

        在HTTP消息中，也可以使用一些在HTTP1.1正式规范中没有定义的头字段，这些投资端统称为自定义的HTTP头或扩展头。

    5. 对于一些报头的说明

        1. Accept

            > 示例  
            > Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,\*/\*;q=0.8

            表示浏览器支持的MIME类型分别是text/html、application/xhtml+xml、application/xml和*/*，优先顺序从前往后

        2. Cache-Control

            指定请求和响应应该遵循的缓存机制。在请求消息或者响应消息总设置Cache-Control并不会影响另一个消息处理过程中的缓存处理过程。  
            请求时的缓存指令：no-cache，no-store，max-stale，min-fresh，only-if-cached。  
            响应时的指令：public，private，no-cache，no-store，no-transform，must-revalidate，proxy-revalidate，max-age。  
            各个指令的含义：  
        　　Public：指示响应可被任何缓存区缓存。 
        　　Private：指示对于单个用户的整个或部分响应消息，不能被共享缓存处理。这允许服务器仅仅描述当前用户的部分响应消息，此响应消息对于其他用户的请求无效。   
        　　no-cache：指示请求或响应消息不能缓存。  
        　　no-store：用于防止重要的信息被无意的发布。在请求消息中发送将使得请求和响应消息都不使用缓存。   
        　　max-age：指示客户机可以接收生存期不大于指定时间（以秒为单位）的响应。   
        　　min-fresh：指示客户机可以接收响应时间小于当前时间加上指定时间的响应。   
        　　max-stale：指示客户机可以接收超出超时期间的响应消息。如果指定max-stale消息的值，那么客户机可以接收超出超时期指定值之内的响应消息。  

        3. User-Agent

            用户使用客户端的一些必要信息，比如操作系统、浏览器版本、浏览器渲染引擎等。