<!--
 * @Date: 2022-03-29 15:13:07
 * @LastEditors: Lq
 * @LastEditTime: 2022-06-15 11:16:39
 * @FilePath: \learnningNotes\vue\index.md
-->

### 设置样式

```html
<div id="box">
    <!--直接添加样式-->
    <p style="background-color: blue;">sssss</p>
    <!--绑定样式-->
    <p v-bind:style="'background-color: red;'">sssss</p>
    <!--将vue中的属性作为样式设置-->
    <p :style="obj">sssss</p>
    <!--将多个属性作为样式设置-->
    <p :style="[obj,obj1]">sssss</p>
</div>
<script type="text/javascript">
    var vm=new Vue({
        el:"#box",
        data:{
            obj:{
                backgroundColor:"gold"
            },
            obj1:{
                fontSize: "30px"
            }
        },
    });
</script>
```

### index.html中的`<%= BASE_URL %>`

 这个是vue-cli的webpack中设置的一个路径

 使用`vue inspect > output.js`这个命令可以在根目录输出出来看，默认是`/`

 如果修改的话，参考[这篇文章](https://blog.csdn.net/wanghuan1020/article/details/108536334?spm=1001.2101.3001.6650.5&utm_medium=distribute.pc_relevant.none-task-blog-2%7Edefault%7EBlogCommendFromBaidu%7ERate-5.pc_relevant_paycolumn_v3&depth_1-utm_source=distribute.pc_relevant.none-task-blog-2%7Edefault%7EBlogCommendFromBaidu%7ERate-5.pc_relevant_paycolumn_v3&utm_relevant_index=7)

 ### vue运行或打包报错：Ineffective mark-compacts near heap limit Allocation failed-JavaScript heap out of memory

 原因：项目大，启动或打包会抛出内存溢出，需要扩展node服务器内存


 方法一：扩展内存（实际使用这个最有效！！！）

    1. 快捷键Win+R 打开运行窗口，运行 `npm install -g increase-memory-limit`

    2. 在项目文件夹运行 `increase-memory-limit` ，内存扩展完成，再启动项目就可以了

方法二：快捷键Win+R 打开运行窗口，运行 `setx NODE_OPTIONS --max_old_space_size=4096`，如果不行在尝试设置为`8192`

### 打包报错

```shell
PS C:\Users\aiyong\Documents\GitHub\itr\itr-btit-fe-adminpc> yarn build
yarn run v1.22.10
$ node --max_old_space_size=4096 node_modules/.bin/vue-cli-service build
C:\Users\aiyong\Documents\GitHub\itr\itr-btit-fe-adminpc\node_modules\.bin\vue-cli-service:2
basedir=$(dirname "$(echo "$0" | sed -e 's,\\,/,g')")
          ^^^^^^^

SyntaxError: missing ) after argument list
    at wrapSafe (internal/modules/cjs/loader.js:915:16)
    at Module._compile (internal/modules/cjs/loader.js:963:27)
    at Object.Module._extensions..js (internal/modules/cjs/loader.js:1027:10)
    at Module.load (internal/modules/cjs/loader.js:863:32)
    at Function.Module._load (internal/modules/cjs/loader.js:708:14)
    at Function.executeUserEntryPoint [as runMain] (internal/modules/run_main.js:60:12)
    at internal/main/run_main_module.js:17:47
error Command failed with exit code 1.
info Visit https://yarnpkg.com/en/docs/cli/run for documentation about this command.
```

原因：是在windows系统中，不支持shell脚本语句导致

解决需要在`node_modules`中找到对应目录的`bin`目录下的文件的位置

如

> node_modules/.bin/vue-cli-service

修改为

> node_modules/@vue/cli-service/bin/vue-cli-service.js

我上面的修改之后为

> "build": "node --max_old_space_size=4096 node_modules/@vue/cli-service/bin/vue-cli-service.js build",

### vue项目中的a标签会自动拼接当前网页域名

如：

> <a href="www.baidu.com">百度</a>   
> 地址会变为：localhost:3000/www.baidu.com  

解决：需要在地址前面拼接上`http`或者`https`

### vue动态修改路由参数

```js
import merge from 'webpack-merge'；
 
// 修改原有参数        
this.$router.push({
    query:merge(this.$route.query,{'id':'1'})
})
 
// 新增参数：
this.$router.push({
    query:merge(this.$route.query,{'name':'张三'})
})
 
// 替换所有参数：
 this.$router.push({
    query:merge({},{'test':123})
})
```

### 项目运行起来了之后页面上报错

```
vue Cannot GET /
```

将`vue\config\index.js`中的`assetsPublicPath`还原

```js
assetsPublicPath: './',
// 改为
assetsPublicPath: '/',
```