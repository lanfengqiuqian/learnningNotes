<!--
 * @Date: 2022-02-22 14:44:05
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-22 17:43:45
 * @FilePath: \itr-btit-fe-adminpc\src\views\formcreate\FormCreate.vue
-->
<template>
  <div>
      <form-create :rule="rule" v-model="fApi" :option="options" :value.sync="value"/>
  </div>
</template>

<script>
export default {
    data(){
        return {
            fApi:{},
            value:{field1:'111',field2:'222',time:'11:11:11'},
            options:{
                onSubmit:(formData)=>{
                    alert(JSON.stringify(formData))
                }
            },
            rule:[
                {type:'input', field:'field1',title:'field1',value:'aaa'},
                {type:'input', field:'field2',title:'field2',value:'sss'},
                // {type:'timePicker', field:'time',title:'time',value:'12:12:12'},
                // {
                //     type:'ElButton',
                //     title:'修改 field1',
                //     native: false,
                //     on:{
                //         click: ()=>{
                //             this.rule[0].value+='a'
                //         }
                //     },
                //     children: ['点击'],
                // }
            ]
        }
    }
}
</script>

<style>

</style>