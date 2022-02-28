#### 资料

1. form-create-designer

    1. [文档](http://designer.form-create.com/guide/)

    2. [github仓库](https://github.com/xaboy/form-create-designer)

    3. [在线演示地址](http://www.form-create.com/designer/?fr=de)

2. form-create

    1. [文档](http://www.form-create.com/v2/guide/)

    2. [github仓库](https://github.com/xaboy/form-create)

3. 补充说明：`form-create-designer`的文档很简单，需要结合`form-create`来使用



#### 寻找form-create和form-create-designer的关系

1. 关系

    1. 官方说明：form-create-designer 是基于 @form-create/element-ui 实现的表单设计器组件

        我的理解：就是`form-create`里面的有3套支持的ui库，这个`designer`是基于`element-ui`这个ui库实现的

    2. 我尝试了手动建立两个空的npm仓库，分别安装这两个依赖，form-create的安装同样选择element-ui的版本的，和form-create-designer对比一下nodemodules之后，发现

        1. 同样都安装了`@form-create`这个模块，不同的是`form-create-designer`这个里面多了`designer`这个子模块

        2. `form-create-designer`还多了一些其他的模块，如`@babel`/`wangeditor`等，也验证了就是在`form-create`这个库基础上开发出来的

        3. 真正运行代码的时候，`form-create-designer`还需要自己手动导入`element-ui`这个库和对应的css文件，但是`form-create`却是不需要的

    3. 验证`form-create-designer`能否改为其他的ui库

        在引用`designer`的模块中

        `import FcDesigner from '@form-create/designer'`

        发现他就是在`@form-create`的其中一个模块，然后第一行就指明了是`element-ui`

        `import {Rule} from "@form-create/element-ui";`

        然后再当前模块中全局搜索`element-ui`和`ant-design-vue`，发现前者有很多，但是后者找不到，后者尝试别的关键字也是如此

        那么我认为这么可以说明不能，或者说是不能简单的直接改为`ant-design-vue`的，另外一套组件库也是同理

    4. 验证`form-create`能否同时支持使用多套ui库

        代码生成器导出来的模块引用都是使用`formCreate`这个组件进行注册和使用

        ```js
        import formCreate from '@form-create/element-ui'
        import formCreate from '@form-create/ant-design-vue'
        ```

        我尝试更改为其他的不重复的名称，发现报错，因为`node_modules`中好像是不允许更改，改了就会报红，这里我暂时还没看明白

        暂时结论：大致好像就是不能随便改换名字，所以暂时不研究如何支持多套ui库


2. 对于两个库的个人理解

    1. form-create

        1. 他是只能使用手写代码的方式去创建页面，不支持拖拉拽

        2. 支持的ui库比较多，可以灵活切换适合自己的，但是同时只能支持一套库

        3. 支持Vue3

    2. fomr-create-designer

        1. 支持在页面上拖拉拽的方式创建配置表单

        2. 也支持导入和导出json的方式渲染为vue页面（好像是需要额外引入第三方库）

        3. 文档很简单，需要结合`form-create`的文档看


3. 仓库说明

    @form-create/core `表单生成组件核心包`

    @form-create/iview `iview版表单生成组件`

    @form-create/iview4 `view-design版表单生成组件`

    @form-create/element-ui `element-ui版表单生成组件`

    @form-create/ant-design-vue `ant-design-vue版表单生成组件`

    @form-create/designer `可视化表单设计器`

    @form-create/utils `助手方法`

    @form-create/data `省市区联动数据`


#### 开始使用form-create-designer

1. 概念

    1. rule：表单设计器区域生成表单的生成规则（是一个数组）

    2. json：表单设计器区域生成表单的生成规则（是rule的json形式）

    3. options：表单设计器区域生成表单的表单配置（是一个对象）

2. 大致原理

    1. 使用表单设计器`fc-designer`设计好表单之后，会生成两个配置json数据

        1. 整个表单的全局配置

        2. 表单的每一个控件的配置信息

    2. 想要重新编辑设计过的表单，只需要将两个json重新设置回去即可

    3. 要在页面上回显设计的表单，需要使用`form-create`的渲染模块

        这个渲染模块最好仍然使用`element-ui`的，用其他的ui库虽然好像也能用，但是会有小bug，因为生成的时候就是用`element-ui`进行生成的

        PS：我开始引用的时候引用错了渲染模块，结果使用的`ant-design-vue`渲染的表单，发现有点小bug，比如颜色选择器和树形选择器组件有问题

3. 使用步骤

    1. 安装`form-create-designer`和`element-ui`：`npm i @form-create/designer; npm i element-ui`

    2. 在`main.js`中引入和全局注册

        ```js
        import formCreate from '@form-create/element-ui'
        import FcDesigner from '@form-create/designer'
        import ELEMENT from 'element-ui'
        import 'element-ui/lib/theme-chalk/index.css'

        Vue.use(formCreate)
        Vue.use(FcDesigner)
        Vue.use(ELEMENT)
        ```

    3. 在`demo.vue`页面中直接使用

        ```html
        <fc-designer ref="designer" />
        ```

4. 方法

    1. getRule

        获取设计器表单区域生成表单的生成规则

        ```js
        // 方法定义
        type getRule = () => Rule[]
        // 方法使用
        const rule = vm.$refs.designer.getRule()
        ```

    2. setRule

        设置设计器表单区域表单的生成规则

        ```js
        // 方法定义
        type setRule = (rule:Rule[]) => void
        // 方法使用
        const rule = [{"type":"input","field":"eeb1lcwnhehiu","title":"输入框","info":"","_fc_drag_tag":"input","hidden":false,"display":true}]
        vm.$refs.designer.setRule(rule)
        ```

    3. getOption

        获取设计器表单区域生成表单的表单配置

        ```js
        // 方法定义
        type getOption = () => {form:Object}
        // 方法使用
        const option = vm.$refs.designer.getOption()
        ```

    4. setOption

        设置设计器表单区域表单的生成规则

        ```js
        // 方法定义
        type setOption = (option: {form:Object}) => void
        // 方法使用
        const option = {
            "form": {
                "labelPosition": "right",
                "size": "mini",
                "labelWidth": "125px",
                "hideRequiredAsterisk": false,
                "showMessage": true,
                "inlineMessage": false
            }
        }

        vm.$refs.designer.setOption(option)
        ```

    5. getJson

        获取设计器表单区域生成表单的JSON规则

        ```js
        // 方法定义
        type getJson = () => string
        // 方法使用
        const json = vm.$refs.designer.getJson()
        ```

    6. addMenu

        在设计器左边组件区域中插入一组拖拽组件

        ```js
        // 方法定义
        type addMenu = (menu: Menu) => void
        ```

    7. removeMenu

        在设计器左边组件区域中删除一组拖拽组件

        ```js
        // 方法定义
        type removeMenu = (name: string) => void
        ```

    8. setMenuItem

        在设计器左边组件区域组件分组中批量覆盖插入拖拽组件

        ```js
        // 方法定义
        type setMenuItem = (menuName: string, items: MenuItem[]) => void
        ```

    9. appendMenuItem

        在设计器左边组件区域组件分组中插入一个拖拽组件

        ```js
        // 方法定义
        type appendMenuItem = (menuName:string, item: MenuItem) => void
        ```

    10. removeMenuItem

        在设计器左边组件区域中删除一个拖拽组件

        ```js
        // 方法定义
        type removeMenuItem = (menu: string | MenuItem) => void
        ```

    11. addComponent

        新增一个拖拽组件的生成规则

        ```js
        // 方法定义
        type addComponent = (item: DragRule) => void
        ```

#### 自定义组件的探索

0. 计划的探索步骤

   1. 能够一模一样的复制一个组件并进行拖拉拽和渲染
   2. 能够手动写死更改一些他的属性，如图标、名称、文案等
   3. 能够在属性设置区域手动更改简单的属性，并在组件上面生效
   4. 能够改换一个原本不存在左侧区域的，但是在element-ui库中的组件出来
   5. 能够自己写一个组件，并引用进来进行拖拉拽和基本属性设置（纯展示组件）
   6. 设计器设计的组件，能够支持手动输入信息，并获取输入的信息用于提交（可输入组件）
   7. 一些更复杂的配置信息，如远程数据，
   8. 设计增加更复杂的一些组件，如动态列表、子表格、用户组件等
   9. 集成如SpreadJS的自定义组件进来

1. 字段说明

    | 字段名   | 说明                       | 类型           |
    | -------- | -------------------------- | -------------- |
    | name     | 组件名称，也是引用的标志符 | string         |
    | label    | 显示在组件上面的中文名称   | string         |
    | rule     | 获取组件生成规则的方法     | Function       |
    | props    | 获取组件配置规则的方法     | Function       |
    | children | 子组件名称                 | string         |
    | drag     | 是否可以拖入组件           | string Boolean |
    | dragBtn  | 是否显示拖拽按钮           | Boolean        |
    | icon     | 图标                       | string         |

    示例

    ```js
    const label = '用户信息';
    const name = 'user-info';
    let i = 1;
    const uniqueId = () => `uni${i++}`;

    const userInfo = {
        icon: 'el-icon-ship',
        label,
        name,
        rule() {
            return {
                type: name,
                field: 'userinfo-demo',
                // field: uniqueId(),
                title: label,
                info: '',
                effect: {
                    fetch: ''
                },
                props: {
                    nameLabel: '姓名标签',
                    ageLabel: '年龄标签',
                    idcardLabel: '身份证标签',
                },
                on: {
                    'on-change': function(el){
                        console.log('user-info 发生变化', el);
                    }
                }
            };
        },
        props() {
            return [{
                type: 'input',
                field: 'nameLabel',
                title: '姓名标签',
                props: {
                    value: '张三'
                },
                emit: ['change']
            }, {
                type: 'number',
                field: 'ageLabel',
                title: '年龄标签',
                props: {
                    value: 12,
                    disabled: true
                },
                emit: ['change']
            }, {
                type: 'input',
                field: 'idcardLabel',
                title: '身份证标签',
                props: {
                    placeholder: '请输入身份证号码',
                    suffixIcon: 'el-icon-delete'
                },
                emit: ['change']
            }, ];
        }
    };

    ```


2. rule属性说明

    |属性|说明|示例|
    |-|-|-|
    |type|组件名称（Vue组件挂在名称或者是内置组件名称|input\|el-input|
    |title|组件的标题（拖出来的组件的label）|这里是标题|
    |info|组件的提示信息（在label上）||
    |field|组件的字段名||
    |value|组件的字段值||
    |props|组件的属性，作为参数传给组件的|{disabled: true, value: 'hello'}|
    |children|组件的插槽配置|[{type:'i',class: '',solt: 'prefix'}]|
    |options|设置radio,select,checkbox等组件option选择项|[{label:'one',value:1}]|
    |validate|验证规则||
    |control|通过组件的值控制其他组件是否显示|配置说明见[文档](http://www.form-create.com/v2/guide/control.html)|
    |col|布局规则||
    |on|组件的事件||
    |prefix、suffix |组件的前缀、后缀||



1. props属性说明（这个props是和rule同级的，而不是rule中return对象的props）

    1. 这个属性用于配置的是`组件配置`中的`属性配置`，对于`基础配置`和`验证规则`没有影响
    2. 返回值是一个对象数组，格式为
        ```js
        // 示例
        [{
            type: 'switch', // 配置组件在表单设计器中展示的类型
            field: 'type', // 字段标志
            title: '按钮类型', // 字段中文标志
            props: { // 整个展示组件本身有的属性
                activeValue: 'button',
                inactiveValue: 'default'
            }
        }]
        ```

    3. props从远端获取数据

        1. 案例一，自定义下拉框的数据从远端获取

            ```js
            rule() {
                return {
                    type: 'select',
                    field: 'city',
                    title: '城市',
                    value: '',
                    options: [],
                };
            },
            props() {
                return [FcDesigner.makeOptionsRule('options')];
            }
            ```

            PS：`FcDesigner.makeOptionsRule`函数说明

                1. 会返回一套固定的属性配置，是静态数据和远端数据选项

                2. 参数是指`options`映射到`rule`中的哪个属性中，因为示例中的`select`组件自带有`options`，所以直接写`options`即可

        2. 案例二，从远端获取到数据之后自己渲染成列表，不是使用默认的`select`

            ```js
            rule() {
                return {
                    type: name,
                    field: uniqueId(),
                    title: label,
                    info: '这里是提示信息',
                    props: {
                        listData: [],
                    },
                };
            },
            props() {
                return [FcDesigner.makeOptionsRule('props.listData')];
            }
            ```

            ```html
            <template>
            <div>
                <h2>列表渲染</h2>
                <div v-for="item in listData" :key="item.label">
                    <div>{{item.label}}-{{item.name}}</div>
                </div>
            </div>
            </template>

            <script>

            export default {
                name: 'listData',
                props: {
                    listData: Array
                },
            }
            </script>
            ```



#### 小技巧

1. 在示例中的代码都是在`created`生命周期函数中初始化的，但是这个时候还没有挂载上`$refs`

    解决方案，将初始化代码放到`mounted`生命周期中

    ```js
    // 会报错，因为this.$refs为undefined
    created(){
        this.$refs.designer.setRule(FcDesignerRule);
        this.$refs.designer.setOption(FcDesignerOption);
    }

    // 放到mounted中
    mounted(){
        this.$refs.designer.setRule(FcDesignerRule);
        this.$refs.designer.setOption(FcDesignerOption);
    }
    ```

2. 在`Vue`文件中直接使用`vm`报错

    ```js
    // 错误
    vm.$refs.designer.getRule()

    // 改为使用this进行引用
    this.$refs.designer.getRule()
    ```
