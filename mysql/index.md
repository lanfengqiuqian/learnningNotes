<!--
 * @Date: 2020-08-19 19:08:33
 * @LastEditors: Lq
 * @LastEditTime: 2020-08-31 14:38:35
 * @FilePath: /learnningNotes/mysql/index.md
-->
进行左连接时，就有涉及到主表、辅表，这时主表条件写在WHERE之后，辅表条件写在ON后面！！！
主表决定了数据条数，辅表决定了拼接的内容是null还是有数据。

#### 查询并替换包含某一部分内容的字段，并替换相应内容
```sql
UPDATE 
  "你的表名" 
SET 
  "字段名" = REPLACE("字段名", '原内容', '要替换的内容') 
WHERE 
  "字段名" LIKE CONCAT('%', '原内容', '%')
```
