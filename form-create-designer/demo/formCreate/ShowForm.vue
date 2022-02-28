<!--
 * @Date: 2022-02-23 14:59:14
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-25 14:12:33
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\ShowForm.vue
-->
<template>
  <form-create
    v-model="fapi"
    :rule="rule"
    :option="option"
    @submit="onSubmit"
  ></form-create>
</template>

<script>

export default {
  data() {
    const { rule, json, option } = JSON.parse(
      localStorage.getItem("form_create_designer")
    );
    return {
      fapi: null,
      rule: rule,
      option: option,
    };
  },
  methods: {
    onSubmit(formData) {
      //todo 提交表单
      console.log('formData', formData);
    },
  },
};
</script>