<!--
 * @Date: 2021-06-17 20:45:23
 * @LastEditors: Lq
 * @LastEditTime: 2021-06-17 20:47:44
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