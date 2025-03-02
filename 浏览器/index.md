### 清除1个网站的缓存

开发者工具，network直接勾选上`disable cache`，然后刷新就会自动清除

多个网站的话还是需要在设置中操作

### 解决浏览器自动填充账号密码问题

<https://blog.csdn.net/qq_65642052/article/details/138075875?utm_medium=distribute.pc_relevant.none-task-blog-2~default~baidujs_baidulandingword~default-0-138075875-blog-125478556.235^v43^control&spm=1001.2101.3001.4242.1&utm_relevant_index=3>

原因：是浏览器的机制

检查代码发现输入框并没有设置默认内容，而且也没有主动给输入框赋值的相关处理代码，并且发现这种自动填充内容现象第一个输入框每次填充的都是当前账号前几位（验证码有输入限制处理只能是4位），每次也只是填充2个输入框，于是合理推论：由于在登录页面输完账号和密码登录后浏览器有时会自动弹出是否记住密码弹窗，然后用户点击记住后，账号密码就会被浏览器缓冲起来，下次再进入同域名网站中，只要遇到页面中第1个输入框是text类型，第2个输入框是password类型，就会触发浏览器的自动填充账号密码功能。但在修改支付密码页面是禁止填充的，下图是项目中问题分析图、谷歌浏览器自动填充功能设置页面。

解决方案：

方案1：禁止浏览器表单自动填充

普通文本框添加 `autocomplete="off"`，密码输入框添加 `autocomplete="new-password"`

```html
<input type="text" autocomplete="off" name="userName"/>
 
<input type="password" autocomplete="new-password" name="password"/>
```

方案2：改变表单结构

不要采取`1个输入框是text类型，第2个输入框是password类型`的结构