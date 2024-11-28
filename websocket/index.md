### 介绍

1. 是HTML5中的协议，本质上是基于TCP的协议
2. 支持`持久`连接
3. 给web端提供了和服务端之间的长连接
4. 使得在建立连接的任何时候服务端都可以`主动`通知web端

其他特点

1. 与HTTP协议有着良好的兼容性。默认端口也是80和443，并且握手阶段采用http协议，因此握手时不容易屏蔽，能通过各种http代理服务器
2. 数据格式比较轻量，性能开销小，通信高效
3. 可以发送文本，也可以发送二进制数据
4. 没有同源限制，客户端可以与任意服务器通信
5. 协议标识符是`ws`，如果加密则为`wss`

### 以前模拟的持久化的方式

1. ajax轮询：每隔几秒就发送一次请求，询问服务端是否有新信息
2. 长连接（long poll）：原理和轮询差不多，不过采取的是`阻塞模型`（一直打电话，没收到就不挂电话）

    客户端发起请求之后，如果没消息，就一直不返回`Response`给客户端。知道有消息才返回，返回完之后，客户端再次建立连接

缺点：`被动性`，非常消耗资源

### 过程

    1. 客户端发起http请求，经过3次握手，建立TCP链接
    2. http请求里面存放websocket支持的版本号的等信息
    3. 服务器接收到客户端的握手请求后，同样采用http协议回馈数据
    4. 客户端收到连接成功的消息后，开始接触TCP传输系信息进行双全工通信

7. websocket解决的问题

    1. http是一种无状态协议，每当一次会话完成后，服务端都不知道下一次的客户端是谁，需要每次知道对方是谁，才会进行相应的响应，因此，本身对于实时通讯就是一种极大的障碍
    2. http协议采用一次请求，一次响应，每次请求和响应都携带有大量的header头，对于实时通讯来说，解析请求头也是需要一定的时间，因此，效率也更低下
    3. 最重要的是，需要客户端主动发，服务端被动发，不能实现主动发送


### WebSocket与Http的关系

1. 相同点

  1. 都是基于tcp的、可靠性的传输协议
  2. 都是应用层协议

2. 不同点

  1. 协议不同，websocket是双向通信协议，模拟socket协议，可以双向发送或者接收信息，而http是单向的
  2. websocket是需要浏览器和服务器握手进行建立连接的，而http是浏览器向服务器的连接，服务器预先并不知道这个连接
  3. websocket只是在握手阶段使用了http


### 典型的WebSocket报文

#### 请求报文

```shell
GET /chat/HTTP/1.1
Host: server.example.com
Upgrade: websocket
Sec-WebSocket-Key: x3JJHMbDL1EzLkh9GBhXDw==
Sec-WebSocket-Protocol: chat, superchat
Sec-WebSocket-Version: 13
Origin: http://example.com
```

这段类似`HTPP`协议的握手请求中，实际多了这么几个东西

```shell
Upgrade: websocket
Sec-WebSocket-Key: x3JJHMbDL1EzLkh9GBhXDw==
Sec-WebSocket-Protocol: chat, superchat
Sec-WebSocket-Version: 13
```

其中，下面这部分是`WebSocket`的和新，相当于告诉Apache、Nginx等服务器：我发起的请求要用WebSocket协议

```shell
Upgrade: websocket
Connection: Upgrade
```

1. Sec-WebSocket-Key是一个`base64 encode`的值，这个是浏览器随机生成的，作用是验证服务器的身份
2. Sec-WebSocket-Protocol是一个用户定义的字符串，用来区分同一个URL下，不同服务所需要的协议
3. Sec-WebSocket-Version是告诉服务器所使用的协议版本，现在基本上都是`13`的版本

```shell
Sec-WebSocket-Key: x3JJHMbDL1EzLkh9GBhXDw==
Sec-WebSocket-Protocol: chat, superchat
Sec-WebSocket-Version: 13
```

#### 响应报文

服务器会返回下列保温，表示已经收到请求，成功建立WebSocket

```shell
HTTP/1.1 101 Switching Protocols
Upgrade: websocket
Connection: Upgrade
Sec-WebSocket-Accept: HSmrc0sMlYUkAGmm5OPpG2HaGWk=
Sec-WebSocket-Protocol: chat
```

其中，这段就是最后负责的区域了，告诉客户端我即将升级的是WebSocket协议

```shell
Sec-WebSocket-Accept: HSmrc0sMlYUkAGmm5OPpG2HaGWk=
Sec-WebSocket-Protocol: chat
```

Sec-WebSocket-Accept是经过服务器确认，并且加密过后的Sec-WebSocket-Key

Sec-WebSocket-Protocol则是表示最终使用的协议

### 问题

#### 浏览器如何自定义请求头

<https://juejin.cn/post/7405152755819233331>

结论：浏览器中WebSocket不支持自定义请求头

#### 参数一般放在哪

1. 拼接在url中
2. 在WebSocket进行握手的http阶段进行添加请求头

    ```js
    const socket = new WebSocket('wss://example.com/socket');

    socket.addEventListener('open', (event) => {
        socket.send('Authorization: Bearer ' + YOUR_TOKEN);
    });
    ```