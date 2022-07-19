<!--
 * @Date: 2020-08-19 19:05:10
 * @LastEditors: Lq
 * @LastEditTime: 2022-07-14 19:27:46
 * @FilePath: \learnningNotes\git\index.md
-->
1. 查看所有分支  
    仅本地分支： `git branch`  
    本地及远程分支：`git branch -a` （其中远程分支会使用红色标记）
2. 新建一个分支  
    `git branch 分支名称`
3. 创建并切换某一个分支  
    `git checkout -b 分支名称`  
    仅切换分支：`git checkout 分支名称`
4. 重命名某一个分支  
    `git branch (-m | -M) <oldbranch> <newbranch>`
5. 删除某一个分支  
    `git branch -d 分支名称`
6. 强制删除某一个分支  
    `git branch -D 分支名称`
7. 查看远程仓库地址  
    `git remote -v`
8. 查看全局配置  
    `git config -l`
9.  全局配置文件位置  
    `.git/config`
10. 配置用户名和邮箱  
    `git config --global user.name "John Doe"`
    `git config --global user.email johndoe@example.com`
11. 查看提交日志（获取hash码）  
    `git log`
12. 回到之前某一次提交  
    `git reset --hard 上一次提交的hash码`
13. 回到上一次提交  
    `git reset --hard HEAD^`
14. 回到n次之前提交  
    `git reset --hard HEAD^n`
15. 撤回`git add`的提交  
    `git reset 文件名`
16. 克隆大文件  
    `git clone --depth=1 http://xxx/mp.git`
17. 关联远程仓库  
    `git remote add origin git@github.com:lenve/test.git`
18. 删除关联的远程仓库，一般情况下是origin，如果不是需要换  
    `git remote rm origin`
19. 查看某个文件或某行代码最近一次改变是谁写的    
    `git blame file_name`  
    `git blame -L 58,100 file_name`  # 58~100 行代码  
    输出格式：  
    `commit_ID | 代码提交作者 | 提交时间 | 代码位于文件中的行数 | 实际代码 `  
    例子  
    `2eb3a3b3 (zhangsan 2020-11-10 14:14:05 +0800 179)   $default_addr = "";`
20. 根据commitid查看对应的提交记录  
    `git show commit_ID`
21. 合并分支  
    `git merge 分支名称`
22. 查看当前项目配置文件  
    `git config -e`  
    `vi ./.git/config`
23. 查看没有`add`的文件，已经`add`的和`commit`的不会记录在这
    `git diff`
24. 强制提交到远程仓库(非特殊情况不使用，会将远程仓库的修改记录覆盖为你本地的)
    `git push -u origin master -f`
25. 初始化子模块仓库
    `git submodule update --init --recursive`
26. 浅拉取最后一次提交记录，用户clone项目体积很大的代码
    `git clone -b 分支名 --depth=1 仓库路径`
27. GIT_TRACE_PACKET=1、GIT_TRACE=1、GIT_CURL_VERBOSE=1等参数设置可以打印调试信息
28. 生成ssh的公钥和私钥
    `ssh-keygen -t rsa -C your@example.com -b 4096`
29. The following untracked working tree files would be overwritten by merge

    解决`以下未跟踪的工作树文件将被合并覆盖`

    原因：本地有(gitignore)忽略的文件和分支上也有这个忽略文件 要拉取下来的，起了冲突

    解决办法：清除本地文件，然后拉取分支上的

    ```bash
    git clean -n
    // 是一次 clean 的演习, 告诉你哪些文件会被删除，不会真的删除
    
    git clean -f
    // 删除当前目录下所有没有 track 过的文件
    // 不会删除 .gitignore 文件里面指定的文件夹和文件, 不管这些文件有没有被 track 过
    
    git clean -f <path>
    // 删除指定路径下的没有被 track 过的文件
    
    git clean -df
    
    // 删除当前目录下没有被 track 过的文件和文件夹
    
    git clean -xf
    
    // 删除当前目录下所有没有 track 过的文件.
    // 不管是否是 .gitignore 文件里面指定的文件夹和文件
    
    git clean 
    // 对于刚编译过的项目也非常有用
    // 如, 他能轻易删除掉编译后生成的 .o 和 .exe 等文件`在这里插入代码片`. 这个在打包要发布一个 release 的时候非常有用
    
    git reset --hard
    git clean -df
    git status
    // 运行后, 工作目录和缓存区回到最近一次 commit 时候一摸一样的状态。
    // 此时建议运行 git status，会告诉你这是一个干净的工作目录, 又是一个新的开始了！
    ```

30. 连接git仓库失败

    > fatal: unable to access 'https://github.com/xxxx/xxx.git/': Failed to connect to 127.0.0.1 port 7891: Connection refused

    原因是git代理失效了，将代理取消即可

    ```shell
    git config --global --unset http.proxy
    git config --global --unset https.proxy
    ```

31. git限制上传大文件（超过25MB）

    > https://www.jianshu.com/p/1071b11a94b4

    1. 仓库`branch`旁边有一个`tag`，点进去
    2. 创建一个`releases`
    3. 然后再上传文件的窗口添加文件即可
    4. 最后点击发布
    5. 之后就能在`releases`的界面看到你的文件了

32. 开启和取消git代理

    开启代理：这里的`7890`是代理`http`的端口号

    ```shell
    git config --global http.proxy http://127.0.0.1:7890
    git config --global https.proxy http://127.0.0.1:7890
    ```

    取消代理

    ```shell
    git config --global --unset http.proxy
    git config --global --unset https.proxy
    ```