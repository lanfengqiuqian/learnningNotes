/*
 * @Date: 2022-02-24 15:21:56
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-25 15:19:26
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\customComponent\index.js
 */
import Vue from 'vue'
import hello from './hello/hello.vue'
import userInfo from './userInfo/userInfo.vue'
import list from './list/list.vue'

// 这里是重点
Vue.component('MyHello',hello)
Vue.component('UserInfo',userInfo)
Vue.component('list',list)
