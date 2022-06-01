<!--
 * @Date: 2022-02-22 16:14:19
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-23 15:27:15
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\FormCreateDesigner.vue
-->
<template>
  <div>
    <div>
      <fc-designer ref="designer" height="1000px" />
    </div>
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
export default {
  data() {
    return {
      rule: "",
      json: "",
      option: "",
    };
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

<style>
</style>