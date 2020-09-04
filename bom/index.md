<!--
 * @Date: 2020-09-02 21:34:19
 * @LastEditors: Lq
 * @LastEditTime: 2020-09-04 22:54:44
 * @FilePath: \learnningNotes\bom\index.md
-->
#### 介绍

1. 操作浏览器的浏览器对象模型  
2. `window`是`浏览器`中的顶级对象 --- 即顶配
3. `doucument`是`页面中`的顶级对象 --- 次顶配
4. `BOM`核心的`window`对象在浏览器中，即是`javascript`访问浏览器窗口的一个接口，又是`ECMAScript`规定的`Global`对象。这意味着在网页中定义的任意的变量/函数/对象都是在`window`这个顶级对象之下的。



#### 常见的BOM对象

注意：小写形式是代表对象`实例`，大写形式是对象`类`

1. window：代表整个浏览器的窗口，是BOM中的最顶级的对象

    ```js
    // var和function声明的变量在window对象下，可以直接访问，也可以通过window.变量名访问
    var a = "hello";
    var fn = function() {
      console.log("hello");
    }
    function fn1() {}
    console.log(window.a); // "hello"
    console.log(a); // "hello"
    console.log(window.fn); // fn(){...}
    console.log(fn); // fn(){...}
    console.log(window.fn1); // fn1(){}
    console.log(fn1); // fn1(){}

    // let和const声明的变量不在window对象下
    let b = "bbb";
    const fn2 = function() {}
    console.log(b); // bbb
    console.log(window.b); // undefined
    console.log(fn2); // fn2(){}
    console.log(window.fn2); // undefined
    ```

    **常用属性**  

    1. innerHeight/innerWidth  
            返回网页的CSS布局占据的浏览器窗口的高度和宽度，单位为像素（px），包括滚动条的宽高    
            当页面进行放大时，该值会缩小（100% -> 110%    =>    1536px -> 1396px）

    2. scrollX/scrollY  
            返回滚动条偏移量，不能手动改变值来控制滚动条

    3. scrollTo/scrollBy/scroll

        scrollTo(x, y)/scroll(x, y)：控制滚动条绝对位置  
        scrollBy：控制滚动条相对位置  

    4. frames  
        返回一个类似数组的对象，每一个成员是页面内的`frame`或`iframe`框架的窗口（就是窗口的`window`对象）  
        如果需要获取对象的dom树，使用`window.frames[0].document`

    5. clientWidth/clientHeight

        返回当前页面视图区域的宽高，兼容写法如下

        ```JS
        var cWidth = document.documentElement.clientWidth || document.body.clientWidth;
        var cHeight = document.documentElement.clientHeight || document.body.clientHeight;
        ```


    **常用方法**

    1. 网页弹窗  
        alert(message)：警告弹窗  
        prompt(label, defaultValue)：有输入框的弹窗  
        confirm()：确认框，返回布尔值  

    2. 打开和关闭窗口

        open(url, 方式)：新建窗口打开指定的url  
        第二个参数如下  
            1. `_blank`：在新窗口中打开链接  
            2. `_self`：`默认`，替换当前页面  
            3. `_parent`：加载到父框架  
            4. `name`：窗口名称  

        **`关于window.open()弹窗被禁`**  

        **原因**：出于安全考虑，当浏览器检测到`非用户直接操作`产生的新弹出窗口会对其进行阻止。因为浏览器认为这是用户不希望看到的页面。

        比如说在一个点击事件的方法中先请求ajax数据，然后`window.open()`就会被拦截

        **解决方案**：先打开一个空的窗口，然后将地址写入`location.href`属性中

        close()：关闭当前的窗口（不是整个浏览器）

    3. 定时器

        1. 间歇调用：每隔一段时间调用一次  

            ```js
            var timerID = setInterval(function,interval);
            /*
            参数 :
            function : 需要执行的代码,可以传入函数名;或匿名函数
            interval : 时间间隔,默认以毫秒为单位 1s = 1000ms
            返回值 : 返回定时器的ID,用于关闭定时器
            */

            //关闭指定id对应的定时器
            clearInterval(timerID);
            ```

        2. 超时调用：一段时间之后执行一次  

            ```js
            //开启超时调用:
            var timerId = setTimeout(function,timeout);
            //关闭超时调用:
            clearTimeout(timerId);
            ```

        3. 超时调用模拟间歇调用：由于使用间歇调用有可能出现前一个调用未结束就调用后一个的情况，所以一般使用超时调用模拟间歇调用  

            ```js
            let num = 0;
            let max = 10;
            let intervalDemo = (time) => {
            num ++;
            if(num > max) {
                console.log("模拟结束了");
            } else {
                setTimeout(() => {
                console.log(num);
                intervalDemo(time);
                }, time)
            }
            };
            intervalDemo(500);
            ```

2. navigator：代表浏览器当前的信息，可以获取用户当前使用的是什么浏览器

    ```js
    let agent = navigator.userAgent;
    if (/chrome/i.test(agent)) {
        alert("谷歌");
    } else if (/firefox/i.test(agent)) {
        alert("火狐");
    } else if (/opera/i.test(agent)) {
        alert("欧朋");
    } else if (/safari/i.test(agent)) {
        alert("safari");
    } else if (/msie/i.test(agent)) {
        alert("低版本ie");
    } else if ("ActiveXObject" in window) {
        alert("低级IE浏览器");
    }
    ```

3. location：代表在当前的地址信息，可以获取或者设置当前的地址信息（包含url等，不是实际的物理地址）

4. history：保存`当前窗口`访问过的url，不是当前浏览器访问过的url

5. screen：代表用户的屏幕信息




