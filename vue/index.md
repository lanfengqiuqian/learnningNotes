<!--
 * @Date: 2022-03-29 15:13:07
 * @LastEditors: Lq
 * @LastEditTime: 2022-07-08 14:35:34
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

### Vue的scoped

1. 什么是`scoped`

    在vue文件的style标签上，有一个特殊的属性`scoped`。

    当一个style标签有这个属性的时候，它的css样式就只能作用于当前的组件，也就是说，这个样式只能够适用于当前组件元素。

    通过该属性，可以使得组件之间的样式不会互相污染

    如果一个项目中的所有style标签全部加上了scoped，相当于实现了样式的模块化

2. scoped的实现原理

    scoped的属性效果主要通过`PostCSS`转译实现

    转译前的代码

    ```html
    <style scoped>
    .example {
        color: red;
    }
    </style>

    <template>
        <div class="example">hi</div>
    </template>
    ```

    转译后的代码

    ```html
    <style>
    .example[data-v-5558831a] {
        color: red;
    }
    </style>

    <template>
        <div class="example" data-v-5558831a>hi</div>
    </template>
    ```

    PostCSS：给一个组件中的所有dom添加了一个独一无二的动态属性，然后给CSS的选择器额外添加一个对应的属性选择器来选择该组建中dom，这种做饭使得样式只作用于含有该属性的dom--组件内部dom。

3. 样式穿透的使用场景

    表面上看起来，每一个组件都有自己独有的样式，不会影响其他的组件，但是如果引用了第三方的组件库，还需要修改的话，就需要使用到样式穿透了

4. scoped穿透使用方式

   1. style为css时，使用`>>>`

   ```html
   <style lang="css">
       .a >>> .b{
       
       }
   </style>
   ```

   2. style为`预处理器`（less/saas/scss）时，使用`/deep/`和`::v-deep`

   ```html
   <style lang="scss">
       /deep/ .active{

       }
       ::v-deep .active{
           
       }
   </style>
   ```

5. 另外一种方式

    在除了含有`scoped`属性的style标签之外，再定义一个不含有`scoped`属性的style标签

    ```html
    <style>
    /* global styles */
    </style>

    <style scoped>
    /* local styles */
    </style>
    ```

### this.$set()

### this.$nextTick()


### 解决uniapp的showToast字数超过7个的显示问题

1. 描述：使用 uni-app 开发小程序，不管是使用微信小程序的 `wx.showToast()` API 或 uni-app的 `uni.showToast()` API 显示消息提示框，显示图标 title 文本最多显示 7 个汉字长度，在不显示图标的情况下，大于两行不显示。

2. 解决方案

    1. 如果要显示超过两行的文本，使用 `uview-ui` 框架的 `Toast` 消息提示组件，这个组件表现形式类似 uni 的 uni.showToast API ,但是也有不同。

        ```html
        <template>
            <view>
                <u-toast ref="uToast" />
            </view>
        </template>
        <script>
            export default {
                onReady() {
                    this.$refs.uToast.show({
                        title: '通过ref调用"<toast/>"组件内部的show方法时，还可以传递其他参数, show方法是通过ref调用的， 注意：所有有关ref的调用，都不能在页面的onLoad生命周期调用，因为此时组件尚未创建完毕，会报错，应该在onReady生命周期调用。',
                        duration: 6000
                    })
                },
                methods: {
                    showToast() {
                        
                    }
                }
            }
        </script>
        ```

    2. 也可以使用`showModal`来代替


### 引入一个依赖后，编译报错`"export 'createVNode' (imported as '_createVNode') was not found in 'vue'`

描述：这个是`vue`版本的问题，安装的这个依赖支持的是`vue3`的语法，但是你用的是`vue2`的

解决：更换版本，找到对应的版本支持`vue2`的

比如，我这边引入的是`@ant-design/icons-vue`，报错如下

```
 warning  in ./node_modules/@ant-design/icons-vue/es/components/Icon.js

"export 'createVNode' (imported as '_createVNode') was not found in 'vue'

 warning  in ./node_modules/@ant-design/icons-vue/es/utils.js

"export 'h' was not found in 'vue'

 warning  in ./node_modules/@ant-design/icons-vue/es/utils.js

"export 'nextTick' was not found in 'vue'
```

是因为我找的`antvue`的图标默认是`vue3`的了，应该用`vue2`的，不需要安装依赖，而是使用`a-icon`的方式

```vue
<template>
  <div class="icons-list">
    <a-icon type="home" />
    <a-icon type="setting" theme="filled" />
    <a-icon type="smile" theme="outlined" />
    <a-icon type="sync" spin />
    <a-icon type="smile" :rotate="180" />
    <a-icon type="loading" />
  </div>
</template>
<style scoped>
.icons-list >>> .anticon {
  margin-right: 6px;
  font-size: 24px;
}
</style>
```