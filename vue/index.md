<!--
 * @Date: 2022-03-29 15:13:07
 * @LastEditors: Lq
 * @LastEditTime: 2022-08-09 21:09:28
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

### this.$set() 和 vue.set()

1. 应用场景

    在给对象进行赋值的时候，发现数据并不会自动更新到视图上去

    vue文档说明：如果在实例创建之后添加新的属性到实例上，他不会触发视图更新

    ```js
    data() {
        return {
            obj: {
                name: 'lan',
                age: 12
            }
        }
    }
    mounted() {
        this.obj.sex = 'man';
    }
    ```

2. 原因分析

    受到`es5`的限制，`vue.js`不能检测到对象属性的添加或删除，即`vue`不能做到脏数据检查。

    因为`vue.js`会在初始化实例的时候，将属性转为`getter`和`setter`，所以属性必须在`data`对象上才能让`vue.js`转化他，才能让他是响应的

    正确写法：`this.$set(this.data, 'key', value)`;

    ```js
    mounted() {
        this.$set(this.obj, 'sex', 'man');
    }
    ```

    注意：`vue`不允许动态添加根级响应式属性

    ```js
    const app = new Vue({
        data: {
            a: 1
        }
    }).$mount('#app1')
    Vue.set(app.data, 'b', 2);
    ```

    这种情况下控制台会报错：`Uncaught TypeError: Cannot convert undefined or null to object`

    只可以使用`Vue.set(object, propertyName, value)`方法向嵌套对象添加响应式属性

    ```js
    var vm = new Vue({
        el: '#test',
        data: {
            info: {
                name: 'lan'
            }
        }
    });
    Vue.set(vm.info, 'sex', 'man');
    ```

3. `Vue.set()`和`this.$set()`实现原理

    ```js
    // Vue.set()的源码
    import { set } from '../observer/index'
    // somecode
    Vue.set = set;
    ```

    ```js
    // this.$set()的源码
    import { set } from '../observer/index';
    // some code
    Vue.prototype.$set = set
    ```

    分析：这两个api的实现原理基本一样，都是使用的相同地方的`set()`方法，区别就是`Vue.set()`是将set绑定在`Vue`构造函数上，`this.$set()`将`set`绑定在`Vue`原型上

    使用区别：`this.$set`只能设置实例创建后存在的数据（数据已经在data中），而`Vue.set()`可以给实例创建之后添加的新的属性（data中不存在的）

### this.$nextTick()

1. 作用

    将回调延迟到下次dom更新循环之后执行，在在修改数据之后立即使用它，然后等待dom更新

2. 应用场景

    1. 需要使用元素选择器来获取元素进行操作
    2. 或者是使用`$refs`来获取元素进行操作

3. 示例

    ```js
    data() {
        return {
            content: '初始值'
        }
    }
    testClick() {
        this.content = '改变了的值'
        // 这时候直接打印的话，由于dom元素还没更新
        // 因此打印出来的还是未改变之前的值
        console.log(this.$refs.tar.innerText) // 初始值
    }
    ```

    使用`this.$nextTick()`

    ```js
    testClick() {
        this.content = '改变了的值'
        this.$nextTick(() => {
            // dom元素更新后执行，因此这里能正确打印更改之后的值
            console.log(this.$refs.tar.innerText) // 改变了的值
        })
    }
    ```


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

### Vue.ls的使用



### vue依赖包分析插件

1. `yarn add webpack-bundle-analyzer`

2. `vue.config.js`文件中配置

    ```js
    module.exports = {    
        chainWebpack: config => {
            config
            .plugin('webpack-bundle-analyzer')
            .use(require('webpack-bundle-analyzer').BundleAnalyzerPlugin)
        },
    }
    ```

3. `yarn serve`跑起来就能看到了


### Computed property "XXX" was assigned to but it has no setter

原因：`v-model`是双向绑定，但是在`computed`只通过`get`获取参数值，没有`set`改变参数值

解决方案：在`computed`中添加`get`和`set`

```js
collapseMenu: {
    get() {
        return this.$store.state.tab.drawer
    },
    set(v) {
        this.$store.state.tab.drawer = v
    }
}
```

另一个方案：不要使用`v-model`双向绑定，而是直接使用`value`赋值


### mixin

1. 什么是Mixin

    1. Mixin不是Vue专属的，他是一种思想，就是混入的意思
    2. 将组件的公用逻辑或者配置提取出来，哪个组件需要用到时，直接将提取的这部分混入入到组件内部即可
    3. 可以减少代码冗余度，让后期维护起来更加容易
    4. 抽取的是逻辑或配置，而不是html或者css代码
    5. 理解为组件的组件，组件和组件之间在重复的部分，使用Mixin再抽离一遍

2. Mixin和Vuex的区别

    相同点：都是抽离公共部分的作用

    不同点：如果在一个组件中更改了Vuex的数据，那么他所应用到的所有的组件都会受到影响，但是Mixin的数据和方法都是独立的，组件之间使用是互不影响的

3. 如何使用

    1. mixin的定义：他是一个对象，里面包含Vue组件中的常见配置

        ```js
        // src/mixin/index.js
        export const mixins = {
            data() {
                return {}
            },
            computed: {},
            methods: {},
            created() {},
            mounted() {}
        }
        ```

    2. 局部混入

        ```js
        // App.vue
        import { mixins } from "./mixin/index";
        ```

    3. 全局混入

        ```js
        // main.js
        import { mixins } from "./mixin/index";
        Vue.mixin(mixins);
        ```

        避免使用全局混入，因为它会影响每个单独创建的Vue实例

4. 选项合并

    当组件中的属性或者方法和mixin相同的时候

    1. 生命周期函数

        名称都是固定的，执行顺序也是固定的

        先执行mixin中的生命周期，然后再执行组件内部的生命周期

    2. data冲突

        当两者相同的时候，组件中的会覆盖mixin中的数据

    3. 方法冲突

        当两者相同的时候，组件中的会覆盖mixin中的数据

5. 优缺点

    1. 优点

        1. 提高了代码复用性
        2. 无需传递状态
        3. 维护方便

    2. 缺点

        1. 命名冲突
        2. 滥用的话后期很难维护
        3. 不好追溯源，排查问题稍显麻烦

### TypeError: this.$confirm is not a function

```js
logout() {
    this.$confirm(`确定进行-[退出]-操作?`, "提示 :", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
    }).then(() => {
    });
}
```
原因：使用了消息提示框，没有引入MessageBox（有时候还有可能是this作用域的问题）

解决：在`main.js`中导入element-ui中的messagebox

```js
import {MessageBox} from 'element-ui'

Vue.prototype.$confirm=MessageBox.confirm;
```

### element ui ——did you register the component correctly报错

背景：使用element-ui的组件，但是告诉我没有注册

原因：组件是element UI 比较新的版本出的组件，element UI 版本过低


### 报错 Syntax Error: SassError: expected selector. ╷ 21 │ /deep/ .el-input__inner { 解决

解决方案：全局搜索把`/deep/` 改成 `::v-deep`

```css
/deep/ .el-input__inner {
    border-radius: 0;
    border: 0;
    padding-left: 0;
    padding-right: 0;
    box-shadow: none !important;
    border-bottom: 1px solid #d9d9d9;
    vertical-align: middle;
}
 
修改为：
::v-deep .el-input__inner {
    border-radius: 0;
    border: 0;
    padding-left: 0;
    padding-right: 0;
    box-shadow: none !important;
    border-bottom: 1px solid #d9d9d9;
    vertical-align: middle;
}
```

### elementui 弹窗遮罩问题；Message层级问题（被遮罩、弹窗遮住，设置层级；弹窗内容被遮罩遮挡）

1. $Message： 提示信息被弹窗（遮罩）遮住。只是层级样式不够

    解决：使用`customClass`来设置`z-index`

2. 弹窗、抽屉： 内容被遮罩遮挡、层级不起效果、需要点击一次遮罩才进行呈现

    解决：通过设置对应属性modal-append-to-body值为false进行改变


### keepalive组件

[https://www.cnblogs.com/JianXin1994/p/16196622.html](https://www.cnblogs.com/JianXin1994/p/16196622.html)

但是发现meta没有生效，待测试


### render遍历生成元素（vue语法）

表格的column，想要遍历生成元素的情况下，使用遍历生成`元素字符串`，然后使用`v-html`插入模板字符串
```js
{
    label: "仓库编号",
    prop: "warehouseCode",
    width: 100,
    render: () => {
    let str = "";
    for (let i = 0; i < 8; i++) {
        str += `<br />${i}`;
    }
    return <div v-html={str}></div>;
    },
},
```