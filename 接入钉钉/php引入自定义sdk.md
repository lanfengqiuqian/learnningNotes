<!--
 * @Date: 2020-09-24 12:17:19
 * @LastEditors: Lq
 * @LastEditTime: 2020-09-24 21:45:08
 * @FilePath: /learnningNotes/接入钉钉/php引入自定义sdk.md
-->
### php引入自定义的库流程（自己下载压缩包或文件夹引入到后端代码中）

1. **位置**：将下载的目录放到根目录的`extend`下（如果是composer安装的一般弄在vendor下）

2. **引入和使用**：在需要调用库的类和方法的地方，首行写入

    > 该方法适用于自带命名空间的类   
    > use crypto\DingtalkCrypt;  
    > $d = new DingtalkCrypt();

    > 该方法适用于不带命名空间的类  
    > require_once "../ectend/WxPay/Wxpay.Api.php" 
    > $d = new \DingtalkCrypt();
