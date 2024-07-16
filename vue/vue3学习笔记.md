[pop]

#### 基础概念

1. 选项式 API 和组合式 API

   选项式 API：包含多个选项的对象来描述组件的逻辑，如 data、methods、mounted，选项所定义的属性都暴露在函数内部的 this 上，它会指向当前组件的实例

   ```js
   <script>
       export default {
           // data() 返回的属性将会成为响应式的状态
           // 并且暴露在 `this` 上
           data() {
               return {
               count: 0
               }
           },

           // methods 是一些用来更改状态与触发更新的函数
           // 它们可以在模板中作为事件监听器绑定
           methods: {
               increment() {
               this.count++
               }
           },

           // 生命周期钩子会在组件生命周期的各个不同阶段被调用
           // 例如这个函数就会在组件挂载完成后被调用
           mounted() {
               console.log(`The initial count is ${this.count}.`)
           }
       }
   </script>

   <template>
       <button @click="increment">Count is: {{ count }}</button>
   </template>
   ```

   组合式 API：通常和`<script setup>`一起使用，`setup`是一个标识，告诉 Vue 需要在编译的时候进行处理，让我们更简洁地使用组合式 API

   ```js
   <script setup>
       import { ref, onMounted } from 'vue'

       // 响应式状态
       const count = ref(0)

       // 用来修改状态、触发更新的函数
       function increment() {
       count.value++
       }

       // 生命周期钩子
       onMounted(() => {
           console.log(`The initial count is ${count.value}.`)
       })
   </script>

   <template>
       <button @click="increment">Count is: {{ count }}</button>
   </template>

   ```

### 笔记

1. setup 函数

   ```js
   <script>
       export default {
           setup() {
               const count = ref(0);
               // 返回值会暴露模版和其他选项式API
               return {
                   count
               }
           },
           mounted() {
               console.log(this.count);
           },
       }
   </script>
   ```

   从模版中访问从`setup`返回的`ref`的时候，它会自动浅解析包，因此不需要再使用`.value`来访问

   `setup`函数中访问`this`将会是`undefined`，因为`setup`自身不包含对组件实例的访问权。你可以在选项式 API 中访问

   `props`是 setup 的第一个参数，他是响应式的，但是如果你进行了解构，那么就会丢失响应式。如果的确需要进行解构使用，那么需要使用`toRefs`或`toRef`

2. 具名插槽

   1. 【#reference】
   2. 【v-slot:reference】
   3. 【slot="reference"】

   1 和 2 等价
   2 的动态插槽写法：【v-slot:[test]】
   3 是很老的一种写法

3. 在 tsx 中使用插槽

   可参见[https://blog.csdn.net/qq_24719349/article/details/116724681](https://blog.csdn.net/qq_24719349/article/details/116724681)

   ```jsx
   const columns = [
     {
       label: "姓名",
       prop: "name",
       render: () => {
         const slots = {
           default: () => "Loading",
           loading: () => {
             return (
               <>
                 <span>用户管理</span>
               </>
             );
           },
         };
         return (
           <>
             <el-button type="primary" v-slots={slots} loading></el-button>
           </>
         );
         // 另外一种写法
         return (
           <>
             <el-button type="primary" loading>
               {slots}
             </el-button>
           </>
         );
       },
     },
   ];
   ```

   ```jsx
   // 导出功能插槽
   const exportSlots = {
     dropdown: () => (
       <>
         <el-dropdown-item onClick={() => handleExport("current")}>
           导出当前页
         </el-dropdown-item>
         <el-dropdown-item onClick={() => handleExport("all")}>
           导出明细页
         </el-dropdown-item>
       </>
     ),
   };

   <el-dropdown v-slots={exportSlots}>
     <el-button type="primary">页面导出</el-button>
   </el-dropdown>;
   ```

4. element-ui 和 element-plus 区别

   1. 对应的 vue 版本不同

      element-ui 对应 Vue2，element-plus 对应 Vue3

   2. 手机版

      element-ui 没有考虑手机版的展示，element-plus 考虑了手机版的展示

   3. 组件的插槽使用方式变化

      ```js
      // element-ui
      // 具名插槽 slot="append"
      // 默认插槽 slot

      // element-plus
      // 具名插槽 #append
      // 默认插槽 #default
      ```

   详见[https://blog.csdn.net/drhrht/article/details/123421598](https://blog.csdn.net/drhrht/article/details/123421598)

5. composable 应用

   场景：有需要复用的属性或方法

   注意：在 composable 中不能使用组件，但是在组件中可以使用 composable

   ```js
   import { ref, onMounted, onUnmounted } from "vue";

   export function useMouse() {
     const x = ref(0);
     const y = ref(0);

     onMounted(() => window.addEventListener("mousemove", update));
     onUnmounted(() => window.removeEventListener("mousemove", update));

     const update = ({ pageX, pageY }) => {
       x.value = pageX;
       y.value = pageY;
     };

     return { x, y };
   }
   ```

   ```js
   <template>
   <h2>
       mouse：{{x}}==={{y}}
   </h2>
   </template>
   <script setup>
   import { useMouse } from '../composable/mouseMove.ts'

   const {x, y} = useMouse();
   </script>
   ```

6. error 'defineProps' is not defined

   解释：语法是没问题的，但是在`eslint`检查的时候被当作未被定义的变量报错

   解决方案

   1. 直接在文件中导入

      > import { defineProps, defineEmits } from 'vue'

   2. 将他们声明为全局变量

      ```js
      // .eslintrc.js
      module.exports = {
        globals: {
          defineProps: "readonly",
          defineEmits: "readonly",
          defineExpose: "readonly",
          withDefaults: "readonly",
        },
      };
      ```

   3. [eslint-plugin-vue](https://eslint.vuejs.org/user-guide/#compiler-macros-such-as-defineprops-and-defineemits-generate-no-undef-warnings)官方的解决方法

      ```js
      // .eslintrc.js
      module.exports = {
        env: {
          browser: true,
          es2021: true,
          // 添加：
          "vue/setup-compiler-macros": true,
        },
      };
      ```

7. 解决 template 标签提示报错

   ```js
   typeScript intellisense is disabled on template. To enable, configure `"jsx": "preserve"` in the `"compilerOptions"` property of tsconfig or jsconfig. To disable this prompt instead, configure `"experimentalDisableTemplateSupport": true` in `"vueCompilerOptions"` property
   ```

   解决方法：要启用 template 需要在`jsconfig.json`的`compilerOption`属性中配置`"jsx":"preserve"`

8. 自定义组件使用 v-model

   1. 基本使用

      ```html
      // 子组件
      <template>
        <input
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
        />
      </template>
      <script setup>
        defineProps(["modelValue"]);
        defineEmits(["update:modelValue"]);
      </script>

      // 父组件
      <Child v-model="hello" />
      ```

   2. 想要更改子组件的`modelValue`参数名

      ```html
      // 子组件
      <script>
        defineProps(["title"]);
        defineEmits(["update:title"]);
      </script>

      // 父组件
      <MyComponent v-model:title="bookTitle" />
      ```

   3. 多个 model 绑定

      ```html
      // 子组件
      <script setup>
        defineProps({
          firstName: String,
          lastName: String,
        });
        defineEmits(["update:firstName", "update:lastName"]);
      </script>
      <template>
        <input
          type="text"
          :value="firstName"
          @input="$emit('update:firstName', $event.target.value)"
        />
        <input
          type="text"
          :value="lastName"
          @input="$emit('update:lastName', $event.target.value)"
        />
      </template>

      // 父组件
      <UserName v-model:first-name="first" v-model:last-name="last" />
      ```

9. 使用`component`组件报错

   ```html
   <template lang="">
     <div>
       <div>
         <button @click="changeHandle('One')">One</button>
         <button @click="changeHandle('Two')">Two</button>
         <button @click="changeHandle('Three')">Three</button>
       </div>
       <div>
         <component :is="currentComponent"></component>
       </div>
     </div>
   </template>

   <script setup>
     import { ref } from "vue";
     import One from "./component-tabs/one.vue";
     import Two from "./component-tabs/two.vue";
     import Three from "./component-tabs/three.vue";

     const currentComponent = ref(One);

     const obj = { One, Two, Three };

     const changeHandle = (type) => {
       console.log("进入了type");
       currentComponent.value = obj[type];
     };
   </script>
   ```

   报错如下

   ```js
   Vue received a Component which was made a reactive object. This can lead to unnecessary performance overhead, and should be avoided by marking the component with `markRaw` or using `shallowRef` instead of `ref`
   ```

   原因是`component`的`is`属性值虽然可以是组件名字符串也可以是组件本身，但是更推荐使用组件名字符串

   修改如下两行即可

   ```js
   const currentComponent = ref("One");
   currentComponent.value = type;
   ```

10. 在`<script setup>`中要使用动态组件`component`的`is`属性，使用组件名字符串无效

    原因：在 vue3 中，组件被引用为变量，而不是字符串键来注册的

    解决方案：需要使用`组件变量`，而不是使用字符串

    详见[https://blog.csdn.net/xxcmyh/article/details/122083315](https://blog.csdn.net/xxcmyh/article/details/122083315)

    [官方文档](https://cn.vuejs.org/api/sfc-script-setup.html#using-components)

11. vue2 和 vue3 组件局部注册区别

    ```js
    // vue2 import进来之后需要使用components中定义
    <template>
        <OneCom />
    </template>
    <script>
        import OneCom from './component-tabs/OneCom.vue'
        export default {
            components: {
                OneCom
            }
        }
    </script>
    ```

    ```js
    // vue3 import进来之后，使用了setup属性之后直接能够使用
    <template>
        <OneCom />
    </template>
    <script setup>
        import OneCom from './component-tabs/OneCom.vue'
    </script>
    ```

12. 传入`defineProps`的泛型参数本身不能是一个导入的类型

    ```js
    import { Props } from './other-file'
    // 不支持！
    defineProps<Props>()
    ```

13. vue-loader 中出现的错误：You may need an additional loader to handle the result of these loaders.

    表现在`script`标签中使用`lang=ts`就报错

    原因：创建的项目没有勾选 ts 选项

    解决：要么重新建一个项目，要么看这个[https://blog.csdn.net/qq_61672548/article/details/125506231](https://blog.csdn.net/qq_61672548/article/details/125506231)

14. vue3+ts 报错 error Insert `⏎` prettier/prettier

    > npm run lint --fix

15. KeepAlive 组件的使用

    注意：`KeepAlive`组件中必须且只能放一个子组件

    ```html
    <template>
      <h2>hello world组件</h2>
      <h4>{{showComponent}}</h4>
      <KeepAlive include="OneCom">
        <component :is="comObj[showComponent]"></component>
      </KeepAlive>
      <button @click="toggleHandle">toggle</button>
    </template>

    <script setup lang="ts">
      import { defineProps, ref } from "vue";
      import OneCom from "./OneCom.vue";
      import TwoCom from "./TwoCom.vue";

      const comObj = { OneCom, TwoCom };

      const showComponent = ref("OneCom");

      const toggleHandle = () => {
        if (showComponent.value === "OneCom") {
          showComponent.value = "TwoCom";
        } else {
          showComponent.value = "OneCom";
        }
      };
    </script>
    ```

16. TSX 语法的类型推导支持

    需要在`tsconfig.json`中配置了`"jsx": "preserve"`，这样就能保证 Vue 的 JSX 语法编译过程的完整性

17. vue3+tsx 的一些写法

    [https://www.jianshu.com/p/d484ad785299](https://www.jianshu.com/p/d484ad785299)

    官方文档见[https://cn.vuejs.org/guide/extras/render-function.html#passing-slots](https://cn.vuejs.org/guide/extras/render-function.html#passing-slots)

18. vite 项目改为 vue-cli

    可参考这两篇进行反向迁移

    > https://www.csdn.net/tags/MtTaMgzsODIxMzAxLWJsb2cO0O0O.html  
    > https://juejin.cn/post/7012494586664714248

    1. 将 package.json 中的依赖替换，运行 script 也替换

       1. 这里直接是全部替换，没有修改
       2. 删除 type: “module”
       3. 除了和 vite 相关的依赖之外的依赖不要删掉了，如 pinia、axios 等

       ```json
       {
         "name": "mobile",
         "private": true,
         "version": "0.0.0",
         "scripts": {
           "serve": "vue-cli-service serve",
           "build": "vue-cli-service build",
           "lint": "vue-cli-service lint"
         },
         "dependencies": {
           "axios": "^1.1.3",
           "core-js": "^3.8.3",
           "normalize.css": "^8.0.1",
           "pinia": "^2.0.23",
           "sass": "^1.26.5",
           "sass-loader": "^8.0.2",
           "vant": "^3.6.4",
           "vue": "^3.2.13",
           "vue-router": "^4.0.3"
         },
         "devDependencies": {
           "@typescript-eslint/eslint-plugin": "^4.18.0",
           "@typescript-eslint/parser": "^4.18.0",
           "@vue/cli-plugin-babel": "~5.0.0",
           "@vue/cli-plugin-eslint": "~5.0.0",
           "@vue/cli-plugin-router": "~5.0.0",
           "@vue/cli-plugin-typescript": "~5.0.0",
           "@vue/cli-service": "~5.0.0",
           "@vue/eslint-config-prettier": "^6.0.0",
           "@vue/eslint-config-typescript": "^7.0.0",
           "eslint": "^8.27.0",
           "eslint-plugin-prettier": "^3.3.1",
           "eslint-plugin-vue": "^7.0.0",
           "typescript": "~4.5.5",
           "unplugin-vue-components": "^0.22.9"
         },
         "config": {
           "commitizen": {
             "path": "./node_modules/cz-conventional-changelog"
           }
         },
         "browserslist": ["> 1%", "last 2 versions", "not dead", "not ie 11"]
       }
       ```

    2. 将配置项进行全部替换

       1. 增加 babel.config.js

       ```js
       module.exports = {
         presets: ["@vue/cli-plugin-babel/preset"],
       };
       ```

       2. 替换 tsconfig.json

       ```json
       {
         "compilerOptions": {
           "target": "esnext",
           "module": "esnext",
           "strict": true,
           "jsx": "preserve",
           "importHelpers": true,
           "moduleResolution": "node",
           "skipLibCheck": true,
           "esModuleInterop": true,
           "noImplicitAny": false,
           "allowSyntheticDefaultImports": true,
           "sourceMap": true,
           "baseUrl": ".",
           "types": ["webpack-env", "jest"],
           "paths": {
             "@/*": ["src/*"]
           },
           "lib": ["esnext", "dom", "dom.iterable", "scripthost"]
         },
         "include": [
           "src/**/*.ts",
           "src/**/*.tsx",
           "src/**/*.vue",
           "tests/**/*.ts",
           "tests/**/*.tsx"
         ],
         "exclude": ["node_modules"]
       }
       ```

       3. 增加 vue.config.js

       ```js
       const { defineConfig } = require("@vue/cli-service");
       const { VantResolver } = require("unplugin-vue-components/resolvers");
       const ComponentsPlugin = require("unplugin-vue-components/webpack");

       module.exports = defineConfig({
         transpileDependencies: true,
         configureWebpack: {
           plugins: [
             ComponentsPlugin({
               resolvers: [VantResolver()],
             }),
           ],
         },
       });
       ```

       4. 删除 vite.config.ts
       5. 删除 tsconfig.node.json
       6. 增加.eslintrc.js

       ```js
       module.exports = {
         root: true,
         env: {
           node: true,
         },
         extends: [
           "plugin:vue/vue3-essential",
           "eslint:recommended",
           "@vue/typescript/recommended",
           "@vue/prettier",
           "@vue/prettier/@typescript-eslint",
         ],
         parserOptions: {
           ecmaVersion: 2020,
         },
         rules: {
           "no-console": process.env.NODE_ENV === "production" ? "warn" : "off",
           "no-debugger":
             process.env.NODE_ENV === "production" ? "warn" : "off",
           "@typescript-eslint/no-explicit-any": ["off"],
         },
       };
       ```

    3. 替换 index.html 并放到 public 中
       1. vite 的 index.html 在根目录
       2. vuecli 在 public
       3. 内容也不大一样
    4. 删除 src/vite-env.d.ts

    过程中遇到的一些问题

    1. ESLint is not a constructor

       原因：eslint 的版本低了，需要`>= 7`，仅更换`eslint`这一个依赖即可

    2. /bin/sh: vue-cli-service: command not found

       原因：依赖出问题了，或者其他原因，我这里单纯的是复制的时候把`@vue/cli-service`漏掉了

    3. Component name "Detail" should always be multi-word

       原因：组件名称需要使用`连字符`，如`hello-world`

       可参考[https://blog.csdn.net/qq_57587705/article/details/124674660](https://blog.csdn.net/qq_57587705/article/details/124674660)

    4. 报了个警告：`the ＞＞＞ and /deep/ combinators have been deprecated. Use :deep() instead.`

       将 css 的写法改一下即可

    5. `defineProps' is not defined`

       修改`.eslintrc.js`的配置

       ```js
       env: {
           node: true,
           'vue/setup-compiler-macros': true
       }
       ```

    6. `Could not find a declaration file for module 'xxx.vue'`

       原因：typescript 中引入了 javascript 开发的代码

       解决：在`scr`目录下增加一个`shims-vue.d.ts`文件，如果不够就根目录在增加一个相同的

       ```js
       /* eslint-disable */
       declare module '*.vue' {
           import type { DefineComponent } from 'vue'
           const component: DefineComponent<{}, {}, any>
           export default component
       }
       ```

### element datepicker 设置时间段禁用

```html
<el-date-picker
  type="daterange"
  v-model="date"
  range-separator="To"
  start-placeholder="Start date"
  end-placeholder="End date"
  :disabled-date="pickerOptions"
/>

const date = ref([]); const pickerOptions = (time) => { return ( new
Date("2022-11-01").getTime() <= time.getTime() && time.getTime() <= new
Date("2022-12-01").getTime() ); };
```

### 使用 Vue 3 Script Setup 时 ESLint 报错 ‘defineProps’ is not defined

1. 检查`eslint-plugin-vue`的版本

   > npm list eslint-plugin-vue

   若版本在 v8.0.0 以上，跳转到 Step 2，否则直接到 Step 3 的内容

2. 版本为 v8.0.0+

   打开`.eslintrc.js`文件并修改如下：

   ```js
   env: {
       node: true,
       // The Follow config only works with eslint-plugin-vue v8.0.0+
       "vue/setup-compiler-macros": true,
   },
   ```

3. 版本为 v8.0.0 以下

   打开 .eslintrc.js 文件并修改如下：

   ```js
   // The Follow configs works with eslint-plugin-vue v7.x.x
   globals: {
       defineProps: "readonly",
       defineEmits: "readonly",
       defineExpose: "readonly",
       withDefaults: "readonly",
   },
   ```

### 查看项目打包大小

1. 在线调试

   1. 安装`webpack`插件

      ```shell
      npm i webpack-boundle-analyzer -D
      或者 npm i webpack-boundle-analyzer --save-dev
      ```

   2. 在`vue.config.js`中配置

      ```js
      module.exports = {
      chainWebpack: config => {
          // 当环境变量user_analyzer为true使用
          if (process.env.use_analyzer) {
              config
              .plugin('webpack-bundle-analyzer')
              .use(require('webpack-bundle-analyzer').BundleAnalyzerPlugin)
          }
      }
      ```

   3. 在`package.json`中配置命令

      ```json
      {
          "scripts": {
              "serve": "vue-cli-service serve"
              "analyzer": "cross-env use_analyzer=true npm run serve"
          }
      }
      ```

   注意： 定义该指令必须要安装`cross_env`（`cross-env`这是一款运行跨平台设置和使用环境变量的脚本），否则会出现下面的报错信息

   4. 运行

      ```js
      npm run analyzer
      ```

      该界面会运行在`8888`端口（`http://127.0.0.1:8888/`）如果端口被占用则会报错。

2. 使用`vue-cli3`中内置命令

   1. 直接在`package.json`中配置命令，在`build`后追加`-report`

      ```js
      "scripts": {
          "build": "vue-cli-service build --report",
      }
      ```

   2. 直接运行`build`

      ```shell
      npm run build
      ```

   3. 打开`dist`目录下的`report.html`文件

### vue-virtual-scroller 虚拟滚动遇到的问题

#### 安装和使用

见官方文档：[https://github.com/Akryum/vue-virtual-scroller/tree/master/packages/vue-virtual-scroller](https://github.com/Akryum/vue-virtual-scroller/tree/master/packages/vue-virtual-scroller)

#### 如何获取子组件的实例

1. 背景

   本来正常情况下，要获取`v-for`渲染的子组件的实例，通过`ref`绑定即可获取到数组，并通过`index`即可定位到 vue 实例

   ```html
   <template>
     <RecycleScroller
       class="scroller"
       :items="list"
       :item-size="32"
       key-field="id"
       v-slot="{ item }"
     >
       <Info ref="info"> {{ item.name }} </Info>
     </RecycleScroller>
   </template>
   ```

   但是由于这里使用的是虚拟列表，`info.value`打印出来的结果只是渲染出来的第一个实例

2. 解决方案

   发现，通过为每一个组件绑定不同的 ref，通过这多个`ref`能够获取到每一个实例，比如`info0.value`、`info1.value`

   那么，就只需要根据`list`动态的创建多个`ref`，优化方案，多个`ref`放到数组中，通过`index`访问

   ```html
   <RecycleScroller
     class="scroller"
     ref="scroller"
     :items="arr"
     :item-size="145"
     :buffer="400"
     key-field="itemCode"
     v-slot="{ item, index }"
   >
     <OutInfo :ref="outInfoRefs[index]" />
   </RecycleScroller>

   //子组件的实例（这里通过数组来进行存储，每一个实例存储一个） const
   outInfoRefs: any = []; arr.value.forEach(item => outInfoRefs.push(ref()));
   ```

   这样打印出来的`outInfoRefs`将会是多个`ref`实例

   `注意`：这里打印出来的并没有所有的，只有视口上展示出来的加上不可见的预加载的几个

   比如是这样的：`[null, null, null, ref(), ref(), ref(), ref(), null, null, null]`

#### 如何保存不在视口区域内的子组件的状态

1. 背景

   如果你在子组件的`onMounted`中输出日志的话，会发现，只有一开始加载的几个元素会输出，后面为了提高效率只是重复渲染这已经加载的几个元素而已

   `那么问题来了`：实际上不同的子组件里面的状态是不一样的，传递进去的`props`是会获取到的，但是自己维护的是不变的

   比如每个子组件有一个`input`，你在第一个输入了一个`hello`，假定你重复渲染的子组件是 5 个，那么在第 6 个子组件渲染的时候，你会惊奇的发现他已经变成了`hello`，这显然不是我们需要的结果

2. 解决方案

   前面说过，`props`是会正常获取到的，那么通过`watch`到`props`的变化，比如传递一个`index`

   然后在这个`watch`中根据需要，去初始化组件状态，那么就可以实现

   ```js
   watch(
     () => props.index,
     (newVal) => {
       // 由于使用的是虚拟滚动，每个子元素是复用的，css样式会保留，通过监听index的变化，来达到重新渲染每个子元素的效果
       if (props.focusIndex === newVal) {
         // 如果当前子元素是选中的，那么需要进行一些操作
       } else {
         // 如果当前子元素不是选中的，那么需要进行另一些操作
         doBlur(1);
         delColor();
         editIsDisabled();
       }
     }
   );
   ```

3. 另一个问题（赋初值，保存变化值）

   假定第一个元素的`input`已经赋值了`hello`，如果通过上面的代码的话，那么第 6 个已经正常置空了

   但是回去到第 1 个时候，会发现也被置空了，但是并不能通过`props`获取到刚才的改变，因为没有保存

   因为子元素无法保存，但是对应的数据是可以保存的，比如添加一个属性`tempValue`，在 change 的时候，通过 props 进行改变，然后在 watch 的时候赋值上去，这样是可行的

#### Module ‘“xx.vue“‘ has no default export.Vetur(1192)

`vetur`是一个 vscode 插件，用于为`.vue`单文件组件提供代码高亮以及语法支持

github 的 issue 中有如下一段话

```js
If you take a look at how Evan recently responded about the recommended approach going forward, it seems that volar is currently the extension of choice for vue 3.
```

那既然官方推荐 *volar*那肯定要去看下，简单的说 volar 是 vetur 的升级版本，提供了更牛叉的功能并有更好的 TS 支持。

提示：实际在 vscode 项目中找不到`volar`插件了，改为叫`Vue-Official`

#### 控制台警告 Feature flag **VUE_PROD_HYDRATION_MISMATCH_DETAILS** is not explicitly defined

原因：这个警告是由 Vue 在开发环境中的特定配置引起的，它提示你在 esm-bundler 版本的 Vue 中需要定义特定的编译时特性标志（compile-time feature flags）以获得更好的树状结构提示（better tree-shaking）。

方案：要解决这个警告，你可以通过在项目的构建配置中定义相关的编译时特性标志。具体的操作取决于你使用的构建工具（如 webpack、Vite 等）和构建配置。

1. webpack

```js
// webpack.config.js

const webpack = require("webpack");

module.exports = {
  plugins: [
    new webpack.DefinePlugin({
      __VUE_OPTIONS_API__: "true",
      __VUE_PROD_DEVTOOLS__: "false",
      __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: "false",
    }),
  ],
  // other webpack config settings
};
```

2. vite

```js
// vite.config.js

export default {
  define: {
    __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false,
  },
  // other Vite config settings
};
```

3. vue-cli

```js
//vue.config.js
const { defineConfig } = require("@vue/cli-service");
module.exports = defineConfig({
  transpileDependencies: true,
  chainWebpack: (config) => {
    config.plugin("define").tap((definitions) => {
      Object.assign(definitions[0], {
        __VUE_OPTIONS_API__: "true",
        __VUE_PROD_DEVTOOLS__: "false",
        __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: "false",
      });
      return definitions;
    });
  },
});
```

4. rollup

```js
//vue.config.js
const { defineConfig } = require("@vue/cli-service");
module.exports = defineConfig({
  transpileDependencies: true,
  chainWebpack: (config) => {
    config.plugin("define").tap((definitions) => {
      Object.assign(definitions[0], {
        __VUE_OPTIONS_API__: "true",
        __VUE_PROD_DEVTOOLS__: "false",
        __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: "false",
      });
      return definitions;
    });
  },
});
```

### 使用`unplugin-auto-import`实现模块自动导入

1. 安装

   > npm i unplugin-auto-import -D

2. 配置（以 vite+ts 为例）

   1. vite.config.js

      ```js
      import { defineConfig } from "vite";
      import vue from "@vitejs/plugin-vue";
      import ViteAutoImport from "unplugin-auto-import/vite";

      export default defineConfig({
        plugins: [
          ViteAutoImport({
            imports: ["vue", "vue-router"],
            dirs: ["src/api"], // 非第三方模块导入位置
            dts: "src/auto-imports.d.ts", // 手动指定生成文件位置
            eslintrc: {
              enabled: false, // 1、改为true用于生成eslint配置。2、生成后改回false，避免重复生成消耗
              filepath: "src/.eslintrc-auto-import.json", // 手动指定生成的eslintrc文件位置
            },
          }),
        ],
      });
      ```

   2. tsconfig.json

      ```json
      {
          "include": [
              "src/**/*.d.ts",
              "./*.d.ts",
              "src/auto-imports.d.ts" // 导入上一步生成的配置文件
          ],
      }
      ``

      ```

   3. .eslintrc.js

      完成 1 和 2 之后如果还报类似`reactive' is not defined`再改这里

      原因：未配置自动导入相应的 eslint 规则

      处理：通过 autoimport 中的配置生成对应 .eslintrc-auto-import.json 配置文件，并在 .eslintrc 中引入

      ```js
      extends: [
          './src/.eslintrc-auto-import.json'
      ],
      ```

      如果提示还是爆红，重新启动一下 vscode，运行起来的项目正常可用即可

### route 和 router 的区别

1. route

   是表示当前激活的路由对象，它包含了与当前路由相关的所有信息，主要包括

   1. path：当前路由的路径
   2. params：动态路径参数
   3. query：url 查询参数
   4. name：路由的名称
   5. meta：路由元信息
   6. matched：当前匹配的路由记录数组

2. router

   是`vue router`的实例，负责管理应用的路由。它包含了控制导航的各种方法，如跳转路由、导航守卫等。

   1. push：导航到一个新的 url
   2. replace：替换当前的 url
   3. go：类似浏览器的 history.go 方法
   4. beforeEach：注册全局前置导航守卫
   5. afterEach：注册全局后置导航守卫
   6. currentRoute：当前激活的路由对象

### 几种路由模式区别：hash、history、memory

1. hash 模式

1. 在实际 url 中存在一个`#`，会导致原本的`锚点`功能不可用，而且不美观
1. 这部分 url 从未实际发送到服务端，所以服务器不需要进行特殊处理
1. 对 seo 不友好

1. memory 模式

1. 不会与 url 进行交互，也不会自动触发初始导航，需要`app.use(router)`之后手动 push 到初始导航
1. 非常适合 node 环境和`ssr`
1. 不会有历史记录，所以无法前进和后退

1. history（html5）模式

1. 美观
1. 需要额外的服务器配置，否则会得到一个`404`错误
1. 原理是服务器添加一个回退路由，在不匹配任何资源的情况下，匹配到`index.html`

nginx 配置如下，其他配置参考[官网](https://router.vuejs.org/zh/guide/essentials/history-mode.html#nginx)

```shell
location / {
  try_files $uri $uri/ /index.html;
}
```

### vue3 `TypeError: Cannot read properties of null (reading 'insertBefore')`报错

本地运行是正常的，但是打包部署到服务器报错了

这个错误通常是由于在组件中使用了 `insertBefore` 方法时，试图插入到一个不存在的父节点导致的。您可以使用 `v-if` 指令或在 `JavaScript` 代码中进行 `null` 值检查来避免这种情况。

可能的一些原因

1. v-if 导致:（使用 v-show 替换了 v-if）
2. v-for 导致：
3. 数据初始化为 undefined，但是在模板中有调用或者渲染。

解决方案（选其一或者都选）

1. 升级`vue`版本，`vue@3.2.45`以上的版本解决了

2. 使用`v-show`替代`v-if`

3. `v-if`的每一步都做非空判断，如`v-if="a.b.c"`改为`v-if="a && a.b && a.b.c"`

### 在 router 中使用 pinia

官方文档的说明[https://pinia.vuejs.org/zh/core-concepts/outside-component-usage.html](https://pinia.vuejs.org/zh/core-concepts/outside-component-usage.html)

```js
import { createRouter } from "vue-router";
const router = createRouter({
  // ...
});

// ❌ 由于引入顺序的问题，这将失败
const store = useStore();

router.beforeEach((to, from, next) => {
  // 我们想要在这里使用 store
  if (store.isLoggedIn) next();
  else next("/login");
});

router.beforeEach((to) => {
  // ✅ 这样做是可行的，因为路由器是在其被安装之后开始导航的，
  // 而此时 Pinia 也已经被安装。
  const store = useStore();

  if (to.meta.requiresAuth && !store.isLoggedIn) return "/login";
});
```
