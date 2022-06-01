<!--
 * @Date: 2022-02-23 15:55:03
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-25 15:20:14
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\CustomComponent.vue
-->
<template>
  <div>
    <div>
      <fc-designer ref="designer" height="1000px" />
    </div>
    <h2>测试组件</h2>
    <br />

    <div>
      <button @click="output">显示并保存配置</button>
    </div>
    <h2>rule</h2>
    <h3>{{ rule }}</h3>
    <h2>json</h2>
    <h3>{{ json }}</h3>
    <h2>option</h2>
    <h3>{{ option }}</h3>
  </div>
</template>

<script>
import checkbox from "./customComponent/demo/checkbox";
import tag from "./customComponent/demo/tag";
import fetch from "./customComponent/demo/fetch";
import hello from "./customComponent/hello/hello";
import userInfo from "./customComponent/userInfo/userInfo";
import list from "./customComponent/list/list";

export default {
  name: "app",
  data() {
    return {
      rule: "",
      json: "",
      option: "",
      num: 5
    };
  },
  created() {},
  mounted() {
    // checkbox
    //插入组件规则
    this.$refs.designer.addComponent(checkbox);
    //插入拖拽按钮到`main`分类下
    this.$refs.designer.appendMenuItem("main", {
      icon: checkbox.icon,
      name: checkbox.name,
      label: checkbox.label,
    });

    // el-tag
    //插入组件规则
    this.$refs.designer.addComponent(tag);
    //插入拖拽按钮到`main`分类下
    this.$refs.designer.appendMenuItem("main", {
      icon: tag.icon,
      name: tag.name,
      label: tag.label,
    });

    // fetch
    //插入组件规则
    this.$refs.designer.addComponent(fetch);
    //插入拖拽按钮到`main`分类下
    this.$refs.designer.appendMenuItem("main", {
      icon: fetch.icon,
      name: fetch.name,
      label: fetch.label,
    });

    // hello
    //插入组件规则
    this.$refs.designer.addComponent(hello);
    //插入拖拽按钮到`main`分类下
    this.$refs.designer.appendMenuItem("main", {
      icon: hello.icon,
      name: hello.name,
      label: hello.label,
    });

    // user-info
    //插入组件规则
    this.$refs.designer.addComponent(userInfo);
    //插入拖拽按钮到`main`分类下
    this.$refs.designer.appendMenuItem("main", {
      icon: userInfo.icon,
      name: userInfo.name,
      label: userInfo.label,
    });

    // list
    //插入组件规则
    this.$refs.designer.addComponent(list);
    //插入拖拽按钮到`main`分类下
    this.$refs.designer.appendMenuItem("main", {
      icon: list.icon,
      name: list.name,
      label: list.label,
    });
  },
  methods: {
    output() {
      const rule = this.$refs.designer.getRule();
      const json = this.$refs.designer.getJson();
      const option = this.$refs.designer.getOption();
      this.rule = rule;
      this.json = json;
      this.option = option;
      localStorage.setItem(
        "form_create_designer",
        JSON.stringify({ rule, json, option })
      );
    },
  },
};
</script>