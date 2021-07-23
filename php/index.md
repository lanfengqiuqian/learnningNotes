1. json_encode()和json_decode()的使用

    1. `json_encode()`：将对象或数组编码为字符串，参数必须要是数组或字符串

    2. `json_decode()`：将字符串转化为数组或对象

        关键：  
        
        1. 原先是数组的默认转化为数组，原先是对象的默认转化为对象
        2. 第二个参数默认为false，即按照原先的转化，如果第二个参数为true强行转化为数组

    3. thinkphp中的`json()`方法：返回值是一个对象

2. 对于对象和数组的访问

    1. 对象：使用`->`进行访问

        > \$obj->name 
        > \$obj->{"姓名"}

    2. 数组：使用`[]`进行访问

        > 数值数组：\$arr[0] = 111;  
        > 关联数组：$arr["name"] = "zhangsan";

3. 理解关联数组

    概念：索引是字符串的数组（如果索引是0到n的数字就是索引数组）

    特点：像对象，但是本质是数组

    ```php
    // 创建
    $arr = array(
        "name" => "zhangsan",
        "age" => 12
    );
    // 访问和取值
    $arr["gender"] = "male";
    // 遍历
    foreach($arr as $key => $value) {
        echo "key:" . $key . "value" . "$value";
    }
    // 转化为索引数组
    $indexArr = array_values($arr);
    ```

4. 对象和数组的转化（这里的数组一般指关联数组）

    1. 使用`json_encode()`和`json_decode()`方法

        这里只能够将对象转为数组

        > json_decode(json_encode($obj), true);

    2. 手写foreach循环转换

        这里是将数组转为对象

        ```php
        protected function arrayTransitionObject(Array $array) 
        {
            if (is_array($array)) {
                // 创建一个空对象
                $obj = new class{};
                foreach ($array as $key => $val) {
                    $obj->$key = $val;
                }
            } else {
                $obj = $array;
            }
            return $obj;
        }
        ```

    3. 强制类型转换（最方便）

        > \$obj = (object)\$arr;  
        > \$arr = (array)\$obj;

    4. 进行深层次的转换

        ```php
        /**
        * 对象转数组
        * @param $obj
        * @return array
        */
        function objectToArray($obj)
        {
            $arr = is_object($obj) ? get_object_vars($obj) : $obj;
            if (is_array($arr)) {
                return array_map(__FUNCTION__, $arr);
            } else {
                return $arr;
            }
        }

        /**
        * 数组转对象
        * @param $arr
        * @return object
        */
        function arrayToObject($arr)
        {
            if (is_array($arr)) {
                return (object)array_map(__FUNCTION__, $arr);
            } else {
                return $arr;
            }
        }
        ```


5. 创建对象时，类名前加`\`

    有时候在实例化类的时候，会报一个错：`Class 'app\api\controller\stdClass' not found`

    > $obj = new stdClass();

    意思是当前命名空间没有这个类

    解决方案：在类名前加`\`，表示如果当前命名空间没有这个类，则到全局中去查找

    > $obj = new \stdClass();

    常见场景：常见于引入第三方类（如引入钉钉加解密类）

    > $d = new \DingtalkCrypt();

6. 创建一个空对象几种方法

    > \$obj = new \stdClass();  
    > \$obj = new class{};  
    > \$obj = (object)array();  
    > \$obj = (object)[];

7. 强制类型转换几种方式

    ```php
    // 第一种方式 (int)  (bool)  (float)  (string)  (array) (object)
    $num1=3.14;   
    $num2=(int)$num1;   

    // 第二种方式 intval()  floatval()  strval()
    $str="123.9abc";   
    $int=intval($str);

    // 第三种方式 settype()
    $num4=12.8;   
    $flg=settype($num4,"int");   
    ```

8. `::`和`->`访问的区别

    简单描述：`::`用于类名调用（用于静态语境，static），`->`用于实例对象调用（用于动态语境）

    ```php
    class () {
        public static function run($a) {
            return $a;
        }

        public function test() {
            echo "hello";
        }
    }
    $car = new Car();
    $a = Math::run(111);
    $car->test();
    ```

9. 魔术常量

    ```php
    echo '这是第 " '  . __LINE__ . ' " 行'. "<br>";
    echo '该文件位于 " '  . __FILE__ . ' " '. "<br>";
    echo '该文件位于 " '  . __DIR__ . ' " '. "<br>";
    echo  '函数名为：' . __FUNCTION__ . "<br>";
    echo '类名为：'  . __CLASS__ . "<br>";
    echo  '函数名为：' . __METHOD__ . "<br>";
    echo '命名空间为："', __NAMESPACE__, '"'. "<br>";
    ```

10. 获取服务器ip，域名

    ```php
    // 服务器IP地址  
    $_SERVER['SERVER_ADDR']

    // 服务器域名    
    $_SERVER['SERVER_NAME'] 
    ```

    更多相关查看[这篇](https://www.cnblogs.com/yangzailu/archive/2019/10/30/11752492.html)文章

    
11. tp6中调用另外一个文件中的类的方法

    ```php
    // 创建类实例
    $phpToExcel = new PhpToExcel($this->app);
    // 进行实例调用
    $phpToExcel->demo();
    ```

12. foreach循环关联数组的数组，为其添加一个键值对

    不能直接给循环出来的关联数组添加键值对，需要从最外层的数组进行访问添加

    ```php
        foreach($data as $key => $value) {
            // 正确形式
            $data[$key]["order_number"] = $key + 1;
            // 错误形式
            // $value["order_number"] = $key + 1;
        }
    ```

13. 使用curl调用，$_REQUEST接收不到参数

    ```php
    // 数据
    $data = [
        'serialNumber' => $serial_number,
        'demo' => 'hello',
    ];

    // 方案1
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_URL, "$baseHost/startExamineForInvoice");
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; curlarset=utf-8',
        'Content-Length: ' . strlen(json_encode($data))
    ));
    $html = curl_exec($curl);
    $res = json_decode($html);
    curl_close($curl);

    // 方案2
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$baseHost/startExamineForInvoice");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    // POST数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // 把post的变量加上
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);
    curl_close($ch);

    // 接收
    public function startExamineForInvoice($demo = "22") {
        // 开票流水号
        $serialNumber = isset($_REQUEST['serialNumber']) ? $_REQUEST['serialNumber'] : '';
    }
    ```

    方案1中：能够接收到demo，但是无法接收到serialNumber

    但是方案2中两个都能够接收到

    `猜测`：和`CURLOPT_HTTPHEADER`属性有关

    可以参考这篇[博客](https://blog.csdn.net/youcijibi/article/details/103818812)

14. 比较时间先后

    strtotime()：将时间转换为unix时间戳
    > strtotime(\$time1) > strtotime(\$time2)

15. 对于url进行编码和解码

    ```php
    // 编码
    urlencode($url);
    // 解码
    urldecode($url);
    ```

16. 对比两个数组的增减

    ```php
    $a = [1,2,3,4]; // 老的数组
    $b = [3,4,5,6]; // 新的数组
    $c = array_diff($a, $b); // 减少的数组
    $d = array_diff($b, $a); // 增加的数组
    ```

17. php文本实现模板字符串效果

    使用双引号效果，相当于js中的模板字符串，自带换行效果和识别变量

    ```php
    // 这种情况下，第一行会空行，如果不想要第一行空行的话，将从引号开始位置开始
    $text = "
        hello: $hello
        name: $name
    ";
    ```

18. phpExcel常用属性

    前提：常用的需要实例化的几种实例

    ```php
    $area = 'A1'; // 需要操作的单元格，也可以是一个范围，如$area = 'A1:L10';
    
    $excel = new \PHPExcel();　　//实例化一个PHPExcel变量

    $excel->setActiveSheetIndex(0);　　//设置要操作的Sheet页

    $excelActSheet = $excel->getActiveSheet();　　//获取当前要操作的Sheet页

    $excelStyle = $excelActSheet->getStyle($area);　　//获取要设置单元格的样式

    $excelAlign = $excelStyle->getAlignment();　　//用来设置对齐属性和单元格内文本换行的一个变量

    $excelFont = $excelStyle->getFont();　　//获得字体属性
    ```

    1. 长数字会使用科学计数法

        写入数据的时候使用`setCellValueExplicit()`而不是`setCellValue()`

        ```php
        $excel->getActiveSheet()->setCellValue($area, $v["bankName"]);
        $excel->getActiveSheet()->setCellValueExplicit($area, $v["bankCNAPS"], \PHPExcel_Cell_DataType::TYPE_STRING);
        ```


    2. 设置单元格字体样式

        ```php
        $excel->getActiveSheet()->setCellValue($area, $v["hasUkey"]);
        $excel->getActiveSheet()->getStyle($area)->applyFromArray([
            'font' => [
                'color' => [
                    'rgb' => $v["hasUkey"] == 'yes' ? '000000' : 'FF0000'
                ]
            ]
        ]);

        // 设置字体
        $excelFont->setName('微软雅黑');
        // 设置字号
        $excelFont->setSize(11);
        // 设置加粗
        $excelBold(false);
        // 设置颜色
        $excelFont->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
        ```

        说明

          1.  其颜色组成为：Alpha（透明度）通道+RGB色彩模式  
          2.  ARGB---Alpha,Red,Green,Blu  
          3.  一般我自己用的值都是"FF"+RGB的颜色值，如："FFCC15DD"  

    3. 设置行高和自动换行

        ```php
        // 范围
        $area = 'A1:L10';
        // 设置行高（某一行）
        $excel->getActiveSheet()->getRowDimension(A)->setRowHeight(30); 
        // 设置自动换行（单元格内换行）
        $excel->getActiveSheet()->getStyle($area)->getAlignment()->setWrapText(true);
        ```

    4. 对齐方式

        1. 水平对齐

        ```php
        //设置单元格内容水平对齐
        $excelAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        ```

        |值|含义|
        |-|-|
        |HORIZONTAL_LEFT|左对齐|
        |HORIZONTAL_CENTER|居中对齐|
        |HORIZONTAL_RIGHT|右对齐|

       1. 垂直对齐

        ```php
        //设置单元格内容水平对齐
        $excelAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        ```

        |值|含义|
        |-|-|
        |VERTICAL_TOP|顶部对齐|
        |VERTICAL_CENTER|竖直居中对齐|
        |VERTICAL_BOTTOM|底部对齐|

    5. 合并单元格

        可以进行行合并，也可以列合并

        ```php
        $excel->getActiveSheet()->mergeCells('B1:B2');
        $excel->getActiveSheet()->mergeCells('C1:H1');
        ```

    `传送门`:

    可以参考这篇[文章](http://www.voidcn.com/article/p-geyhgkkf-bss.html)  
    也可以参考这篇[文章](https://www.cnblogs.com/lglblogadd/p/7117486.html)

19. 数组置为空值和去数组空值

    ```php
    $arr = [1,2,3,4];
    // 置为空值
    $arr[0] = null;
    // 去空值
    $newArr = array_filter($arr);
    ```

20. 判断某一个字符是否存在，字符串替换

    ```php
    // 判断是否存在
    echo strstr("Hello world!","world");  // 输出 world!
    // 替换（区分大小写）
    str_replace('Hel', 'hhh', "hello world");
    // 替换（不区分大小写）
    str_ireplace('Hel', 'hhh', "hello world");
    ```

21. 判断一个元素是否在一个数组中

    > array_in(1, [1,2,3]);

    这里有一个坑，就是进行数字和字符串比较的时候，会将字符串转化为数字进行比较

    如下

    ```php
    $arr = [1,2,3,4];
    $num = '3';
    $arr1 = ['1','2','3'];
    $num1 = 3;
    $is_exist = in_array($num, $arr); // true
    $is_exist1 = in_array($num1, $arr1); // true
    ```

22. 数组和字符串转化

    ```php
    // 数组转字符转
    $array = array('lastname', 'email', 'phone');
    $comma_separated = implode(",", $array);

    // 字符串转数组
    $pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
    $pieces = explode(" ", $pizza);
    ```

23. 函数内部访问外部变量

    1. 外部用`global`关键字定义，内部用`$GLOBALS`数组引用

        ```php
        global $mytext;
        $mytext="外部使用global定义";
        function test(){
            echo $GLOBALS['mytext']."<br>";
        }
        test();
        ```

    2. 内部用`global`定义，直接访问或者使用`$GLOBALS`数组访问都行

        ```php
        $mytext="内部使用global定义";
        function test(){
            global $mytext;
            echo $GLOBALS['mytext']."<br>";
            echo $mytext."<br>";
        }
        test();
        ```

        这种方式我在在线网页运行没问题，但是在接口方法里面失效了

    3. 通过函数传参的方式传递进去

        ```php
        function test($a) {
            echo $a;
            $a ++;
        }
        $b = 1;
        echo $b;
        test($b);
        echo $b;
        ```

        要注意一下就是值传递和引用传递的区别

24. 重复调用接口

    ```php
    public function checkSqlBugDemo() {
        // 检查是否重复执行
        $sql = "SELECT id FROM demo WHERE id = 26 AND account_id = 333";
        $res = Db::query($sql);
        // 如果重复执行则返回
        if(empty($res)) {
            return 'fail';
        }
        /**
         * 中间执行操作
         */
        // 将重复执行标志改变用于判断
        $sql = "UPDATE demo SET account_id = 444 WHERE id = 26";
        $res = Db::execute($sql);
        return 'success';
    }
    ```

25. 获取时间戳

    ```php
    // 获取秒级时间戳
    $time = time();
    
    // 获取毫秒时间戳
    $time = explode ( " ", microtime () );
    $time = $time[1] . ($time[0] * 1000);
    $time2 = explode( ".", $time );
    $time = $time2[0];
    ```

26. 将网络图片url地址下载到服务器上

    入参：网络图片链接
    出参：服务器图片链接
    前提：你需要有权限访问该图片，比如宜搭的图片，是需要用户登录过网页宜搭并有相应权限才能够预览和下载，否则只会是一个空文件

    ```php
    public function getgPullImage($url = "") {
        $save_path = "/www/wwwroot/test-invoice.zhushang.net/lqtest/";	# 图片保存的地址 对于自己保存图片的地址
        $file_name = time().mt_rand(1000,9999).'.png';	# 截取网络图片的名称，用做保存的图片名称 可根据自己需求自己修改
        # 远程文件处理 
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);  # 过期时间
        //当请求https的数据时，会要求证书，加上下面这两个参数，规避ssl的证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $img = curl_exec($ch);
        curl_close($ch);
        $size=strlen($img);   # 文件大小
        # 如果目录不存在，创建要保存的目录
        if(!file_exists($save_path )){
            mkdir($save_path ,0777,true);
        }
        $fp2 = @fopen($save_path .$file_name ,'a');
        fwrite($fp2,$img);
        fclose($fp2);
        unset($img,$url);
        return json("test-invoice.zhushang.net/lqtest/".$file_name);
    }
    ```

27. 去除反斜杠

    场景：接受的json字符串汇总，使用的反斜杠进行转义，如果直接使用`json_decode()`是不行的，结果还是个`null`，需要先去除反斜杠

    `stripslashes($str)`


28. 使用正则匹配获取字符串

    使用场景：评论中修改打款账号格式为`修改打款账号：（123456789012）`，账号长度固定12位

    ```php
    $comments = "部长：修改打款账号：（123456789012），请您验收！";
    if (preg_match('/[修改打款账号：\（]+[\d{12}]+[\）]/', $comments, $commentsAccount)) {
        $account = preg_match('/\d{12}/', $commentsAccount[0], $accountArr);
        $account = $accountArr[0];
    }
    ```

    这里有一个需要注意的地方：有可能会出现编码错误，具体表现为出现`�`这个符号（php环境会有这个问题，但是js环境就没有这个问题）

    > 输出结果类似下面：
    > 修改打款账号：（123456789123� 

    我的解决方案：将`/[修改打款账号：\（]+[\d{12}]+[\）]/`换成`/[修改打款账号：\（+[\d{12}]+[\）]/`，去掉了一个中括号，然后成功了。。。具体原因没找出来


29. 字符串编码

    ```php
    // 获取当前字符串编码
    $encode = mb_detect_encoding($str, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5')); 

    // 将gbk换为utf-8
    $str_encode = mb_convert_encoding($str, 'UTF-8', 'GBK');
    ```

    如果一个字符串输出出来是utf-8，但是使用json_encode()报编码错误的话，可以尝试将他转换为其他编码再转换回来

    ```php
    $newStr = mb_convert_encoding($str, 'GBK', 'UTF-8');
    $str = mb_convert_encoding($newStr, 'UTF-8', 'GBK');
    ```

    将数组中的元素进行转码

    ```php
    //更改编码为utf8
    protected function array2utf8($array){
        $array = array_map(function($value){
            if(is_array($value)){
                return $this->array2utf8($value);
            }else{
                return mb_convert_encoding($value, "UTF-8", "GB2312");
            }
        }, $array);
        return $array;
    }  
    ```

    解决数据库中查询出来的字段报编码问题：`Malformed UTF-8 characters, possibly incorrectly encoded`

    有可能是数据库中部分字段编码有问题

    ```php
    // 先将数据库数据转成GBK，再转成UTF-8
    $friend['name']=iconv("utf-8","gbk//IGNORE",$friend['name']);
    $friend['name'] = mb_convert_encoding($friend['name'],'UTF-8','GBK');
    ```

30. 格式化时间

```php
/**
 * 计算近一周或近一个月的开始时间戳和结束时间戳
 * @param $type 1表示今天，2表示近一周，3表示近一个月
 * @return array
 */
function nearFormatTime($type){
  $start_time = strtotime(date('Y-m-d 00:00:00'));//今天0点的时间戳
  $end_time = $start_time + 86399;//今天23:59的时间戳
  $res = array('start_time'=>0,'end_time'=>$end_time);
  if($type == 1){
    //今天
    $res['start_time'] = $start_time;
  }else if($type == 2){
    //近一周
    $res['start_time'] = $start_time - 86400*6;//包括今天,共七天
  }else if($type == 3){
    //近一个月
    $res['start_time'] = $start_time - 86400*30;//包括今天,共31天
  }
  return $res;
}

/**
 * 将中文的日期格式化为正常的日期
 * @param $date
 * @return mixed
 */
function formatCnDateToDate($date){
  //把年月替换为-，日替换为空
  $date = str_replace('年','-',$date);
  $date = str_replace('月','-',$date);
  $date = str_replace('日','',$date);
  //避免提交的格式不统一，例如2018-3-2等，标准化
  return date('Y-m-d',strtotime($date));
}
```

31. 运行composer出现`do not run Composer as root/super user!`

    说明：不能使用`root`用户运行`composer`命令，重新创建一个用户就行
    > useradd test  
    > passwd test
    国内镜像http://packagist.phpcomposer.com不能进行访问，国外镜像访问速度也很慢

    使用 Composer 镜像加速（选择一个就行）
    
    > composer config -g repo.packagist composer https://packagist.laravel-china.org  
    > composer config -g repo.packagist composer https://packagist.phpcomposer.com

32. 生成固定长度的随机数

    ```php
    function generate_code($length = 4) {
        return rand(pow(10,($length-1)), pow(10,$length)-1);
    }
    ```

33. 跳出和终止循环

    > 跳出本次循环：continue  
    > 终止循环：break