### 分页器

#### 使用

1. 引入样式文件`<link rel="stylesheet" href="./paginationself.css">`

2. 引入js代码文件` <script src="./paginationself.js"></script>`

3. js代码添加

   ```javascript
   var fy = document.getElementById("pagination_self");//父容器,负责存储分页器,id名不要改
   paginationself(fy, {});
   ```

#### 具体参数

paginationself(fatherDom,options,callback)

1. fatherDom:生成器生成的父容器
2. options对象:参数配置
   - pageInfo对象
     - pageNum:当前页
     - totalPage:总页数
     - least:当总页数低于least的时候页码全部显示
     - size:一次显示多少页码
   - textInfo对象:设置显示文字
     - first:(默认为首页)
     - prev:(默认为上一页)
     - next:(默认为下一页)
     - last:(默认为尾页)
3. callback:当用户单击页数的时候触发回调函数,会返回一个用户单击后的页码

#### 参考示例

```html
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./paginationself.css">
    <style>
        /* 外壳样式,可选,写了就覆盖默认的 */
        /* #pagination_self {
            width: 98%;
            height: 50px;
            border: 1px solid #e5e5e5;
            margin: 20px auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }  */
    </style>
</head>

<body>
    <!-- id名不可变动! -->
    <div id="pagination_self">
    </div>
    <script src="./paginationself.js"></script>
    <script>
        // 使用
        var fy = document.getElementById("pagination_self");
        paginationself(fy, {
            pageInfo: {
                pageNum:2,
                totalPage:25
            }
        }, (nowPage) => {
            //此为回调函数,可省略~
            console.log("当前显示的页为",nowPage);
        });
        //等同于
        // paginationself(fy,{});
    </script>
</body>

</html>
```

### 效果图
#### 图1
![](README/img/20220403154238.png)
#### 图2
![](README/img/20220403154403.png)
#### 图3
![](README/img/20220403154454.png)
#### 图4
![](README/img/20220403154318.png)
