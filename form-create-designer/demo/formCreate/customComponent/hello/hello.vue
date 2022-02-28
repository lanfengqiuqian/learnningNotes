<!--
 * @Date: 2022-02-24 14:50:34
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-25 18:15:24
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\customComponent\hello\hello.vue
-->
<template>
  <div>
      <h2 @click="clickJHandle">手写的组件-hello</h2>
      <h2>{{title}}</h2>
      <h3>填写内容：{{content}}</h3>
      <h3>姓名：{{name}}</h3>
      <h3>年龄：{{age}}</h3>
  </div>
</template>

<script>

export default {
    name: 'hello',
    props: {
        title: String,
        content: String,
        name: String,
        age: Number
    },
    methods: {
        clickJHandle() {
            console.log('子组件点击事件')
        }
    }
}
</script>

<style>

</style>