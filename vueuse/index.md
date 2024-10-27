### 文档

<https://vueuse.pages.dev/guide/>

### vueuse 和 lodash 的区别

相同点：都是 js 开发中常用的工具库，但是他们的侧重点和用途有所不同

VueUse

1. 是专门为`vuejs`设计的工具集
2. 它提供了一系列与`vue2/vue3`兼容的`组合api`钩子，例如状态管理、数据操作、事件处理和网络请求等。
3. 特点是轻量级、易学易用，并且支持`tree sharking`，这意味着之需要打包实际使用的功能，有助于保持最终应用的体积小巧
4. 优势是为`vuejs`开发提供了专用的组件和功能，使得开发者可以更加便捷地使用`vue`的特性

lodash

1. 是一个更为通用的 js 工具库
2. 它提供了超过 400 个函数，涵盖了字符串操作、数组操作、对象操作、数学运算和集合处理等广泛领域
3. 特点是高性能和丰富的函数库，他的函数经过优化，以实现更高效的执行，适合处理各种数据和操作任务
4. 优势是提供了一个庞大的函数库，可以用于各种`js`应用开发，不仅限于`vuejs`

### 安装

> npm i @vueuse/core @vueuse/components

其中`@vueuse/components`是组件，不需要可以不引入

### 常用的一些 api

1. useDraggable

   ```html
   <template>
     <div ref="el" class="container" :style="style" style="position: fixed">
       拖动我！我在 {{ x }}，{{ y }} 的位置
     </div>
   </template>

   <script setup>
     import { ref } from "vue";
     import { useDraggable } from "@vueuse/core";

     const el = ref(null);
     const { x, y, style } = useDraggable(el, {
       initialValue: { x: 40, y: 40 },
     });
   </script>

   <style scoped>
     .container {
       width: 200px;
       height: 200px;
       background-color: pink;
     }
   </style>
   ```

   组件用法

   ```html
   <template>
     <UseDraggable v-slot="{ x, y }" :initial-value="{ x: 10, y: 10 }">
       拖动我！我在 {{ x }}，{{ y }} 的位置
     </UseDraggable>
   </template>
   ```

2. useClipboard: 用于处理剪贴板操作，可以轻松实现文本的复制和粘贴功能

3. useScriptTag: 动态加载外部脚本，可以在组件挂载时自动加载脚本，卸载时自动卸载

4. usePermission: 获取浏览器权限状态，例如麦克风或摄像头权限

5. useElementBounding: 获取 DOM 元素的位置和大小信息

6. useWindowScroll: 监听窗口滚动事件，获取滚动的 X 和 Y 坐标

7. useWindowSize: 监听窗口大小变化，获取窗口的宽度和高度

8. useIntervalFn 和 useTimeoutFn: 提供了方便的定时器功能，可以设置定时执行或延迟执行的函数

9. useStorage: 用于在本地存储中读写数据，同时保持响应式

10. debouncedWatch: 提供了防抖功能的 watcher，可以在数据变化后延迟执行某些操作

11. onClickOutside: 检测点击事件是否发生在元素外部

12. useFocusTrap: 用于创建焦点陷阱，确保焦点不会离开某个元素

13. useHead: 用于操作文档的 <head> 部分，例如动态添加样式或元标签

14. useVModel: 创建一个自定义的 v-model，用于在组件之间同步状态

15. useImage: 用于处理图片加载和错误状态

16. useDark: 用于检测和切换深色模式
