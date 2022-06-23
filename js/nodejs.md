<!--
 * @Date: 2021-06-17 20:45:23
 * @LastEditors: Lq
 * @LastEditTime: 2022-06-09 12:08:04
 * @FilePath: \learnningNotes\js\nodejs.md
-->
#### 递归创建文件夹，并将网络图片地址下载到本地创建的文件夹中
```js
// 递归创建目录
function mkdirs(dirname) {
    if (fs.existsSync(dirname)) {
        console.log('目录已存在')
    } else {
        fs.mkdir(dirname, { recursive: true }, (err) => {
            if (err) throw err;
        });
    }
}

// 将网络文件下载到本地目录中
async function downloadFileToDir(url, path, fileName) {
    let msg = "";
    try {
        mkdirs(path);
        await uploadData(url, path + fileName);
        msg = "存储文件成功";
    } catch (e) {
        msg = "存储文件失败";
        console.log('存储文件失败了', e);
    }
    return new Promise(resolve => {
        resolve(msg);
    })
}

// 调用方式
let openInvoiceName = '景宁筑商嘻嘻嘻商务服务工作室';
let time = '2021-04-12';
let invoiceCode = '0000';
let invoiceNo = '11111';
let url = 'http://zhushang-c-invoice.oss-cn-zhangjiakou.aliyuncs.com/hh/test.pdf';
await downloadFileToDir(url, `/Users/aiyong/Downloads/invoice/${openInvoiceName}`, `/${time}_${invoiceCode}_${invoiceNo}.pdf`)
```

### node升级

1. 查看当前node版本

    > node -v

2. 清除npm缓存

    > npm cache clean -f

3. n模块是专门用来管理nodejs的版本，安装n模块

    > npm install -g n

    这里可能会报错

    > Unsupported platform for n@8.2.0: wanted {"os":"!win32","arch":"any"} (current: {"os":"win32","arch":"x64"})

    解决方案：这其实主要是因为n模块不适配windows系统，所以虽然可以安装，但是还是需要相办法安装一个“linux”环境。在运行n 命令时提示使用wsl2

    > npm install -g n --force

    如果是windows可能是需要安装一个linux环境，参考这个：

4. 更新升级node版本

    ```shell
    n stable // 把当前系统的 Node 更新成最新的 “稳定版本”
    n lts // 长期支持版
    n latest // 最新版
    n 16.13.1 // 指定安装版本
    ```

5. 升级完成查看 node版本

    > node -v

6. 如果是需要频繁切换版本可以尝试这个：[https://blog.csdn.net/cnds123321/article/details/121257762](https://blog.csdn.net/cnds123321/article/details/121257762)

### node切换版本值nvm的安装

1. 下载： https://github.com/coreybutler/nvm-windows/releases

2. 安装一直下一步就行，会自动配置到环境变量中

3. 检查是否安装完成

    > nvm -v

    如果提示找不到命令，有可能是没有配置到环境变量中

    > NVM_HOME C:\Users\aiyong\AppData\Roaming\nvm  // 这个是nvm的安装目录   
    > NVM_SYMLINK C:\Program Files\nodejs   // 这个是nodejs的安装目录

4. 安装node其他版本

    > nvm install 12.22.12

    ```shell
    Downloading node.js version 12.22.12 (64-bit)...
    Complete
    Creating C:\Users\aiyong\AppData\Roaming\nvm\temp

    Downloading npm version 6.14.16... Complete
    Installing npm v6.14.16...

    Installation complete. If you want to use this version, type

    nvm use 12.22.12
    ```

5. 切换node版本

    > nvm use 12.22.12

    这里有可能出现乱码并且失败

    ```shell
    exit status 5: �ܾ����ʡ�

    exit status 1: ���ļ��Ѵ���ʱ���޷��������ļ���
    ```

    解决方案：使用管理员身份重新打开一个终端再执行命令即可即可

### Node Sass does not yet support your current environment: Windows 64-bit with

这种情况一般是node版本问题，可能过高了

### 全局安装模块和卸载

> npm install -g xxx   
> npm uninstall -g xxx   
> yarn global add xxx   
> yarn global remove xxx

### 全局安装的模块默认位置

用户目录下的`node_modules`
> C:\Users\aiyong\node_modules

### nodejs中js文件变量的引用

因为不能使用import和export，只能使用基础的require进行导入

```js
// 被引用文件 info.js
exports.info = {
    name: 'lan',
    age: 12
}
```

```js
// 引用文件
const { info: { name, age }} = require('./info.js');
console.log('name', name);
console.log('age', age);
```