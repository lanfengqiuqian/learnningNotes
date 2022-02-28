<!--
 * @Date: 2022-02-24 14:50:34
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-25 15:22:09
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\customComponent\list\list.vue
-->
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

<style>

</style>