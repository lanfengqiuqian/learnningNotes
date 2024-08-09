[toc]

## 文档

<https://doc.dcloud.net.cn/uniCloud/>

## 知识点

### 云对象 url 化之后，如何判断是 uniapp 中通过对象实例调用，还是使用 http 请求进行调用的

通过`this.getHttpInfo()`

1. 如果是 http 调用，返回是一个对象

   ```js
   {
       path: '/add',
       httpMethod: 'POST',
       headers: {
           'content-length': '42',
           cookie: 'aliyungf_tc=93b34806b748e262b1e5435333cbc31df9ffeae29c81210d3e4841ea66f060a7; acw_tc=ac11000117230969356601186ed5882f2b6c460907b51a322bc4cbff08021d',
           'x5-uuid': 'ae953551fcbe32875bf47880013101e1',
           'x-client-ip': '222.70.4.242',
           'x-forwarded-for': '222.70.4.242, 120.27.173.104, 39.96.130.154',
           accept: '*/*',
           'x-real-ip': '222.70.4.242',
           'x-sinfo': 'on',
           host: 'fc-mp-dac08bb9-18fc-409f-b327-6964ab132d81.next.bspapp.com',
           'content-type': 'text/plain',
           'x-forwarded-by': '172.28.211.109:80',
           'accept-encoding': 'gzip, deflate, br',
           'user-agent': 'Apifox/1.0.0 (https://apifox.com)'
       },
       queryStringParameters: { content: '111', title: '222' },
       isBase64Encoded: false,
       body: '{\r\n    "title": "",\r\n    "content": "",\r\n}'
       }
   ```

   详细见<https://doc.dcloud.net.cn/uniCloud/cloud-obj.html#get-http-info>

2. 如果是 uniapp 中通过对象实例调用，返回的是`undefined`

## 问题
