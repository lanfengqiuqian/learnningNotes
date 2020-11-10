<!--
 * @Date: 2020-08-31 14:47:26
 * @LastEditors: Lq
 * @LastEditTime: 2020-11-09 19:11:20
 * @FilePath: /learnningNotes/antd/index.md
-->
### 修改antd组件样式的几种方式
1. 直接在组件上添加类名，然后在css文件中添加样式；  
  直接在组件上写`style`；  
`但是很多情况下这种方式并不能生效，就要使用到下面的方式了`

##### 前提：先学会如何正确的找到组件的样式选择器
 


1. 全局修改（不添加选择器限定条件）  
   **特点：** 虽然你是在当前目录下的less或css文件修改了，但是全局生效的，建议如果有全局修改的需求，放到`global.less`的文件中修改，并做好注释。

    ```less
    // global.less

    // primary按钮修改背景色
    .ant-btn-primary {
      background-color: #346BF5;
    }
    // tab选项激活字体颜色
    .ant-tabs-nav .ant-tabs-tab-active {
      color: #346BF5;
    }
    // 修改左侧导航栏被选中样式
    .ant-menu.ant-menu-dark .ant-menu-item-selected, .ant-menu-submenu-popup.ant-menu-dark .ant-menu-item-selected {
      background-color: #346BF5;
    }
    ```

********************************

### 重置`DatePicker`组件

关键：给DatePicker设置一个key，在重置时将key置为`new Date()`

```js
<RangePicker key={dateKey} style={{width: '240px'}} onChange={dateOnChange} />

// 重置方法
setDateKey(new Date());
```

******************************

### 重置Select和Input

1. Select

    将`value`置为`undefined`

2. Input

    将`value`置为`''`

********************

### pagination组件指定了showQuickJumper属性但是没有生效

检查一下是不是手动加上了`pageSize`属性，如果手动加了`pageSize`属性的话，会无法显示快速跳转

*****************