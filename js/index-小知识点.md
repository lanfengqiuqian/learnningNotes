<!--
 * @Date: 2020-09-02 10:46:40
 * @LastEditors: Lq
 * @LastEditTime: 2020-11-18 09:58:46
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

    > str.trim()