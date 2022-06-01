<!--
 * @Date: 2022-03-25 15:52:44
 * @LastEditors: Lq
 * @LastEditTime: 2022-03-30 11:41:47
 * @FilePath: \learnningNotes\spreadjs\demo\4-update-changes.vue
-->
<template>
  <div>
    <gc-spread-sheets
      :hostClass="hostClass"
      @workbookInitialized="initWorkbook"
      id="ss"
    >
    </gc-spread-sheets>
    <input type="button" value="Refresh" @click="refresh" />
    <input type="button" value="saveToDB" @click="saveToDB" />

    <br>
    <textarea rows="8" cols="50">{{dirtyCells}}</textarea>
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
      dirtyCells: ''
    };
  },
  methods: {
    initWorkbook: function (spread) {
      //初始化spread
      var spread = new GC.Spread.Sheets.Workbook(document.getElementById("ss"));
      // 调用refresh函数
      this.refresh();
      const _this = this;
      // 绑定 CellChanged
      spread.bind(GC.Spread.Sheets.Events.CellChanged, function (event, data) {
        var row = data.row,
          col = data.col;
        if (
          data.propertyName !== "value" ||
          row === undefined ||
          col === undefined
        ) {
          return;
        }
        // 执行showChanged函数
        _this.showChanges(spread, row, col);
      });
      // 绑定 RangeChanged
      spread.bind(GC.Spread.Sheets.Events.RangeChanged, function (event, data) {
        var row = data.row,
          col = data.col,
          rowCount = data.rowCount,
          colCount = data.colCount;
        if (
          row === undefined ||
          col === undefined ||
          rowCount === undefined ||
          colCount === undefined
        ) {
          return;
        }
        // 执行showChanged函数
        _this.showChanges(spread, row, col, rowCount, colCount);
      });
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
        console.log("sheet", sheet);
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

    refresh() {
      console.log("进入了refresh");
      var ss = GC.Spread.Sheets.findControl(document.getElementById("ss"));
      // 1. 获取活动表单
      var sheet = ss.getActiveSheet();
      // Reset the sheet and set the column count
      sheet.reset();
      sheet.setColumnCount(7);
      // 使用样本数据加载spread实例的表
      var data = this.createSampleData();
      this.loadTable(ss, data);

      // 暂停脏单元格
      sheet.suspendDirty();
      // 设置F1单元格的值、背景颜色和halign
      sheet
        .getCell(0, 5)
        .backColor("yellow")
        .value("Changes")
        .hAlign(GC.Spread.Sheets.HorizontalAlign.center);
      // 恢复脏单元格
      sheet.resumeDirty();

      // 保护表单并锁定F列
      sheet.options.isProtected = true;
      // 4.1) 将表单默认样式设置为不锁定单元格
      var s = sheet.getDefaultStyle();
      s.locked = false;
      sheet.setDefaultStyle(s);
      // 4.1) 指定锁定列F以显示新值和旧值(列索引5)
      sheet.getRange(-1, 5, -1, 1).locked(true);
    },
    // Step 2: 创建 showChanges()
    showChanges(ss, row, col, rowCount, colCount) {
      // 获取活动表单
      var sheet = ss.getActiveSheet();
      // 如果activesheet有挂起的变更
      if (sheet.hasPendingChanges()) {
        // 暂停绘制，事件，脏
        ss.suspendPaint();
        ss.suspendEvent();
        sheet.suspendDirty();
        // 将脏单元集合存储在名为dirtyDataArray的数据数组中
        var dirtyDataArray = sheet.getDirtyCells(row, col, rowCount, colCount);

        // 跳过“F”列的脏变更
        for (var i = 0; i < dirtyDataArray.length; i++) {
          // 将脏单元格数据存储在脏数据数组中
          var dirtyCell = dirtyDataArray[i];

          // 显示dirtyDataArray值中的旧值和新值
          // row index --> dirtyCell.row 返回进行变更的行的行索引
          // column index -->5是F列的行索引
          sheet.setValue(
            dirtyCell.row,
            5,
            "old: " + dirtyCell.oldValue + ", new: " + dirtyCell.newValue
          );
        }
        // 恢复绘制，事件，脏
        sheet.resumeDirty();
        ss.resumeEvent();
        ss.resumePaint();
      }
    },
     saveToDB() {
    //获取活动表 from the DOM element "ss"
    var ss = GC.Spread.Sheets.findControl(document.getElementById("ss"));
    var sheet = ss.getActiveSheet();
    // 将脏单元格信息存储在dirtyCells变量中
    this.dirtyCells = JSON.stringify(sheet.getDirtyCells());
}
  },
};
</script>

<style>
.spread-host {
  width: 100%;
  height: 600px;
}
</style>