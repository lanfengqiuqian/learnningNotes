<!--
 * @Date: 2020-08-19 19:05:50
 * @LastEditors: Lq
 * @LastEditTime: 2020-08-19 19:06:05
 * @FilePath: /learnningNotes/redis/index.md
-->
### Redis简介和优势

1. 性能极高。
2. 完全开源免费的key-value数据库。
3. 支持数据持久化，可以将内存中的数据保存在磁盘中，重启的时候再次加载使用。
4. 还支持list、set、zset、hash等数据结构的存储。
5. 支持数据的备份，master-slave模式的数据备份。

### 安装

1. [官网](https://redis.io/download)下载稳定版。
2. 解压到`/usr/local`目录下：`tar zxvf redis-4.0.10.tar.gz /usr/local`
3. 编译测试：`sudo make test`
4. 编译安装：`sudo make install`
5. 测试启动redis：`redis-server`
    会出现下面界面
    

菜鸟教程链接[点击这里](https://www.runoob.com/redis/redis-install.html)
tp6设置redis[点击这里](https://www.cnblogs.com/luojie-/p/12964330.html)

### 常用命令

1. 启动：`redis-server`
2. 查看redis是否启动：`redis-cli`
3. 终端状态(通过`redis-cli`打开)
    > redis 127.0.0.1:6379>
4. 在终端状态下命令
    1. `ping`：如果回应是`PONG`说明成功安装
    2. `CONFIG GET CONFIG_SETTING_NAME`：获取配置信息，如果是`*`则是获取所有配置信息。
    3. `CONFIG SET CONFIG_SETTING_NAME NEW_CONFIG_VALUE`：设置配置信息。
    4. `SET KEY_NAME VALUE`：设置key和value。
    5. `GET KEY_NAME`：读取value。
    6. `DEL KEY_NAME`：删除key。
5. `redis-cli info`：查看redis服务器信息
    关于信息描述可查看[这篇文章](https://www.cnblogs.com/ywrj/p/9519645.html)

### Redis配置

1. 文件位于Redis安装目录下，文件名为`redis.conf`（Windows名为redis.windows.conf)
2. 读取和设置配置信息命令。
    1. `CONFIG GET CONFIG_SETTING_NAME`
    2. `CONFIG SET CONFIG_SETTING_NAME NEW_CONFIG_VALUE`
3. 配置部分参数说明见[菜鸟教程](https://www.runoob.com/redis/redis-conf.html)

### 数据类型

1. String
    1. redis最基本的类型，一个key对应一个value
    2. 可以包含任何数据，比如jpg图片或者序列化的对象
    3. 最大存储512MB
2. Hash
    1. 是一个键值对(key=>value)的集合。
    2. 特别适合用于存储对象。
    3. demo