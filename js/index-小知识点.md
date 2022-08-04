<!--
 * @Date: 2020-09-02 10:46:40
 * @LastEditors: Lq
 * @LastEditTime: 2022-08-03 20:23:58
 * @FilePath: \learnningNotes\js\index-小知识点.md
-->
1. substr()和substring()

    |      | substr             | substring            |
    | ---- | ------------------ | -------------------- |
    | 功能 | 截取一定长度字符串 | 截取一定长度字符串   |
    | 参数 | (start, length)    | (start, end)左闭右开 |
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

    | 参数         | 子参数       | 说明               |
    | ------------ | ------------ | ------------------ |
    | callbck      |              | 累加回调           |
    |              | total        | 累加初始值         |
    |              | currentValue | 当前元素           |
    |              | currentIndex | 当前元素索引       |
    |              | arr          | 数组对象           |
    | initialValue |              | 可传递的累加初始值 |

10. 获取含特殊字符的对象属性

    使用转义字符表示

    常见转义字符

    | 字符 | 描述   |
    | ---- | ------ |
    | \’   | 单引号 |
    | \"   | 双引号 |
    | \&   | 和号   |
    | \\   | 反斜杠 |
    | \n   | 换行符 |
    | \r   | 回车符 |
    | \t   | 制表符 |
    | \b   | 退格符 |

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

18. 获取FormData的内容

    ```js
    let formData = new FormData();
    formData('name', 'name');
    formData('age', 12);
    //第一种
    for (var value of formData.values()) {
        console.log(value);
    }
    //第二种
    for (var [a, b] of formData.entries()) {
        console.log(a, b);
    }    
    ```

19. 时间戳转化为时间

    ```js
    function add0(m){return m<10?'0'+m:m }
    function format(shijianchuo) {
        //shijianchuo是整数，否则要parseInt转换
        var time = new Date(shijianchuo);
        var y = time.getFullYear();
        var m = time.getMonth()+1;
        var d = time.getDate();
        var h = time.getHours();
        var mm = time.getMinutes();
        var s = time.getSeconds();
        return y+'-'+add0(m)+'-'+add0(d)+' '+add0(h)+':'+add0(mm)+':'+add0(s);
    }
    ```

    js获取时间戳

    ```js
    let time1 = Date.parse(new Date()); //1603009257000,精确到秒
    let time2 = new Date().getTime(); //1603009495724,精确到毫秒
    let time3 = new Date().valueOf(); //1603009495724.精确到毫秒
    let time4 = Date.now(); //1603009495724,精确到毫秒，实际上是new Date().getTime()
    ```

20. 生成随机数字或者字符串

    ```js
    /**
     * 随机生成数字
     *
     * 示例：生成长度为 12 的随机数：randomNumber(12)
     * 示例：生成 3~23 之间的随机数：randomNumber(3, 23)
     *
     * @param1 最小值 | 长度
     * @param2 最大值
     * @return int 生成后的数字
     */
    export function randomNumber() {
        // 生成 最小值 到 最大值 区间的随机数
        const random = (min, max) => {
            return Math.floor(Math.random() * (max - min + 1) + min)
        }
        if (arguments.length === 1) {
            let [length] = arguments
            // 生成指定长度的随机数字，首位一定不是 0
            let nums = [...Array(length).keys()].map((i) => (i > 0 ? random(0, 9) : random(1, 9)))
            return parseInt(nums.join(''))
        } else if (arguments.length >= 2) {
            let [min, max] = arguments
            return random(min, max)
        } else {
            return Number.NaN
        }
    }

    /**
    * 随机生成字符串
    * @param length 字符串的长度
    * @param chats 可选字符串区间（只会生成传入的字符串中的字符）
    * @return string 生成的字符串
    */
    export function randomString(length, chats) {
        if (!length) length = 1
        if (!chats) chats = '0123456789qwertyuioplkjhgfdsazxcvbnm'
        let str = ''
        for (let i = 0; i < length; i++) {
            let num = randomNumber(0, chats.length - 1)
            str += chats[num]
        }
        return str
    }
    ```

21. 获取最近或者未来多少天的时间

    ```js
    //获取时间
    function getDay(day) { //这里的day是时间（列如：7，-7）
        let today = new Date();
        let targetday_milliseconds = today.getTime() + 1000 * 60 * 60 * 24 * day;
        today.setTime(targetday_milliseconds); //注意，这行是关键代码，到这时间已经转行为毫秒
        return this.format(today)
    }
    //格式化日期
    function format(date) {
        let year = date.getFullYear()
        let month = date.getMonth() + 1
        let day = date.getDate()
        if (month >= 1 && month <= 9) { month = `0${month}` }
        if (day >= 1 && day <= 9) { day = `0${day}` }
        return `${year}-${month}-${day}`
    }
    ```

22. 解决内存溢出的问题

    1. 使用插件的方式

        1. 安装插件：`npm install -g increase-memory-limit cross-env`

        2. 在`package.json`中增加下面的脚本

            > "fix-memory-limit": "cross-env LIMIT=4096 increase-memory-limit"

        3. 执行脚本

            > npm run fix-memory-limit

        4. 找到node_modules/@vue/cli-service/bin/vue-cli-service.js文件，把最后的限制删掉

            > const requiredVersion = require('../package.json').engines.node --max-old-space-size=4096   
            改为
            > const requiredVersion = require('../package.json').engines.node   

    2. 在`package.json`文件的打包脚本的地方增加命令

        如我的

        > "build": "node --max_old_space_size=4096 node_modules/.bin/vue-cli-service build",

        这里的关键点就是找到对应的打包命令的文件在哪里

23. 计算两个日期相差天数

    > const day = (Date.parse(startDay) - Date.parse(endDay)) / (24 * 60 * 60 * 1000)


24. 禁止页面缩放
    ```js
    // 禁止通过	ctrl + +/- 和 	ctrl + 滚轮 对页面进行缩放
    disableBrowserZoom = () => {
    document.addEventListener('keydown', function (event) {
        if ((event.ctrlKey === true || event.metaKey === true) &&
        (event.which === 61 || event.which === 107 ||
            event.which === 173 || event.which === 109 ||
            event.which === 187 || event.which === 189)) {
        event.preventDefault()
        }
    }, false)
    // Chrome IE 360
    window.addEventListener('mousewheel', function (event) {
        if (event.ctrlKey === true || event.metaKey) {
        event.preventDefault()
        }
    }, {
        passive: false
    })

    // firefox
    window.addEventListener('DOMMouseScroll', function (event) {
        if (event.ctrlKey === true || event.metaKey) {
        event.preventDefault()
        }
    }, {
        passive: false
    })
    }
    ```

25. 打印catch里面的error

    在某种情况下，不能够直接输出catch里面的error的时候

    > console.log("error", String(error))

26. js转化非正常格式的json

27. 普通的对象

    ```js
    let obj1 = {
        name: 'lan',
        age: 12
    }
    let str1 = JSON.stringify(obj1); // '{"name":"lan","age":12}'
    ```

28. 如果对象的属性是非字符串

    ```js
    let obj2 = {
        name: 'lan',
        100: 200
    }
    // 注意这里经过序列化之后数字属性也加上了引号，所以是可以正常转化回来的
    let str2 = JSON.stringify(obj2); // '{"100":200,"name":"lan"}'

    let _obj2 = JSON.parse(str2); // {100: 200, name: 'lan'}
    ```

29. 如果给到你的字符串属性没有被引号包裹，是转化不了的，会报错

    ```js
    let str3 = '{100:200,"name":"lan"}';

    let obj3 = JSON.parse(str3); // 报错
    ```

30. 判断数组是否有重复元素（非引用类型）

    > new Set(arr).size != arr.length

31. 英文数字单位转化

```js
// 将数字转化为英文单位，如1000为1K，10000000位10M
// 保留两位小数，如果数值不合法返回false
function translateNumToEn(num) {
    if (typeof num !== 'number') {
        return false;
    }
    // 判断正负数
    let sign = num >= 0 ? '' : '-';

    // 取绝对值
    num = Math.abs(num);

    let str = "";
    if (num === 0) {
        str = "0";
    } else if (num < 1e3) {
        str = Math.round(num * 1e2) / 1e2 + "";
    } else if (num < 1e6 && num >= 1e3) {
        str = Math.round(num / 1e3 * 1e2) / 1e2 + "K";
    } else if (num < 1e9 && num >= 1e3) {
        str = Math.round(num / 1e6 * 1e2) / 1e2 + "M";
    } else if (num >= 1e9) {
        str = Math.round(num / 1e9 * 1e2) / 1e2 + "B";
    } else {
        return false;
    }
    return sign + str;
}

// 将英文单位数字转化为纯数字
function translateEnToNum(str) {
    if (typeof str !== "string") {
        return false;
    }

    // 考虑有些英文是用千分位逗号分隔的
    str = str.replaceAll(',', '');

    // 判断正负数
    let sign = str.includes('-') ? '-' : '';
    str = str.replaceAll('-', '');

    if (str.includes('k') || str.includes('K')) {
        str = str.replaceAll('k', '');
        str = str.replaceAll('K', '');
        str = Number(str) * 1e3;
    } else if (str.includes('m') || str.includes('M')) {
        str = str.replaceAll('m', '');
        str = str.replaceAll('M', '');
        str = Number(str) * 1e6;
    } else if (str.includes('b') || str.includes('B')) {
        str = str.replaceAll('b', '');
        str = str.replaceAll('B', '');
        str = Number(str) * 1e9;
    } else {
    }

    return Number(sign + str);
}
```

注意：这里如果`replaceAll`不支持的话，使用`str.replace(/,/g, '');`来达到效果

29. 将英文日期转化为标准日期

```js
// 转化英文的日期为标准日期
// 英文：月 日 年 如：Jun 12 2022 单日的话是"Jun 8 2022"
// 标准：年-月-日 如：2022-06-12
function translateEnDateToNorm(str) {
    let monObj = {
        "Jan": "01",
        "Feb": "02",
        "Mar": "03",
        "Apr": "04",
        "May": "05",
        "Jun": "06",
        "Jul": "07",
        "Aug": "08",
        "Spt": "9",
        "Oct": "10",
        "Nov": "11",
        "Dec": "12"
    };
    let arr = str.split(' ');
    let year = arr[2];
    let month = monObj[arr[0]];
    let day = arr[1];
    day = day.length === 1 ? '0' + day : day;
    return `${year}-${month}-${day}`;
}
```

30. replaceAll这个方法有些浏览器不支持

    `replaceAll`这个方法chrome和node是正常能够使用的，但是现在已知钉钉浏览器和puppeteer无头浏览器都不支持这个方法

    会报错：`str.replaceAll is not a function`

    如果要达到效果的话，建议使用`replace`加上正则来做

    > str.replace(/,/g, '');

31. 调用接口获取ip

    ```js
    fetch('https://api.ipify.org/?format=json')
    .then(res => res.json())
    .then(res => console.log(res))
    ```

32. 将任意文件转换为base64

    ```html
    <!doctype html>
    <html>
    <head>
    <meta charset="utf-8">
    <meta name="description" content="在线Base64生成转换小工具，可以实现任意文件转Base64 Data-URI编码，文件往页面中一拖即可。" />
    <meta name="keywords" content="base64, FileReader, readAsDataURL, 文件" />
    <meta name="author" content="谢勇彬，XYB" />
    <title>任意文件转base64-直接拖进来</title>
    <style>
        body { word-break: break-all; margin: 0 1em; min-height: 100vh; font-family: Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace; overflow: hidden;}
        .empty::before{position: absolute; font-size: 50px; content: '任意文件\A拖到这里'; white-space: pre; left: 50%; top: 50%; transform: translate(-50%,-50%); color: gray;}
    </style>
    </head>
    <body class="empty">
    <script>
        window.addEventListener("dragenter", function(event) { event.preventDefault(); }, false);
        window.addEventListener("dragover", function(event) { event.preventDefault(); }, false);
        window.addEventListener("drop", function(event) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.body.insertAdjacentHTML("afterBegin", '<p>' + e.target.result + '</p>');
                document.body.classList.remove('empty');
            };
            reader.readAsDataURL(event.dataTransfer.files[0]);
            event.preventDefault();
        }, false);
    </script>
    
    </body>
    </html>
    ```

33. 前端实现访问一个图片url直接下载该图片

```js
function downloadIamge(imgsrc, name){
 
  let image = new Image();
 
  // 解决跨域 Canvas 污染问题
  image.setAttribute("crossOrigin", "anonymous");
 
  image.onload = function() {
 
    let canvas = document.createElement("canvas");
 
    canvas.width = image.width;
 
    canvas.height = image.height;
 
    let context = canvas.getContext("2d");
 
    context.drawImage(image, 0, 0, image.width, image.height);
 
    let url = canvas.toDataURL("image/png"); //得到图片的base64编码数据
 
    let a = document.createElement("a"); // 生成一个a元素
 
    let event = new MouseEvent("click"); // 创建一个单击事件
 
    a.download = name || "photo"; // 设置图片名称
 
    a.href = url; // 将生成的URL设置为a.href属性
 
    a.dispatchEvent(event); // 触发a的单击事件
 
  }
 
  image.src = imgsrc;
}

downloadIamge('http://172.168.10.21:3006/test/image/download','ppcm')
```

在oss上传的时候如果制定了`Content-Type`是`image/jpeg`，则产生的外链在浏览器上直接显示。

如果设置的`Content-Type`是`application/octet-steam`或者`multipart/form-data`，则外链是直接下载的


34. 截取两个字符串之间的字符串

核心：使用`match`方法

```js
let str = 'hskdfhska;jl234iyiofsdhaklfnaskn,xcnvm,zxn891237499safhas,n';
let s = str.match(/ha(\S*)n,/)[1];
// 'klfnask'
```

35. 刷新网页页面

    1. `history.go(0)`，除非有在服务端解释才能生成的页面代码，否则直接读取缓存中的数据

        不刷新

    2. `location.reload()`，重新连接服务器以读得新的页面

        刷新

    3. `location=location`，执行后仍支持前进后退
        

    4. `location.assign(location)`：相当于一个链接跳转到指定url

        可以后退

    5. `document.execCommand('Refresh')`

    6. `window.navigate(location)`

    7. `location.replace(location)`

        执行后没有前进后退

    8. `document.URL = location.href`

37. 常用的Match对象的方法

    1. Math.abs() : 返回一个数的绝对值

    2. Math.ceil() : 向上取整

    3. Math.floor() : 向下取整

    4. Math.round() : 四舍五入

    5. Math.trunc() : 返回整数部分

    5. Math.min() : 返回一组数据最小值

        > Math.min(1,2,3,4,5); // 1

        如果没有参数，返回`Infinity`

        如果有一个参数不能转为数值，则结果为`NaN`

    6. Match.max() : 返回一组数据最大值


38. 获取浏览器地址栏中的参数

    ```js
    getQueryVariable(variable) {
        // 从?开始获取后面的所有数据
        var query = decodeURIComponent(window.location.search).substring(1);
        // 从字符串&开始分隔成数组split
        var vars = query.split('&');
        // 遍历该数组
        for (var i = 0; i < vars.length; i++) {
            // 从等号部分分割成字符
            var pair = vars[i].split('=');
            // 如果第一个元素等于 传进来的参的话 就输出第二个元素
            if (pair[0] == variable) {
                return pair[1];
            }
        }
        return false;
    }
    ```

39. JSON.parse(JSON.stringify(obj))实现深拷贝的弊端

1. 深拷贝和浅拷贝

    深拷贝：只是将数据中所有的数据饮用下来，依旧指向同一个存放地址，拷贝之后的数据修改之后，也会影响到元数据中的对象数据。如`Object.assign()`/`...扩展运算符`

    浅拷贝：将数据中所有的数据拷贝下来，对拷贝之后的数据进行修改不会影响到原数据

2. JSON.parse(JSON.stringify(obj))深拷贝的弊端

    | 对象            | 序列化结果 |
    | --------------- | ---------- |
    | 时间对象        | 字符串     |
    | RegExp、Error   | 空对象     |
    | 函数、undefined | 丢失       |
    | NaN、Infinity   | null       |
    
    只能序列化对象的可枚举的自有属性，如果obj中的对象是由构造函数生成的，则会丢失对象的`constructor`

    如果对象中存在循环引用的情况也无法正确实现深拷贝

    ```js
    function Person (name) {
        this.name = 20
    }

    const p = new Person('p')

    let a = {
        data0: '1',
        date1: [new Date('2020-03-01'), new Date('2020-03-05')],
        data2: new RegExp('\\w+'),
        data3: new Error('1'),
        data4: undefined,
        data5: function () {
            console.log(1)
        },
        data6: NaN,
        data7: p
    }

    let b = JSON.parse(JSON.stringify(a))
    ```

3. 递归实现深拷贝

    ```js
    function deepClone(obj) {
        // 如果不是对象，则直接返回
        if (typeof obj !== 'object') {
            return obj;
        }
        // 判断是数组还是对象，如果是数据，对于数组进行拷贝，如果是对象对于对象进行拷贝
        let objClone = Array.isArray(obj) ? [] : {};
        // 进行深拷贝不能为空
        if (obj && typeof obj === "object") {
            for(key in obj) {
                if (obj[key] && typeof obj[key] === "object") {
                    objClone[key] = deepClone(obj[key]);
                } else {
                    objClone[key] = obj[key];
                }
            }
        }
        return objClone;
    }    
    ```

40. call、apply与bind 用法和区别

相同点：都用于改变`this`指向的绑定

不同点：

1. call、apply会`立即执行函数`。`call`传递参数调用形参是以散列的形式（`fn.call(obj,1,2,3)`），而`apply`的形参是一个数组。在传参的情况下，`call`的性能要高于`apply`，因为`apply`在执行的时候还要多一步解析数组

2. `bind`在改变`this`之后返回的是一个全新的绑定函数，即返回一个新的函数，不会立即执行函数。并且之后的`this`指向无法再通过call、apply、bind改变。

实现

1. call

    ```js
    let obj = {
        name: "lan"
    }
    function fn() {
        console.log('...arguments', ...arguments);
        console.log('this.name', this.name);
    }
    fn.call(obj, 1, 2, 3);
    ```

2. apply

    ```js
    let obj = {
        name: "lan"
    }
    function fn() {
        console.log('...arguments', ...arguments);
        console.log('this.name', this.name);
    }
    fn.apply(obj, [1, 2, 3]);
    ```

3. bind

    ```js
    let bindObj = {
        name: 'bind-name'
    }
    let applyObj = {
        name: 'apply-name'
    }
    function fn() {
        console.log('...arguments', ...arguments);
        console.log('this.name', this.name);
    }
    let bfn = fn.bind(bindObj, [1, 2, 3]);
    bfn();

    // 这里重新绑定不会改变this指向
    bfn.apply(applyObj);
    ```

41. 将当前时间/指定时间转换为时间戳（毫秒）

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