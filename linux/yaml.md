## 介绍

`YAML`是`YAML Ain't a Markup Language`（YAML不是一种标记语言）的递归缩写。

在开发这种语言时，其实是`Yet Another Markup Language`（仍是一种标记语言）

合其他高级语言类似，并且可以简单表达清单、散列表、标量等数据形态

它使用空白符好缩进合大量依赖外观的特色，特别适用用来表达或编辑数据结构、各种配置文件、倾印调试内容、文件大纲（例如愈多点子邮件标题格式合YAML非常接近）

配置文件后缀为`.yml`，如`config.yml`

## 基本语法

1. 大小写敏感
2. 使用缩进表示层级关系
3. 缩进不允许使用tab，只允许使用空格
4. 所进的空格数不重要，只要相同层级的元素左对齐即可
5. `#`表示注释

## 数据类型

1. 对象：键值对的集合，又称为`映射`（mapping）、`哈希`（hashes）、`字典`（dictionary）
2. 数组：一组按次序排列的值，又称为`序列`（sequence）、`列表`（list）
3. 纯量：单个的、不可再分的值

### YAML对象

对象键值对使用冒号结构表示`key: value`，冒号后面要加一个空格

也可以是以哦那个`key: {key1: value1, key2: vaue2, ...}`

还可以使用缩进表示层级关系

```yaml
key:
    child-key: value
    child-key2: value2
```

较为复杂的对象格式，可以使用问号+一个空格代表一个复杂的key，配合一个冒号+一个空格代表一个value

```yaml
?
    - complexkey1
    - complexkey2
:
    - complexvalue1
    - complexvalue2
```

意思是对象的属性是一个数组，`[complexkey1, complexkey2]`，对应的值也是一个数组`[complexvalue1, complexvalue2]`

### YAML数组

以`-`开头的行表示构成一个数组

```yaml
- A
- B
- C
```

YAML支持多维数组，可以使用行内表示

```yaml
key: [value, value2, ...]
```

数据结构的子成员是一个数组，则可以在该项下面缩进一个空格

```yaml
-
    -A
    -B
    -C
```

一个相对复杂的例子：companies是一个数组，数组的元素是一个由id、name、age组成的对象

```yaml
companies:
    -
        id: 1
        name: zhangsan
        age: 12
    -
        id: 2
        name: lisi
        age: 14
```

数组也可以使用流式`flow`的方式表示

```yaml
companies: [{id: 1,name: company1,price: 200W},{id: 2,name: company2,price: 500W}]
```

### 纯量

是最基本的，不可再分的值

1. 字符串
2. 布尔值
3. 整数
4. 浮点数
5. Null
6. 时间
7. 日期

```yaml
boolean: 
    - TRUE  #true,True都可以
    - FALSE  #false，False都可以
float:
    - 3.14
    - 6.8523015e+5  #可以使用科学计数法
int:
    - 123
    - 0b1010_0111_0100_1010_1110    #二进制表示
null:
    nodeName: 'node'
    parent: ~  #使用~表示null
string:
    - 哈哈
    - 'Hello world'  #可以使用双引号或者单引号包裹特殊字符
    - newline
      newline2    #字符串可以拆成多行，每一行会被转化成一个空格
date:
    - 2018-02-17    #日期必须使用ISO 8601格式，即yyyy-MM-dd
datetime: 
    -  2018-02-17T15:02:31+08:00    #时间使用ISO 8601格式，时间和日期之间使用T连接，最后使用+代表时区
```

### 引用

`&`锚点和`*`别名，可以用来引用

```yaml
defaults: &defaults
  adapter:  postgres
  host:     localhost

development:
  database: myapp_development
  <<: *defaults

test:
  database: myapp_test
  <<: *defaults
```

相当于

```yaml
defaults:
  adapter:  postgres
  host:     localhost

development:
  database: myapp_development
  adapter:  postgres
  host:     localhost

test:
  database: myapp_test
  adapter:  postgres
  host:     localhost
```

`&`用来建立锚点（defaults）

`<<`表示合并到当前数据

`*`用来引用锚点