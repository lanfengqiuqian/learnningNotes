<!--
 * @Date: 2021-06-26 15:04:31
 * @LastEditors: Lq
 * @LastEditTime: 2021-06-29 14:11:11
 * @FilePath: \learnningNotes\puppeteer\index.md
-->
### window安装fun并部署项目到阿里云上

1. 安装`fun`和查看版本
    > npm install @alicloud/fun -g
    > fun --version

2. 安装`docker`和查看版本

    查看官网(教程)[https://hub.docker.com/editions/community/docker-ce-desktop-windows]

    查看版本：`docker version`

3. 进行`fun`的配置

    > fun config

    需要依次配置：`Account ID`、`Access Key Id`、`Secret Access Key`、 `Default Region Name`。  

    其中 Account ID、Access Key Id 你可以从函数计算控制台首页的右上方获得

    ```shell
    ? Aliyun Account ID 1970852473468835
    ? Aliyun Access Key ID ***********O6z2
    ? Aliyun Access Key Secret ***********mxIJ
    ? Default region name cn-shanghai
    ? The timeout in seconds for each SDK client invoking 2000
    ? The maximum number of retries for each SDK client 5
    ? Allow to anonymously report usage statistics to improve the tool over time? No
    ? Use custom endpoint? No
    ```

    完成 config 操作后，fun 会将配置保存到用户目录下的 `.fcli/config.yaml` 文件中

4. 简单使用

    参见[文章](https://github.com/alibaba/funcraft/blob/master/docs/usage/getting_started-zh.md?spm=a2c4g.11186623.2.11.16e15124siSIfQ&file=getting_started-zh.md)