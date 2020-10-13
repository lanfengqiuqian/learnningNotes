1. 查看php装了哪些扩展

    > // 前提是php命令已经配置到环境变量中  
    > php -m   
    > // 注意php安装位置和版本
    > /www/server/php/72/bin/php -m |grep -i mcrypt  