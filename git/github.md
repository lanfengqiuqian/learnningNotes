<!--
 * @Date: 2020-09-09 10:28:50
 * @LastEditors: Lq
 * @LastEditTime: 2021-05-10 17:56:35
 * @FilePath: /learnningNotes/git/github.md
-->
#### 解决加载页面是样式文件加载过慢

方案：使用`DNS`域名解析加快解析速度  

1. 登录[http://ipaddress.com/](http://ipaddress.com/)网站获取最近的dns网址  

2. 搜索`assets-cdn.github.com`这个加载样式文件的`cdn`地址  

3. 获取到你访问最快的`ip`

4. 修改本地电脑的`hosts`文件，修改方法参考我的这篇[文章](https://blog.csdn.net/qq_43382853/article/details/106264294?ops_request_misc=%257B%2522request%255Fid%2522%253A%2522159961941819724839807442%2522%252C%2522scm%2522%253A%252220140713.130102334.pc%255Fblog.%2522%257D&request_id=159961941819724839807442&biz_id=0&utm_medium=distribute.pc_search_result.none-task-blog-2~blog~first_rank_v2~rank_blog_default-7-106264294.pc_v2_rank_blog_default&utm_term=host&spm=1018.2118.3001.4187)


#### Git/Github/Gitlab/Gitee之间的关系

Git：是一种版本控制系统，一个命令，一种工具，有点像cmd（命令行工具）。  
Github：是基于git实现的在线代码托管的仓库，向互联网开放，企业版要收费。  
Gitlab：类似github的代码托管功能，一般用于在企业内部搭建git私服，需要自己搭建环境。  
Gitee：即码云，是oschina免费给企业使用的，不用自己搭建环境，可以建立自己的私有仓库。  
Git-ce：是社区版，gitlab-ee是企业版，收费的。

适用场景

主要使用Github和Gitee，其中Github在国外，访问比较慢，Gitee在国内，访问比较快。