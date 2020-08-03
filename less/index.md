### 使用

1. 在nodejs中使用

> npm install -g less  // 安装

> lessc styles.less styles.css  // 编译

2. 在浏览器中使用

> <link rel="stylesheet/less" type="text/css" href="styles.less" />

> <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.11.1/less.min.js" ></script>

### 新功能

1. 变量
```less
@width: 10px;
@height: @width + 10px;

#header {
  width: @width;
  height: @height;
}
```

2. 混合：将一组属性从一个规则集引入到另外一个规则集。能够通过像调用方法一样使用已经使用过的css。
```less
.bordered {
  border-top: dotted 1px black;
  border-bottom: solid 2px black;
}

#menu a {
  color: #111;
  .bordered();
}

.post a {
  color: red;
  .bordered();
}
```

3. 嵌套：当需要使用后代选择器的时候，可以使用嵌套的方式，能够将后代选择器像标签一样被包裹在外层选择器中。
```less
#header {
  color: black;
  .navigation {
    font-size: 12px;
  }
  .logo {
    width: 300px;
  }
}
```

4. `&`符号：表示当前选择器的父级，一般和伪类选择器一起使用。
```less
.box {
    width: 100px;
    &:hover {
        width: 200px;
    }
}
```

5. `@`规则：例如，`@media`、`@supportes`，@规则会被放到前面，同一规则中的其他元素相对顺序保持不变，这种特性叫`冒泡`。
```less
.component {
  width: 300px;
  @media (min-width: 768px) {
    width: 600px;
    @media  (min-resolution: 192dpi) {
      background-image: url(/img/retina2x.png);
    }
  }
  @media (min-width: 1280px) {
    width: 800px;
  }
}
```
编译后
```css
.component {
  width: 300px;
}
@media (min-width: 768px) {
  .component {
    width: 600px;
  }
}
@media (min-width: 768px) and (min-resolution: 192dpi) {
  .component {
    background-image: url(/img/retina2x.png);
  }
}
@media (min-width: 1280px) {
  .component {
    width: 800px;
  }
}
```

6. 算数运算：可以对于数字，颜色或变量进行运算。在进行加减之前会进行单位转化，结果以左侧单位类型为准。如果单位换算无效或失去意义，则会忽略单位。
```less
// 所有操作数被转换成相同的单位
@conversion-1: 5cm + 10mm; // 结果是 6cm
@conversion-2: 2 - 3cm - 5mm; // 结果是 -1.5cm

// conversion is impossible
@incompatible-units: 2 + 5px - 3cm; // 结果是 4px

// example with variables
@base: 5%;
@filler: @base * 2; // 结果是 10%
@other: @base + @filler; // 结果是 15%
```
乘法和除法不做转化。

7. 转义：使用字符串作为变量值。
```less
@min768: (min-width: 768px);
@min768: ~"(min-width: 768px)"; // 3.5+版本可以忽略~和引号

.element {
    @media @min768 {
        font-size: 1.2rem;
    }
}
```

8. 函数：less内置了多种函数，用于转换颜色、处理字符串、算数运算等。查看这篇[文章](https://www.cnblogs.com/czf-zone/p/4436006.html)

9. 