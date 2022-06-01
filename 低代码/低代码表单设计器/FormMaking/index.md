<!--
 * @Date: 2022-02-28 10:54:12
 * @LastEditors: Lq
 * @LastEditTime: 2022-04-27 11:50:39
 * @FilePath: \learnningNotes\低代码\低代码表单设计器\FormMaking\index.md
-->
### 资料

[官网](http://form.making.link/#/zh-CN/)

[在线演示网站-基础版](http://form.making.link/basic-version/#/zh-CN/)

[基础版-文档](https://gitee.com/gavinzhulei/vue-form-making/blob/master/docs/guide.zh-CN.md)

[在线演示网站-高级版](http://form.making.link/sample/#/zh-CN/)

[高级版-文档](https://www.yuque.com/ln7ccx/ntgo8q/cliyas)

### 版本对比

||	基础版本 |	高级版本 |
|-|-|-|
|功能 |	提供了一些基础表单控件，表单校验，获取数据等基础功能。|相较于基础版本，高级版本提供了更丰富的功能：页面更加美观|
|||通过点击即可快速添加字段；|
|||更多的属性设置，包括数据源与表单事件；|
|||更多的控件字段（子表单、自定义组件等）；|
|||更多的布局容器，并且可以相互嵌套（栅格、表格、标签页）；|
|||更多的API，满足更复杂的业务需求；|
|||加入自定义字段，可以快速将自己开发的组件引入；|
|||可快速添加自定义样式；|
|||支持数据源，方便表单数据配置；|
|||支持动作事件，可以让表单更加灵活配置；|
|||多终端适配展示；|
|||提供了  Ant Design 风格的组件（通过引入 antd vue 修改）；|
|演示地址 |	http://form.making.link/basic-version |	http://form.making.link/sample|
|是否开源 |	是|	否|
|使用协议 |	LGPL	|授权许可协议|
|是否能商用 |	否|	是|
|地址 |	Github 、Gitee	|官网|
|文档 |	Github	|官方文档|
|服务 |	不定期更新修复bug	|定期更新和修复bug|
|技术支持 ||相关意见将被我们作为首要考虑 |

#### 结果

由于我们项目中最需要的就是自定义表单设计器组件，所以我笔记中记录的就是高级版的。

### 起步准备工作

1. 将在`form-making`控制台下载的源码放到项目的`lib`目录下

    注意：如果你的项目没有`lib`目录的话，新建即可

    ```bash
    ├── lib                       # 项目lib目录，用于放置FormMaking产品
    │   │── vue-form-making       # 从网站下载的FormMaking程序包
    │   │   │── src				  # FormMaking 源码包，源码版本才有该目录										
    │   │   │── dist              # FormMaking 打包后的文件目录
    │   │   │── package.json	  # 配置文件
    ├── src                       # 项目代码
    ├── package.json              # package.json
    ├── vue.config.js             # vue-cli 配置
    ```

    完整版目录解析

    ```sh
    ├── public                                       # 静态资源
    │   │── lib                                      # 第三方插件库
    │   │── index.html                               # html模板
    ├── src                                          # 源代码
    │   │── assets                                   # 图片等静态资源
    │   │── components                               # 组件库
    │   │   │── AntdvGenerator                       # Ant Design Vue 生成器目录
    │   │   │── CodeEditor                           # 代码编辑器组件
    │   │   │── Editor                               # 富文本编辑器组件
    │   │   │── FormTable                            # 子表单生成器组件
    │   │   │── Upload                               # 上传组件
    │   │   │── CodeDialog.vue                       # 代码编辑器弹框组件
    │   │   │── componentsConfig.js                  # 设计器字段配置
    │   │   │── Container.vue                        # 设计器入口组件
    │   │   │── CusDialog.vue                        # 封装的公用的弹框组件
    │   │   │── FormConfig.vue                       # 设计器表单属性配置
    │   │   │── generateCode.js                      # 生成代码js文件
    │   │   │── GenerateColItem.vue                  # 生成栅格布局
    │   │   │── GenerateElementItem.vue              # 生成表单子项对应的组件
    │   │   │── GenerateForm.vue                     # 生成器入口组件
    │   │   │── GenerateFormItem.vue                 # 生成表单子项
    │   │   │── GenerateReport.vue                   # 生成表格组件
    │   │   │── GenerateTabItem.vue                  # 生成标签组件
    │   │   │── WidgetColItem.vue                    # 栅格设计组件
    │   │   │── WidgetConfig.vue                     # 设计器字段属性配置
    │   │   │── WidgetElementItem.vue                # 设计器表单子项内部详细组件
    │   │   │── WidgetForm.vue                       # 设计器表单设计区域
    │   │   │── WidgetFormItem.vue                   # 设计器表单子项设计
    │   │   │── WidgetReport.vue                     # 设计器表格组件
    │   │   │── WidgetTabItem.vue                    # 设计器标签组件
    │   │   │── WidgetTable.vue                      # 设计器子表单组件
    │   │   │── WidgetTableItem.vue                  # 设计器子表单内部组件
    │   │── demo                                     # 示例demo
    │   │   │── CustomComponent.vue                  # 演示自定义组件
    │   │   │── Home.vue                             # 演示设计器
    │   │   │── Test.vue                             # 测试功能
    │   │── directive                                # 全局指令
    │   │── iconfont                                 # iconfont 字体库
    │   │── lang                                     # 国际化配置
    │   │── router                                   # 路由
    │   │── styles                                   # 全局样式
    │   │── util                                     # 全局公用方法
    │   │── App.vue                                  # 入口页面
    │   │── editorBundle.js                          # 打包 VueEditor
    │   │── index.js                                 # 设计器打包入口
    │   │── main.js                                  # 入口文件 加载组件 初始化等
    ├── package.json                                 # package.json
    ├── vue.config.js                                # vue-cli 配置
    ```

2. 引入`Vue`完整版本

    在`vue.config.js`文件中

    ```js
    chainWebpack: config => {
        config.resolve.alias.set('vue$', 'vue/dist/vue.esm.js')
    }
    ```

3. 安装和引入`element-ui`

    > yarn add element-ui

    然后在项目的`main.js`文件中引入和全局注册

    ```js
    import ElementUI from 'element-ui';
    import 'element-ui/lib/theme-chalk/index.css';

    Vue.use(ElementUI);
    ```

4. 引入`FormMaking`

    在`main.js`文件中

    ```js
    import FormMaking from '@/lib/vue-form-making'
    import '@/lib/vue-form-making/dist/FormMaking.css'

    Vue.use(FormMaking)
    ```

5. 官方文档中有要修改`babel`配置的，但是我这里没有做更改

    两种方式根据自己项目情况选择一种就行

    ```js
    // 在package.json中如下配置，适用于项目babel配置在package.json中
    "babel": {
    "sourceType": "unambiguous"
    }

    // 在 babel.config.js 中如下配置，适用于项目 babel 配置在单独的 babel.config.js 文件中
    module.exports = {
    sourceType: 'unambiguous'
    }
    ```

6. demo页面使用

    ```js
    <template>
    <fm-making-form 
        ref="makingform" 
        style="height: 500px;" 
        preview 
        generate-code 
        generate-json
    >
    </fm-making-form>
    </template>
    ```

### 修改代码配置

1. 几个踩过的坑

    1. 说明：由于组件直接引用的是`dist`中的代码，而不是`src`中的代码，所以每次改动都需要重新打包才能够生效

    2. 需要本地安装了`vue-cli`：`npm install -g @vue/cli`

    3. 然后需要给这部分安装`node_modules`，可以看到这部分源码是有`package.json`和`dist`的，但是给你的包是没有`node_modules`

        不过如果没有修改代码的需求是不用修改的，直接正常引用dist就好

    4. 然后需要使用在源码根目录（注意不是项目根目录哦）进行打包：`npm run build-bundle`

        这里如果失败（我自己失败了好几种情况），进行下面几种方式的尝试

        1. 删除`node_modules`之后重新安装然后打包

        2. 如果还不行，使用`npm`进行安装，不要使用`cnpm`和`yarn`
    
    5. 这边成功打包好了`dist`之后，你的项目理论上来说会重新更新构建

        但是不排除会报错，说某些模块或者文件找不到，这种情况将项目重启即可（我也是这种情况）

2. 根据上述步骤，`dist`里面有了你改动之后的代码之后就可以正常看到生效了

3. 修改的几种配置文件路径

    1. 表单属性：设计器右侧的【表单属性】、【字段属性】

        1. `src/components/Container.vue`：增加配置（增加字段）

            ```js
            export default{
            data () {
                return {
                widgetForm: {
                    list: [],
                    config: {
                    // 在此处扩展表单的配置信息，例如：
                    // width: '100%'
                    },
                }
                }
            }
            }
            ```

        2. `src/components/FormConfig.vue`：在表单设计器中增加ui组件（为增加的字段赋值）

            ```html
            <el-form>
            <el-form-item label="宽度" >
                <el-input v-model="data.width" clearable></el-input>
            </el-form-item>
            </el-form>
            ```

        3. `src/components/GenerateForm.vue`：设计器生成的表单如何渲染（将增加的字段值用于控制表单）

            ```html
            <div :style="{width: data.config.width}" class="fm-form">...</div>
            ```

    2. 表单组件：设计器左侧的【表单组件】

        1. `src/components/componentsConfig.js`：增加新的组件配置（增加字段）

            ```js
            {
                type: 'input', // 组件类型，保持唯一
                name: '单行文本', //组件展示名称
                icon: 'icon-input', //组件展示icon, 如果需要自定义，请参考 如何自定义图标
                options: { // 组件配置信息，根据自定义组件自己添加配置
                    defaultValue: '', // 该值表示组件的默认值
                    // 根据自己的组件自定义添加配置参数
                }
            }
            ```

            `src\lang\zh-CN.js`：增加对于该组件的中文名称定义（之后的组件属性的中文名也在这里设置）

        2. `src/components/Container.vue`：在表单设计器中左侧拖拽组件中增加该组件

            ```js
            export default {
            props: {
                basicFields: {
                type: Array,
                default: () => ['input']
                }
            }
            }
            ```
        
        3. 这里需要额外增加一步，就是在`src/components`下新建一个目录或文件，用于定义你新增加的组件


        4. `src/components/WidgetElementItem.vue`：引用组件，即拖拉拽组件在设计器中该如何渲染

            ```html
            <template v-if="element.type == 'input'">
            <custom-compontnets
                v-model="element.options.defaultValue"
            ></custom-compontnets>
            </template>

            <script>
            import CustomComponent from '...'
            export default {
                components: {
                    CustomComponent
                }
            }
            </script>
            ```

        5. `src/components/WidgetConfig.vue`：为表单组件增加属性配置

            > 参考前面表单属性配置

        6. `src/components/GenerateElementItem.vue`：引用上一步中增加的组件，生成器生成的该表单组件如何渲染

            ```html
            <template v-if="widget.type == 'input'">  
            <div :style="{width: isTable ? '100%' : widget.options.width}">
                <custom-compontnets v-model="dataModel"></custom-compontnets>
            </div>
            </template>

            <script>
            import CustomComponent from '...'
            export default {
                components: {
                    CustomComponent
                }
            }
            </script>
            ```

    3. 需要补充的是，中文描述位于`lib\vue-form-making\src\lang\zh-CN.js`这个文件里面

    4. 布局组件（也是表单组件的一种）

        我这里是按照`inline`行内组件的实现方式进行模仿的，是个很好的主意

        前几步同表单组件

        1. `src/components/componentsConfig.js`：增加新的组件配置（增加字段）

        2. `src/components/Container.vue`：在表单设计器中左侧拖拽组件中增加该组件

        3. `zh-CN.js`：增加对应的中文描述

        接下来新的几个步骤

        设计器相关

        1. `src\components\FormMaking`目录下新增设计器组件实现文件，如：`src\components\FormMaking\WidgetCard.vue`

        2. `src\components\FormMaking\WidgetColItem.vue`：生成器栅格设计增加该组件的引用和渲染

        3. `src\components\FormMaking\WidgetConfig.vue`：生成器组件配置文件加该组件的渲染

        4. `src\components\FormMaking\WidgetForm.vue`：生成器表单设计区域增加该组件的引用和渲染

        5. `src\components\FormMaking\WidgetReport.vue`：生成器表格增加该组件的引用和渲染

        6. `src\components\FormMaking\WidgetTabItem.vue`：生成器标签增加该组件的引用和渲染

        7. `src\components\FormMaking\WidgetReport.vue`：生成器子表单增加该组件的引用和渲染


        生成器相关

        1. `src\components\FormMaking`目录下新增生成器组件实现文件，如：`src\components\FormMaking\GenerateCard.vue`

        2. `src\components\FormMaking\GenerateForm.vue`：生成器入口组件中增加该组件

        3. `src\components\FormMaking\GenerateColItem.vue`：生成栅格布局组件中增加该组件

        4. `src\components\FormMaking\GenerateReport.vue`：生成表格组件组件中增加该组件

        5. `src\components\FormMaking\GenerateTabItem.vue`：生成器标签组件中增加该组件

        样式相关

        1. `styles/index.cscc`：样式文件里面需要增加相应的样式

        生成代码相关

        1. `src\components\FormMaking\generateCode.js`：生成代码里面增加对于容器组件的判断

### 表单的校验配置实现方式

1. 设计器组件的配置设置组件校验字段配置：`src/components/WidgetConfig.vue`

    这里是：右边设置的字段配置

    搜索这一段代码：`<el-form-item :label="$t('fm.config.widget.validate')">`，大概在1400行左右

2. 设计器组件规则的相关生成函数：`src/components/WidgetConfig.vue`

    这里是将设置的字段配置进行校验和整理为一个数组

    1. validateRequired
   
    2. validateDataType

    3. valiatePattern

    4. generateRule

3. 生成器组件规则整理为`element-ui`中form需要的格式

    1. 文件位置：`src/components/GenerateForm.vue`

    2. 格式化函数：`generateModel`

    3. 使用位置：`el-form`组件的`rules`属性

    4. `rules`规则使用的是`element`的`form`的rules，具体在[https://github.com/yiminghe/async-validator](https://github.com/yiminghe/async-validator)


### 一些小技巧

1. 表单校验首次清空之后多了英文提示

    原因：`elemenet-ui`的`el-form-item`组件中如果`require`属性为`true`的话会对于这个表单绑定的字段进行校验，但是实际上我们一般情况下都是对于表单里面的具体组件进行添加校验规则的，这里就重复且多余了，就会多一条默认的英文提示

    解决：因为我们自己添加了自定义的精确到表单具体组件的校验规则，那么


2. this.setData()方法在只读模式下不生效

    官方文档少了一个参数的，代码里面支持第二个参数（这个参数表示是否在只读模式下执行setData，默认是true表示不执行）

    ```js
    setData(value, addOnly = true) { // addOnly 仅编辑状态下执行
      if (!addOnly || this.edit) {
        Object.keys(value).forEach((item) => {
          this.$set(this.models, item, value[item]);
        });
      }
    }
    ```

    调整后使用如下

    ```js
    // 原来的使用
    this.setData({name: 123});

    // 现在的使用
    this.setData({name: 123}, false);
    ```

3. 更改了`componentsConfig`这个文件的配置的话，最好重启一下项目，有时候不生效