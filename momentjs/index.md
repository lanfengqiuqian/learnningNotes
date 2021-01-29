<!--
 * @Date: 2020-08-19 16:20:42
 * @LastEditors: Lq
 * @LastEditTime: 2021-01-27 15:17:46
 * @FilePath: /learnningNotes/momentjs/index.md
-->
### 常使用到的一些方法

1. 当前周7天
```javascript
let startTime = moment().week(moment().week()).startOf('week'); // 周一日期
let indexWeek = moment(startTime).add(index, 'days').format('MM-DD'); // 周index+1的日期
```
2. 获取本月有多少天
```javascript
let days = moment().endOf("month").format("DD");
```
3. 获取本季度月份
```javascript
let currentQuarter = moment().quarter(); // 当前是第几季度
let currentYear = moment().year(); // 当前年
let beginMonth = moment(moment(moment(currentYear + '-01-01').toDate()).quarter(currentQuarter)).format('MM'); // 本季度开始的月份
```
4. 获取过去或未来某段时间内的时间：如3天前，5月后等
```javascript
/**
 * Lq
 * @description 获取过去或未来某段时间内的时间
 * @type 是过去时间还是未来时间 before after
 * @param times 间隔时间次数
 * @param unit 间隔时间 hours days weeks months years
 */
beforeOrAfterTime: (type: string, times: number, unit: string) => {
  if(type === 'after') {
    return moment(new Date()).add(times, unit).format('YYYY-MM');
  }
  return moment(new Date()).subtract(times, unit).format('YYYY-MM');
}
```
5. 获取本周、本月、本季度、本年开始时间和结束时间
```javascript
getTimeDistance: (type: 'week' | 'month' | 'quarter' | 'year'): RangePickerValue => {
  const now = new Date();
  const oneDay = 1000 * 60 * 60 * 24;
  
  if (type === 'week') {
    let day = now.getDay();
    now.setHours(0);
    now.setMinutes(0);
    now.setSeconds(0);

    if (day === 0) {
      day = 6;
    } else {
      day -= 1;
    }

    const beginTime = now.getTime() - day * oneDay;

    return [moment(beginTime), moment(beginTime + (7 * oneDay - 1000))];
  }
  const year = now.getFullYear();

  if (type === 'month') {
    const month = now.getMonth();
    const nextDate = moment(now).add(1, 'months');
    const nextYear = nextDate.year();
    const nextMonth = nextDate.month();

    return [
      moment(`${year}-${fixedZero(month + 1)}-01 00:00:00`),
      moment(moment(`${nextYear}-${fixedZero(nextMonth + 1)}-01 00:00:00`).valueOf() - 1000),
    ];
  }

  if (type === 'quarter') {
    let start = moment().startOf('quarter').format('YYYY-MM-DD')
    let end = moment().endOf('quarter').format('YYYY-MM-DD')
    return [moment(start), moment(end)];
  }

  // 非财年计算版本
  // return [moment(`${year}-01-01 00:00:00`), moment(`${year}-12-31 23:59:59`)];
  // 由于这里是计算财年：04-01 ~ 03-31
  if(now.getMonth() > 3) {
    return [moment(`${year}-04-01 00:00:00`), moment(`${year + 1}-03-31 23:59:59`)];
  }
  return [moment(`${year - 1}-04-01 00:00:00`), moment(`${year}-03-31 23:59:59`)];
}
```


### 学习笔记

1. 安装和使用

    `npm install moment`

    ```js
    // nodejs
    var moment = require('moment');
    moment().format();

    // 浏览器
    <script src="moment.js"></script>
    <script>
        moment().format();
    </script>
    ```

    特殊：chrome控制台可以直接使用moment库

2. moment(param)参数

    第一个参数
    1. undefined，默认形式
    2. 时间片段

        如：2020-10-12 22:22:22

    3. new Date()
    4. moment()
    5. 时间戳
    6. 数组：[year, month, day, hour, minute, second, millisecond]
    7. 详细可参见[文档](http://momentjs.cn/docs/#/parsing/string/)

    第二个参数：传入一个时间格式，用于规范第一个参数的格式，便于识别，也可以传入一个数组，规定可能存在的格式

3. moment()常用方法
   
   1. format(param)：格式化时间
    
    2. isValid()：判断moment()的结果是不是一个合法的moment对象

        ```js
        moment([2015, 25, 35]).isValid(); // false
        moment('lsjflsjd').isValid(); // false
        ```

    3. creationData()：访问moment对象的所有输入

        ```js
        moment("2013-01-02", "YYYY-MM-DD", true).creationData() === {
            input: "2013-01-02",
            format: "YYYY-MM-DD",
            locale: 语言环境对象,
            isUTC: false,
            strict: true
        }
        ```

4. 取值和赋值

    1. Moment.js使用重载的`getter`和`setter`方法。此模式和`jQuery`使用类似  

        1. 不带参数调用会作为`getter`进行取值
        2. 带参数调用会作为`setter`进行赋值
        3. 单数和复数意义相同
        4. 一般规律

            `moment().get(unit) === moment()[unit]()`

    2. 实例

        1. millisecond() 获取或设置毫秒

            如果超出范围（0-999），则会冒泡到秒钟

            ```js
            moment().millisecond(Number);
            moment().millisecond(); // 数字
            moment().milliseconds(Number);
            moment().milliseconds(); // 数字
            ```

        2. second() 获取或设置秒 如果超出范围（0-59），则会冒泡到分钟

            

        3. minute() 获取或设置分钟 如果超出范围（0-59），则会冒泡到小时
            
        4. hour() 获取或设置小时 如果超出范围（0-23），则会冒泡到日期
            
        5. date() 日期 （0-31） 冒泡到月份

        6. day() 星期几 （0-6） 冒泡到其他星期（10 下周三）

        7. month() 月份 （0-11）冒泡到年份

        8. quarter() 季度 （1-4） 不冒泡

        9. year() 年份 （-270000-270000）

    3. get()

        ```js
        moment().get('year');
        moment().get('quarter'); // 季度
        moment().get('month');  // 0 至 11
        moment().get('day'); // 星期
        moment().get('date'); // 天
        moment().get('hour');
        moment().get('minute');
        moment().get('second');
        moment().get('millisecond');
        ```

        单位不区分大小写，单数和复数都支持

    4. set()

        ```js
        moment().set('year', 2013);
        moment().set('month', 3);  // 四月
        moment().set('date', 1);
        moment().set('hour', 13);
        moment().set('minute', 20);
        moment().set('second', 30);
        moment().set('millisecond', 123);

        moment().set({'year': 2013, 'month': 3});
        ```

        单位不区分大小写，单数和复数都支持

    5. 最大值和最小值

        ```js
        moment.max(Moment[,Moment...]);
        moment.max(Moment[]);

        moment.min(Moment[,Moment...]);
        moment.min(Moment[]);
        ```

5. 操作

    moment是流式接口模式，也成为方法链，就是说低啊用方法之后的返回值还是moment对象。

    注意：moment是可变的。调用任何一种操作方法都会改变原始的moment（可以创建副本并进行操作）

    1. add() 通过增加时间来改变原始moment

        moment(数量, 时间键); // 时间键可以使用简写
        ```
        moment().add(7, 'days');
        moment().add(7, 'd');
        ```

        |全称|简写|
        |-|-|
        |years|y|
        |querters|Q|
        |months|M|
        |weeks|w|
        |days|d|
        |hours|h|
        |minutes|m|
        |seconds|s|
        |milliseconds|ms|

        如果需要增加多个不同的键，则可以将它们作为对象字面量传入

        ```js
        moment().add(7, 'days').add(1, 'months'); // 链式
        moment().add({days:7,months:1}); // 对象字面量
        ```

        如果原始日期的月份中的日期大于最终月份中的天数，则该月份中的日期将会更改为最终月份的最后一天

        ```js
        moment([2010, 0, 31]);                  // 一月 31 号
        moment([2010, 0, 31]).add(1, 'months'); // 二月 28 号
        ```

    2. subtract() 通过减去时间来改变原始的moment

        用法和add()完全相同

        并且，add()负数作为参数和subtract()正数作为参数相同

    3. startOf() 通过将原始的moment设置为时间单位的开头来对其进行更改

        ```js
        moment().startOf('year');    // 设置为今年一月1日上午 12:00
        moment().startOf('month');   // 设置为本月1日上午 12:00
        moment().startOf('quarter');  // 设置为当前季度的开始，即每月的第一天上午 12:00
        moment().startOf('week');    // 设置为本周的第一天上午 12:00
        moment().startOf('isoWeek'); // 根据 ISO 8601 设置为本周的第一天上午 12:00
        moment().startOf('day');     // 设置为今天上午 12:00
        moment().startOf('date');     // 设置为今天上午 12:00
        moment().startOf('hour');    // 设置为当前时间，但是 0 分钟、0 秒钟、0 毫秒
        moment().startOf('minute');  // 设置为当前时间，但是 0 秒钟、0 毫秒
        moment().startOf('second');  // 与 moment().milliseconds(0); 相同
        ```

    4. endOf() 通过将原始的moment设置为时间单位的结尾来对其进行更改


6. 显示

    一旦对于时间解析和操作完成之后就需要通过某种方式来显示或格式化时间

    1. format() 

        参数常用格式

        |格式|例子|说明|
        |-|-|-|
        |YYYY\|YY|2020、20|两位数或四位数的年份|
        |MM\|M|01、1|补0和不补0的月份|
        |DD\|D|2、02|补0和不补0的天数|
        |L|04/09/1985|通过本地格式输出日期|
        |ww\|w|3、03|补0和不补0的本年第几周|
        |e|3|本周星期几|
        |HH\H|8、08|小时（24小时制，00-23）|
        |hh\|h|8、08|小时（12小时制）|
        |kk\|k|8、08|小时（24小时制，01-24）|
        |mm\|m|8|分钟|
        |ss\|s|8|秒钟|
        |YYYY-MM-DD HH-mm-ss|2020-10-12 20-20-20|最常用的时间格式|
        |YYYY:MM:DD HH:mm:ss|2020:10:12 20:20:20|最常用的时间格式|

        更详细的可以参考[官方文档](http://momentjs.cn/docs/#/displaying/format/)

    2. fromNow()

        moment初始时间到现在的时间间隔，一般情况要初始化moment，参数为true表示不带后缀

        ```js
        moment().fromNow();
        moment().fromNow(Boolean);

        moment([2007, 0, 29]).fromNow();     // 4 年前
        moment([2007, 0, 29]).fromNow(true); // 4 年
        ```

    3. form()

        两个时间段的时间间隔

        ```js
        var start = moment([2007, 0, 5]);
        var end   = moment([2007, 0, 10]);
        end.from(start);       // "5 天内"
        end.from(start, true); // "5 天"
        ```

    4. toNow()

        和`fromNow`相反：`fromNow() === -toNow()`

    5. to()

        和`from`相反：`from() === to()`

    6. diff()

        获取两个时间间隔，默认单位单位是毫秒，第二个参数可接受其他单位

        ```js
        var a = moment([2007, 0, 29]);
        var b = moment([2007, 0, 28]);
        a.diff(b, 'days') // 1
        ```

    7. valueOf() unix()

        获取毫秒级和秒级的时间戳

    8. daysInMonth()

        获取当月天数

    9. toArray() toJSON() toObject() toString()

        通过一定数据格式输出时间

7. 查询

    1. isBefore()

        检查一个moment是否在另一个moment之前

        ```js
        moment('2010-10-20').isBefore('2010-10-21'); // true
        ```
        
        默认精度是毫秒，第二个参数用于确定精度，当传入之后将会检查对应的精度

        ```js
        moment('2010-10-20').isBefore('2010-12-31', 'year'); // false
        moment('2010-10-20').isBefore('2011-01-01', 'year'); // true
        ```

        当没有参数是，默认为当前时间

    2. isSame() 

        检查一个moment是否和另一个momnet相同

        默认精度是毫秒，第二个参数用于确定精度，当传入之后将会检查对应的精度

    3. isAfter()

        和`isBefore`相反

    4. isSameOrBefore()  isSameOrAfter()

        相同或之前，相同或之后

    5. isBetween()

        一个moment是否在两个moment之间

        ```js
        moment('2010-10-20').isBetween('2010-10-19', '2010-10-25'); // true
        moment('2010-10-20').isBetween('2010-10-19', undefined); // true, 因为 moment(undefined) 等效于 moment()
        ```

        第三个参数是精度，第四个是区间范围开闭情况（中括号表示闭，小括号表示开）

        ```js
        moment('2016-10-30').isBetween('2016-10-30', '2016-12-30', null, '()'); //false
        moment('2016-10-30').isBetween('2016-10-30', '2016-12-30', null, '[)'); //true
        moment('2016-10-30').isBetween('2016-01-01', '2016-10-30', null, '()'); //false
        moment('2016-10-30').isBetween('2016-01-01', '2016-10-30', null, '(]'); //true
        moment('2016-10-30').isBetween('2016-10-30', '2016-10-30', null, '[]'); //true
        ```

8. 时长

    将moment定义为单个时间点，将duration定义为时间的长度。时长没有定义开始和结束日期，他们是没有上下文的

    `注意这里的moment是对象，而不是函数`

    1. duration()

        创建时长

        ```js
        moment.duration(2, 'seconds');
        moment.duration({
            seconds: 2,
            minutes: 2,
        });
        ```

    2. 获取时长，这里是最大的单位

        ```js
        moment.duration(1, "minutes").humanize(); // 1 分钟
        // 参数传true表示带后缀
        moment.duration(2, "minutes").humanize(true); // 2 分钟内
        ```

    3. 获取不同的时长

        毫秒数：millseconds()  
        秒数：seconds()  
        分钟数：minutes()  
        ...

    4. add() subtract()

        通过增加和减少时间来更改原始时长

    5. duration(x.diff(y))

        获取两个moment之间的时长

    6. get()

        通过传入不同参数的方式来获取时长

        ```js
        duration.get('hours');
        ```