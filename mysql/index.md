<!--
 * @Date: 2020-08-19 19:08:33
 * @LastEditors: Lq
 * @LastEditTime: 2022-08-12 20:22:55
 * @FilePath: \learnningNotes\mysql\index.md
-->

## Navicat破解教程：https://www.cnblogs.com/kkdaj/p/14987106.html

注意：会顺便下载一些垃圾软件


进行左连接时，就有涉及到主表、辅表，这时主表条件写在WHERE之后，辅表条件写在ON后面！！！
主表决定了数据条数，辅表决定了拼接的内容是null还是有数据。

0. 查询并替换包含某一部分内容的字段，并替换相应内容
```sql
UPDATE 
  "你的表名" 
SET 
  "字段名" = REPLACE("字段名", '原内容', '要替换的内容') 
WHERE 
  "字段名" LIKE CONCAT('%', '原内容', '%')

// 示例
UPDATE `zhu_c_invoice` SET `invoice_category_json` =  REPLACE (`invoice_category_json`, '[[{', '[{'), `invoice_category_json` = REPLACE (`invoice_category_json`  , '}]]', '}]')  WHERE `invoice_category_json` NOT LIKE '[{%'
```


1. tp框架中`where`和`whereOr`方法同时使用

    ```php
    // 需要||的条件
    $arr = [['status', '=', '1'], ['status', '=', '2'], ['status', '=', '3']];

    // 想要效果 money = 111 && (status = 1 || status = 2 || status = 3)

    // 错误写法1
    $result = Db::table('table')
        ->whereOr($arr)
        ->where([['money', '=', 111]])
        ->order('id', 'desc')
        ->select()
        ->toArray();

    // 相当于 status = 1 || status = 2 || status = 3 && money = 111 (没有了括号效果)

    // 错误写法2
    $result = Db::table('table')
        ->where([['money', '=', 111]])
        ->whereOr($arr)
        ->order('id', 'desc')
        ->select()
        ->toArray();

    // 相当于 money = 111 && status = 1 || status = 2 || status = 3 (没有了括号效果)
    
    // 正确写法
    $result = Db::table('zhu_b_task_cycle')
        ->where(
            function ($query) use ($arr) {
                $query->whereOr($arr);
            }
        )
        ->where('money', '=', 111)
        ->select()
        ->toArray();
    ```

2. 在某一个字段的基础上进行算术运算，或两个字段进行相加等操作

    > update money_user_bank set account_money=account_money-100 where id=1

    > UPDATE zhu_c_salary a, zhu_c_task b SET b.month_limit_money = (a.ensure_money + b.month_limit_money) WHERE a.b_task_cycle_id = 1 AND a.tel = b.tel

3. tp框架中`qeury`和`execute`操作的区别

    query：返回的是结果集，增删改的操作永远返回的是`[]`，所以一般用来执行查询操作

    execute：返回的是影响行数，查询的结果永远返回的是0，所以一般用来执行增删改操作

4. 关于左连接

    [链接](https://zhuanlan.zhihu.com/p/85856388)

5. 左连接去重

    在查询到a表和b表之后连接c表，但是c表有多条数据

    关键：连接的时候给c表进行去重

    ```sql
    SELECT a.*,
        b.`openid`,
    c.`sign_result` , c.`sign_end_time`
    FROM `zhu_post_user` a
    LEFT JOIN zhu_c_user b ON a.tel= b.tel
    LEFT JOIN (SELECT * FROM `zhu_e_baby_info` GROUP BY tel) c ON (c.`tel` = a.tel AND c.`sign_result` = '完成' )
    WHERE a.`social_credit_code`= '1111'
    ORDER BY a.`id` DESC
    ```

6. IFNULL、ISNULL、IF、IF CASE

    1. 如果a字段不是null，则查询a字段，否则查询b字段

        ```sql
        SELECT id, tel, ifnull(`content`, `content2` )  FROM  `demo` WHERE id = 832
        ```

    2. 如果一个字段有值，则不更新，否则更新

        ```sql
        UPDATE `demo` set `account_id` = ifnull(`account_id`, 999) WHERE id = 833
        ```

    3. 类似于3目运算符,如果content有值返回content2，否则返回content3

        ```sql
        SELECT id, tel, if(`content`, `content2`, `content3`)  FROM  `demo` WHERE id = 832;
        UPDATE demo SET `name` = IF(`name`, `name`, `tom`) WHERE id = 888;
        ```

        说明：  
        1. 如果 expr1 是TRUE (expr1 <> 0 and expr1 <> NULL and expr1 <> '')，则 IF()的返回值为expr2; 否则返回值则为 expr3。IF()的返回值为数字值或字符串值，具体情况视其所在语境而定。  
        2. expr1 作为一个整数值进行计算，就是说，假如你正在验证浮点值或字符串值，   那么应该使用比较运算进行检验。

    4. CASE THEN

        1. 简单CASE函数

            格式
            ```sql
            case 列名
            when   条件值1   then  选项1
            when   条件值2    then  选项2.......
            else     默认值      end
            ```
            示例
            ```sql
            SELECT 
            CASE id
            when 1 then '111'
            when 2 then '222'
            when 3 then '333'
            else id end
            as id
            FROM demo            
            ```
        2. CASE搜索函数

            格式
            ```sql
            case  
            when  列名= 条件值1   then  选项1
            when  列名=条件值2    then  选项2.......
            else    默认值 end
            ```
            示例
            ```sql
            update demo
            set content =
            case 
            when id = 1 then 1
            when id = 2 then 2
            when id = 3 then 3
            else 888 end            
            ```

1. 查询字符串长度（检验中文字符）

    1. length()： 单位是字节，utf8编码下,一个汉字三个字节，一个数字或字母一个字节。gbk编码下,一个汉字两个字节，一个数字或字母一个字节。  
    2. char_length()：单位为字符，不管汉字还是数字或者是字母都算是一个字符。

        ```sql
        SELECT char_length(`name`) FROM `demo` WHERE char_length(`username`) = 2;
        ```

    3. length()<>char_length()，可以用来检验是否含有中文字符。utf-8编码中判定某个字段为全英文，length(字段) = char_length(字段)即可。

        ```sql
        SELECT username FROM demo WHERE char_length(username) != length(username);
        ```

2. 查询重复字段的记录

    ```sql
    select *, COUNT(id) AS count from `zhu_license_queue`  group by `name`  having count>1;


    SELECT a.`name`,
        a.tel,
        a.`create_time`,
        COUNT(a.id) as count,
        b.`gongwei`
    from `zhu_license_queue` a
    LEFT JOIN zhu_c_user b on a.tel= b.tel
    WHERE b.`gongwei` IS NOT NULL
    AND a.`auto_flow_details`= '14、success!'
    GROUP BY a.`name`
    HAVING count> 1
    ORDER BY a.id;
    ```

3. 条件搜索字符串，但是搜索不到

    如

    > $sql =  "SELECT * FROM a WHERE name = $name";  
    > 解析出来结果是（没有加上引号，不被当做字符串）  
    > SELECT * FROM a WHERE name = zhangsan  
    > 我们想要的效果是  
    > SELECT * FROM a WHERE name = 'zhangsan'  

    两种解决方式

    ```php
    // 使用参数
    $sql =  "SELECT * FROM a WHERE name = ?";
    $res = Db::query($sql, [$name]);

    // 加上引号（注意外层是双引号，内层是单引号，不能使用反引号代替单引号）
    $sql =  "SELECT * FROM a WHERE name = '$name'";  
    $res = Db::query($sql);
    ```


4.  mysql查询`!= 1`的条件会失败

    > ifnull(字段名),0)<>1  或者 ifnull(字段名),0) !=1

5.  联表查询字段

    ```sql
    select a.name, b.tel, address from a, b where a.id = b.a_id
    ```

    如果两张表的字段名不一样的话可以不用加表名，如果字段名一样的话必须加表名进行限定

6.  UPDATE语句不能使用AND连接两个SET

    ```sql
    // 错误写法
    UPDATE demo SET `name` = 'zhangsan' AND `age` = 10 WHERE `id` = 1;
    // 正确写法
    UPDATE demo SET `name` = 'zhangsan', `age` = 10 WHERE `id` = 1;
    ```

    错误写法：sql会认为`and`是逻辑与，于是执行就变成了下面这样

    ```sql
    UPDATE demo SET `name` = ('zhangsan' AND `age` = 10) WHERE `id` = 1;
    ```

    其中`('zhangsan' AND `age` = 10)`的结果会被作为`name`字段的更新值

7.  替换字段

    ```sql
    // 将所有姓张的替换成姓李的
    UPDATE demo SET `name` = REPLACE ( `name`, '张', '李'); 
    ```

8.  插入数据的时候根据另一张表的数据

    1. 表的结构一样

        ```sql
        insert into 表1
            select * from 表2
        ```
    2. 表的结构不一样

        ```sql
        insert into 表1 (列名1,列名2,列名3)
            select  列1,列2,列3 from 表2
        ```

    3. 只从另外一张表中取部分字段（最常用）

        ```sql
        insert into 表1 (列名1,列名2,列名3) 
            values(列1,列2,(select 列3 from 表2));
        ```

9.  `GROUP BY`的使用

    常和聚合函数结合使用

10. 查询在a表不在b表的数据

    ```sql
    select *
    from infolist
    where(
    select count(id) as num
    from namelist
    where infolist.name= namelist.name)= 0;
    ```

11. 使用Navicat连接阿里云ECS服务器上的Mysql数据库

    [参考博客](https://blog.csdn.net/nw_ningwang/article/details/76218997)

12. 将不同表的相同列的数据查询出来

    UNION ALL （会查出重复数据）
    UNION （会自动将数据进行去重）
    ```sql
    SELECT `account` as tel
    FROM zhu_b_user a
    UNION ALL 
    SELECT tel
    FROM `zhu_b_user_account` b
    ORDER BY tel
    LIMIT 0,10
    ```

13. 查询一张表中数据重复的数据（比如，相同数据有6条，查询出5条即是重复多余的，保留id最大的一条），为了删除做准备

    ```sql
    select *
    FROM `zhu_license_queue`
    WHERE tel in(
    SELECT tel
    FROM `zhu_license_queue`
    GROUP BY tel
    HAVING COUNT(tel)> 1)
    AND id not in(
    SELECT MAX(id)
    FROM `zhu_license_queue`
    GROUP BY tel
    HAVING COUNT(tel)> 1)
    ```

14. 按照字段的重复数进行排序

    ```sql
    select source_job_number,count(id) as count from v1_user WHERE source_id=3 group by source_job_number ORDER BY count DESC;
    ```

15. 每条数据应该都有创建时间和修改时间（自动生成）

    ```sql
    create_date datetime DEFAULT CURRENT_TIMESTAMP COMMENT ‘创建时间’,
    update_date datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT ‘修改时间’,
    ```
16. 去除重复的记录

    ```sql
    DELETE demo
    FROM demo,
        (
    SELECT min(id) id, user_id, monetary, consume_time
    FROM demo
    GROUP BY user_id, monetary, consume_time
    HAVING count(*)> 1) t2
    WHERE demo.user_id= t2.user_id
    and demo.monetary= t2.monetary
    and demo.consume_time= t2.consume_time
    AND demo.id> t2.id;
    ```

17. 一个字段like另外一个字段

    ```sql
    c.`settle_order_list` LIKE concat('%', b.`settle_order`, '%')
    ```

18. 字符串类型的数字比较大小

    ```sql
    // 使用`cast`方法，转为浮点型，`deciaml(10, 2)`，代表整数位加小数位10位，精度位2位小数（四舍五入）
    CAST(a.`task_commission` as DECIMAL )  < CAST(b.`quarterly_limit_money` as DECIMAL)

    // 加0，自动转为小数
    select (money + 0) as money from demo
    ```

    注意：不能直接比较，因为会造成逐级比较，如9大于100

19. 类型转换

    1. 使用`CAST(value as type)`

    2. 使用`CONVERT(value, type)`

    但是类型是有限制的，只能是下面几种类型

    1. 二进制，同binary前缀的效果：BINARY
    2. 字符型，可带参数：CHAR()
    3. 日期：DATE
    4. 时间：TIME
    5. 日期时间型：DATETIME
    6. 浮点数：DECIMAL
    7. 整数：SIGNED
    8. 无符号整数：UNSIGNED

20. 写注释的格式

    ```sql
    #DELETE FROM SeatInformation  
    /*DELETE FROM SeatInformation */
    -- DELETE FROM SeatInformation
    ```

21. 获取表的字段类型

    ```sql
    SELECT * FROM `information_schema`.columns WHERE TABLE_NAME = 'zhu_c_user';
    ```

22. 查询最近6个月的月份，本月天数，本月所有天数

    ```sql
    SELECT
        date_format( @cdate := DATE_ADD( @cdate, INTERVAL - 1 MONTH ), '%Y-%m' ) AS days 
    FROM
        ( SELECT @cdate := DATE_ADD( NOW(), INTERVAL + 1 MONTH ) FROM `sys_user` ) t0 
        LIMIT 6;
    ```

    ```sql
    <!-- 查询两个时间段之内的连续时间，这里需要手动算出想差天数，然后用开始时间累加 -->
    SELECT a.id, (@i := DATE_ADD(@i,INTERVAL + 1 day)) as no FROM sys_user a, (SELECT @i := DATE_SUB('2022-04-08',INTERVAL 1 day)) t ORDER BY id DESC LIMIT 30
    ```

    解释：从一张临时表中查询出6条数据，然后将当前的月份存入一个会话变量中，然后查询的时候进行月份递减

    注意：需要确保你要查询的临时表`sys_user`有6条以上的数据

    示例：查询近6个月的收入和支出，如果没有为NULL（如果需要是0的话自行修改）

    ```sql
    SELECT
        total_income,
        total_out,
        days AS MONTH 
    FROM
        (
        SELECT
            date_format( @cdate := DATE_ADD( @cdate, INTERVAL - 1 MONTH ), '%Y-%m' ) AS days 
        FROM
            ( SELECT @cdate := DATE_ADD( NOW(), INTERVAL + 1 MONTH ) FROM `sys_user` ) t0 
            LIMIT 6 
        ) a
        LEFT JOIN (
        SELECT
            SUM( total_income ) AS total_income,
            SUM( total_out ) AS total_out,
            bill_date 
        FROM
            gm_bill_month 
        WHERE
            bill_date BETWEEN DATE_FORMAT( DATE_SUB( NOW(), INTERVAL 5 MONTH ), '%Y-%m' ) 
            AND DATE_FORMAT( NOW(), '%Y-%m' ) 
        GROUP BY
            bill_date 
        ) b ON a.days = b.bill_date;
    ```

    ```sql
    -- 获取本月天数
    select DATEDIFF(date_add(curdate()-day(curdate())+1,interval 1 month ),DATE_ADD(curdate(),interval -day(curdate())+1 day))
    ```

23. 查询条件有则查询，没有则查询全部

    ```sql
    SELECT food_name FROM food_traceability WHERE if (true, food_name = '土豆丝', id is not null);
    ```

24. 查询列表的时候同时查询出total

    ```sql
    SELECT username, total FROM sys_user a LEFT JOIN (SELECT count(id) as total FROM sys_user) b on 1 = 1
    ```

25. mysql limit 动态赋值问题

    ```sql
    SELECT 字段1,字段2 FROM 表1 ORDER BY 字段1 DESC LIMIT (1 - 1) * 1, 1 #错误
    SELECT 字段1,字段2 FROM 表1 ORDER BY 字段1 DESC LIMIT 0, 1 #正常
    ```

    格式：`limit 常量,常量`
    现在没办法动态的

26. 列表查询结果添加序号

    ```sql
    SELECT a.id, (@i := @i + 1) as no FROM sys_user a, (SELECT @i := 0) t ORDER BY id DESC LIMIT 0, 10;
    SELECT a.id, (@i := @i + 1) as no FROM sys_user a, (SELECT @i := 10) t ORDER BY id DESC LIMIT 10, 10;
    ```

27. 保留小数点后两位

    ```sql
    select format(money, 2) as money from demo
    ```

28. 判断一个字段为空字符串或者null

    ```sql
    if(commission_money is null or commission_money = '', '-', commission_money) as '佣金'
    ```

29. 设置数据库支持存储表情、其他字体等字符

    默认的字符集`utf8`是不支持这些字符的，进行更新和插入的时候会报错

    比如：`hitomi👀`、`𝗛𝗲𝗹𝗹𝗼 𝗛𝗼𝘂𝘀𝗲`这些

    原因：UTF-8编码有可能是两个、三个、四个字节。Emoji表情或者某些特殊字符是4个字节，而Mysql的utf8编码最多3个字节，所以数据插不进去。

    解决方案：

        1. 将数据库字符集设置为`utf8mb4`

            > alter database `xxxxx` character set utf8mb4;

        2. 将对应的表字符集设置为`utf8mb4`

        3. 将对应的字段字符集设置为`utf8mb4`

        4. 如果还没有生效的话，尝试重启一下数据库

    附：我这边其实只改了数据库和字段，并且没有重启就生效了

30. Mybatis.xml文件中大于、小于、等于

    这个文件中使用`>=`/`<=`这些符号会报错，需要进行替换

    | 原符号 | 替换符号 |
    | ------ | -------- |
    | <      | &lt;     |
    | <=     | &lt;=    |
    | >      | &gt;     |
    | >=     | &gt;=    |
    | &      | &amp;    |
    | '      | &apos;   |
    | "      | &quot;   |