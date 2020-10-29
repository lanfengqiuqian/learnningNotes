<!--
 * @Date: 2020-08-19 19:08:33
 * @LastEditors: Lq
 * @LastEditTime: 2020-10-29 12:13:36
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

6. IFNULL和ISNULL

    1. 如果a字段不是null，则查询a字段，否则查询b字段

        ```sql
        SELECT id, tel, ifnull(`content`, `content2` )  FROM  `demo` WHERE id = 832
        ```

    2. 如果一个字段有值，则不更新，否则更新

        ```sql
        UPDATE `demo` set `account_id` = ifnull(`account_id`, 999) WHERE id = 833
        ```

7. 查询字符串长度（检验中文字符）

    1. length()： 单位是字节，utf8编码下,一个汉字三个字节，一个数字或字母一个字节。gbk编码下,一个汉字两个字节，一个数字或字母一个字节。  
    2. char_length()：单位为字符，不管汉字还是数字或者是字母都算是一个字符。

        ```sql
        SELECT char_length(`name`) FROM `demo` WHERE char_length(`username`) = 2;
        ```

    3. length()<>char_length()，可以用来检验是否含有中文字符。utf-8编码中判定某个字段为全英文，length(字段) = char_length(字段)即可。

        ```sql
        SELECT username FROM demo WHERE char_length(username) != length(username);
        ```

7. 查询重复字段的记录

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