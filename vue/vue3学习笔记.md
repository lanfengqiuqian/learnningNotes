[pop]

#### 基础概念

1. 选项式API和组合式API

    选项式API：包含多个选项的对象来描述组件的逻辑，如data、methods、mounted，选项所定义的属性都暴露在函数内部的this上，它会指向当前组件的实例

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

    组合式API：通常和`<script setup>`一起使用，`setup`是一个标识，告诉Vue需要在编译的时候进行处理，让我们更简洁地使用组合式API

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

1. setup函数

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

    `setup`函数中访问`this`将会是`undefined`，因为`setup`自身不包含对组件实例的访问权。你可以在选项式API中访问

    `props`是setup的第一个参数，他是响应式的，但是如果你进行了解构，那么就会丢失响应式。如果的确需要进行解构使用，那么需要使用`toRefs`或`toRef`

2. 具名插槽

    1. 【#reference】
    2. 【v-slot:reference】
    3. 【slot="reference"】

    1和2等价
    2的动态插槽写法：【v-slot:[test]】
    3是很老的一种写法

3. 在tsx中使用插槽

    可参见[https://blog.csdn.net/qq_24719349/article/details/116724681](https://blog.csdn.net/qq_24719349/article/details/116724681)

    ```jsx
    const columns = [{
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
                    )
                }
            }
            return (<>
                <el-button type="primary" v-slots={slots} loading>
                </el-button>
            </>)
            // 另外一种写法
            return (<>
                <el-button type="primary" loading>
                    {slots}
                </el-button>
            </>)
        }
    }]
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
    </el-dropdown>
    ```

4. element-ui和element-plus区别

    1. 对应的vue版本不同

        element-ui对应Vue2，element-plus对应Vue3

    2. 手机版

        element-ui没有考虑手机版的展示，element-plus考虑了手机版的展示

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

5. composable应用

    场景：有需要复用的属性或方法

    注意：在composable中不能使用组件，但是在组件中可以使用composable

    ```js
    import { ref, onMounted, onUnmounted } from 'vue'

    export function useMouse() {
        const x = ref(0);
        const y = ref(0);
        
        onMounted(() => window.addEventListener("mousemove", update))
        onUnmounted(() => window.removeEventListener("mousemove", update))
        
        const update = ({pageX ,pageY}) => {
        x.value = pageX;
        y.value = pageY;
        }
        
        return { x, y }
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
                withDefaults: "readonly"
            }
        }
        ```

    3. [eslint-plugin-vue](https://eslint.vuejs.org/user-guide/#compiler-macros-such-as-defineprops-and-defineemits-generate-no-undef-warnings)官方的解决方法

        ```js
        // .eslintrc.js
        module.exports = {
            env: {
                browser: true,
                es2021: true,
                // 添加：
                'vue/setup-compiler-macros': true
            }
        }
        ```

7. 解决template标签提示报错

    ```js
    typeScript intellisense is disabled on template. To enable, configure `"jsx": "preserve"` in the `"compilerOptions"` property of tsconfig or jsconfig. To disable this prompt instead, configure `"experimentalDisableTemplateSupport": true` in `"vueCompilerOptions"` property
    ```

    解决方法：要启用template需要在`jsconfig.json`的`compilerOption`属性中配置`"jsx":"preserve"`

8. 自定义组件使用v-model

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
            defineProps(['modelValue'])
            defineEmits(['update:modelValue'])
        </script>

        // 父组件
        <Child v-model="hello" />
        ```

    2. 想要更改子组件的`modelValue`参数名

        ```html
        // 子组件
        <script>
            defineProps(['title'])
            defineEmits(['update:title'])
        </script>
        
        // 父组件
        <MyComponent v-model:title="bookTitle" />
        ```

    3. 多个model绑定

        ```html
        // 子组件
        <script setup>
            defineProps({
                firstName: String,
                lastName: String
            })
            defineEmits(['update:firstName', 'update:lastName'])
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
        <UserName
            v-model:first-name="first"
            v-model:last-name="last"
        />

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
    import { ref } from 'vue'
    import One from './component-tabs/one.vue'
    import Two from './component-tabs/two.vue'
    import Three from './component-tabs/three.vue'

    const currentComponent = ref(One)

    const obj = {One, Two, Three}

    const changeHandle = (type) => {
        console.log('进入了type')
        currentComponent.value = obj[type]
    }

    </script>
    ```

    报错如下

    ```js
    Vue received a Component which was made a reactive object. This can lead to unnecessary performance overhead, and should be avoided by marking the component with `markRaw` or using `shallowRef` instead of `ref`
    ```
    
    原因是`component`的`is`属性值虽然可以是组件名字符串也可以是组件本身，但是更推荐使用组件名字符串

    修改如下两行即可

    ```js
    const currentComponent = ref('One')
    currentComponent.value = type
    ```

11. 在`<script setup>`中要使用动态组件`component`的`is`属性，使用组件名字符串无效

    原因：在vue3中，组件被引用为变量，而不是字符串键来注册的

    解决方案：需要使用`组件变量`，而不是使用字符串

    详见[https://blog.csdn.net/xxcmyh/article/details/122083315](https://blog.csdn.net/xxcmyh/article/details/122083315)

    [官方文档](https://cn.vuejs.org/api/sfc-script-setup.html#using-components)

10. vue2和vue3组件局部注册区别

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

13. vue-loader中出现的错误：You may need an additional loader to handle the result of these loaders.

    表现在`script`标签中使用`lang=ts`就报错

    原因：创建的项目没有勾选ts选项

    解决：要么重新建一个项目，要么看这个[https://blog.csdn.net/qq_61672548/article/details/125506231](https://blog.csdn.net/qq_61672548/article/details/125506231)

14. vue3+ts报错error Insert `⏎` prettier/prettier

    > npm run lint --fix

15. KeepAlive组件的使用

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
    import { defineProps, ref } from 'vue'
    import OneCom from './OneCom.vue'
    import TwoCom from './TwoCom.vue'

    const comObj = { OneCom, TwoCom }

    const showComponent = ref('OneCom');

    const toggleHandle = () => {
    if (showComponent.value === 'OneCom') {
        showComponent.value = 'TwoCom';
    } else {
        showComponent.value = 'OneCom';
    }
    }
    </script>
    ```

16. TSX语法的类型推导支持

    需要在`tsconfig.json`中配置了`"jsx": "preserve"`，这样就能保证Vue的JSX语法编译过程的完整性

17. vue3+tsx的一些写法

    [https://www.jianshu.com/p/d484ad785299](https://www.jianshu.com/p/d484ad785299)

    官方文档见[https://cn.vuejs.org/guide/extras/render-function.html#passing-slots](https://cn.vuejs.org/guide/extras/render-function.html#passing-slots)

18. vite项目改为vue-cli

    可参考这两篇进行反向迁移

    > https://www.csdn.net/tags/MtTaMgzsODIxMzAxLWJsb2cO0O0O.html  
    > https://juejin.cn/post/7012494586664714248

    1. 将package.json中的依赖替换，运行script也替换
        1. 这里直接是全部替换，没有修改
        2. 删除type: “module”
        3. 除了和vite相关的依赖之外的依赖不要删掉了，如pinia、axios等

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
            "browserslist": [
                "> 1%",
                "last 2 versions",
                "not dead",
                "not ie 11"
            ]
        }
        ```

    2. 将配置项进行全部替换
        1. 增加babel.config.js
        ```js
        module.exports = {
            presets: [
                '@vue/cli-plugin-babel/preset'
            ]
        }
        ```
        2. 替换tsconfig.json
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
                "types": [
                "webpack-env",
                "jest"
                ],
                "paths": {
                "@/*": [
                    "src/*"
                ]
                },
                "lib": [
                "esnext",
                "dom",
                "dom.iterable",
                "scripthost"
                ]
            },
            "include": [
                "src/**/*.ts",
                "src/**/*.tsx",
                "src/**/*.vue",
                "tests/**/*.ts",
                "tests/**/*.tsx"
            ],
            "exclude": [
                "node_modules"
            ]
        }
        ```
        3. 增加vue.config.js
        ```js
        const { defineConfig } = require('@vue/cli-service')
        const { VantResolver } = require('unplugin-vue-components/resolvers');
        const ComponentsPlugin = require('unplugin-vue-components/webpack');

        module.exports = defineConfig({
            transpileDependencies: true,
            configureWebpack: {
                plugins: [
                ComponentsPlugin({
                    resolvers: [VantResolver()],
                }),
                ],
            },
        })

        ```
        4. 删除vite.config.ts
        5. 删除tsconfig.node.json
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
                "no-debugger": process.env.NODE_ENV === "production" ? "warn" : "off",
                "@typescript-eslint/no-explicit-any": ["off"]
            },
        };
        ```
    3. 替换index.html并放到public中
        1. vite的index.html在根目录
        2. vuecli在public
        3. 内容也不大一样
    4. 删除src/vite-env.d.ts




    过程中遇到的一些问题

    1. ESLint is not a constructor

        原因：eslint的版本低了，需要`>= 7`，仅更换`eslint`这一个依赖即可

    2. /bin/sh: vue-cli-service: command not found

        原因：依赖出问题了，或者其他原因，我这里单纯的是复制的时候把`@vue/cli-service`漏掉了

    3. Component name "Detail" should always be multi-word

        原因：组件名称需要使用`连字符`，如`hello-world`

        可参考[https://blog.csdn.net/qq_57587705/article/details/124674660](https://blog.csdn.net/qq_57587705/article/details/124674660)

    4. 报了个警告：`the ＞＞＞ and /deep/ combinators have been deprecated. Use :deep() instead.`

        将css的写法改一下即可

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

### element datepicker设置时间段禁用

```html
<el-date-picker
    type="daterange"
    v-model="date"
    range-separator="To"
    start-placeholder="Start date"
    end-placeholder="End date"
    :disabled-date="pickerOptions"
/>

const date = ref([]);
const pickerOptions = (time) => {
  return (
    new Date("2022-11-01").getTime() <= time.getTime() &&
    time.getTime() <= new Date("2022-12-01").getTime()
  );
};
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
