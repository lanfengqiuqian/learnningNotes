<!--
 * @Date: 2022-02-23 14:29:31
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-23 17:39:06
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\ShowFormCreateDesigner.vue
-->
<template>
  <div>
    <div>
      <fc-designer ref="designerForShow" />
    </div>
  </div>
</template>

<script>
export default {
  name: "app",
  data() {
    return {};
  },
  mounted() {
      const { rule, json, option } = JSON.parse(
        localStorage.getItem("form_create_designer")
      );
      console.log("rule, json, option", rule, json, option);
      this.$refs.designerForShow.setRule(rule);
      this.$refs.designerForShow.setOption(option);
  },
};
</script>