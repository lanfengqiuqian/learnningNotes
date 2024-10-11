<!--
 * @Date: 2020-09-02 10:46:40
 * @LastEditors: Lq
 * @LastEditTime: 2022-08-24 14:39:28
 * @FilePath: \learnningNotes\js\index-小知识点.md
-->

1. substr()和 substring()

   |      | substr             | substring            |
   | ---- | ------------------ | -------------------- |
   | 功能 | 截取一定长度字符串 | 截取一定长度字符串   |
   | 参数 | (start, length)    | (start, end)左闭右开 |

   如果`start`或`end`为`NaN`或负数，那么将会被替换为 0

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

   js 的`分号插入机制`：如果语句没有使用分号结束，会自动不充分号，所以上面的代码相当于

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
       age: 12,
     };
   }
   console.log(test()); // {name: "lan", age: 12}
   ```

3. js 中对象的属性名只能是字符串，如果以数字作为属性名也会被强行转化为字符串

4. a 标签中的 download 属性需要同源才能够生效
5. 去除前后空格

   该方法不会去除中间的空格

   > str.trim()

6. concat()

   不会改变原来的数组，返回的是一个新的拼接后的数组，参数可以是一个数组，也可以是数组中的元素

   ```js
   let arr1 = [1, 2, 3];
   let arr2 = [2, 3, 4];
   // 参数是数组
   let arr3 = arr1.concat(arr2); // [1,2,3,2,3,4]
   // 参数是数组元素
   let arr4 = arr1.concat(...arr2); // [1,2,3,2,3,4]
   ```

7. 计算数组的交并差补

   使用 concat、filter

   ```js
   var a = [1, 2, 3, 4];
   var b = [3, 4, 5, 6];
   // 交集（同时在a和b中的元素）
   var c = a.filter((item) => b.indexOf(item) > -1); // [3,4]
   // 差集（只在a中不在b中的元素）
   var d = a.filter((item) => b.indexOf(item) === -1); // [1,2]
   // 并集（将a和b合并，只包含一份重复的元素）
   var e = b.concat(a.filter((item) => b.indexOf(item) === -1)); // [1,2,3,4,5,6]
   // 补集（去除a和b中重复的元素之后，将两个数组进行合并），也可以看做是两个差集合并
   var tempA = a.filter((item) => b.indexOf(item) === -1); // [1,2]
   var tempB = b.filter((item) => a.indexOf(item) === -1); // [5,6]
   var f = tempA.concat(tempB); // [1,2,5,6]
   ```

8. 对象解构：赋初值，重命名，嵌套解构

   ```js
   const obj = {
     name: "lan",
     age: 12,
     address: {
       province: "jiangxi",
       city: "yichun",
     },
   };

   // 解构
   const { name, age, address } = obj;

   // 赋初值
   const { name = "zhangsan" } = obj;

   // 重命名
   const { age: myAge } = obj;

   // 嵌套解构
   const {
     address: { province, city },
   } = obj;
   ```

9. reduce()

   一般用于数组的求和

   ```js
   let arr = [1, 2, 3];
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

    > let val = item['第一行\n 第二行'];

11. JSON.stringify 和 JSON.parse 的参数

    1. JSON.stringify

       ```js
       JSON.stringify(value[, replacer [, space]])
       ```

       第二个参数 replacer，可以是一个数组，也可以是一个回调函数

       1. 当为数组时，只有一个在数组中的属性名才会被序列化到最终的 JSON 字符串中

       2. 当为回调函数是，每一个属性都会执行该回调函数，需要返回值

       ```js
       let obj = {
         name: "jack",
         age: 12,
       };
       JSON.stringify(obj, ["name"]); // {"name":"jack"}
       JSON.stringify(obj, (key, value) => {
         console.log(key, value); // name jack age 12
         return value;
       }); // {"name":"jack","age":12}
       ```

       第三个参数是控制字符串间距，如果是一个数字，则序列化的时候每一级别回比上一级别多缩进该值的空格（最多 10 个空格）；如果是一个字符串，则每一级别回比上一级别多缩进该字符串。

       ```js
       let obj = {
         name: "jack",
         age: 12,
       };
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

       第二个参数 reviver 是一个回调，每一个属性都会调用此函数

       ```js
       let str = "{name: "jack", age: 12}";
       JSON.parse(str, (key ,val) => {
           console.log(key, val); // name jack age 12
           return val;
       });
       ```

12. 解析 get 中的参数

    ```js
    const q = {};
    location.search.replace(/([^?&=]+)=([^&]+)/g, (_, k, v) => (q[k] = v));
    console.log(q);
    ```

13. new 操作符过程过做了什么

    > var p = new Person();

    ```js
    // 创建一个空对象
    var o = new Object();
    // 设置原型链，让该对象继承构造函数的原型
    o.__proto__ = Person.prototype;
    // 把构造函数的this指向新对象，并执行函数体
    var result = Person.call(o);
    // 判断构造函数的返回值类型，如果是值类型则返回该对象，如果是引用类型，就返回这个引用类型的对象
    if (typeof result === "object") {
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
      return typeof result === "object" ? result : res;
    }
    ```

    **对于构造函数返回值的解释：**  
    如果构造函数返回了一个“对象”，那么这个对象会取代整个 new 出来的结果。如果构造函数没有返回对象，那么 new 出来的结果为步骤 1 创建的对象。（一般情况下构造函数不返回任何值，不过用户如果线覆盖这个返回值，可以自己选择一个普通对象来覆盖。当然，返回数组也会覆盖，因为数组也是对象）

14. 构造函数和普通函数的区别

    #### 前言 函数内部有两个不同的内部方法：`【Call】和【construct】`

    1. 当使用 new 调用函数是，会执行【coustruct】方法，执行过程就是`new`操作符执行的过程
    2. 当直接调用函数，会执行【call】方法，直接执行函数体

    #### 区别

    1. 形式上看构造函数也是一个普通函数，创建方式和普通函数一样，但是`构造函数习惯上首字母大写`
    2. 调用方式不一样，作用也不一样（`构造函数用来新建实例对象`）
       1. 普通函数调用：`person()`
       2. 构造函数调用：需要使用`new`关键字`new Person()`
    3. 构造函数的函数名和类名相同：Person()这个构造函数，Person 既是函数名，也是对象的类名
    4. 构造函数内部用`this`来构造属性和方法

       ```js
       function Person(name, age) {
         this.name = name;
         this.age = age;
         this.say = function () {
           console.log("hello");
         };
       }
       ```

    5. 当函数体为空时，执行结果不一样

       1. 普通函数结果为 undefined
       2. 构造函数结果为一个空对象

    6. 用`instanceof`可以检查一个对象是否是一个类的实例

       > console.log(p instanceof Person); // true  
       > console.log(p instanceof Car); // false

       任何对象和 Object 做 instanceof 结果都是 true

    7. 判断函数被调用的方式

       1. es5 中依据`this`是否为构造函数的实例，来判断函数被调用的方式

          ```js
          function Person() {
            if (this instanceof Person) {
              console.log("作为构造函数调用");
            } else {
              console.log("作为普通函数调用");
            }
          }
          ```

          缺陷：如果使用 call 或者 apply 修改函数内的 this 只想到函数的实例上，就不能够区分是否通过 new 调用

          ```js
          let p = new Person();
          Person.call(p);
          ```

       2. es6 引入了`new.target`这个元属性进行区分。

          > 元属性：是指非对象的属性，可以提供非对象目标的补充信息  
          > 使用 new 调用函数时，会执行【construct】方法，new.target 是函数本身  
          > 直接调用函数，会执行【Call】方法，nwe.target 为 undefined  
          > new.target 在函数体外使用是一个语法错误

          ```js
          function Person() {
            if (new.target === Person) {
              console.log("构造函数调用");
            } else {
              console.log("普通函数调用");
            }
          }
          ```

15. 正则匹配去除括号

    1. 仅去除括号，不去除括号内容

       ```js
       // 移除所有小括号
       str.replace(/\[|]/g, "");
       ```

    2. 去除括号，以及括号内容
       ```js
       // 去除中括号及其内容
       str.replace(/\[.*\]/g, "");
       ```

16. 正则匹配密码

    1. 至少 8 位字母和数字混合：` /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,}$/`

    2. 6 位纯数字：`/^\d{6}$/`

17. 创建固定长度为空的数组，并进行填充

    ```js
    let arr = new Array(5); // [empty, empty, empty, empty, empty]
    arr.fill("hello"); // ["hello", "hello", "hello", "hello", "hello"]
    ```

18. 获取 FormData 的内容

    ```js
    let formData = new FormData();
    formData("name", "name");
    formData("age", 12);
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
    function add0(m) {
      return m < 10 ? "0" + m : m;
    }
    function format(shijianchuo) {
      //shijianchuo是整数，否则要parseInt转换
      var time = new Date(shijianchuo);
      var y = time.getFullYear();
      var m = time.getMonth() + 1;
      var d = time.getDate();
      var h = time.getHours();
      var mm = time.getMinutes();
      var s = time.getSeconds();
      return (
        y +
        "-" +
        add0(m) +
        "-" +
        add0(d) +
        " " +
        add0(h) +
        ":" +
        add0(mm) +
        ":" +
        add0(s)
      );
    }
    ```

    js 获取时间戳

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
        return Math.floor(Math.random() * (max - min + 1) + min);
      };
      if (arguments.length === 1) {
        let [length] = arguments;
        // 生成指定长度的随机数字，首位一定不是 0
        let nums = [...Array(length).keys()].map((i) =>
          i > 0 ? random(0, 9) : random(1, 9)
        );
        return parseInt(nums.join(""));
      } else if (arguments.length >= 2) {
        let [min, max] = arguments;
        return random(min, max);
      } else {
        return Number.NaN;
      }
    }

    /**
     * 随机生成字符串
     * @param length 字符串的长度
     * @param chats 可选字符串区间（只会生成传入的字符串中的字符）
     * @return string 生成的字符串
     */
    export function randomString(length, chats) {
      if (!length) length = 1;
      if (!chats) chats = "0123456789qwertyuioplkjhgfdsazxcvbnm";
      let str = "";
      for (let i = 0; i < length; i++) {
        let num = randomNumber(0, chats.length - 1);
        str += chats[num];
      }
      return str;
    }
    ```

21. 获取最近或者未来多少天的时间

    ```js
    //获取时间
    function getDay(day) {
      //这里的day是时间（列如：7，-7）
      let today = new Date();
      let targetday_milliseconds = today.getTime() + 1000 * 60 * 60 * 24 * day;
      today.setTime(targetday_milliseconds); //注意，这行是关键代码，到这时间已经转行为毫秒
      return this.format(today);
    }
    //格式化日期
    function format(date) {
      let year = date.getFullYear();
      let month = date.getMonth() + 1;
      let day = date.getDate();
      if (month >= 1 && month <= 9) {
        month = `0${month}`;
      }
      if (day >= 1 && day <= 9) {
        day = `0${day}`;
      }
      return `${year}-${month}-${day}`;
    }
    ```

22. 解决内存溢出的问题

    1. 使用插件的方式

       1. 安装插件：`npm install -g increase-memory-limit cross-env`

       2. 在`package.json`中增加下面的脚本

          > "fix-memory-limit": "cross-env LIMIT=4096 increase-memory-limit"

       3. 执行脚本

          > npm run fix-memory-limit

       4. 找到 node_modules/@vue/cli-service/bin/vue-cli-service.js 文件，把最后的限制删掉

          > const requiredVersion = require('../package.json').engines.node --max-old-space-size=4096  
          > 改为
          > const requiredVersion = require('../package.json').engines.node

    2. 在`package.json`文件的打包脚本的地方增加命令

       如我的

       > "build": "node --max_old_space_size=4096 node_modules/.bin/vue-cli-service build",

       这里的关键点就是找到对应的打包命令的文件在哪里

23. 计算两个日期相差天数

    > const day = (Date.parse(startDay) - Date.parse(endDay)) / (24 _ 60 _ 60 \* 1000)

24. 禁止页面缩放

    ```js
    // 禁止通过	ctrl + +/- 和 	ctrl + 滚轮 对页面进行缩放
    disableBrowserZoom = () => {
      document.addEventListener(
        "keydown",
        function (event) {
          if (
            (event.ctrlKey === true || event.metaKey === true) &&
            (event.which === 61 ||
              event.which === 107 ||
              event.which === 173 ||
              event.which === 109 ||
              event.which === 187 ||
              event.which === 189)
          ) {
            event.preventDefault();
          }
        },
        false
      );
      // Chrome IE 360
      window.addEventListener(
        "mousewheel",
        function (event) {
          if (event.ctrlKey === true || event.metaKey) {
            event.preventDefault();
          }
        },
        {
          passive: false,
        }
      );

      // firefox
      window.addEventListener(
        "DOMMouseScroll",
        function (event) {
          if (event.ctrlKey === true || event.metaKey) {
            event.preventDefault();
          }
        },
        {
          passive: false,
        }
      );
    };
    ```

25. 打印 catch 里面的 error

    在某种情况下，不能够直接输出 catch 里面的 error 的时候

    > console.log("error", String(error))

26. js 转化非正常格式的 json

27. 普通的对象

    ```js
    let obj1 = {
      name: "lan",
      age: 12,
    };
    let str1 = JSON.stringify(obj1); // '{"name":"lan","age":12}'
    ```

28. 如果对象的属性是非字符串

    ```js
    let obj2 = {
      name: "lan",
      100: 200,
    };
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
  if (typeof num !== "number") {
    return false;
  }
  // 判断正负数
  let sign = num >= 0 ? "" : "-";

  // 取绝对值
  num = Math.abs(num);

  let str = "";
  if (num === 0) {
    str = "0";
  } else if (num < 1e3) {
    str = Math.round(num * 1e2) / 1e2 + "";
  } else if (num < 1e6 && num >= 1e3) {
    str = Math.round((num / 1e3) * 1e2) / 1e2 + "K";
  } else if (num < 1e9 && num >= 1e3) {
    str = Math.round((num / 1e6) * 1e2) / 1e2 + "M";
  } else if (num >= 1e9) {
    str = Math.round((num / 1e9) * 1e2) / 1e2 + "B";
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
  str = str.replaceAll(",", "");

  // 判断正负数
  let sign = str.includes("-") ? "-" : "";
  str = str.replaceAll("-", "");

  if (str.includes("k") || str.includes("K")) {
    str = str.replaceAll("k", "");
    str = str.replaceAll("K", "");
    str = Number(str) * 1e3;
  } else if (str.includes("m") || str.includes("M")) {
    str = str.replaceAll("m", "");
    str = str.replaceAll("M", "");
    str = Number(str) * 1e6;
  } else if (str.includes("b") || str.includes("B")) {
    str = str.replaceAll("b", "");
    str = str.replaceAll("B", "");
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
    Jan: "01",
    Feb: "02",
    Mar: "03",
    Apr: "04",
    May: "05",
    Jun: "06",
    Jul: "07",
    Aug: "08",
    Spt: "9",
    Oct: "10",
    Nov: "11",
    Dec: "12",
  };
  let arr = str.split(" ");
  let year = arr[2];
  let month = monObj[arr[0]];
  let day = arr[1];
  day = day.length === 1 ? "0" + day : day;
  return `${year}-${month}-${day}`;
}
```

30. replaceAll 这个方法有些浏览器不支持

    `replaceAll`这个方法 chrome 和 node 是正常能够使用的，但是现在已知钉钉浏览器和 puppeteer 无头浏览器都不支持这个方法

    会报错：`str.replaceAll is not a function`

    如果要达到效果的话，建议使用`replace`加上正则来做

    > str.replace(/,/g, '');

31. 调用接口获取 ip

    ```js
    fetch("https://api.ipify.org/?format=json")
      .then((res) => res.json())
      .then((res) => console.log(res));
    ```

32. 将任意文件转换为 base64

    ```html
    <!DOCTYPE html>
    <html>
      <head>
        <meta charset="utf-8" />
        <meta
          name="description"
          content="在线Base64生成转换小工具，可以实现任意文件转Base64 Data-URI编码，文件往页面中一拖即可。"
        />
        <meta
          name="keywords"
          content="base64, FileReader, readAsDataURL, 文件"
        />
        <meta name="author" content="谢勇彬，XYB" />
        <title>任意文件转base64-直接拖进来</title>
        <style>
          body {
            word-break: break-all;
            margin: 0 1em;
            min-height: 100vh;
            font-family: Consolas, "Andale Mono", "Lucida Console",
              "Lucida Sans Typewriter", Monaco, "Courier New", monospace;
            overflow: hidden;
          }
          .empty::before {
            position: absolute;
            font-size: 50px;
            content: "任意文件\A拖到这里";
            white-space: pre;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            color: gray;
          }
        </style>
      </head>
      <body class="empty">
        <script>
          window.addEventListener(
            "dragenter",
            function (event) {
              event.preventDefault();
            },
            false
          );
          window.addEventListener(
            "dragover",
            function (event) {
              event.preventDefault();
            },
            false
          );
          window.addEventListener(
            "drop",
            function (event) {
              var reader = new FileReader();
              reader.onload = function (e) {
                document.body.insertAdjacentHTML(
                  "afterBegin",
                  "<p>" + e.target.result + "</p>"
                );
                document.body.classList.remove("empty");
              };
              reader.readAsDataURL(event.dataTransfer.files[0]);
              event.preventDefault();
            },
            false
          );
        </script>
      </body>
    </html>
    ```

33. 前端实现访问一个图片 url 直接下载该图片

```js
function downloadIamge(imgsrc, name) {
  let image = new Image();

  // 解决跨域 Canvas 污染问题
  image.setAttribute("crossOrigin", "anonymous");

  image.onload = function () {
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
  };

  image.src = imgsrc;
}

downloadIamge("http://172.168.10.21:3006/test/image/download", "ppcm");
```

在 oss 上传的时候如果制定了`Content-Type`是`image/jpeg`，则产生的外链在浏览器上直接显示。

如果设置的`Content-Type`是`application/octet-steam`或者`multipart/form-data`，则外链是直接下载的

34. 截取两个字符串之间的字符串

核心：使用`match`方法

```js
let str = "hskdfhska;jl234iyiofsdhaklfnaskn,xcnvm,zxn891237499safhas,n";
let s = str.match(/ha(\S*)n,/)[1];
// 'klfnask'
```

35. 刷新网页页面

    1. `history.go(0)`，除非有在服务端解释才能生成的页面代码，否则直接读取缓存中的数据

       不刷新

    2. `location.reload()`，重新连接服务器以读得新的页面

       刷新

    3. `location=location`，执行后仍支持前进后退

    4. `location.assign(location)`：相当于一个链接跳转到指定 url

       可以后退

    5. `document.execCommand('Refresh')`

    6. `window.navigate(location)`

    7. `location.replace(location)`

       执行后没有前进后退

    8. `document.URL = location.href`

36. 常用的 Match 对象的方法

    1. Math.abs() : 返回一个数的绝对值

    2. Math.ceil() : 向上取整

    3. Math.floor() : 向下取整

    4. Math.round() : 四舍五入

    5. Math.trunc() : 返回整数部分

    6. Math.min() : 返回一组数据最小值

       > Math.min(1,2,3,4,5); // 1

       如果没有参数，返回`Infinity`

       如果有一个参数不能转为数值，则结果为`NaN`

    7. Match.max() : 返回一组数据最大值

37. 获取浏览器地址栏中的参数

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

38. JSON.parse(JSON.stringify(obj))实现深拷贝的弊端

39. 深拷贝和浅拷贝

    深拷贝：只是将数据中所有的数据饮用下来，依旧指向同一个存放地址，拷贝之后的数据修改之后，也会影响到元数据中的对象数据。如`Object.assign()`/`...扩展运算符`

    浅拷贝：将数据中所有的数据拷贝下来，对拷贝之后的数据进行修改不会影响到原数据

40. JSON.parse(JSON.stringify(obj))深拷贝的弊端

    | 对象            | 序列化结果 |
    | --------------- | ---------- |
    | 时间对象        | 字符串     |
    | RegExp、Error   | 空对象     |
    | 函数、undefined | 丢失       |
    | NaN、Infinity   | null       |

    只能序列化对象的可枚举的自有属性，如果 obj 中的对象是由构造函数生成的，则会丢失对象的`constructor`

    如果对象中存在循环引用的情况也无法正确实现深拷贝

    ```js
    function Person(name) {
      this.name = 20;
    }

    const p = new Person("p");

    let a = {
      data0: "1",
      date1: [new Date("2020-03-01"), new Date("2020-03-05")],
      data2: new RegExp("\\w+"),
      data3: new Error("1"),
      data4: undefined,
      data5: function () {
        console.log(1);
      },
      data6: NaN,
      data7: p,
    };

    let b = JSON.parse(JSON.stringify(a));
    ```

41. 递归实现深拷贝

    ```js
    function deepClone(obj) {
      // 如果不是对象，则直接返回
      if (typeof obj !== "object") {
        return obj;
      }
      // 判断是数组还是对象，如果是数据，对于数组进行拷贝，如果是对象对于对象进行拷贝
      let objClone = Array.isArray(obj) ? [] : {};
      // 进行深拷贝不能为空
      if (obj && typeof obj === "object") {
        for (let key in obj) {
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

42. call、apply 与 bind 用法和区别

相同点：都用于改变`this`指向的绑定

不同点：

1. call、apply 会`立即执行函数`。`call`传递参数调用形参是以散列的形式（`fn.call(obj,1,2,3)`），而`apply`的形参是一个数组。在传参的情况下，`call`的性能要高于`apply`，因为`apply`在执行的时候还要多一步解析数组

2. `bind`在改变`this`之后返回的是一个全新的绑定函数，即返回一个新的函数，不会立即执行函数。并且之后的`this`指向无法再通过 call、apply、bind 改变。

实现

1. call

   ```js
   let obj = {
     name: "lan",
   };
   function fn() {
     console.log("...arguments", ...arguments);
     console.log("this.name", this.name);
   }
   fn.call(obj, 1, 2, 3);
   ```

2. apply

   ```js
   let obj = {
     name: "lan",
   };
   function fn() {
     console.log("...arguments", ...arguments);
     console.log("this.name", this.name);
   }
   fn.apply(obj, [1, 2, 3]);
   ```

3. bind

   ```js
   let bindObj = {
     name: "bind-name",
   };
   let applyObj = {
     name: "apply-name",
   };
   function fn() {
     console.log("...arguments", ...arguments);
     console.log("this.name", this.name);
   }
   let bfn = fn.bind(bindObj, [1, 2, 3]);
   bfn();

   // 这里重新绑定不会改变this指向
   bfn.apply(applyObj);
   ```

4. 将当前时间/指定时间转换为时间戳（毫秒）

```js
// 方式一
Date.now(); // 1606381881650(打印时的时间戳)
// 方式二
new Date() - 0; // 1606381881650
new Date("2022-03-05") - 0; // 1646438400000
// 方式三
+new Date(); // 1646572862004
+new Date("2022-03-05"); // 1646438400000
// 方式四
new Date().valueOf(); // 1606381881650
new Date("2022-03-05").valueOf(); // 1646438400000
// 方式五
new Date() * 1; // 1606381881650
new Date("2022-03-05") * 1; // 1646438400000
// 方式六
Number(new Date()); // 1646574434807
Number(new Date("2022-03-05")); // 1646438400000
// 方式七
new Date().getTime(); // 1606381881650
new Date("2022-03-05").getTime(); // 1646438400000
```

42. 页面加载完成

纯 js 方法

```js
// (1)、页面所有内容加载完成执行
window.onload = function () {};

// (2)、页面加载完毕
document.onreadystatechange = function () {
  if (doucument.readyState == "complete") {
    // 页面加载完毕
  }
};
```

jquery 方法

注：
（1）jquery 方法兼容性好，并且实在 dom 资源加载完毕的情况下执行，（不包括图片视频资源）
（2）第 1 种是第 2 种的简写方式。两个是 document 加载完成后就执行方法
（3）window.onload = function(){};都是等到整个 window 加载完成执行方法体。是使用 dom 对象
（4）执行顺序 1.）第 1 种和第 2 种无论放在哪里都是最先执行，window.onload = function(){};在其之后执行，“在标签上静态绑定 onload 事件，<body onload="aaa()">等待 body 加载完成，就会执行 aaa()方法/函数”最后执行

```js
$(function () {});

$(document).ready(function () {
  // document 不写默认document
});
```

需要补充的是，如果页面元素是根据接口动态渲染的话，接口数据是异步的，可能有些节点获取不到

43. js 获取浏览器语言

```js
function getCurrentPageLanguage() {
  var JsSrc = (navigator.language || navigator.browserLanguage).toLowerCase();
  if (JsSrc.indexOf("zh") >= 0) {
    // 假如浏览器语言是中文
    return "zh";
  } else if (JsSrc.indexOf("en") >= 0) {
    // 假如浏览器语言是英文
    return "en";
  } else {
    // 假如浏览器语言是其它语言
    return "other";
  }
}
```

44. 判断页面网速

    ```js
    navigator.connection.downlink; // 无限制为10
    navigator.connection.downlink; // 高速3G为1.5
    navigator.connection.downlink; // 低速3G为0.4
    navigator.connection.downlink; // 离线状态为0
    ```

45. 变量名下划线开头

    1. 系统内置的变量或函数，方便和用户不重名
    2. 私有变量

46. Symbol

    1. 定义

       1. 是独一无二的值
       2. 是基本数据类型，不是引用类型

    2. 基本用法

       ```js
       // 参数name没有任何意义，只适用于标识
       const name = Symbol("name");
       ```

    3. 使用 Symbol 作为对象属性名

       注意：需要使用`[]`进行包裹，不可以使用`obj.xxx`来访问

       ```js
       //后面的括号可以给symbol做上标记便于识别
       let name = Symbol("name");
       let say = Symbol("say");
       let obj = {
         //如果想 使用变量作为对象属性的名称，必须加上中括号，.运算符后面跟着的都是字符串
         [name]: "lnj",
         [say]: function () {
           console.log("say");
         },
       };
       obj.name = "it666";
       obj[Symbol("name")] = "it666";
       console.log(obj);
       ```

    4. 转换和运算

       只能转换为字符串和布尔值（恒为`true`）

       不能做任何运算，会报错，如`(Symbol()) + 1`

    5. 遍历

       普通的遍历对象无法访问到 symbol 的属性，需要使用`Object.getOwnPropertySymbols()`或者`Reflect.ownKeys()`

       ```js
       let _password = Symbol("password");
       const obj = {
         name: "小明",
         gender: "male",
         [_password]: "11038",
       };
       for (let item in obj) {
         console.log(item);
       }
       console.log(Object.keys(obj));
       console.log(Object.values(obj));
       console.log(Object.getOwnPropertyNames(obj));
       console.log(Object.getOwnPropertySymbols(obj)); // [Symbol(password)]
       console.log(Reflect.ownKeys(obj)); // ['name', 'gender', Symbol(password)]
       // 输出11038，所以还是可以直接访问到symbol类型的属性，所以symbol并不能真正实现私有变量的设定，所以一般只用于定义一些非私有的、但又希望只用于内部的方法
       console.log(obj[_password]);
       ```

    6. Symbol 自带的方法

       1. Symbol.for

          1. 因为 Symbol 的值都是独一无二的，但是我们希望可以重新使用同一个 Symbol 值
          2. 接受一个字符串作为参数，然后搜索有没有以该参数作为名称的“Symbol 值，如果有，就返回这个 Symbol 值，否则就新建一个以该字符串为名称的 Symbol 值，并将其注册到全局

          ```js
          const s1 = Symbol.for("foo");
          const s2 = Symbol.for("foo");
          console.log(s1 === s2); // true
          ```

       2. Symbol.keyFor

          由于`Symbol()`写法没有登记机制，每次调用都会返回一个不同的值

          `Symbol.keyFor()`返回一个一个已登机的 Symbol 类型值的 key

          ```js
          const s1 = Symbol.for("foo");
          Symbol.keyFor(s1); // foo
          const s2 = Symbol("foo");
          Symbol.keyFor(s2); // undefined
          ```

    7. 应用场景

       1. 企业开发中如果需要对一些第三方的插件、框架进行自定义的时候，可能会因为添加了同名的属性或者方法，将框架中原有的属性或者方法覆盖掉，这时候可以使用 Symbol 作为属性或者方法的名称

       2. 消除魔术字符串

          魔术字符串：在代码中多次出现、与代码形成强耦合的某一个具体的`字符串或者数值`

       3. 为对象定义一些非私有的，但是又只希望内部可以访问的成员

47. history 和 hash 路由

    1. hash 模式

       1. 介绍：hash 就是 url 尾巴后的`#`号以及后面的字符，由于 hash 值的变化不会导致浏览器向服务器发送请求，而且 hash 改变会触发`hashchange`事件，hashChange 事件中获取当前 hash 值，并根据 hash 值来修改页面内容，则达到了前端路由的目的。在 html5 之前，都是使用 hash 来做前端路由的。

       2. 核心：可以在 window 对象上监听`onhashchange`事件

       3. 使用

          ```js
          window.onhashchange = function (event) {
            console.log(event.oldURL, event.newURL);
            document.body.style.color = location.hash.slice(1);
          };
          ```

    2. history 模式

       1. 介绍：已经有了 hash 模式了，为什么还要搞一个 history 呢？

          1. `#`hash 本身是用来做页面定位的，如果用来做路由的话，原来的锚点的功能就不能用了。
          2. hash 穿参是基于 url 的，如果要传递复杂的数据，会有体积的限制，而 history 不仅可以在 url 里放参数，还可以将数据存放在一个特定的对象中

       2. history 的 api

          ```js
          window.history.pushState(state, title, url);
          // state：需要保存的数据，这个数据在触发popstate事件时，可以在event.state里获取
          // title：标题，基本没用，一般传 null
          // url：设定新的历史记录的 url。新的 url 与当前 url 的 origin 必须是一樣的，否则会抛出错误。
          // url可以是绝对路径，也可以是相对路径。
          // 如 当前url是 https://www.baidu.com/a/,执行history.pushState(null, null, './qq/')，
          // 则变成 https://www.baidu.com/a/qq/，
          // 执行history.pushState(null, null, '/qq/')，则变成 https://www.baidu.com/qq/
          window.history.replaceState(state, title, url);
          // 与 pushState 基本相同，但她是修改当前历史记录，而 pushState 是创建新的历史记录
          window.addEventListener("popstate", function () {
            // 监听浏览器前进后退事件，pushState 与 replaceState 方法不会触发
            console.log(event.state);
          });
          history.state; //是一个属性，可以得到当前页的state信息。
          // 通过window.history对象来控制页面历史记录跳转
          window.history.back(); // 后退
          window.history.forward(); // 前进
          window.history.go(1); // 前进一步，-2为后退两步，window.history.lengthk可以查看当前历史堆栈中页面的数量
          ```

       3. 区别

          ```
          1. hash模式较丑，history模式较优雅;
          2. pushState设置的新URL可以是与当前URL同源的任意URL；而hash只可修改#后面的部分，故只可设置与当前同文档的URL;
          3. pushState设置的新URL可以与当前URL一模一样，这样也会把记录添加到栈中；而hash设置的新值必须与原来不一样才会触发记录添加到栈中;
          4. pushState通过stateObject可以添加任意类型的数据到记录中；而hash只可添加短字符串;
          5. pushState可额外设置title属性供后续使用;
          6. hash兼容IE8以上，history兼容IE10以上;
          7. history模式需要后端配合将所有访问都指向index.html，否则用户刷新页面，会导致404错误。
          ```

48. base64 编码和解码

```js
//下面是64个基本的编码
const base64EncodeChars =
  "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
const base64DecodeChars = [
  -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
  -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
  -1, -1, -1, -1, -1, 62, -1, -1, -1, 63, 52, 53, 54, 55, 56, 57, 58, 59, 60,
  61, -1, -1, -1, -1, -1, -1, -1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,
  14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1, -1, 26,
  27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45,
  46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1,
];
//编码的方法
function base64encode(str) {
  let out, i;
  let c1, c2, c3;
  const len = str.length;
  i = 0;
  out = "";
  while (i < len) {
    c1 = str.charCodeAt(i++) & 0xff;
    if (i == len) {
      out += base64EncodeChars.charAt(c1 >> 2);
      out += base64EncodeChars.charAt((c1 & 0x3) << 4);
      out += "==";
      break;
    }
    c2 = str.charCodeAt(i++);
    if (i == len) {
      out += base64EncodeChars.charAt(c1 >> 2);
      out += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xf0) >> 4));
      out += base64EncodeChars.charAt((c2 & 0xf) << 2);
      out += "=";
      break;
    }
    c3 = str.charCodeAt(i++);
    out += base64EncodeChars.charAt(c1 >> 2);
    out += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xf0) >> 4));
    out += base64EncodeChars.charAt(((c2 & 0xf) << 2) | ((c3 & 0xc0) >> 6));
    out += base64EncodeChars.charAt(c3 & 0x3f);
  }
  return out;
}
//解码的方法
function base64decode(str) {
  let c1, c2, c3, c4;
  let i, out;
  const len = str.length;
  i = 0;
  out = "";
  while (i < len) {
    do {
      c1 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
    } while (i < len && c1 == -1);
    if (c1 == -1) break;

    do {
      c2 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
    } while (i < len && c2 == -1);
    if (c2 == -1) break;
    out += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4));

    do {
      c3 = str.charCodeAt(i++) & 0xff;
      if (c3 == 61) return out;
      c3 = base64DecodeChars[c3];
    } while (i < len && c3 == -1);
    if (c3 == -1) break;
    out += String.fromCharCode(((c2 & 0xf) << 4) | ((c3 & 0x3c) >> 2));

    do {
      c4 = str.charCodeAt(i++) & 0xff;
      if (c4 == 61) return out;
      c4 = base64DecodeChars[c4];
    } while (i < len && c4 == -1);
    if (c4 == -1) break;
    out += String.fromCharCode(((c3 & 0x03) << 6) | c4);
  }
  return out;
}
function utf16to8(str) {
  let out, i, c;
  out = "";
  const len = str.length;
  for (i = 0; i < len; i++) {
    c = str.charCodeAt(i);
    if (c >= 0x0001 && c <= 0x007f) {
      out += str.charAt(i);
    } else if (c > 0x07ff) {
      out += String.fromCharCode(0xe0 | ((c >> 12) & 0x0f));
      out += String.fromCharCode(0x80 | ((c >> 6) & 0x3f));
      out += String.fromCharCode(0x80 | ((c >> 0) & 0x3f));
    } else {
      out += String.fromCharCode(0xc0 | ((c >> 6) & 0x1f));
      out += String.fromCharCode(0x80 | ((c >> 0) & 0x3f));
    }
  }
  return out;
}
function utf8to16(str) {
  let out, i, c;
  let char2, char3;
  out = "";
  const len = str.length;
  i = 0;
  while (i < len) {
    c = str.charCodeAt(i++);
    switch (c >> 4) {
      case 0:
      case 1:
      case 2:
      case 3:
      case 4:
      case 5:
      case 6:
      case 7:
        // 0xxxxxxx
        out += str.charAt(i - 1);
        break;
      case 12:
      case 13:
        // 110x xxxx   10xx xxxx
        char2 = str.charCodeAt(i++);
        out += String.fromCharCode(((c & 0x1f) << 6) | (char2 & 0x3f));
        break;
      case 14:
        // 1110 xxxx  10xx xxxx  10xx xxxx
        char2 = str.charCodeAt(i++);
        char3 = str.charCodeAt(i++);
        out += String.fromCharCode(
          ((c & 0x0f) << 12) | ((char2 & 0x3f) << 6) | ((char3 & 0x3f) << 0)
        );
        break;
    }
  }
  return out;
}

//编码
function encodeBase64(str: string): string {
  return base64encode(utf16to8(str));
}
//解码
function decodeBase64(str: string): string {
  return utf8to16(base64decode(str));
}

export { encodeBase64, decodeBase64 };
```

49. console 对象常用方法

```js
console.log(text,text2,...)   //用于在console窗口输出信息。它可以接受多个参数，将它们的结果连接起来输出。如果第一个参数是格式字符串（使用了格式占位符），console.log方法将依次用后面的参数替换占位符，然后再进行输出。
console.info()   //在console窗口输出信息，同时，会在输出信息的前面，加上一个蓝色图标。
console.debug()  //在console窗口输出信息，同时，会在输出信息的前面，加上一个蓝色图标。
console.warn()  //输出信息时，在最前面加一个黄色三角，表示警告；
console.error()  //输出信息时，在最前面加一个红色的叉，表示出错，同时会显示错误发生的堆栈
console.table()  //可以将复合类型的数据转为表格显示。
console.count()  //用于计数，输出它被调用了多少次。
console.dir()    //用来对一个对象进行检查（inspect），并以易于阅读和打印的格式显示。
console.dirxml()  //用于以目录树的形式，显示DOM节点。
console.assert()  //接受两个参数，第一个参数是表达式，第二个参数是字符串。只有当第一个参数为false，才会输出第二个参数，否则不会有任何结果。

//这两个方法用于计时，可以算出一个操作所花费的准确时间。
console.time()
console.timeEnd()
//time方法表示计时开始，timeEnd方法表示计时结束。它们的参数是计时器的名称。调用timeEnd方法之后，console窗口会显示“计时器名称: 所耗费的时间”。

console.profile()  //用来新建一个性能测试器（profile），它的参数是性能测试器的名字。
console.profileEnd()  //用来结束正在运行的性能测试器。

console.group()
console.groupend()
//上面这两个方法用于将显示的信息分组。它只在输出大量信息时有用，分在一组的信息，可以用鼠标折叠/展开。
console.groupCollapsed()  //用于将显示的信息分组，该组的内容，在第一次显示时是收起的（collapsed），而不是展开的。

console.trace()  //显示当前执行的代码在堆栈中的调用路径。
console.clear()  //用于清除当前控制台的所有输出，将光标回置到第一行
```

50. Failed to execute 'atob' on 'Window': The string to be decoded is not correctly encoded.

    背景：将 base64 转化为文件对象的时候报错了

    原因：不需要 base64 开头的类型标志

    ```js
    // 出问题的str
    const base64 = "data:application/pdf;base64,JVBERi0xLjUKJeLjz9";

    // 应该进行替换
    let str = "data:application/pdf;base64,JVBERi0xLjUKJeLjz9";
    const base64 = str.replace("data:application/pdf;base64,", "");
    ```

51. 获取页面上的图片，进行批量下载

```js
function downloadIamge(imgsrc, name) {
  //下载图片地址和图片名
  let image = new Image();
  // 解决跨域 Canvas 污染问题
  image.setAttribute("crossOrigin", "anonymous");
  image.onload = function () {
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
  };
  image.src = imgsrc;
}

const arr = document.querySelectorAll(
  "#main > div:nth-child(11) > div.accept > div.v-md-editor-preview > div > p:nth-child(2) > img"
);
const srcList = [];
arr.forEach((el) => {
  srcList.push(el.src);
  downloadIamge(el.src, el.alt, index);
});
console.log("srcList :>> ", srcList);
```

52. reduce 有初始值和无初始值区别

    1. 有初始值，从 index 为 0 开始执行，初始值为设定的初始值
    2. 无初始值，从 index 为 1 开始执行，初始值为 index 为 0 的项

    ```js
    const arr = [1, 2, 3, 4];
    arr.reduce((a, b) => {
      console.log(a, b);
      return a + b;
    });
    arr.reduce((a, b) => {
      console.log(a, b);
      return a + b;
    }, 0);
    ```

53. Number 类型精度丢失问题

    可参考[https://cloud.tencent.com/developer/article/1752099](https://cloud.tencent.com/developer/article/1752099)

    场景：后端返回的一个字段，为比较长的数字，在`preview`和`response`中的值不一样

    原因：

    1. 在其他语言，如 Java 中，Long 类型占 64 位二进制 bit，最大值为：9223372036854774807（2^63 - 1）长度约 19 位。
    2. 而在 Js 中，由于 Number 类型的值也包含了小数，最大值为：9007199254740993（2^53 - 1）长度约 16 位。
    3. 因此当 Java 返回超过 16 位的 Long 型字段转为 json 时，前端 Js 得到的数据将由于溢出而导致精度丢失。

    解决方案

    1. 推荐后端解决，后端传 string 类型即可
    2. 前端通过`正则表达式解析替换`、或者`修改json parser`，但比较麻烦

54. node_modules 中 lib/es/dist 三种打包产物的区别

    是通过三个不同的模块系统打包生成的

    1. es：es module 模块系统
    2. lib: commonjs 模块系统
    3. dist：UMD 模块系统

    dist 目录：

    dist 目录通常包含已经经过构建和打包的库文件，适用于生产环境使用。
    这些文件可能被压缩和合并，适合直接在浏览器中使用或者在生产环境构建工具中进行打包。
    如果你不需要对该库进行自定义处理或构建操作，可以直接引入 dist 目录中的文件。

    lib 目录：

    lib 目录通常包含库的源代码或经过编译但未压缩的文件，适用于开发和自定义构建。
    这些文件可能包含源代码、非压缩的文件、模块化的文件等，适用于进行自定义构建、修改或拓展库的功能。
    如果你需要对库进行自定义操作，比如按需引入特定模块、修改源代码或进行二次开发，可以引入 lib 目录中的文件。

    es 目录：

    es 目录通常包含库的 ES 模块化文件，适用于现代的构建工具和模块化系统（如 webpack、Rollup 等）。
    这些文件使用原生 ES 模块语法，可以支持按需引入和静态分析等特性。
    如果你的项目使用了现代的构建工具，并希望以模块化的方式使用库，可以引入 es 目录中的文件。
    在选择引入的目录时，你应该考虑你的项目的构建工具和目标环境。如果你使用的是传统的打包工具（如 Browserify）或需要支持旧版浏览器，可以选择引入 dist 目录的文件。如果你使用的是现代的构建工具和模块化系统，并希望充分利用 ES 模块化特性，可以选择引入 es 目录的文件。如果你需要对库进行二次开发或自定义操作，可以选择引入 lib 目录的文件。

    最佳做法是查看库的文档或官方指南，了解它们推荐的引入方式，并与你的项目需求进行匹配。有些库可能同时提供 dist、lib 和 es 目录，以适应不同的项目需求。

55. 解决 map 中需要进行 promise 请求的问题

    背景：在一个表格 list 中，有一个字段需要请求接口来获取

    问题：在 map 的回调用请求接口返回的是 promise，无法渲染 list

    解决：使用`Promise.all()`

    ```js
    const getList = async () {
        const list = await getTableList();
        const tableList = await Promise.all(list.map((item) => {
            const data = await getStatus(item.code);
            return {
                ...item,
                code: data.code,
            }
        }));
    }
    ```

56. 字符串排序

```js
let arr = ["a", "c", "d", "b", "x", "q", "j"];
arr.sort((a, b) => a.localeCompare(b)); // ['a', 'b', 'c', 'd', 'j', 'q', 'x']
```

57. 常用的页面浏览器的几种高度

| 属性                      | 介绍                                                               | 备注                                         |
| ------------------------- | ------------------------------------------------------------------ | -------------------------------------------- |
| window.screen.height      | 电脑屏幕高度                                                       | 只和设备有关，和浏览器，工具栏，控制台等无关 |
| window.screen.availHeight | 电脑屏幕可用高度                                                   | 电脑屏幕高度减去顶部工具栏和底部工具栏       |
| window.innerHeight        | 浏览器视口（viewport）高度（单位：像素），如果存在滚动条则包括它。 | 网页页面的可视区域，不包括控制台，书签栏等   |
| window.outerHeight        | 整个浏览器的高度                                                   | 浏览器窗口拉伸可以改变                       |
| element.clientHeight      | 元素的可视高度                                                     |                                              |
| element.scrollHeight      | 元素的高度                                                         | 包括不可见的                                 |
| element.offsetHeight      | 元素的可视高度 + 滚动条的高度                                      |                                              |

58. Failed to execute ‘setRequestHeader‘ on ‘XMLHttpRequest‘: String contains non ISO-8859-1 code point

原因：接口请求的 headers 参数里有不符合 ISO-8859-1 标准的字符，所以导致设置接口 headers 参数的 setRequestHeader 方法失效，然后报错

    正常情况是不会给请求头插入非标准字符的

    比如我这次是因为登录之后获取的token异常，然后每次请求的时候放的token取出来也异常了

59. &&运算符和||运算符的优先级

`&&`高于`||`

如下案例

```js
true || (false && false); // true

(true || false) && false; // false
true || (false && false); // true
```

60. 全局 dom 变量

页面上有 id 的元素，会自动在全局上创建一个和 id 同名的变量，值为该 dom 元素

```js
// html
<div id="hello"></div>;

// js
if (typeof hello == "undefined") {
  console.log("永远不会执行 ");
}
```

61. 如何使用 js 设置 hover 属性

使用`onmouseover`和`onmouseout`

```js
<body>
<ul>
    <li>雪花</li>
    <li>百威</li>
    <li>燕京</li>
    <li>青岛</li>
    <li>崂山</li>
    <li>珠江</li>
</ul>
</body>

<script>

    //获取所有的li标签
    var list = document.getElementsByTagName("li");
    for (var i = 0; i < list.length; i++) {
        //为li注册鼠标进入事件
        list[i].onmouseover = function () {
            //设置其背景颜色为黄色
            this.style.backgroundColor = "yellow";
        };
        //为li注册鼠标离开事件
        list[i].onmouseout = function () {
            //恢复到这个标签默认的颜色
            this.style.backgroundColor = "";
        };
    }

</script>
```

62. js 动态设置 video 的 src 不更新

正常情况下，video 的 scr 两种写法

```html
<video src="xxx"></video>

<video>
  <source src="xxx" />
</video>
```

如果 src 不是写死的，而是从后台获取的，需要动态更新

在使用`srouce`的写法时，不会重新加载，只能用`video`的`src`

63. dom 增删类名

```js
element.classList.add("className");
element.classList.add("className1", "className2", "className3");

// 切换类名，如果不存在，则添加，如果存在则删除
element.classList.toggle("className");

element.classList.remove("className");
element.classList.remove("className1", "className2", "className3");

// 如果需要支持更老的浏览器，使用className属性来当成字符串操作
var className = element.className; // 获取原有类名
var removeClassName = "className"; // 需要删除的类名
var newClassName = className.replace(removeClassName, ""); // 移除需要删除的类名
element.className = newClassName; // 更新类名
```

64. 设置 select 的提示值

```js
var selectElement = document.getElementById("mySelect");
selectElement.selectedIndex = 0; // 设置初始选中提示值
```

65. 逻辑假值

有`""`、`null`、`undefined`、`NaN`、`0`

进行`==`比较的时候，怎么记忆，记忆为`true`的，其他的都是`false`

1.

2.  判断运算符

    有`&&`、`||`、`?`、`?.`、`??`

    对于逻辑假值怎么判断

3.  axios 几种传参

4.  body 中放纯字符串

```js
axios.post(url, str, {
  headers: {
    "Content-Type": "text/plain",
  },
});
```

2. post 请求，使用 query 传参

```js
axios.post(url + "?id=1");
```

3. 下载文件

```js
// 发送请求
export function exportHandle(data: any) {
  return axios.post("/api/admin/xxx", data, {
    responseType: "blob",
  });
}

// 处理响应
axios.interceptors.response.use((response: AxiosResponse<HttpResponse>) => {
  const res = response.data;
  if (res instanceof Blob) {
    const url = URL.createObjectURL(res);
    const link = document.createElement("a");
    link.href = url;
    link.download = "下载.xlsx";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    return "";
  }
});
```
