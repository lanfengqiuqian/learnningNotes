<!--
 * @Date: 2020-11-09 20:21:24
 * @LastEditors: Lq
 * @LastEditTime: 2020-11-09 21:40:18
 * @FilePath: \learnningNotes\ts\index.md
-->
### 安装和使用

1. 安装
> cnpm install -g typescript

2. 编译文件，会在当前目录下生成一个同名的js文件

> tsc test.ts

3. 设置自动编译

    1. 当前目录输入：`tsc --init`，会自动生成一个`tsconfig.json`文件

    2. 修改生成的`tsconfig.json`文件

        放开17行的注释，将输出目录改为`./js`，保存

        这样的话每次编译自动就会保存在当前目录的js目录下

    3. vscode菜单栏

        终端 -> 运行任务 -> typescript -> tsc:监视 -tsconfig.json

### 基础类型

1. 最基本的
    ```js
    // 布尔
    let isDone: boolean = false;
    // 数字
    let num:  number = 1;
    // 字符串
    let str: string = 'hello';
    ```

2.  数组

    ```js
    // 元素类型后加[]
    let arr: number[] = [1, 2, 3];
    // 数组泛型
    let array: Array<number> = [1, 2, 3];
    ```

3. 元组：Tuple

    属于数组的一种，元组类型允许表示一个已知元素数量和类型的数组，各元素的类型不必相同

    ```js
    let arr: [string, number] = ["hello", 123];
    ```

4. 枚举：enum

    使用一组单词来表示一个状态的所有情况

    ```js
    enum Flag {
        success = 1,
        error = -1
    }
    let f: Flag = Flag.success;
    ```

    如果没有给美剧类型赋值的话，默认是索引值，如果上一个已经赋值的话，会自动加1

    ```js
    enum Flags {
        red,
        yellow = 2,
        green
    }

    console.log(Flags.red, Flags.yellow, Flags.green); // 0, 2, 3
    ```

5. 任意类型

    一个变量的类型有可能是动态获取的，定义的时候不清楚是什么类型，让编译阶段跳过检查

    ```js
    let a: any = 111;
    a.name = "lan";
    ```

6. null和undefined

    是其他所有类型的子类型

    ```js
    let num: number;
    console.log(num); // 报错，在赋值之前被使用

    let num: number | undefined;
    console.log(num); // 正确
    ```

    null同理

7. void

    表示没有任何类型，一般用于方法返回值

    ```js
    function noReturn(): void {
        console.log('没有返回值的方法');
    }
    ```

    只能够被undefined和null赋值

8. never

    表示从来不会出现的值或类型

    如：总是会抛出异常或根本不会有返回值的函数表达式或箭头函数表达式的返回值类型


### 函数

##### 介绍

es5中定义函数的方式

```js
// 函数声明
function demo01() {}
// 匿名函数
let demo02 = function() {}
```

ts中定义函数的方式

```js
function demo01(name: string, age: number): string {
    return "hello" + name + "you are " + age; 
}
```