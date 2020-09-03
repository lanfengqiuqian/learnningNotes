#### 修改antd组件样式的几种方式
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


##### 可控组件与不可控组件
介绍：