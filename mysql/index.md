<!--
 * @Date: 2020-08-19 19:08:33
 * @LastEditors: Lq
 * @LastEditTime: 2021-05-27 10:54:11
 * @FilePath: /learnningNotes/mysql/index.md
-->
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