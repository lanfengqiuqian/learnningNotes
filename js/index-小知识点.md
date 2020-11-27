<!--
 * @Date: 2020-09-02 10:46:40
 * @LastEditors: Lq
 * @LastEditTime: 2020-11-25 14:51:01
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