<!--
 * @Date: 2020-10-26 10:32:28
 * @LastEditors: Lq
 * @LastEditTime: 2022-06-30 12:24:06
 * @FilePath: \learnningNotes\js\重学js-大知识点.md
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


### 纯函数

1. 定义
   1. 函数的返回结果只依赖于他的参数
   2. 函数执行过程中没有副作用

2. 解释

    1. 返回结果只依赖于参数：只要参数相同，结果一定相同

        ```js
        let a = 2;
        function add(x) {
            return a + x;
        }
        add(2);
        ```
        add不是一个纯函数，因为他的返回结果依赖于外部变量a，外部变量的值不可预料（有可能变化），导致相同的参数可能会导致出现不同的结果

    2. 执行过程中没有副作用：不会对外部产生可观察的变化

        ```js
        function add(a, b) {
            console.log(a + b);
            return a + b;
        }
        add(1, 2);
        ```

        add不是一个纯函数，因为在执行的过程中会在控制台打印数据，产生了可观察的变化

        可观察的变化：如

        1. 在控制台输出数据
        2. 修改了函数外部的变量的值
        3. 请求数据
        4. 调用dom修改页面
        5. 刷新页面
        6. 。。。。

        总之，除了计算数据做不了其他的事情，并且计算数据还不能依赖函数外部的数据

3. 优点

    不会产生不可预料的行为，也不会对外部产生影响。  
    程序调试、测试江湖非常方便。


### 函数式编程

1. 定义：一种编程标准，也就是如何编写程序的方法论。主要思想就是把sun算过程尽量携程一系列嵌套的函数调用。

    egg：(1 + 2) * 3 - 4

    ```js
    // 老式写法
    let a = 1 + 2;
    let b = a * 3;
    let c = b - 4;

    // 函数式编程：将过程定义成不同的函数
    let res = subtract(multiply(add(1, 2), 3), 4);
    ```

2. 特点

    1. 函数式”第一等公民“

        函数和其他数据类型一样，处于平等地位，可以复制给其他变量，也可以作为参数，传入另一个函数，或者作为别的函数的返回值。

    2. 只用”表达式“，不用”语句“

        表达式：单纯的元素过程，总是有返回值。

        语句：是执行某种操作，没有返回值。

        因为函数式编程的最初目的，就是为了处理运算，不考虑系统的读写（IO操作），语句属于对于系统的读写操作，但是实际应用中，只能做到少使用语句，不能完全避免

    3. 没有副作用：不会对于外部产生可观察的变化

    4. 不修改状态：不能够修改外部变量的值

    5. 引用透明：相同的参数总是返回相同的结果，不依赖于外部变量或状态


3. 优点

    1. 代码简洁，开发快速

        大量使用函数，减少了代码的重复，因此程序比较短，开发速度较快

    2. 接近自然语言，易于理解

        函数式编程自由度很高，可以写出很接近自然语言的代码

        ```js
        subtract(multiply(add(1,2), 3), 4)

        add(1,2).multiply(3).subtract(4)
        ```

    3. 更方便的代码管理

        函数式编程不依赖、也不会改变外部的状态，只要给定输入参数，返回的结果一定相同。因此，每一个函数都可以被看做独立单元，很利于进行单元测试和除错，以及模块化组合。

    4. 易于”并发编程“

        函数式编程不需要考虑思索，因为他不修改变量，所以根部不存在锁线程的问题。不必担心一个线程的数据，被另一个线程修改，所以可以很放心的把工作分摊到多个县城，部署并发编程。

        ```js
        let a = f(1);
        let b = f(2);
        let c = fn(a, b);
        ```

        因为a和b互不干扰，不会修改变量，所以谁先执行是无所谓的，所以可以放心的增加线程。

        多核CPU是将来的潮流，所以函数式编程的这个特性非常重要。

    5. 代码的热升级

        函数式编程没有副作用，只要保证接口不变，内部实现和外部无关。所以可以在运行状态下直接升级代码，不需要重启，也不需要停机。


### 闭包

1. 定义：本质是一个函数，它能够访问另外一个函数作用于的变量

    最简单创建闭包的方式：将一个函数作为另一个函数的返回值

    ```js
    function aaa(){
        var name = "xxx"
        return function bbb(){
            alert(name);
        }
    }
    ```

    在这里bbb能够访问aaa中的变量

2. 特性：闭包中的变量不会被垃圾回收机制处理，能够将函数内部的变量一直保存在内存中

3. 使用案例：

    ```js
    for( var i = 0; i < 5; i++ ) {
        setTimeout(() => {
            console.log( i );
        }, 1000)
    }
    ```

    这里的打印结果是5个5，如果想要打印0~4要怎么修改

    关键点：在for循环内创建闭包

    ```js
    // 匿名自执行函数写法
    for (var i = 0; i < 5; i++) {
        ((j) => {
            setTimeout(function() {
                console.log(j);
            },1000)
        })(i)
    }

    // 翻译一下
    for (var i = 0; i < 5; i++) {
        function demo(j) {
            setTimeout(function() {
                console.log(j);
            },500)
        }
        demo(i)
    }
    ```

### 防抖和节流

0. [参考文章](https://segmentfault.com/a/1190000018428170)

1. 使用场景：适用于高频触发的函数或事件，快速连续触发和不可控的高频触发

    如：鼠标移动事件，窗口放大缩小，input输入

    影响：响应跟不上触发，导致页面卡顿、假死现象

2. 防抖：debounce

    1. 介绍：当事件触发时，设定一个周期延迟执行动作，如果期间又被触发，则重新设定周期，直到周期结束，才会执行动作。

    2. 例子：监听页面滚动事件,如果靠近底部则出现回到顶部按钮

        ```js
        function showTop() {
            var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
            console.log('滚动条位置：', scrollTop);
        }
        window.onscroll = showTop;
        ```

        如果这样写的话执行频率太高，进行防抖处理

        ```js
        function debounce(fn, delay) {
            let timer = null;
            return function() {
                if (timer) {
                    clearTimeout(timer);
                }
                timer = setTimeout(fn, delay);
            }
        }
        window.onscroll = debounce(showTop, 1000);
        ```

3. 节流：throttle

    1. 介绍：不定周期内，只执行一次动作，如果在周期内有新事件触发，不执行（`这里不会重新设定周期`）。周期结束后，如果又有事件触发，又开始新的周期。

    2. 例子：监听页面滚动事件,如果靠近底部则出现回到顶部按钮

        使用上面的防抖方法的话，会导致，如果页面一直在滚动，那么永远只会执行一次，如果想在这种情况下每隔一段时间再执行的话考虑使用节流。

        ```js
        function throttle(fn, delay) {
            let valid = true;
            return function() {
                if (!valid) {
                    return false;
                }
                valid = false;
                setTimeout(() => {
                    fn();
                    valid = true;
                }, delay);
            }
        }
        window.onscroll = throttle(showTop, 1000);
        ```

4. 区别：是否会重新设定周期（如果很长一段时间都在触发事件的话，防抖只会执行一次，节流可执行多次）

5. 选择策略

    防抖：操作高频触发，但有停顿。窗口拉伸，联想搜索。

    节流：操作高频触发，连续不断。页面滚动，鼠标不断点击。


### xhr、fetch、jQuery、axios的区别

1. ajax

    1. Asynchronous JavaScript and XML（异步的 JavaScript 和 XML）。
    2. 最早出现的发送后端请求技术，更新部分网页（不重新加载整个页面）。
    3. 核心是使用`XMLHttpRequest`对象，现代浏览器都支持。

2. xhr

    1. 是`XMLHttpRequeest`对象的实例。
    2. 配置信息比较混乱复杂。
    3. 如果请求有先后顺序会出现回调地狱。

3. jQuery

    1. 是对于原生xhr的封装，除此之外添加了jsonp的支持。
    2. jQuery整个项目比较大，如果单纯的为了ajax引入不合理。
    3. 配置和调用方式飞创婚礼，对于基于事件的异步模型不友好。

4. fetch

    1. 并不是对于xhr的封装，没有使用XMLHttpRequest对象。
    2. 是基于promise设计的，代码结构清晰，支持async/await。
    3. 比较底层的api，意味着配置相对麻烦。

5. axios

    1. 基于Promise。
    2. 本质上也是对于原生xhr的封装。
    3. 是一个非常轻量的库。




### Proxy

1. 介绍

   1. 是一个全局对象，可以直接使用。
   2. 构造函数`Proxy(target, handler)`
   
       1. 返回值是一个代理对象
       2. target是被代理的对象
       3. handler是声明了各类代理操作的一个对象
       4. 外部每次通过代理对象访问target对象的属性时，都会经过过handler对象，这个流程有点像中间件     
2. Reflect

    1. 是一个内置的对象，提供拦截JavaScript操作的方法，这些方法和proxy的handler的方法相同
    2. 不是一个函数对象，所以它是不可构造的，不能使用new运算符调用
    3. 它所有的手续性和方法都是静态的，只能通过该对象调用（像Math）


3. 特性

    1. 拦截和监事外部对对象的访问
    2. 降低函数或者类的复杂度
    3. 在复杂操作前对操作进行校验或对所需资源进行管理

4. 简单demo

    ```js
    let test = {
        name: "小红"
    };
    test = new Proxy(test, {
        get(target, key) {
        console.log('获取了getter属性');
            return Reflect.get(target, key);
        }
    });
    console.log(test.name);
    ```

5. 常用handler

    1. get：读取属性
    2. set：设置属性
    3. deleteProperty：删除属性
    4. has：in操作捕捉器
    5. apply：函数调用捕捉器

    参数和返回值

    ```js
    getPrototypeOf? (target: T): object | null;
    setPrototypeOf? (target: T, v: any): boolean;
    isExtensible? (target: T): boolean;
    preventExtensions? (target: T): boolean;
    getOwnPropertyDescriptor? (target: T, p: PropertyKey): PropertyDescriptor | undefined;
    has? (target: T, p: PropertyKey): boolean;
    get? (target: T, p: PropertyKey, receiver: any): any;
    set? (target: T, p: PropertyKey, value: any, receiver: any): boolean;
    deleteProperty? (target: T, p: PropertyKey): boolean;
    defineProperty? (target: T, p: PropertyKey, attributes: PropertyDescriptor): boolean;
    ownKeys? (target: T): PropertyKey[];
    apply? (target: T, thisArg: any, argArray?: any): any;
    construct? (target: T, argArray: any, newTarget?: any): object;

    ```


#### 使用场景

1. 请求代理

    1. 作用：主要用于解决浏览器跨域问题（同源策略）
    2. 思想

        1. 关键点

            1. 先请求一个同源的服务器，再由该服务器去请求其他的服务器
            2. 浏览器存在同源策略，但是服务器不存在

        2. 实现过程

            1. 本地环境是`http://localhost:3000`
            2. 本来要请求`https://demo.com`服务器，但是他存在跨域
            3. 所以 先请求`http://localhost:3000`，它不存在跨域问题，所以受理了请求，并可以获取它返回的数据
            4. 而有`http://localhost:3000`返回的数据，又是从真实的`http://demo.com`获取来的，因为服务端不是浏览器环境，所以没有浏览器的安全策略问题
            5. 因为`http://localhost:3000` 这个服务器，只是把请求的参数，转发到真实的服务端，又把真实服务端下发的数据，转发给我们，所以我们称它为代理

2. 表单校验

    1. 作用：在对表单的值进行 改动的时候，可以在set里面进行拦截，判断值是否合法

    2. demo

        需求：校验输入的姓名是否合法

        ```js
        let checkForm = {
            set(target, key, value, receiver) {
                if (key === 'age') {
                    if (value < 0 || !Number.isInteger(value)) {
                        throw new TypeError('年龄必须是正整数');
                    }
                }
                return Reflect.set(target, key, value, receiver);
            }
        }
        let obj = new Proxy({age: 18}, checkForm);
        obj.age = '少奶n';
        ```

3. 增加附加属性

    1. demo

        需求：在用户输入正确的身份证号码之后，将出生年月，籍贯，性别都添加到用户信息中

        ```js
        const PROVINCE_NUMBER = {
            44: '广东省',
            46: '海南省'
        }
        const CITY_NUMBER = {
            4401: '广州市',
            4601: '海口市'
        }
        let ecCardNumber = {
            set(target, key, value, receiver) {
                if (key === 'cardNumber') {
                    Reflect.set(target, 'hometown', PROVINCE_NUMBER[value.substr(0, 2)] + CITY_NUMBER[value.substr(0, 4)], receiver);
                    Reflect.set(target, 'date', value.substr(6, 8), receiver);
                    Reflect.set(target, 'gender', value.substr(-2, 1)%2 === 1 ? '男' : '女', receiver);
                }
                return Reflect.set(target, key, value, receiver);
            }
        }
        let obj = new Proxy({cardNumber: '4401111111111111'});
        console.log(obj.)
        ```



### Promise

#### 概念

1. 是异步变成的一种解决方案，比传统的解决方案（回调函数和事件）更合理和强大。ES6将其写进了语言标准，统一了用法，原生提供了`Promise`对象。

2. 简单来说，Promise就是一个容器，里面保存着某一个未来才会结束的事件（通常是一个异步操作）的结果。从语法上来说，Promise是一个对象，从它可以获取异步操作的消息。

### 特点

1. Promise对象代表一个异步操作，有3种状态

    1. pending：进行中
    2. fulfilled：已成功
    3. reject：已失败

    只有异步操作的结果，可以决定当前是哪一种状态，其他的任何操作都无法改变这个状态

2. 一旦状态改变，就不会再变，任何时候都可以得到这个结果。Promise对象的状态改变，只有两种可能，
   
   1. 从pending变为fulfilled
   2. 从pending变为rejected。



### 时间日期相关

#### 原生js的Date

1. 将当前时间/指定时间转换为时间戳（毫秒）

```js
// 方式一
Date.now(); // 1606381881650(打印时的时间戳)
// 方式二
new Date() - 0; // 1606381881650
new Date('2022-03-05')-0; // 1646438400000
// 方式三
+new Date(); // 1646572862004
+new Date('2022-03-05'); // 1646438400000
// 方式四
new Date().valueOf() // 1606381881650
new Date('2022-03-05').valueOf() // 1646438400000
// 方式五
new Date() * 1 // 1606381881650
new Date('2022-03-05') * 1 // 1646438400000
// 方式六
Number(new Date()) // 1646574434807
Number(new Date('2022-03-05')) // 1646438400000
// 方式七
new Date().getTime() // 1606381881650
new Date('2022-03-05').getTime()// 1646438400000
```

2. 创建Date对象的兼容性问题

```js
// window和安卓支持，ios和mac不支持
new Date('2020-11-26'); 
// window和安卓支持，ios和mac支持
new Date('2020/11/26');
```