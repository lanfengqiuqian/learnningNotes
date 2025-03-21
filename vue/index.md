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
  var vm = new Vue({
    el: "#box",
    data: {
      obj: {
        backgroundColor: "gold",
      },
      obj1: {
        fontSize: "30px",
      },
    },
  });
</script>
```

### index.html 中的`<%= BASE_URL %>`

这个是 vue-cli 的 webpack 中设置的一个路径

使用`vue inspect > output.js`这个命令可以在根目录输出出来看，默认是`/`

如果修改的话，参考[这篇文章](https://blog.csdn.net/wanghuan1020/article/details/108536334?spm=1001.2101.3001.6650.5&utm_medium=distribute.pc_relevant.none-task-blog-2%7Edefault%7EBlogCommendFromBaidu%7ERate-5.pc_relevant_paycolumn_v3&depth_1-utm_source=distribute.pc_relevant.none-task-blog-2%7Edefault%7EBlogCommendFromBaidu%7ERate-5.pc_relevant_paycolumn_v3&utm_relevant_index=7)

### vue 运行或打包报错：Ineffective mark-compacts near heap limit Allocation failed-JavaScript heap out of memory

原因：项目大，启动或打包会抛出内存溢出，需要扩展 node 服务器内存

方法一：扩展内存（实际使用这个最有效！！！）

    1. 快捷键Win+R 打开运行窗口，运行 `npm install -g increase-memory-limit`

    2. 在项目文件夹运行 `increase-memory-limit` ，内存扩展完成，再启动项目就可以了

方法二：快捷键 Win+R 打开运行窗口，运行 `setx NODE_OPTIONS --max_old_space_size=4096`，如果不行在尝试设置为`8192`

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

原因：是在 windows 系统中，不支持 shell 脚本语句导致

解决需要在`node_modules`中找到对应目录的`bin`目录下的文件的位置

如

> node_modules/.bin/vue-cli-service

修改为

> node_modules/@vue/cli-service/bin/vue-cli-service.js

我上面的修改之后为

> "build": "node --max_old_space_size=4096 node_modules/@vue/cli-service/bin/vue-cli-service.js build",

### vue 项目中的 a 标签会自动拼接当前网页域名

如：

> <a href="www.baidu.com">百度</a>  
> 地址会变为：localhost:3000/www.baidu.com

解决：需要在地址前面拼接上`http`或者`https`

### vue 动态修改路由参数

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

### Vue 的 scoped

1. 什么是`scoped`

   在 vue 文件的 style 标签上，有一个特殊的属性`scoped`。

   当一个 style 标签有这个属性的时候，它的 css 样式就只能作用于当前的组件，也就是说，这个样式只能够适用于当前组件元素。

   通过该属性，可以使得组件之间的样式不会互相污染

   如果一个项目中的所有 style 标签全部加上了 scoped，相当于实现了样式的模块化

2. scoped 的实现原理

   scoped 的属性效果主要通过`PostCSS`转译实现

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

   PostCSS：给一个组件中的所有 dom 添加了一个独一无二的动态属性，然后给 CSS 的选择器额外添加一个对应的属性选择器来选择该组建中 dom，这种做饭使得样式只作用于含有该属性的 dom--组件内部 dom。

3. 样式穿透的使用场景

   表面上看起来，每一个组件都有自己独有的样式，不会影响其他的组件，但是如果引用了第三方的组件库，还需要修改的话，就需要使用到样式穿透了

4. scoped 穿透使用方式

   1. style 为 css 时，使用`>>>`

   ```html
   <style lang="css">
     .a >>> .b {
     }
   </style>
   ```

   2. style 为`预处理器`（less/saas/scss）时，使用`/deep/`和`::v-deep`

   ```html
   <style lang="scss">
     /deep/ .active {
     }
     ::v-deep .active {
     }
   </style>
   ```

5. 另外一种方式

   在除了含有`scoped`属性的 style 标签之外，再定义一个不含有`scoped`属性的 style 标签

   ```html
   <style>
     /* global styles */
   </style>

   <style scoped>
     /* local styles */
   </style>
   ```

#### ::v-deep /deep/ v-deep() >>> 几种区别

|方式|用法 区别|兼容性|注意|
|-|-|-|-|
|/deep/|是vue2.x中用的|支持css预处理器（less，scss）|vue3.x不被官方支持，会报警告，甚至无效|
|::v-deep|在vue2.x中是/deep/的别名，但是官方文档未提及，在vue3.x中土建用法|支持css预处理器和原生css|
|>>>|是css原生语法，但是在vue单文件组件（.vue）中，并不总是被直接支持，因为vue会将其视为普通css选择器的一部分|仅在某些某些特定环境（如webpack的css-loader中）和原生css中有效，vue单文件组件中通常需要特定配置才能使用|
|v-deep()|特殊用法，在vue3的composition API中，可以通过v-deep()函数在style标签中动态应用深度选择器，这不是css语法的一部分，而是vue3特有的模板编译特性||

总结：vue2中推荐使用`/deep/`，vue3中推荐使用`::v-deep`

```html
<!-- vue2 -->
<style scoped>
.parent /deep/ .child {
  /* 样式规则 */
}
</style>

<!-- vue3 -->
 <style scoped>
.parent::v-deep .child-class {
  color: blue;
  font-weight: bold;
}
</style>
```

### this.$set() 和 vue.set()

1. 应用场景

   在给对象进行赋值的时候，发现数据并不会自动更新到视图上去

   vue 文档说明：如果在实例创建之后添加新的属性到实例上，他不会触发视图更新

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
       a: 1,
     },
   }).$mount("#app1");
   Vue.set(app.data, "b", 2);
   ```

   这种情况下控制台会报错：`Uncaught TypeError: Cannot convert undefined or null to object`

   只可以使用`Vue.set(object, propertyName, value)`方法向嵌套对象添加响应式属性

   ```js
   var vm = new Vue({
     el: "#test",
     data: {
       info: {
         name: "lan",
       },
     },
   });
   Vue.set(vm.info, "sex", "man");
   ```

3. `Vue.set()`和`this.$set()`实现原理

   ```js
   // Vue.set()的源码
   import { set } from "../observer/index";
   // somecode
   Vue.set = set;
   ```

   ```js
   // this.$set()的源码
   import { set } from "../observer/index";
   // some code
   Vue.prototype.$set = set;
   ```

   分析：这两个 api 的实现原理基本一样，都是使用的相同地方的`set()`方法，区别就是`Vue.set()`是将 set 绑定在`Vue`构造函数上，`this.$set()`将`set`绑定在`Vue`原型上

   使用区别：`this.$set`只能设置实例创建后存在的数据（数据已经在 data 中），而`Vue.set()`可以给实例创建之后添加的新的属性（data 中不存在的）

### this.$nextTick()

1. 作用

   将回调延迟到下次 dom 更新循环之后执行，在在修改数据之后立即使用它，然后等待 dom 更新

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

### 解决 uniapp 的 showToast 字数超过 7 个的显示问题

1. 描述：使用 uni-app 开发小程序，不管是使用微信小程序的 `wx.showToast()` API 或 uni-app 的 `uni.showToast()` API 显示消息提示框，显示图标 title 文本最多显示 7 个汉字长度，在不显示图标的情况下，大于两行不显示。

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
              title:
                '通过ref调用"<toast/>"组件内部的show方法时，还可以传递其他参数, show方法是通过ref调用的， 注意：所有有关ref的调用，都不能在页面的onLoad生命周期调用，因为此时组件尚未创建完毕，会报错，应该在onReady生命周期调用。',
              duration: 6000,
            });
          },
          methods: {
            showToast() {},
          },
        };
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

### Vue.ls 的使用

### vue 依赖包分析插件

1. `yarn add webpack-bundle-analyzer`

2. `vue.config.js`文件中配置

   ```js
   module.exports = {
     chainWebpack: (config) => {
       config
         .plugin("webpack-bundle-analyzer")
         .use(require("webpack-bundle-analyzer").BundleAnalyzerPlugin);
     },
   };
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

1. 什么是 Mixin

   1. Mixin 不是 Vue 专属的，他是一种思想，就是混入的意思
   2. 将组件的公用逻辑或者配置提取出来，哪个组件需要用到时，直接将提取的这部分混入入到组件内部即可
   3. 可以减少代码冗余度，让后期维护起来更加容易
   4. 抽取的是逻辑或配置，而不是 html 或者 css 代码
   5. 理解为组件的组件，组件和组件之间在重复的部分，使用 Mixin 再抽离一遍

2. Mixin 和 Vuex 的区别

   相同点：都是抽离公共部分的作用

   不同点：如果在一个组件中更改了 Vuex 的数据，那么他所应用到的所有的组件都会受到影响，但是 Mixin 的数据和方法都是独立的，组件之间使用是互不影响的

3. 如何使用

   1. mixin 的定义：他是一个对象，里面包含 Vue 组件中的常见配置

      ```js
      // src/mixin/index.js
      export const mixins = {
        data() {
          return {};
        },
        computed: {},
        methods: {},
        created() {},
        mounted() {},
      };
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

      避免使用全局混入，因为它会影响每个单独创建的 Vue 实例

4. 选项合并

   当组件中的属性或者方法和 mixin 相同的时候

   1. 生命周期函数

      名称都是固定的，执行顺序也是固定的

      先执行 mixin 中的生命周期，然后再执行组件内部的生命周期

   2. data 冲突

      当两者相同的时候，组件中的会覆盖 mixin 中的数据

   3. 方法冲突

      当两者相同的时候，组件中的会覆盖 mixin 中的数据

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

原因：使用了消息提示框，没有引入 MessageBox（有时候还有可能是 this 作用域的问题）

解决：在`main.js`中导入 element-ui 中的 messagebox

```js
import { MessageBox } from "element-ui";

Vue.prototype.$confirm = MessageBox.confirm;
```

### element ui ——did you register the component correctly 报错

背景：使用 element-ui 的组件，但是告诉我没有注册

原因：组件是 element UI 比较新的版本出的组件，element UI 版本过低

### 报错 Syntax Error: SassError: expected selector. ╷ 21 │ /deep/ .el-input\_\_inner { 解决

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

修改为： ::v-deep .el-input__inner {
  border-radius: 0;
  border: 0;
  padding-left: 0;
  padding-right: 0;
  box-shadow: none !important;
  border-bottom: 1px solid #d9d9d9;
  vertical-align: middle;
}
```

### elementui 弹窗遮罩问题；Message 层级问题（被遮罩、弹窗遮住，设置层级；弹窗内容被遮罩遮挡）

1. $Message： 提示信息被弹窗（遮罩）遮住。只是层级样式不够

   解决：使用`customClass`来设置`z-index`

2. 弹窗、抽屉： 内容被遮罩遮挡、层级不起效果、需要点击一次遮罩才进行呈现

   解决：通过设置对应属性 modal-append-to-body 值为 false 进行改变

### keepalive 组件

[https://www.cnblogs.com/JianXin1994/p/16196622.html](https://www.cnblogs.com/JianXin1994/p/16196622.html)

但是发现 meta 没有生效，待测试

### render 遍历生成元素（vue 语法）

表格的 column，想要遍历生成元素的情况下，使用遍历生成`元素字符串`，然后使用`v-html`插入模板字符串

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

### 下拉菜单或者弹出层关闭会闪或者飘走

原因：绝对定位的根元素消失了，但是这个时候，弹窗元素还没有消失，导致无法定位

解决方案：强制让弹窗先消失，然后再消失根元素

### 报错`[plugin:vite:vue] Unnecessary value binding used alongside v-model. It will interfere with v-model's behavior.`

代码如下

```js
<input type="text" value="" v-model="text1" />
```

原因：多写了`value=""`，删除即可

### uniapp 报错`Undefined variable $u-type-primary-light`

背景：`uniapp`引入`uview-ui`后，出现这个报错了

解决步骤

1. 排查`HBuilder X`是否没有安装`scss/sass`插件
2. 查看根目录下`uni.scss`文件中是否引入了`theme.scss`
3. 查看根目录下`App.vue`文件中是否添加了`lang="scss"`和`index.scss`

### 报错`Can’t find stylesheet to import.`

```shell
10:28:29.004 [plugin:vite:css] Can’t find stylesheet to import.
10:28:29.009 ╷
10:28:29.009 5 │ @import ‘uview-ui/theme.scss’;
10:28:29.017 │ ^^^^^^^^^^^^^^^^^^^^^
10:28:29.017 ╵
10:28:29.035 /Users/xxxxx/wallpaper/pages/user/user.vue 5:9 root stylesheet
```

### input 自动转为大写

1. 使用`toUpperCase`方法

   可以实现，但是输入文字会有干扰，比较有局限性，适合纯字母输入。

   ```html
   <el-input
     onkeyup="this.value=this.value.toUpperCase()"
     v-model="form.hphm"
     placeholder="请输入号牌号码"
   ></el-input>
   ```

2. 使用`text-transform`属性

   只需要给输入框加上一个 class，把属性加上即可，局限性非常小，推荐使用。

   ```html
   <div class="toUpperCase">
     <el-input v-model="form.hphm" placeholder="请输入号牌号码"></el-input>
   </div>

   .toUpperCase ::v-deep .el-input__inner { text-transform: uppercase
   !important; }
   ```

3. `toUpperCase`方法+`computed`属性

   最佳方案

   ```html
   <!-- //v-model="codeval" 绑定的codeval要和computed中的codeval一致 -->
   <el-input v-model="codeval" placeholder="请输入号牌号码"></el-input>

   computed: { codeval: { get: function () { return
   this.form.hphm;//绑定的model数据 }, set: function (val) { this.form.hphm =
   val.toUpperCase();//toUpperCase()方法用于将小写字符转换为大写 } } },
   ```

### 为应用内抛出的未捕获错误指定一个全局处理函数。

```js
interface AppConfig {
  errorHandler?: (
    err: unknown,
    instance: ComponentPublicInstance | null,
    // `info` 是一个 Vue 特定的错误信息
    // 例如：错误是在哪个生命周期的钩子上抛出的
    info: string
  ) => void;
}

app.config.errorHandler = (err, instance, info) => {
  // 处理错误，例如：报告给一个服务
};
```

### 动态绑定多个值

使用不带参数的`v-bind`进行绑定

```js
const objectOfAttrs = {
  id: 'container',
  class: 'wrapper'
}

<div v-bind="objectOfAttrs"></div>
```

### vue 运行的项目如何在手机上查看

拿 vue3+vite 举例

1. 查询本机的 ip 地址（需要时内网的）
2. 修改项目的`vite.config.js`文件，在`defineConfig`添加`server`项如下

```js
export default defineConfig({
  server: {
    // 如果不想查看ip也可以直接使用0.0.0.0，会自动使用ip
    // host: "0.0.0.0"
    host: "192.168.1.10", // 本机内网host地址
    port: 3344, // 随便开放一个未占用端口
  },
});
```

或者是修改启动命令

```js
"dev": "vite --host 0.0.0.0",
```

3. 手机和电脑在同一个局域网（连接同一个 wifi 即可），然后电脑启动项目，手机端输入`host:port`即可浏览

### html项目如何局域网查看

vscode插件：live server

修改插件设置：搜索`use local ip`，勾选

然后启动的是ip，而不是localhost就可以了

然后其他设备访问这个地址

`注意`：其他设备无法访问的情况

1. 电脑防火墙需要关闭，如果无法关闭是否电脑有其他软件接管了防火墙功能
2. 防火墙有3道：局域网、专用网络、公用网络
3. 尝试使用其他wifi（有可能这个wifi限制了），最好直接用手机热点
4. 考虑是否因为vpn导致的问题

### 报错：vue3 terser not found. Since Vite v3, terser has become an optional dependency. You need to install

安装指定依赖`npm install terser -D`

### 直接打开打包的`dist/index.html`报资源跨域问题

原因：这是因为打包后并不支持 file 引用协议。这就给混合式开发等时候带来困扰，因为在这种场景下，是有需要直接打开 index.html 文件的需求的。

1. 安装兼容插件 `@vitejs/plugin-legacy`

   > npm i @vitejs/plugin-legacy -D

2. 在 vite.config.ts 中进行配置

   ```js
   // 引入@vitejs/plugin-legacy
   import { defineConfig} from 'vite'
   import legacy from '@vitejs/plugin-legacy';
   // 在plugins中添加
   export default defineConfig({
     plugins: [
        legacy({
          targets: ['defaults', 'not IE 11']
        }),
        vue()
     ],
    base：'./'
   })

   ``

   ```

3. 手动修改打包完的 index.html 文件（不建议使用，可直接略过使用第 4 步）

   先执行 `npm run build` 命令进行打包，打包完成后打开 `dist/index.html`。将 index.html 中所有的 `<script></script>` 标签中的 ` type="module"``、crossorigin `、`nomodule` 删除。

4. 自动修改打包完的 index.html 文件（建议使用）

   1. 实现的就是将需要手动的变成自动的，如果每次打完包之后都要像第二步那样手动更改，那太麻烦了，太不符合程序员的风格了。
   2. 自动化的话，最简单的方式就是将原本符合条件的引用中需要保留的（src 地址、标签内部的 js），重新创建一个引用标签，重新引用
   3. 这样做，虽然页面打开的时候还会报错，页面会自动处理相关的错误的标签引用，在处理完毕后，页面会正常显现。
   4. 在项目的根目录下的 index.html 文件中的尾部添加新的来处理，一定要添加在尾部。

   ```js
   <script>
   (function (win) {
      // 获取页面所有的 <script > 标签对象
      let scripts = document.getElementsByTagName('script')
      // 遍历标签
      for(let i = 0; i < scripts.length; i++) {
        // 提取单个<script > 标签对象
        let script = scripts[i]
        // 获取标签中的 src
        let url = script.getAttribute("src")
        // 获取标签中的 type
        let type = script.getAttribute("type")
        // 获取标签中的js代码
        let scriptText = script.innerHTML
        // 如果有引用地址或者 type 属性 为 "module" 则代表该标签需要更改
        if (url || type === "module") {
          // 创建一个新的标签对象
          let tag=document.createElement('script');
          // 设置src的引入
          tag.setAttribute('url',url);
          // 设置js代码
          tag.innerHTML = scriptText
          // 删除原先的标签
          script.remove()
          // 将标签添加到代码中
          document.getElementsByTagName('head')[0].appendChild(tag)
        }
      }
   })(window)
   </script>

   ```

### userRouter 函数返回的是 undefined

原因：`useRouter`一定要放在`setup`方法内的顶层，否则作用域改变 useRouter()执行返回的是 undefined。

解决方案：

1. 在 setup 函数中使用（vue3）

2. 如果非要在普通的 ts 或者 js 文件中使用 router 的话

导入 router 的定义的文件暴露出来的`router`对象

```js
// 定义位置 src\router\index.ts
export const router = createRouter({});

// 使用
import router from "@/router/index";
router.push({ name: "login" });
```

### Vue 项目使用 Nprogress

> https://cloud.tencent.com/developer/article/2192271

1. 安装

> yarn add nprogress
> 如果要带 ts 版本 yarn add @types/nprogress -D

2. 引入

在需要用的文件中文件中引入功能和样式，比如`route/index.ts`

```js
import NProgress from "nprogress";
import "nprogress/nprogress.css";
```

3. 修改配置（可选）

```js
NProgress.configure({
  easing: "ease", // 动画方式
  speed: 1000, // 递增进度条的速度
  showSpinner: false, // 是否显示加载ico
  trickleSpeed: 200, // 自动递增间隔
  minimum: 0.3, // 更改启动时使用的最小百分比
  parent: "body", //指定进度条的父容器
});
```

4. 基础使用

```js
// 开启进度条
NProgress.start();
// 关闭进度条
NProgress.done();
// 随机递增
NProgress.inc();
// 手动递增
NProgress.inc(0.2);
// 手动设置百分比
NProgress.set(0.4);
```

### 动态引入本地图片的几种方式

```html
<template>
  <img src="@/assets/images/logo.png" alt="方式1" />
  <img src="../../../assets/images/logo.png" alt="方式2" />
  <img :src="LogoImg1" alt="方式3" />
  <img :src="LogoImg2" alt="方式4" />
  <!-- <img :src="imgUrl1" alt="方式5">
  <img :src="imgUrl2" alt="方式6"> -->
  <!-- <LogoImg1 placeholder="方式7" />
  <LogoImg2 placeholder="方式8" /> -->
</template>

<script setup lang="ts">
  import LogoImg1 from "@/assets/images/logo.png";
  import LogoImg2 from "../../../assets/images/logo.png";

  const imgUrl1 = "@/assets/images/logo.png";
  const imgUrl2 = "../../../assets/images/logo.png";
</script>
```

这里有 8 种方式，前面 4 种没有注释的方式可行，后面 4 种注释了方式不可行，最后 2 种代码会报错

### 右键菜单功能

> https://juejin.cn/post/7250513276236267557

1. 原生 vue 实现

```html
<template>
  <div class="home">
    <!-- 在需要右键菜单的元素，绑定contextmenu事件 -->
    <div class="element" @contextmenu.prevent="openMenu($event, 'item1')">
      right click this element
    </div>

    <!-- 右键菜单部分 -->
    <ul
      v-show="visible1"
      :style="{ left: position.left + 'px', top: position.top + 'px', display: (visible1 ? 'block' : 'none') }"
      class="contextmenu"
    >
      <div class="item">复制Vue代码</div>
      <div class="item" @click="console.log('copy');">复制SVG</div>
      <div class="item" @click="console.log('download1');">下载SVG</div>
      <div class="item" @click="console.log('download2');">下载PNG</div>
    </ul>
  </div>
</template>
<script lang="ts" setup>
  import { ref, watch } from "vue";

  const visible1 = ref(false);
  const position = ref({
    top: 0,
    left: 0,
  });
  const rightClickItem = ref("");
  const openMenu = (e: MouseEvent, item: any) => {
    visible1.value = true;
    position.value.top = e.pageY;
    position.value.left = e.pageX;
    rightClickItem.value = item;
  };
  const closeMenu = () => {
    visible1.value = false;
  };
  watch(visible1, () => {
    if (visible1.value) {
      document.body.addEventListener("click", closeMenu);
    } else {
      document.body.removeEventListener("click", closeMenu);
    }
  });
</script>
<style scoped lang="less">
  .element {
    width: 100px;
    height: 100px;
    background: lightblue;
  }
  .contextmenu {
    width: 100px;
    margin: 0;
    background: #fff;
    z-index: 3000;
    position: absolute;
    list-style-type: none;
    padding: 5px 0;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 400;
    color: #333;
    box-shadow: 2px 2px 3px 0 rgba(0, 0, 0, 0.3);

    .item {
      padding: 0 15px;
      height: 35px;
      width: 100%;
      line-height: 35px;
      color: rgb(29, 33, 41);
      cursor: pointer;
    }
    .item:hover {
      background: rgb(229, 230, 235);
    }
  }
</style>
```

2. npm 包推荐

> https://github.com/CyberNika/v-contextmenu

### 去除默认的深浅色主题

vue 框架默认加了跟随系统主题（深色和浅色）

但是如果你的项目页面没有做适配的话，会很违和

在`src\assets\base.css`中有如下代码，把他们注释掉即可

```css
@media (prefers-color-scheme: dark) {
  :root {
    --color-background: var(--vt-c-black);
    --color-background-soft: var(--vt-c-black-soft);
    --color-background-mute: var(--vt-c-black-mute);

    --color-border: var(--vt-c-divider-dark-2);
    --color-border-hover: var(--vt-c-divider-dark-1);

    --color-heading: var(--vt-c-text-dark-1);
    --color-text: var(--vt-c-text-dark-2);
  }
}
```

### 添加字体

在`@/assets/fonts`下放入字体文件

然后在`App.vue`的`style`中定义

```css
@font-face {
  font-family: 'pmzd';
  src: url('@/assets/fonts/PangMenZhengDaoBiaoTiTiMianFeiBan.ttf');
}
```

之后就可以在页面中使用了

```css
.title {
  font-family: 'pmzd';
}
```