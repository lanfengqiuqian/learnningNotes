<!--
 * @Date: 2020-09-02 10:46:40
 * @LastEditors: Lq
 * @LastEditTime: 2021-05-12 11:22:27
 * @FilePath: /learnningNotes/js/index-小知识点.md
-->
1. substr()和substring()

    ||substr|substring|
    |-|-|-|
    |功能|截取一定长度字符串|截取一定长度字符串|
    |参数|(start, length)|(start, end)左闭右开|
    如果`start`或`end`为`NaN`或负数，那么将会被替换为0

2. 大括号必须跟在前一个语句的同一行

    ```js
    function test() {
        return 
        {
            name: "lan",
            age: 12
        }
    }
    console.log(test()); // undefined
    ```

    理想的情况下，应该是输出一个对象，上面代码结果输出是`undefined`，为什么呢？  

    js的`分号插入机制`：如果语句没有使用分号结束，会自动不充分号，所以上面的代码相当于

    ```js
    function test() {
        return undefined; // 自动插入分号
        {
            name: "lan",
            age: 12
        }
    }
    console.log(test()); // undefined
    ```

    应该改为

    ```js
    function test() {
        return {
            name: "lan",
            age: 12
        }
    }
    console.log(test()); // {name: "lan", age: 12}
    ```

3. js中对象的属性名只能是字符串，如果以数字作为属性名也会被强行转化为字符串

4. a标签中的download属性需要同源才能够生效
    
5. 去除前后空格

    该方法不会去除中间的空格

    > str.trim()

6. concat()

    不会改变原来的数组，返回的是一个新的拼接后的数组，参数可以是一个数组，也可以是数组中的元素

    ```js
    let arr1 = [1,2,3];
    let arr2 = [2,3,4];
    // 参数是数组
    let arr3 = arr1.concat(arr2); // [1,2,3,2,3,4]
    // 参数是数组元素
    let arr4 = arr1.concat(...arr2); // [1,2,3,2,3,4]
    ```

7. 计算数组的交并差补

    使用concat、filter

    ```js
    var a = [1,2,3,4];
    var b = [3,4,5,6];
    // 交集（同时在a和b中的元素）
    var c = a.filter(item => b.indexOf(item) > -1); // [3,4]
    // 差集（只在a中不在b中的元素）
    var d = a.filter(item => b.indexOf(item) === -1); // [1,2]
    // 并集（将a和b合并，只包含一份重复的元素）
    var e = b.concat(a.filter(item => b.indexOf(item) === -1)); // [1,2,3,4,5,6]
    // 补集（去除a和b中重复的元素之后，将两个数组进行合并），也可以看做是两个差集合并
    var tempA = a.filter(item => b.indexOf(item) === -1); // [1,2]
    var tempB = b.filter(item => a.indexOf(item) === -1); // [5,6]
    var f = (tempA).concat(tempB); // [1,2,5,6]
    ```

8. 对象解构：赋初值，重命名，嵌套解构

    ```js
    const obj = {
        name: "lan",
        age: 12,
        address: {
            province: 'jiangxi',
            city: 'yichun'
        }
    }

    // 解构
    const {name, age, address} = obj;

    // 赋初值
    const {name = 'zhangsan'} = obj;

    // 重命名
    const {age: myAge} = obj;

    // 嵌套解构
    const {address: {
        province,
        city
    }} = obj;
    ```

9. reduce()

    一般用于数组的求和

    ```js
    let arr = [1,2,3];
    let total = arr.reduce((a, b) => a + b); // 6
    ```

    参数：callback（累加回调）, initialValue

    |参数|子参数|说明|
    |-|-|-|
    |callbck||累加回调|
    ||total|累加初始值|
    ||currentValue|当前元素|
    ||currentIndex|当前元素索引|
    ||arr|数组对象|
    initialValue||可传递的累加初始值|

10. 获取含特殊字符的对象属性

    使用转义字符表示

    常见转义字符

    |字符|描述|
    |-|-|
    |\’ |单引号|
    |\"| 双引号|
    |\& |和号|
    |\\ |反斜杠|
    |\n |换行符|
    |\r |回车符|
    |\t |制表符|
    |\b |退格符|

    比如：换行符

    > let val = item['第一行\n第二行'];

11. JSON.stringify和JSON.parse的参数

    1. JSON.stringify

        ```js
        JSON.stringify(value[, replacer [, space]])
        ```

        第二个参数replacer，可以是一个数组，也可以是一个回调函数

        1. 当为数组时，只有一个在数组中的属性名才会被序列化到最终的JSON字符串中

        2. 当为回调函数是，每一个属性都会执行该回调函数，需要返回值

        ```js
        let obj = {
            name: 'jack',
            age: 12
        }
        JSON.stringify(obj, ['name']); // {"name":"jack"}
        JSON.stringify(obj, (key, value) => {
            console.log(key, value); // name jack age 12
            return value;
        }); // {"name":"jack","age":12}
        ```

        第三个参数是控制字符串间距，如果是一个数字，则序列化的时候每一级别回比上一级别多缩进该值的空格（最多10个空格）；如果是一个字符串，则每一级别回比上一级别多缩进该字符串。

        ```js
        let obj = {
            name: 'jack',
            age: 12
        }
        JSON.stringify(obj, null, 2);
        /*
        "{"name":"jack","age":12}"
        */
        JSON.stringify(obj, null, 2);
        /*
        "{
          "name": "jack",
          "age": 12
        }"
        */
        ```

        注意，如果一个被序列化的对象拥有`toJson`方法，那么该`toJson`方法就会覆盖该对象默认的序列化行为，如`fetch`方法的`reponse`

    2. JSON.parse

        ```js
        JSON.parse(text[, reviver])
        ```

        第二个参数reviver是一个回调，每一个属性都会调用此函数

        ```js
        let str = "{name: "jack", age: 12}";
        JSON.parse(str, (key ,val) => {
            console.log(key, val); // name jack age 12
            return val;
        });
        ```

12. 解析get中的参数

    ```js
    const q = {};
    location.search.replace(/([^?&=]+)=([^&]+)/g,(_,k,v)=>q[k]=v);
    console.log(q);
    ```

13. new操作符过程过做了什么

    > var p = new Person();

    ```js
    // 创建一个空对象
    var o = new Object();
    // 设置原型链，让该对象继承构造函数的原型
    o.__proto__ = Person.prototype;
    // 把构造函数的this指向新对象，并执行函数体
    var result = Person.call(o);
    // 判断构造函数的返回值类型，如果是值类型则返回该对象，如果是引用类型，就返回这个引用类型的对象
    if (typeof(result) === 'object') {
        obj = result;
    } else {
        obj = o;
    }
    ```

    模拟`new`操作

    ```js
    function New(obj, ...arg) {
        // 创建新对象，原型为构造函数的原型
        // 可以拆分写法，如下
        // let newObj = {};
        // newObj.__proto = obj.prototype;
        let newObj = Object.create(obj.prototype);
        // 修改this指向为新对象，并执行函数体
        let result = obj.apply(res, arg);
        // 如果返回值不是有效对象，则返回新对象
        return (typeof result === 'object') ? result : res;
    }
    ```

    **对于构造函数返回值的解释：**  
    如果构造函数返回了一个“对象”，那么这个对象会取代整个new出来的结果。如果构造函数没有返回对象，那么new出来的结果为步骤1创建的对象。（一般情况下构造函数不返回任何值，不过用户如果线覆盖这个返回值，可以自己选择一个普通对象来覆盖。当然，返回数组也会覆盖，因为数组也是对象）

14. 构造函数和普通函数的区别

    #### 前言 函数内部有两个不同的内部方法：`【Call】和【construct】`  

    1. 当使用new调用函数是，会执行【coustruct】方法，执行过程就是`new`操作符执行的过程
    2. 当直接调用函数，会执行【call】方法，直接执行函数体


    #### 区别

    1. 形式上看构造函数也是一个普通函数，创建方式和普通函数一样，但是`构造函数习惯上首字母大写`
    2. 调用方式不一样，作用也不一样（`构造函数用来新建实例对象`）
       1. 普通函数调用：`person()`
       2. 构造函数调用：需要使用`new`关键字`new Person()`
    3. 构造函数的函数名和类名相同：Person()这个构造函数，Person既是函数名，也是对象的类名
    4. 构造函数内部用`this`来构造属性和方法

        ```js
        function Person(name, age) {
            this.name = name;
            this.age = age;
            this.say = function() {
                console.log('hello');
            }
        }
        ```
    5. 当函数体为空时，执行结果不一样

        1. 普通函数结果为undefined
        2. 构造函数结果为一个空对象

    6. 用`instanceof`可以检查一个对象是否是一个类的实例

        > console.log(p instanceof Person); // true  
        > console.log(p instanceof Car); // false
        
        任何对象和Object做instanceof结果都是true

    7. 判断函数被调用的方式

        1. es5中依据`this`是否为构造函数的实例，来判断函数被调用的方式

            ```js
            function Person() {
                if (this instanceof Person) {
                    console.log('作为构造函数调用');
                } else {
                    console.log('作为普通函数调用');
                }
            }
            ```

            缺陷：如果使用call或者apply修改函数内的this只想到函数的实例上，就不能够区分是否通过new调用

            ```js
            let p = new Person();
            Person.call(p);
            ```

        2. es6引入了`new.target`这个元属性进行区分。

            > 元属性：是指非对象的属性，可以提供非对象目标的补充信息  
            > 使用new调用函数时，会执行【construct】方法，new.target是函数本身  
            > 直接调用函数，会执行【Call】方法，nwe.target为undefined  
            > new.target在函数体外使用是一个语法错误
            
            ```js
            function Person(){
                if(new.target === Person){
                    console.log('构造函数调用');
                }else{
                    console.log('普通函数调用');
                }
            }
            ```

15. 正则匹配去除括号

    1. 仅去除括号，不去除括号内容
        ```js
        // 移除所有小括号
        str.replace(/\[|]/g,"")
        ```

    2. 去除括号，以及括号内容
        ```js
        // 去除中括号及其内容
        str.replace(/\[.*\]/g, "");
        ```

16. 正则匹配密码

    1. 至少8位字母和数字混合：` /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,}$/`


    2. 6位纯数字：`/^\d{6}$/`

17. 创建固定长度为空的数组，并进行填充

    ```js
    let arr = new Array(5); // [empty, empty, empty, empty, empty]
    arr.fill("hello"); // ["hello", "hello", "hello", "hello", "hello"]
    ```