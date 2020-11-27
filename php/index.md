1. json_encode()和json_decode()的使用

    1. `json_encode()`：将对象或数组编码为字符串，参数必须要是数组或字符串

    2. `json_decode()`：将字符串转化为数组或对象

        关键：  
        
        1. 原先是数组的默认转化为数组，原先是对象的默认转化为对象
        2. 第二个参数默认为false，即按照原先的转化，如果第二个参数为true强行转化为数组

2. 对于对象和数组的访问

    1. 对象：使用`->`进行访问

        > \$obj->name 
        > \$obj->{"姓名"}

    2. 数组：使用`[]`进行访问

        > 数值数组：\$arr[0] = 111;  
        > 关联数组：$arr["name"] = "zhangsan";

3. 理解关联数组

    概念：索引是字符串的数组

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

15. php导出表格长数字会使用科学计数法

    写入数据的时候使用`setCellValueExplicit()`而不是`setCellValue()`

    ```php
    $excel->getActiveSheet()->setCellValue('F' . ($k + 2), $v["bankName"]);
    $excel->getActiveSheet()->setCellValueExplicit('G' . ($k + 2), $v["bankCNAPS"], \PHPExcel_Cell_DataType::TYPE_STRING);
    ```

16. 对于url进行编码和解码

    ```php
    // 编码
    urlencode($url);
    // 解码
    urldecode($url);
    ```

17. 对比两个数组的增减

    ```php
    $a = [1,2,3,4]; // 老的数组
    $b = [3,4,5,6]; // 新的数组
    $c = array_diff($a, $b); // 减少的数组
    $d = array_diff($b, $a); // 增加的数组
    ```

18. phpExcel设置单元格字体样式

    ```php
    $excel->getActiveSheet()->setCellValue('L' . ($k + 2), $v["hasUkey"]);
    $excel->getActiveSheet()->getStyle('L' . ($k + 2))->applyFromArray([
        'font' => [
            'color' => [
                'rgb' => $v["hasUkey"] == 'yes' ? '000000' : 'FF0000'
            ]
        ]
    ]);
    ```

19. php文本实现模板字符串效果

    使用双引号效果，相当于js中的模板字符串，自带换行效果和识别变量

    ```php
    // 这种情况下，第一行会空行，如果不想要第一行空行的话，将从引号开始位置开始
    $text = "
        hello: $hello
        name: $name
    ";
    ```