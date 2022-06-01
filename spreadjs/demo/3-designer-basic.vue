<!--
 * @Date: 2022-03-30 10:38:24
 * @LastEditors: Lq
 * @LastEditTime: 2022-03-30 10:38:24
 * @FilePath: \learnningNotes\spreadjs\demo\3-designer.vue
-->
<template>
    <div style="background:#fff;position:relative;height:1200px;top:0;left:0;right:0;">
        <div id="ss" style="width:100%; height:100%;"></div>
        <div id="designerHost" style="width:100%; height:100%;border: 1px solid gray;"></div>
    </div>
</template>
<script>
import '@grapecity/spread-sheets/styles/gc.spread.sheets.excel2016colorful.css'
import GC from '@grapecity/spread-sheets'
import '@grapecity/spread-sheets-resources-zh'
import '@grapecity/spread-sheets-designer/styles/gc.spread.sheets.designer.min.css'
import "@grapecity/spread-sheets-designer-resources-cn"
import "@grapecity/spread-sheets-designer"
GC.Spread.Common.CultureManager.culture("zh-cn")
export default {
    data(){
        return {
            
        }
    },
    computed:{
        
    },
    created () {

    },
    mounted () {
        // 初始化 Spread
        var spread = new GC.Spread.Sheets.Workbook(document.getElementById("ss"));
        //获取活动表
        var sheet = spread.getSheet(0);
        //设置列宽
        sheet.setColumnWidth(2, 100);
        sheet.setColumnWidth(4, 100);
        // 创建数据数组
        var dataArray =
            [
                ['Region', 'Subregion', 'country', 'Population'],
                ['Asia', 'Southern', 'India', 1354051854],
                [, , 'Pakistan', 200813818],
                [, , 'Bangladesh', 166368149],
                [, , 'Others', 170220300],
                [, 'Eastern', 'China', 1415045928],
                [, , 'Japan', 127185332],
                [, , 'Others', 111652273],
                [, 'South-Eastern', , 655636576],
                [, 'Western', , 272298399],
                [, 'Central', , 71860465],
                ['Africa', 'Eastern', , 433643132],
                [, 'Western', , 381980688],
                [, 'Northern', , 237784677],
                [, 'Others', , 234512021],
                ['Europe', , , 742648010],
                ['Others', , , 1057117703]
            ];
        // 设置数组
        sheet.setArray(1, 1, dataArray);
        var treemapChart = sheet.charts.add('chart1',GC.Spread.Sheets.Charts.ChartType.treemap, 450, 0, 500, 500, "B2:E18");
        
        // 初始化设计器
        // var designer = new GC.Spread.Sheets.Designer.Designer(document.getElementById("designerHost"))

        // 初始化设计器与默认配置和上面创建的扩展组件
        var designer = new GC.Spread.Sheets.Designer.Designer(document.getElementById("designerHost"), '', spread);
    }
}
</script>
<style>

</style>
