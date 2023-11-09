## 使用插件库

### 参考博客

[https://blog.csdn.net/windgentle/article/details/118751441?spm=1001.2101.3001.6650.15&utm_medium=distribute.pc_relevant.none-task-blog-2%7Edefault%7EBlogCommendFromBaidu%7ERate-15-118751441-blog-126308550.pc_relevant_3mothn_strategy_recovery&depth_1-utm_source=distribute.pc_relevant.none-task-blog-2%7Edefault%7EBlogCommendFromBaidu%7ERate-15-118751441-blog-126308550.pc_relevant_3mothn_strategy_recovery&utm_relevant_index=19](https://blog.csdn.net/windgentle/article/details/118751441?spm=1001.2101.3001.6650.15&utm_medium=distribute.pc_relevant.none-task-blog-2%7Edefault%7EBlogCommendFromBaidu%7ERate-15-118751441-blog-126308550.pc_relevant_3mothn_strategy_recovery&depth_1-utm_source=distribute.pc_relevant.none-task-blog-2%7Edefault%7EBlogCommendFromBaidu%7ERate-15-118751441-blog-126308550.pc_relevant_3mothn_strategy_recovery&utm_relevant_index=19)

### 实战代码

```js
<template>
    <div>
        <h2>签名插件</h2>
        <vueSignature ref="signature" :w="'100%'" :h="'400px'" :sigOption="option"></vueSignature>
        <button @click="save">提交</button>
        <button @click="clear">清空重写</button>
    </div>
</template>

<script setup>
import vueSignature from "vue-signature";
import { ref } from 'vue';

const option = ref({
    penColor: "rgb(0, 0, 0)",//画笔颜色
    backgroundColor: "rgb(245,245,245)"//背景颜色
})

const signature = ref();

//保存
const save = function() {
    var png = signature.value.save();
    var jpeg = signature.value.save("image/jpeg");
    var svg = signature.value.save("image/svg+xml");
    console.log(png);
    console.log(jpeg);
    console.log(svg);
}
    //清空
const clear = function() {
    console.log("signature.value", signature.value);
    signature.value.clear();
}

</script>

<style lang="scss" scoped>

</style>
```


## 使用canvas手写

### 先来一个直线版

```js
<template>
  <div>
    <h2>Canvas绘制手写签名</h2>
  </div>
  <div>
    <button @click="plant">plant</button>
  </div>
  <div>--------------------------</div>
  <div>
    <canvas id="canvas" width="700" height="800"></canvas>
  </div>
</template>

onMounted(() => {
    var startdraw = false;
    var point = {
    x: 0,
    y: 0
    };
    drawCanvas = document.getElementById('canvas');
    ctx = drawCanvas.getContext('2d');
    drawCanvas.width = 400;
    drawCanvas.height = 300;

    canvasOffset = {
        left: drawCanvas.offsetLeft,
        top: drawCanvas.offsetTop,
    }

    drawCanvas.onmousemove = function(e) {
        console.log("-----mousemove------")
        if (startdraw) {
            ctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
            ctx.strokeStyle = 'blue';
            ctx.lineWidth = 1;
            ctx.beginPath();
            if (arrlines.length > 0) {
                for (var i = 0; i < arrlines.length; i++) {
                    var p = arrlines[i];
                    ctx.moveTo(p[0].x, p[0].y);
                    ctx.lineTo(p[1].x, p[1].y);
                    ctx.stroke();
                }
            }
            ctx.moveTo(point.x, point.y);
            ctx.lineTo(e.pageX - canvasOffset.left, e.pageY - canvasOffset.top);
            ctx.stroke();
        }
    };

    drawCanvas.onmousedown = function(e) {
        console.log("-----mousedown------")
        ctx.beginPath();
        point = {
            x: e.pageX - canvasOffset.left,
            y: e.pageY - canvasOffset.top
        }
        arr.push(point);
        startdraw = true;
    };

    drawCanvas.onmouseup = function(e) {
        console.log("-----mouseup------")
        startdraw = false;
        var obj = {
            x: e.pageX - canvasOffset.left,
            y: e.pageY - canvasOffset.top
        };
        arr.push(obj);
        arrlines.push(arr);
        arr = [];
        console.log(arrlines);
    };
});
```

### 再来一个跟随轨迹移动版

```js
<template>
  <div>
    <h2>Canvas绘制手写签名</h2>
  </div>
  <div>
    <button @click="clear">clear</button>
    <button @click="getBase64">getBase64</button>
    <button @click="download">download</button>
  </div>
  <div>--------------------------</div>
  <div>
    <canvas id="canvas" width="400" height="300"></canvas>
  </div>
</template>

<script setup lang="ts">
import { onMounted } from "vue";

let cas: unknown;
let ctx: unknown;

// 这个是移动h5版本
// onMounted(() => {
//   cas = document.getElementById("canvas");
//   if (!cas || !cas.getContext) {
//     return false;
//   } else {
//     ctx = cas.getContext("2d");
//     let isAllowDrawLine = false;
//     cas.ontouchstart = function (e: { touches: { clientY: number; clientX: number }[]; }) {
//       isAllowDrawLine = true;
//       let ele = windowToCanvas(cas, e.touches[0].clientX, e.touches[0].clientY);
//       let { x, y } = ele;
//       ctx.moveTo(x, y);

//       // 小技巧：onmousedown内部添加一个onmousemove事件，就能监听长按鼠标并移动事件啦（不要忘记在onmouseup事件中消除绘制路径功能，否则轨迹会随着鼠标移动不停增加）
//       cas.ontouchmove = (e: { touches: { clientY: number; clientX: number }[]; }) => {
//         if (isAllowDrawLine) {
//           let ele = windowToCanvas(
//             cas,
//             e.touches[0].clientX,
//             e.touches[0].clientY
//           );
//           let { x, y } = ele;
//           ctx.lineTo(x, y);
//           ctx.stroke();
//         }
//       };
//     };
//     cas.ontouchend = () => {
//       isAllowDrawLine = false;
//     };
//   }
// });

// 这个是pc版本
onMounted(() => {
  cas = document.getElementById("canvas");
  if (!cas || !cas.getContext) {
    return false;
  } else {
    ctx = cas.getContext("2d");
    let isAllowDrawLine = false;
    cas.onmousedown = function (e) {
      isAllowDrawLine = true;
      let ele = windowToCanvas(cas, e.clientX, e.clientY);
      let { x, y } = ele;
      ctx.moveTo(x, y);

      // 小技巧：onmousedown内部添加一个onmousemove事件，就能监听长按鼠标并移动事件啦（不要忘记在onmouseup事件中消除绘制路径功能，否则轨迹会随着鼠标移动不停增加）
      cas.onmousemove = (e) => {
        if (isAllowDrawLine) {
          let ele = windowToCanvas(cas, e.clientX, e.clientY);
          let { x, y } = ele;
          ctx.lineTo(x, y);
          ctx.stroke();
        }
      };
    };
    cas.onmouseup = () => {
      isAllowDrawLine = false;
    };
  }
});

// 通常情况下，可以是x - rect.left和y - rect.top。但为什么实际上却是x - rect.left * (canvas.width/rect.width)呢？canvas.width/rect.width表示判断canvas中存在的缩放行为，求出缩放的倍数。
const windowToCanvas = (canvas, x, y) => {
  let rect = canvas.getBoundingClientRect();
  return {
    x: x - rect.left * (canvas.width / rect.width),
    y: y - rect.top * (canvas.height / rect.height),
  };
};

const clear = () => {
    ctx.clearRect(0,0,800,600);
    // 其实clearRect实际上清除的只是fill跟stroke的内容，而不会清除path路径，上一次的path没有清除就stroke了，所以表现的就是上次绘制的图形也跟着出来了
    // 再beginPath一次，那么就能开启新的path，从而达到清除旧的path的效果
    ctx.beginPath();
}

const getBase64 = () => {
    const dataURL = cas.toDataURL('image/png');
    console.log(dataURL);
    return dataURL;
}

const download = () => {
  let url = cas.toDataURL("image/png");
  var oA = document.createElement("a");
  oA.download = ""; // 设置下载的文件名，默认是'下载'
  oA.href = url;
  document.body.appendChild(oA);
  oA.click();
  oA.remove(); // 下载之后把创建的元素删除
};
</script>

<style lang="scss" scoped>
#canvas {
  background-color: #ccc;
}
</style>
```



### 成品组件

#### 子组件

```js
<template>
  <h3 v-if="props.isShowTitle">{{ props.title }}</h3>
  <div>
    <canvas id="canvas" :width="props.width" :height="props.height"></canvas>
  </div>
  <div>--------------------------</div>
  <div>
    <button v-if="props.isShowClear" @click="clear">clear</button>
    <button v-if="props.isShowClear" @click="download">download</button>
  </div>
  <div>--------------------------</div>
</template>

<script setup lang="ts">
import { onMounted, defineProps, defineExpose } from "vue";

const props = defineProps({
  width: {
    type: Number,
    default: 400,
  },
  height: {
    type: Number,
    default: 300,
  },
  title: {
    type: String,
    default: "",
  },
  isShowTitle: {
    type: Boolean,
    default: true,
  },
  isShowClear: {
    type: Boolean,
    default: true,
  },
  isShowDownload: {
    type: Boolean,
    default: true,
  },
})

let cas: unknown;
let ctx: unknown;

// 移动h5版本
onMounted(() => {
  cas = document.getElementById("canvas");
  if (!cas || !cas.getContext) {
    return false;
  } else {
    ctx = cas.getContext("2d");
    let isAllowDrawLine = false;
    cas.ontouchstart = function (e: { touches: { clientY: number; clientX: number }[]; }) {
      isAllowDrawLine = true;
      let ele = windowToCanvas(cas, e.touches[0].clientX, e.touches[0].clientY);
      let { x, y } = ele;
      ctx.moveTo(x, y);

      // 小技巧：onmousedown内部添加一个onmousemove事件，就能监听长按鼠标并移动事件啦（不要忘记在onmouseup事件中消除绘制路径功能，否则轨迹会随着鼠标移动不停增加）
      cas.ontouchmove = (e: { touches: { clientY: number; clientX: number }[]; }) => {
        if (isAllowDrawLine) {
          let ele = windowToCanvas(
            cas,
            // 这里移动h5的事件对象的取值不大一样
            e.touches[0].clientX,
            e.touches[0].clientY
          );
          let { x, y } = ele;
          ctx.lineTo(x, y);
          ctx.stroke();
        }
      };
    };
    cas.ontouchend = () => {
      isAllowDrawLine = false;
    };
  }
});

// pc版本
// onMounted(() => {
//   cas = document.getElementById("canvas");
//   if (!cas || !cas.getContext) {
//     return false;
//   } else {
//     ctx = cas.getContext("2d");
//     let isAllowDrawLine = false;
//     cas.onmousedown = function (e) {
//       isAllowDrawLine = true;
//       let ele = windowToCanvas(cas, e.clientX, e.clientY);
//       let { x, y } = ele;
//       ctx.moveTo(x, y);

//       // 小技巧：onmousedown内部添加一个onmousemove事件，就能监听长按鼠标并移动事件啦（不要忘记在onmouseup事件中消除绘制路径功能，否则轨迹会随着鼠标移动不停增加）
//       cas.onmousemove = (e) => {
//         if (isAllowDrawLine) {
//           let ele = windowToCanvas(cas, e.clientX, e.clientY);
//           let { x, y } = ele;
//           ctx.lineTo(x, y);
//           ctx.stroke();
//         }
//       };
//     };
//     cas.onmouseup = () => {
//       isAllowDrawLine = false;
//     };
//   }
// });

// 通常情况下，可以是x - rect.left和y - rect.top。但为什么实际上却是x - rect.left * (canvas.width/rect.width)呢？canvas.width/rect.width表示判断canvas中存在的缩放行为，求出缩放的倍数。
const windowToCanvas = (canvas, x, y) => {
  let rect = canvas.getBoundingClientRect();
  return {
    x: x - rect.left * (canvas.width / rect.width),
    y: y - rect.top * (canvas.height / rect.height),
  };
};

const clear = () => {
    ctx.clearRect(0,0,800,600);
    // 其实clearRect实际上清除的只是fill跟stroke的内容，而不会清除path路径，上一次的path没有清除就stroke了，所以表现的就是上次绘制的图形也跟着出来了
    // 再beginPath一次，那么就能开启新的path，从而达到清除旧的path的效果
    ctx.beginPath();
}

const getBase64 = () => {
    const dataURL = cas.toDataURL('image/png');
    console.log("子组件获取的url", dataURL);
    return dataURL;
}

const download = () => {
  let url = cas.toDataURL("image/png");
  var oA = document.createElement("a");
  oA.download = "";
  oA.href = url;
  document.body.appendChild(oA);
  oA.click();
  oA.remove();
};

defineExpose({
    getBase64
})
</script>

<style lang="scss" scoped>
#canvas {
  background-color: #ccc;
}
</style>
```

#### 父组件

```html
<template>
  <CanvasSign ref="signRef" title="手绘canvas签名" />
  <button @click="getBase64">父组件submit</button>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import CanvasSign from "./CanvasSign.vue";

const signRef = ref();

const getBase64 = () => {
  console.log("signRef.value", signRef.value);
  const base64 = signRef.value ? signRef.value.getBase64() : "";
  console.log("父组件获得base64", base64);
};
</script>
```