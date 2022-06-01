<!--
 * @Date: 2022-03-25 15:52:44
 * @LastEditors: Lq
 * @LastEditTime: 2022-03-28 14:19:29
 * @FilePath: \learnningNotes\spreadjs\demo\1-basic.vue
-->
<template>
  <div>
    <gc-spread-sheets
      :hostClass="hostClass"
      @workbookInitialized="initWorkbook"
      id="ss"
    >
    </gc-spread-sheets>
  </div>
</template>

<script>
import "@grapecity/spread-sheets/styles/gc.spread.sheets.excel2016colorful.css";
import * as GC from "@grapecity/spread-sheets";
import "@grapecity/spread-sheets-vue";

export default {
  name: "App",
  data() {
    return {
      hostClass: "spread-host",
    };
  },
  methods: {
    initWorkbook: function (spread) {
        this.refresh(spread)
      //   let sheet = spread.getActiveSheet();
      //   //Setting Values - Text
      //   sheet.setValue(1, 1, "Setting Values");
      //   //Setting Values - Number
      //   sheet.setValue(2, 1, "Number");
      //   sheet.setValue(2, 2, 23);
      //   sheet.setValue(3, 1, "Text");
      //   sheet.setValue(3, 2, "GrapeCity");
      //   sheet.setValue(4, 1, "Datetime");
      //   //Setting Values - DateTime
      //   sheet.getCell(4, 2).value(new Date(2020, 10, 7)).formatter("mm-dd-yyyy");
      //   //Setting style
      //   sheet.setColumnWidth(1, 200);
      //   sheet.setColumnWidth(2, 200);
      //   sheet
      //     .getRange(1, 1, 1, 2)
      //     .backColor("rgb(130, 188, 0)")
      //     .foreColor("rgb(255, 255, 255)");
      //   sheet.getRange(3, 1, 1, 2).backColor("rgb(211, 211, 211)");
      //   sheet.addSpan(1, 1, 1, 2);
      //   sheet
      //     .getRange(1, 1, 4, 2)
      //     .setBorder(
      //       new GC.Spread.Sheets.LineBorder(
      //         "Black",
      //         GC.Spread.Sheets.LineStyle.thin
      //       ),
      //       {
      //         all: true,
      //       }
      //     );
      //   sheet
      //     .getRange(1, 1, 4, 2)
      //     .setBorder(
      //       new GC.Spread.Sheets.LineBorder(
      //         "Black",
      //         GC.Spread.Sheets.LineStyle.dotted
      //       ),
      //       {
      //         inside: true,
      //       }
      //     );
      //   sheet
      //     .getRange(1, 1, 1, 2)
      //     .hAlign(GC.Spread.Sheets.HorizontalAlign.center);

    //   var sheet = spread.getSheet(0);
    //   var person = {
    //     name: "Peter Winston",
    //     age: 25,
    //     gender: "Male",
    //     address: { postcode: "10001" },
    //   };
    //   var source = new GC.Spread.Sheets.Bindings.CellBindingSource(person);
    //   sheet.setBindingPath(2, 2, "name");
    //   sheet.setBindingPath(3, 2, "age");
    //   sheet.setBindingPath(4, 2, "gender");
    //   sheet.setBindingPath(5, 2, "address.postcode");
    //   sheet.setDataSource(source);
    },
    // 创建示例数据
    createSampleData() {
      return [
        {
          Course: "Calculus",
          Term: 1,
          Credit: 5,
          Score: 80,
          Teacher: "Nancy.Feehafer",
        },
        {
          Course: "P.E.",
          Term: 1,
          Credit: 3.5,
          Score: 85,
          Teacher: "Andrew.Cencini",
        },
        {
          Course: "Political Economics",
          Term: 1,
          Credit: 3.5,
          Score: 95,
          Teacher: "Jan.Kotas",
        },
        {
          Course: "Basic of Computer",
          Term: 1,
          Credit: 2,
          Score: 85,
          Teacher: "Steven.Thorpe",
        },
        {
          Course: "Micro-Economics",
          Term: 1,
          Credit: 4,
          Score: 62,
          Teacher: "Jan.Kotas",
        },
        {
          Course: "Linear Algebra",
          Term: 2,
          Credit: 5,
          Score: 73,
          Teacher: "Nancy.Feehafer",
        },
        {
          Course: "Accounting",
          Term: 2,
          Credit: 3.5,
          Score: 86,
          Teacher: "Nancy.Feehafer",
        },
        {
          Course: "Statistics",
          Term: 2,
          Credit: 5,
          Score: 85,
          Teacher: "Robert.Zare",
        },
        {
          Course: "Marketing",
          Term: 2,
          Credit: 4,
          Score: 70,
          Teacher: "Laura.Giussani",
        },
      ];
    },
    //2.1: 使用来自数据源的数据创建表
    loadTable(ss, data) {
      //暂停绘制，立即重新绘制所有变更的最佳做法
      ss.suspendPaint;
      try {
        //获取活动表
        var sheet = ss.getActiveSheet();
        console.log('sheet', sheet);
        //2.2: 添加具有指定数据源的范围表
        var table = sheet.tables.addFromDataSource(
          "Table1",
          0,
          0,
          data,
          GC.Spread.Sheets.Tables.TableThemes.medium2
        );
        // 3.1) 显示标题
        table.showHeader(true);

        // 3.1) 高亮第一列
        table.highlightFirstColumn(true);

        // 3.2) 设置列宽
        sheet.setColumnWidth(0, 130);
        sheet.setColumnWidth(1, 130);
        sheet.setColumnWidth(2, 70);
        sheet.setColumnWidth(3, 70);
        sheet.setColumnWidth(4, 100);
        sheet.setColumnWidth(5, 260);
      } catch (e) {
        console.log(e.message);
      }
      //恢复绘制，立即用所有变更重新绘制整个spread实例
      ss.resumePaint;
    },
    //4:- 创建refresh函数
    refresh(spread) {
      var ss = spread;
      // 得到activesheet
      var sheet = ss.getActiveSheet();
      // 重置表单并设置列数
      sheet.reset();
      sheet.setColumnCount(7);
      // 使用样本数据加载spread实例的表
      var data = this.createSampleData();
      this.loadTable(ss, data);
    },
  },
};
</script>

<style>
.spread-host {
  width: 100%;
  height: 600px;
}
</style>