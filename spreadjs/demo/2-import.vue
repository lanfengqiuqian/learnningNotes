<template>
  <div>
    <gc-spread-sheets
      :hostClass="hostClass"
      @workbookInitialized="initWorkbook"
      id="ss"
    >
    </gc-spread-sheets>

    <div>
      <el-upload
        class="upload-demo"
        action="https://jsonplaceholder.typicode.com/posts/"
        :on-change="handleChange"
        :file-list="fileList"
      >
        <el-button size="small" type="primary">点击上传</el-button>
        <div slot="tip" class="el-upload__tip">
          只能上传jpg/png文件，且不超过500kb
        </div>
      </el-upload>
    </div>
  </div>
</template>

<script>
import "@grapecity/spread-sheets/styles/gc.spread.sheets.excel2016colorful.css";
import * as GC from "@grapecity/spread-sheets";
import { IO } from "@grapecity/spread-excelio";
import "@grapecity/spread-sheets-vue";

export default {
  name: "App",
  data() {
    return {
      hostClass: "spread-host",
      spread: {},
      fileList: []
    };
  },
  methods: {
    initWorkbook: function (spread) {
      this.spread = spread;
    },
    //1: 创建 importJSON()
    importJSON(spreadJson) {
      var ss = this.spread;
      if (spreadJson.version && spreadJson.sheets) {
        // 从JSON字符串spreadJSON加载对象
        ss.fromJSON(spreadJson);
        // 聚焦工作簿组件
        ss.focus();
      }
    },
    //2: 创建 importSpreadFromExcel()
    importSpreadFromExcel(file, options) {
        const excelIO = new IO();
      // 加载一个Excel文件来绘制SpreadJS实例
      excelIO.open(
        file,
        function (json) {
            console.log('读取到了json文件', json);
          // 调用步骤1中创建的importJson()来导入Excel文件
          this.importJSON(json);
        },
        function (e) {
          console.log('excelIO出错了', e);
        },
        options
      );
    },
    //3: 创建 importSpreadFromJSON()
    importSpreadFromJSON(file) {
      function importSuccessCallback(responseText) {
        // 解析JSON字符串
        var spreadJson = JSON.parse(responseText);
        // 执行importJSON方法从解析的JSON字符串加载SpreadJS实例
        this.importJSON(spreadJson);
      }
      // 创建一个文件来读取JSON字符串
      var reader = new FileReader();
      // 当下面的readAsText()完成时，将触发此事件以成功返回回调
      reader.onload = function () {
        this.importSuccessCallback(this.result);
      };
      // 触发readAsText()方法
      // 这将读取文件的内容，并在完成时触发加载事件
      reader.readAsText(file);
      return true;
    },
    //4: 创建importFile()函数来决定一个文件是.xlsx还是.JSON/.SSJSON
    importFile(file) {
      // 获取所选文件的名称
      var fileName = file.name;
      // 获取文件名的最后一个“.”的索引位置
      var index = fileName.lastIndexOf(".");
      // 返回最后一个“.”索引位置的文件名的最后一部分。
      var fileExt = fileName.substr(index + 1).toLowerCase();
      // 根据文件扩展名确定要调用的导入扩展函数
      console.log('fileExt', fileExt);
      if (fileExt === "json" || fileExt === "ssjson") {
        this.importSpreadFromJSON(file);
      } else if (fileExt === "xlsx") {
        this.importSpreadFromExcel(file);
      } else {
          this.importSpreadFromExcel(file);
      }
    },
    handleChange(file, fileList) {
        // this.fileList = fileList.slice(-3);
        console.log('file', file);
        this.importFile(file);
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