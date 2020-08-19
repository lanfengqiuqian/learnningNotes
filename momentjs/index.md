<!--
 * @Date: 2020-08-19 16:20:42
 * @LastEditors: Lq
 * @LastEditTime: 2020-08-19 16:42:52
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
