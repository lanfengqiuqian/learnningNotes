<!--
 * @Date: 2022-02-24 14:50:34
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-25 12:05:30
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\customComponent\userInfo.vue
-->
<template>
  <div>
      <h2>采集用户信息</h2>
      <div>
          <span>{{nameLabel}}</span>
          <el-input v-model="obj.name" @change="onchanage('name')" placeholder="请输入"></el-input>
      </div>
      <div>
          <span>{{ageLabel}}</span>
          <el-input v-model="obj.age" @change="onchanage('age')" placeholder="请输入"></el-input>
      </div>
      <div>
          <span>{{idcardLabel}}</span>
          <el-input v-model="obj.idcard" @change="onchanage('idcard')" placeholder="请输入"></el-input>
      </div>
  </div>
</template>

<script>

export default {
    name: 'userInfo',
    data() {
        return {
            obj: {
                name: '',
                age: '',
                idcard: ''
            }
        }
    },
    props: {
        nameLabel: String,
        ageLabel: Number,
        idcardLabel: String
    },
    methods: {
        onchanage(type) {
            // 将组件改变的值整个更新到表单组件中
            this.$emit('input', this.obj)
        }
    }
}
</script>

<style>

</style>