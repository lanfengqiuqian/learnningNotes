<!--
 * @Date: 2021-06-12 18:31:22
 * @LastEditors: Lq
 * @LastEditTime: 2021-07-31 16:53:17
 * @FilePath: \learnningNotes\windows\index.md
-->
#### windows安装puppeteer
1. 更换国内Chromium源

    > set	PUPPETEER_DOWNLOAD_HOST=https://storage.googleapis.com.cnpmjs.org

2. 安装cnpm

    > npm install -g cnpm --registry=https://registry.npm.taobao.org

3. 安装puppeteer

    > cnpm i puppeteer

4. 在当前目录创建一个`index.js`文件，测试

    ```js

    const puppeteer = require('puppeteer');
    
    (async () => {
    const browser = await puppeteer.launch({headless: false})
    const page = await browser.newPage();
    await page.goto('https://baidu.com');
    await page.screenshot({path: 'example.png'});
    
    await browser.close();
    ```

    会自动打开一个无头浏览器，程序跑完之后会在当前目录生辰一张截图

5. 删除`nodemodules`

    > npm install -g rimraf    
    > cd xxx[include node_modules folder]  
    > rimraf node_modules  

#### 查看本机的内网和外网ip

1. 内网ip

    > win+R：cmd，然后输入ipconfig  
    > 其中ipv4的那个就是内网ip了

2. 外网ip

    > 百度输入：ip查询，就能够有了  
    > 或者直接打开地址栏：www.ip138.com


#### win10使用恶意软件删除工具

> https://jingyan.baidu.com/article/4ae03de351484e7efe9e6b2f.html