<!--
 * @Date: 2020-10-26 10:32:28
 * @LastEditors: Lq
 * @LastEditTime: 2020-10-29 16:20:23
 * @FilePath: /learnningNotes/js/重学js-大知识点.md
-->
### Set和Map

##### Set

1. 基本用法：类似于数组，但是成员的值都是唯一的，没有重复的值

    本身是一个构造函数，用来生成Set数据结构

    ```js
    const s = new Set();

    [1, 2, 3, 4, 5, 1, 2].forEach(item => s.add(item));

    for (let i of s) {
        console.log(i);
    }
    // 1,2,3,4,5
    ```

    可以接受一个数组（或者具有迭代器的其他数据结构）作为参数，用于初始化

    ```js
    const s = new Set([1,2,3,1,2]);
    console.log([...s]); // [1,2,3]
    console.log(s.size); // 3

    const s1 = new Set(doucument.querySelectorAll('div));
    console.log(s1.size); // 10
    ```

    常用快捷方法
    ```js
    // 常用于去重数组
    [...new Set(arr)]

    // 用于去重重复字符串
    [...new Set('abababc')].join('')

    // Array.from()可以将Set结构转化为数组
    const s = new Set([1, 2, 3, 4, 5]);
    const arr = Array.from(s);
    console.log(arr); // [1, 2, 3, 4, 5]
    ```

2. Set实例的属性和方法

    1. 属性

        `constructor`：构造函数，默认就是Set函数  
        `size`：返回Set实例的成员总数

    2. 方法

        1. 操作方法

            `add(value)`：添加一个值，返回Set结构本身（`可以进行链式调用`）  
            `delete(value)`：删除一个值，返回一个布尔值，表示删除是否成功  
            `has(value)`：判断是否有某一个值，返回一个布尔值，表示是否为Set的成员  
            `clear()`：清除所有成员，无返回值


        2. 遍历方法：Set的遍历顺序就是插入顺序，这个特性有时候很有用，比如说用Set结构保存一个回调函数的列表，调用用的时候就能够保证按照添加顺序进行调用。

            `keys()`：返回键名的遍历器  
            `values()`：返回键值的遍历器  
            `entries()`：返回键值对的遍历器  
            `forEach()`：使用回调函数遍历每一个成员

            由于Set结构的键名和键值相同，所以`keys()`和`values()`完全一致

            ```js
            const s = new Set(['one', 'two', 'three']);

            // keys或values的使用
            for (let item of set.keys()) {
                console.log(item); // 'one', 'two', 'three'
            }

            // entries的使用
            for (let item of set.entries()) {
                console.log(item); // ["one", "one"], ["two", "two"], ["three", "three"]
            }
            ```

            Set实例默认就可以进行遍历，默认遍历器生成函数就是values方法

            ```js
            const s = new Set(['one', 'two', 'three']);

            for (let item of s) {
                console.log(item); // 'one', 'two', 'three'
            }
            ```

            forEach的使用：参数1和参数2相同（都是键值），参数3为集合本身

            ```js
            const s = new Set(['one', 'two', 'three']);

            s.forEach((key, value, item) => {
                console.log(key, value, item);
            })
            ```

    3. 如果想在遍历的操作中改变原来的Set结构，并没有直接的方法，但是可以使用变通的方法。  
        一种是利用原Set结构映射出一个新的结构，然后复制给原来的Set结构；  
        第二种是利用`Array.from()`方法
        ```js
        // 方法一
        let set = new Set([1, 2, 3]);
        set = new Set([...set].map(val => val * 2));
        // set的值是2, 4, 6

        // 方法二
        let set = new Set([1, 2, 3]);
        set = new Set(Array.from(set, val => val * 2));
        // set的值是2, 4, 6
        ```

##### Map

1. 基本用法和含义

    js中的对象，本质上是键值对的集合（Hash结构），但是传统上只能用字符串当做键名。

    为了解决这个问题，ES6提供了Map数据结构。他类似于对象，也是键值对的集合，但是键名的范围不限于字符串，各种类型的值（包括对象）都可以当做键。  
    也就是说，Object结构提供了”字符串-值“的对应关系，Map结构提供了”值-值“的对应关系，是一种更完善的Hash结构。

    ```js
    const m = new Map();
    const o = { name: "lan" };
    m.set(o, "hello");
    m.get(o); // hello
    m.has(o); // true
    m.delete(o); // true
    ```

    通过构造函数进行初始化，接受一个数组作为参数，数组的成员是一个个表示键值对的数组。

    或者说，只要是具有迭代器的结构，并且每一个成员都是一个双元素的数组的数据结构就能用来作为Map构造函数的参数。也就是说，Set和Map的实例都可以用来生成新的Map
    ```js
    const m = new Map([
        ["name", "lan"],
        ["age", 12],
        ["gender", "male"]
    ]);
    
    const s = new Set([['one', 1], ['two', 2], ['three', 3]]);
    const m1 = new Map(s);
    const m2 = new Map(m);

    // 下面写法是错误的
    const arr = [1,23,4,5];
    const m = new Map(new Set(arr));
    const m1 = new Map({name: "lan"});
    ```

    注意：对于引用类型作为键名的话，如果引用地址没有改变，则视为同一个键；同理，如果引用地址改变了，就算值相同也视为不同的键

    ```js
    const m = new Map();
    const arr = [1,2,3];
    const arr1 = arr;
    m.set(arr, "arr");
    m.set(arr1, "arr1"); // 在这里之前的arr被arr1给覆盖了，因为是相同的引用地址

    const a1 = [1,2];
    const a2 = [1,2];
    m.set(a1, 'a1');
    m.set(a2, 'a2');
    m.get(a1); // a1
    m.get(a2); // a2   
    ```

    特殊：对于NaN来说，虽然NaN不严格相等，但是在Map中，这两个视为相同

    ```js
    const m = new Map();
    m.set(NaN, 111);
    m.get(NaN); // 111
    ```

2. Map实例的属性和方法

    1. 属性

        `size`：返回Map结构的成员总数

        ```js
        const m = new Map([[1, 1], [2, 2]]);
        m.size; // 2
        ```

    2. 方法

        1. 操作方法

            `set()`：设置键名和键值，如果已经有了则会覆盖，返回的还是Set对象，所以可以进行链式调用  
            `get()`：返回键值，参数是键名，如果找不到返回undefined  
            `has()`：返回布尔值，参数是键名，表示某一个键是否在Map结构中  
            `delete()`：返回布尔值，参数是键名，删除某一个键值对  
            `clear()`：清除所有成员，没有返回值

            ```js
            const m = new Map();
            m.set("name", "lan").set("age", 12);
            m.get("name"); // lan
            m.has("name"); // true
            m.delete("name"); // true
            m.clear();
            ```

        2. 遍历方法：提供了3个遍历器生成函数和一个遍历方法（基本同Set）

            `keys()`：返回键名的遍历器  
            `values()`：返回键值的遍历器  
            `entries()`：返回所有成员的遍历器  
            `forEach()`：遍历所有Map成员  

            默认的遍历器是entries：`m[Symbol.iterator] === map.entries`

            Map的遍历顺序就是插入顺序

            ```js
            const m = new Map([
                ["one", 1],
                ["two", 2],
                ["three", 3]
            ]);

            for (let key of m.keys()) {
                console.log(key); // one, two, three
            }

            for (let values of m.values()) {
                console.log(values); // 1,2,3
            }

            for (let item of m.entries()) {
                console.log(item); // ["one", 1], ["two", 2], ["three", 3]
            }

            // 使用默认的遍历器 
            for (let item of m) {
                console.log(item); // ["one", 1], ["two", 2], ["three", 3]
            }

            // 遍历的同时进行解构键值对
            for (let [key, value] of m) {
                console.log(key, value);
            }

            // 使用foreach，注意回调中的参数顺序，forEach的第二个参数还可以用来绑定this
            m.forEach((v, k, m) => {
                // 键值，键名，map对象
                console.log(k, v, m);
            })
            ```

    3. 一些操作技巧
       1. Map转化为数组结构，比较快的方法就是使用扩展运算符

            ```js
            const m = new Map([
                ["one", 1],
                ["two", 2],
                ["three", 3]
            ]);

            [...m.keys()]; // ["one", "two", "three"]

            [...m.values()]; // [1, 2, 3]

            [...m.entries()]; // [["one", 1], ["two", 2], ["three", 3]]

            [...m]; // [["one", 1], ["two", 2], ["three", 3]]
            ```

        2. 结合数组的map和filter方法，可以实现Map的遍历和过滤

            ```js
            const m = new Map()
                .set(1, 'a')
                .set(2, 'b')
                .set(3, 'c');
            
            const m1 = new Map(
                [...m].filter(([k, v]) => k > 2 )
            );

            const m2 = new Map(
                [...m].map(([k, v]) => [k * 2, v + 1])
            );
            ```

3. 和其他数据结构的相互转换

    1. Map转为数组：扩展运算符

        ```js
        const m = new Map([[1, 2], [3, 4], [5, 6]]);

        const arr = [...m];
        ```

    2. 数组转Map：数组必须是二维的，且第二维只希望有2个元素（不足自动补undefined，多余自动忽略）

        ```js
        const arr = [[1, 2], [4, 5], [3], [7, 8, 9]];

        const m = new Map(arr);
        ```

    3. Map转对象：最好键名都是字符串

        如果键名是字符串，那么可以无损的转换，如果不是字符串会被强制转化为字符串作为键名

        ```js
        function strMapToObj(strMap) {
            let obj = {};
            for (let [k, v] of strMap) {
                obj[k] = v;
            }
            return obj;
        }

        const m = new Map()
            .set("name", "lan")
            .set("age", 12);
        strMapToObj(m); // {name: "lan", age: 12}
        ```

    4. 对象转Map：借用`Object.entires()`方法

        ```js
        const obj = {name: "lan", age: 12};

        const m = new Map(Object.entires(obj));
        ```

    5. Map转JSON：分为对象JSON和数组JSON两种情况

        ```js
        // 如果键名都是字符串，可以转化为对象JSON
        function strMapToJson(strMap) {
            return JSON.stringify(strMapToObj(strMap));
        }
        let m = new Map().set("name", "lan").set("age", 12);
        strMapToJson(m);

        // 如果键名有非字符串，可以转化为数组JSON
        function mapToArrayJson(map) {
            return JSON.stringify([...map]);
        }
        let m1 = new Map().set("name", "lan").set(111, 12);
        mapToArrayJson(m1);
        ```

    6. JSON转Map：正常情况下，所有的键名都是字符串

        ```js
        function jsonToStrMap(jsonStr) {
            return objToStrMap(JSON.parse(jsonStr));
        }

        jsonToStrMap('{"name": "lan", "age": 12}');
        ```

        有一种特殊情况，整个JSON就是一个数组，并且每一个数组成员本身又是一个有两个成员的数组。这时，就可以无损的转为Map。这往往是Map转为数组JSON的逆操作。

        ```js
        function jsonToMap(jsonStr) {
            return new Map(JSON.parse(jsonStr));
        }

        jsonToMap('[["name", "lan"], ["age", 12]]');
        ```


### 递归

1. 定义：在执行一个函数的时候调用函数本身

2. 示例：求阶乘

    ```js
    function f(n) {
        if (n === 1) {
            return 1;
        }
        return n * f(n -1);
    }

    console.log(f(3)); // 6
    ```

3. 求解步骤：求阶乘

    1. 明确功能：算n的阶乘

    2. 寻找结束条件：当n小于等于1的时候

        说明：就是当参数满足的条件能够让你直接获取结果的时候

    3. 寻找递归前后的关系：f(n) = n * f(n-1);

        说明：我们在这里是每次n进行减1，那么就是寻找`f(n)`和`f(n-1)`之间 的关系

4. 新的案例

##### 递归和循环的区别

```js
// 递归求阶乘
function f(n) {
    if (n === 1) {
        return 1;
    }
    return n * f(n -1);
}


// 循环求阶乘
function fn(n) {
    let num = 1;
    for(let i = 1; i <= n; i++) {
        num = num * i;
    }
    return num;
}
```

在某种程度上来说，两者都能做到一样的事情。  
能用循环的优先用循环，效率高，速度快。

递归：  
    缺点：每次调用需要创建新的变量，会增加额外的堆栈处理，执行效率低，占用过多内存，有可能会造成栈溢出。  
    优点：代码简洁清晰，易验证准确性

循环：  
    缺点：不能解决所有问题，有的问题更适合用递归  
    优点：速度快，结构简单


### 迭代器