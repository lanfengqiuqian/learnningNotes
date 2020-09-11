<!--
 * @Date: 2020-09-09 10:28:50
 * @LastEditors: Lq
 * @LastEditTime: 2020-09-09 10:44:24
 * @FilePath: /learnningNotes/git/github.md
-->
#### 解决加载页面是样式文件加载过慢

方案：使用`DNS`域名解析加快解析速度  

1. 登录[http://ipaddress.com/](http://ipaddress.com/)网站获取最近的dns网址  

2. 搜索`assets-cdn.github.com`这个加载样式文件的`cdn`地址  

3. 获取到你访问最快的`ip`

4. 修改本地电脑的`hosts`文件，修改方法参考我的这篇[文章](https://blog.csdn.net/qq_43382853/article/details/106264294?ops_request_misc=%257B%2522request%255Fid%2522%253A%2522159961941819724839807442%2522%252C%2522scm%2522%253A%252220140713.130102334.pc%255Fblog.%2522%257D&request_id=159961941819724839807442&biz_id=0&utm_medium=distribute.pc_search_result.none-task-blog-2~blog~first_rank_v2~rank_blog_default-7-106264294.pc_v2_rank_blog_default&utm_term=host&spm=1018.2118.3001.4187)