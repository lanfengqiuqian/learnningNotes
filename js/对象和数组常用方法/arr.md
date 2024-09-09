## 添加或者删除

### 破坏性数组方法

会更改原始数组

| 方法    | 使用                                     | 作用                       | 返回值                                       |
| ------- | ---------------------------------------- | -------------------------- | -------------------------------------------- |
| pop     | arr.pop()                                | 删除最后一个元素           | 已删除的元素                                 |
| ｜ push | arr.push('a', 'b')                       | 往最后增加元素（可以多个） | 新数组的长度                                 |
| shift   | arr.shift()                              | 删除第一个元素             | 已删除的元素                                 |
| unshift | arr.unshift('a', 'b')                    | 往最前添加元素（可以多个） | 新数组的长度                                 |
| splice  | arr.splice(index, length, el1, el2, ...) | 添加或者删除特定元素       | 返回删除的数组，如果只添加元素时，返回空数组 |
| fill    | arr.fill(el, start, end)                 | 填充数组                   | 填充之后的数组                               |

### 非破坏性数组方法

不改变原始数组

| 方法   | 使用                                                   | 作用                                            | 返回值                   |
| ------ | ------------------------------------------------------ | ----------------------------------------------- | ------------------------ |
| concat | arr1.concat(arr2, arr3, ...), arr1.concat('a','b', ..) | 连接数组                                        | 连接后的新数组           |
| slice  | arr.slice(startIndex, endIndex)                        | 获取开始和结束索引的数组，如果 end 不传则到结尾 | 开始和结束索引之间的数组 |

## 拼接数组

| 方法 | 使用          | 作用                     | 返回值           |
| ---- | ------------- | ------------------------ | ---------------- |
| join | arr.join(',') | 使用特定符号拼接数组元素 | 拼接之后的字符串 |

## 遍历

| 方法      | 使用                                  | 作用                                           | 返回值                                     |
| --------- | ------------------------------------- | ---------------------------------------------- | ------------------------------------------ |
| includes  | arr.includes(el, startIndex)          | 判断是否包含某个元素（起始位置不传默认 0）     | true/false                                 |
| every     | arr.every((el, index, arr) => el > 0) | 判断数组中是都满足条件的                       | true/false                                 |
| some      | arr.some((el, index, arr) => el > 0)  | 判断数组是否有满足条件的值                     | true/false                                 |
| find      | arr.find(callback)                    | 查找数组中第一个满足条件的值                   | 满足条件的第一个元素，没有则返回 undefined |
| filter    | arr.filter(callback)                  | 获取所有满足条件的元素                         | 满足条件的数组，没有则为空数组             |
| forEach   | arr.forEach(callback)                 | 遍历数组                                       | undefined                                  |
| map       | arr.map(callback)                     | 整理数组，修改成需要的结构                     | 修改之后的数组                             |
| findIndex | arr.findIndex(callback)               | 查找数组中第一个满足条件的索引                 | 满足条件的第一个索引，没有则返回-1         |
| findIndex | arr.findIndex(el, startIndex)         | 查找第一个元素的位置, 起始位置负数则从末尾开始 | 满足条件的第一个索引，没有则返回-1         |

### 复杂方法 reduce

一般用于数组的求和

```js
let arr = [1, 2, 3];
let total = arr.reduce((total, cur) => total + cur, 0); // 6
```

参数：callback（累加回调）, initialValue

| 参数         | 子参数       | 说明               |
| ------------ | ------------ | ------------------ |
| callbck      |              | 累加回调           |
|              | total        | 累加初始值         |
|              | currentValue | 当前元素           |
|              | currentIndex | 当前元素索引       |
|              | arr          | 数组对象           |
| initialValue |              | 可传递的累加初始值 |

initialValue 如果不传的话，默认是数组第一个元素，迭代从 index 为 1 开始

initialValue 如果传的话，迭代从 index 为 0 开始



## 嵌套数组解构

| 方法 | 使用 | 作用 | 返回值 |
| ---- | ---- | ---- | ------ |
| flat |arr.flat(deep)|根据指定的深度连接所有子数组元素来创建新数组|解构之后的新数组|
|flatmap|arr.flatmap(callback)|相当于arr.map(callback).flat(1)||
