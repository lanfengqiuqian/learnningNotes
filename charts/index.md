<!--
 * @Date: 2020-08-19 11:05:42
 * @LastEditors: Lq
 * @LastEditTime: 2020-08-19 17:27:46
 * @FilePath: /learnningNotes/charts/index.md
-->
#### 传送门
1. antd pro的[图表使用](https://v2-pro.ant.design/components/charts-cn),数量种类不多，但是很基础的东西都有，可配置性不高。[图表介绍](https://v2-pro.ant.design/docs/graph-cn)
2. BizCharts的[入门文档](https://www.cnblogs.com/xjnotxj/p/12601021.html)
3. BizCharts[官方文档](https://bizcharts.net/product/bizcharts/gallery)


#### 使用bizCharts需要注意的地方

1. padding的使用：如果出现坐标轴、图例等显示不全的情况，那么适当的调整`padding`可以达到显示完全的效果（属性基本和css的padding方式一样）
2. 注意数据的对象数组的属性名是否正确，否则会导致坐标轴错乱
3. 代表数据纵坐标的值一定要是`number`类型，注意不要是字符串的数字，要不然纵坐标好会出现奇怪的现象，如位置错乱，排序出问题等
4. 双y轴坐标统一：scale的配置中两个y轴`min`和`max`相同即可
5. 不希望y轴出现小数：scale中设置`minTickInterval`属性，值为1
6. 为图表加标题直接在`<Chart>`组件前面加标题，就是说`Charts`好像不支持标题

更多可以参考这位掘金大佬的[文章](https://juejin.im/post/6844903965566435336)

#### 独立使用antd pro样式不生效

需要手动导入css文件
> import 'ant-design-pro/dist/ant-design-pro.css';


