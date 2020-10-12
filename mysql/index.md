<!--
 * @Date: 2020-08-19 19:08:33
 * @LastEditors: Lq
 * @LastEditTime: 2020-10-12 19:05:53
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

2. 在某一个字段的基础上进行算术运算

    > update money_user_bank set account_money=account_money-100 where id=1