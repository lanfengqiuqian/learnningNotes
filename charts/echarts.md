<!--
 * @Date: 2022-07-28 17:16:29
 * @LastEditors: Lq
 * @LastEditTime: 2022-08-01 17:25:30
 * @FilePath: \learnningNotes\charts\echarts.md
-->
### 文档

1. [官方文档](https://echarts.apache.org/handbook/zh/get-started)

2. [常见问题](https://echarts.apache.org/zh/faq.html)

3. [示例集合](https://echarts.apache.org/examples/zh/index.html)

4. [术语速查手册](https://echarts.apache.org/zh/cheat-sheet.html)

    组件的基本概念，看这个图基本就清楚了


### 开始

1. 入门demo（vue）

    ```html
    <template>
    <div class="container">
        <h2>红人数据看板</h2>
        <div id="main"></div>
    </div>
    </template>

    <script>
    // 引入 echarts 核心模块，核心模块提供了 echarts 使用必须要的接口。
    import * as echarts from 'echarts/core';
    // 引入柱状图图表，图表后缀都为 Chart
    import { BarChart } from 'echarts/charts';
    // 引入提示框，标题，直角坐标系，数据集，内置数据转换器组件，组件后缀都为 Component
    import {
    TitleComponent,
    TooltipComponent,
    GridComponent,
    DatasetComponent,
    TransformComponent
    } from 'echarts/components';
    // 标签自动布局，全局过渡动画等特性
    import { LabelLayout, UniversalTransition } from 'echarts/features';
    // 引入 Canvas 渲染器，注意引入 CanvasRenderer 或者 SVGRenderer 是必须的一步
    import { CanvasRenderer } from 'echarts/renderers';

    // 注册必须的组件
    echarts.use([
    TitleComponent,
    TooltipComponent,
    GridComponent,
    DatasetComponent,
    TransformComponent,
    BarChart,
    LabelLayout,
    UniversalTransition,
    CanvasRenderer
    ]);

    export default {
    mounted() {
        this.init();
    },
    methods: {
        init() {
        const options = {
            title: {
            text: 'lq测试'
            },
            tooltip: {},
            legend: {
            data: ['销量']
            },
            xAxis: {
            data: ['衬衫', '羊毛衫', '雪纺衫', '裤子', '高跟鞋', '袜子']
            },
            yAxis: {},
            series: [
            {
                name: '销量',
                type: 'bar',
                data: [5, 15, 25, 18, 19, 33]
            }
            ]
        }
        // 接下来的使用就跟之前一样，初始化图表，设置配置项
        var myChart = echarts.init(document.getElementById('main'));
        myChart.setOption(options);
        }
    }
    }
    </script>

    <style scoped>
    #main {
    width: 800px;
    height:600px;
    }
    </style>
    ```

2. 动态响应大小

    ```js
    init() {
        // 注册一个监听事件，页面变化时调用重新设置大小
        window.addEventListener('resize', this.resizeHandler);
    },
    resizeHandle() {
        // 重新设置大小
        this.chart.resize();
    },
    // 销毁的生命周期中移除监听
    beforeDestroy() {
        window.removeEventListener('resize', this.resizeHandler)
    }
    ```

3. 一个echarts实例中展现多个图

    在`series`属性中设置多个元素即可，即`series: [{第一个图表数据}, {第二个图表数据}]`

4. 多个`dataset`分配到多个`series`

    关键：使用`dataset`的序号来控制是哪一个

    ```js
    // dataset定义
    let dataset = [{
    source: [
            { product: 'Matcha Latte', count: 823, score: 95.8 },
            { product: 'Milk Tea', count: 235, score: 81.4 },
            { product: 'Cheese Cocoa', count: 1042, score: 91.2 },
            { product: 'Walnut Brownie', count: 988, score: 76.9 }
        ]
        }, {
        source: [
            { product: 'aaa', count: 5, score: 95.8 },
            { product: 'bbb', count: 6, score: 81.4 },
            { product: 'ccc', count: 7, score: 91.2 },
            { product: 'ddd', count: 8, score: 76.9 }
        ]
        }, {
        source: [
            { product: '第一个', count: 111, score: 95.8 },
            { product: '第二个', count: 222, score: 81.4 },
            { product: '第三个', count: 333, score: 91.2 },
            { product: '第四个', count: 444, score: 76.9 }
        ]
    }]
    // series使用
    const options = {
        dataset: this.dataset,
        series: [{
            // some code
            datasetIndex: 0,
        }, {
            // some code
            datasetIndex: 1,
        }, {
            // some code
            datasetIndex: 2,
        }]
    }
    ```

5. 空数据

    预期表现：比如说折线图，想要在某一个点为空的时候断掉

    分析：这个时候如果使用数值`0`来表示的话，仍然会连接左右两个点，组成连线，和预期的不一样

    解决方案：使用`-`来表示

    ```js
    // 错误做法
    data: [0, 22, 0, 23, 19]
    
    // 正确做法
    data: ['-', 22, '-', 23, 19]
    ```

### 常见问题

1. Initialize failed: invalid dom

    原因：初始化的时候没有获取到`dom`，可能原因及排查如下

    1. 查看初始化传入的dom，如：`var myChart = echarts.init(document.getElementById('main'));`

    2. 控制台打印这里的dom能否获取到：`document.getElementById('main')`

    3. 如果是项目中使用的话看是否在元素渲染完毕的生命周期之前调用的

        如vue不能在`created`中调用，需要在`mounted`中调用

2. ecahrts的元素比父元素更宽

    ```html
    <div :id="name" class="container"></div>
    ```

    比如这里`.container`的`height`为`800px`，但是生成的里面的canvas为`845px`

    第一种原因是先设置配置项生成了图表，然后再去适应大小，就失效了

    ```js
    this.chart.setOption(options);
    this.chart.resize();
    ```

    需要把适应大小放到生成图表之前，就可以了

    ```js
      this.chart.resize();
      this.chart.setOption(options);
    ```

    第二种原因是`dataset`数据项是动态的，先有一个默认数据，然后适应了大小，后来又传入了数据，但是没有去设置大小，所以需要再次去设置一次

    如，我这边在监听数据改变之后，再去触发`init`方法，这个方法中就包括了`resize`

    ```js
    watch: {
        dataset(val) {
            this.init();
        }
    }
    init() {
        // some code
        this.chart = echarts.init(document.getElementById(this.name));
        this.chart.resize();
        this.chart.setOption(options);
    }
    ```

3. 使用漏斗图的时候，形状不规则，比例不对

    表现：

     1. 超过一部分的全部一样大
     2. 数值都比较小的时候特别窄

    这个原因是`min`和`max`属性控制了，示例中的是`0-100`，固定了最大值和最小值，把他们删除就会自动了

4. 控制台报警告`There is a chart instance already initialized on the dom.`

    原因：在已经初始化`chart`对象了之后再去初始化，比如我上面的`init`函数多次调用，就会多次触发`this.chart = echarts.init(document.getElementById(this.name));`

    解决方案：初始化之前先进行判断，如果已经初始化过了就不调用这个`charts.init()`

    ```js
    data() {
        return {
            chart: undefined
        }
    }
    init() {
        // some code
        if (!this.chart) {
            this.chart = echarts.init(document.getElementById(this.name));
        }
    }
    ```