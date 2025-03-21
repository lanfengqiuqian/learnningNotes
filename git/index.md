<!--
 * @Date: 2020-08-19 19:05:10
 * @LastEditors: Lq
 * @LastEditTime: 2022-08-08 18:04:43
 * @FilePath: \learnningNotes\git\index.md
-->

1. 查看所有分支  
   仅本地分支： `git branch`  
   仅远程分支： `git branch -r`  
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
9. 全局配置文件位置  
   `.git/config`
10. 配置用户名和邮箱  
    `git config --global user.name "John Doe"`
    `git config --global user.email johndoe@example.com`
11. 查看提交日志（获取 hash 码）  
    `git log`
12. 回到之前某一次提交  
    `git reset --hard 上一次提交的hash码`
    ```
    // git reset 参数
    --mixed 默认，重置暂存区的文件（和上一次保持一致），工作区内容保持不变
    --sort 用于回退到某个版本
    --hard 撤销工作区所有未提交的修改内容，将暂存区和工作区都都回退到某个版本，并删除之前的所有信息提交（这是很危险的参数，会把回退点之前的信息都删除）
    ```
13. 回到上一次提交  
    `git reset --hard HEAD^`
14. 回到 n 次之前提交  
    `git reset --hard HEAD^n`
15. 撤回`git add`的提交  
    `git reset 文件名`  
    `git reset .` 撤回所有暂存区的更改
16. 克隆大文件  
    `git clone --depth=1 http://xxx/mp.git`
17. 关联远程仓库  
    `git remote add origin git@github.com:lenve/test.git`
18. 删除关联的远程仓库，一般情况下是 origin，如果不是需要换  
    `git remote rm origin`
19. 查看某个文件或某行代码最近一次改变是谁写的  
    `git blame file_name`  
    `git blame -L 58,100 file_name` # 58~100 行代码  
    输出格式：  
    `commit_ID | 代码提交作者 | 提交时间 | 代码位于文件中的行数 | 实际代码 `  
    例子  
    `2eb3a3b3 (zhangsan 2020-11-10 14:14:05 +0800 179)   $default_addr = "";`
20. 根据 commitid 查看对应的提交记录  
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
    `git push -f origin master`
25. 初始化子模块仓库
    `git submodule update --init --recursive`
26. 浅拉取最后一次提交记录，用户 clone 项目体积很大的代码
    `git clone -b 分支名 --depth=1 仓库路径`
27. GIT_TRACE_PACKET=1、GIT_TRACE=1、GIT_CURL_VERBOSE=1 等参数设置可以打印调试信息
28. 生成 ssh 的公钥和私钥
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

30. 连接 git 仓库失败

    > fatal: unable to access 'https://github.com/xxxx/xxx.git/': Failed to connect to 127.0.0.1 port 7891: Connection refused

    原因是 git 代理失效了，将代理取消即可

    ```shell
    git config --global --unset http.proxy
    git config --global --unset https.proxy
    ```

31. git 限制上传大文件（超过 25MB）

    > https://www.jianshu.com/p/1071b11a94b4

    1. 仓库`branch`旁边有一个`tag`，点进去
    2. 创建一个`releases`
    3. 然后再上传文件的窗口添加文件即可
    4. 最后点击发布
    5. 之后就能在`releases`的界面看到你的文件了

32. 开启和取消 git 代理

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

33. 文件被忽略，但是不在 gitignore 中

vscode 中表现：文件名是灰色的（git 没有发现他改变）

git 中表现：`git add .`没有任何内容，`git status`也没有改变

解决方案：使用`-f`参数手动添加被`ignored`忽略的文件

    > git add xxx -f

34. 常见的 git 工作流

    > https://www.jianshu.com/p/7eba1f0b5b42

35. git bash 箭头无效

    1. 使用数字进行选择
    2. 使用其他终端

36. git rm -r --cached .把暂存区全清了之后挽救

    `git reset HEAD `保存工作区修改，并回到上一次提交状态

37. 忽略文件

    `gitignore`：整个仓库的文件忽略，对于本地远程都生效

    `.git/info/exclude`：只对于本地的仓库代码生效

    注意：这两种方式都只适用于新创建的文件，如果文件已经被纳入了版本管理中，那么修改是无效的

38. git 提交规范（前缀）

    ```
    feat: 新功能（feature）
    fix: 修补bug
    docs: 文档（documentation）
    style: 格式（不影响代码运行的变动）
    refactor: 重构（即不是新增功能，也不是修改bug的代码变动）
    chore: 构建过程或辅助工具的变动
    revert: 撤销，版本回退
    perf: 性能优化
    test：测试
    improvement: 改进
    build: 打包
    ci: 持续集成
    ```

39. 分支名规范和对应的环境

    分支名

    1. sprint 分支：当开发产品新功能或者试验新功能时，从 master 创建一个新的 sprint 分支
    2. develop 分支：汇总开发这完成的工作成果
    3. hotfix 分支：当 master 分支产品出现需要立即修复的 bug 时，从 master 创建一个新的 hostfix 分支，修复完成合并到 master，然后删除 hotfix 分支
    4. feature 分支：开发公用方法、组件等模块
    5. master 分支：存储功能已开发完成的工作分支

    环境

    1. dev：开发调试使用，本地开发完成部署的环境
    2. test：开发自测完成，提交给测试部署的测试环境
    3. stg：预生产环境，导入生产环境数据进行产品和业务的验收测试
    4. uat：用户验收测试环境
    5. pre：灰度测试环境，生产数据，影响的是生产环境，不过范围比较小
    6. prod：线上真实环境

40. release 和 tag 的区别

    1. tag：是 git 的功能，用于给一次 commit 进行标识，以识别特定的版本，一般用于给版本标识
    2. release：是 github、码云等代码托管平台的功能，可以在 tag 的基础上添加编译好的二进制文件，如.deb、.ext 等，方便用户下载，也方便以后查找特定版本的程序

41. local 和 remote 分支名不同，如何 push

    问题：当不同的时候报如下错误

    > src refspec 分支名 does not match any

    原因：默认情况下，需要 local 和 remote 分支名相同才能 push

    解决方案：

    1. 本地新建一个新的分支，和远程分支名相同，然后 push

    2. 强制指定分支名

       > git push -u origin local_branch_name:romote_branch_name

    3. 修改默认配置文件

       详见[https://segmentfault.com/a/1190000002783245](https://segmentfault.com/a/1190000002783245)

42. 远程新建了分支，本地看不到

    拉取分支，远程被删除的分支不会同步删除本地 origin 的分支

    1. git fetch

       如果只想更新指定分支`git fetch origin xxx`

    必须带有–prune，否则跟 git fetch 等价。除了会拉取新分支，还会删除掉别人远程删除的分支 2. git remote update origin --prune

43. Pulling without specifying how to reconcile divergent branches is discouraged. You can squelch this message by running one of the following commands sometime before your next pull

    ```shell
    hint: Pulling without specifying how to reconcile divergent branches is
    hint: discouraged. You can squelch this message by running one of the following
    hint: commands sometime before your next pull:
    hint:
    hint:   git config pull.rebase false  # merge (the default strategy)
    hint:   git config pull.rebase true   # rebase
    hint:   git config pull.ff only       # fast-forward only
    hint:
    hint: You can replace "git config" with "git config --global" to set a default
    hint: preference for all repositories. You can also pass --rebase, --no-rebase,
    hint: or --ff-only on the command line to override the configured default per
    hint: invocation.
    ```

    ```
    大致意思是 不建议在没有为偏离分支指定合并策略时执行pull操作。
    您可以在执行下一次pull操作之前执行下面一条命令来抑制本消息：
    git config pull.rebase false # 合并（缺省策略）
    git config pull.rebase true # 变基
    git config pull.ff only # 仅快进
    ```

    解决方案：

    1. 先使用`git config pull.rebase false`，然后重新进行拉取
    2. 如果不生效，再使用`git config pull.rebase true`然后重新进行拉取

44. git stash

    1. 介绍：将当前的工作状态保存到 git 栈，在需要的时候再恢复。

    2. 使用场景：当在一个分支的开发工作未完成，却又要切换到另外一个分支进行开发的时候，可以先将自己写好的代码，储存到`git`栈，进行另外一个分支的代码开发。这时候`git stash`命令就派上用场了！

    3. 常用命令

       1. git stash：保存当前工作区和暂存区的状态，将当前的修改保存到 git 栈，等以后需要的时候再恢复

       2. git stash save '注释'：存储时增加注释，便于查找

       3. git stash pop：将最新的一个记录拿出来，并且会将最新保存的内容删除

       4. git stash list：查看 stash 的所有内容

       5. git stash apply stash@{$num}：将内容恢复到当前分支下，不会删除栈中保存的记录

       6. git stash show：查看堆栈中最新保存的 stash 和当前目录的差异，显示做了哪些改动

       7. git stash clear: 清除所有 stash 的内容

       8. git stash drop stash@{0} 删除第一个队列

    4. 注意

        1. git stash apply 'stash@{$num}' 需要加引号
        2. git stash 进行储存的时候只有进行了`git add`文件才会被stash

45. git 报错：'origin' does not appear to be a git repository

    原因：是由于 git 找不到远端的仓库地址了，在 git 文件夹下，config 文件里配置上即可

    ```bash
    // 查看配置
    vi .git/config

    // 输出如下，分为3个部分
    [core]
        repositoryformatversion = 0
        filemode = false
        bare = false
        logallrefupdates = true
        symlinks = false
        ignorecase = true

    [remote "origin"]
        url = xxx(你的远端仓库地址)
        fetch = +refs/heads/*:refs/remotes/origin/*
    [branch "master"]
        remote = origin
        merge = refs/heads/master

    // 如果缺少了哪一部分的话直接手填也行，除了url都是固定的
    ```

46. 删除项目 git 配置

    > rm -r .git

47. git 初始化警告

    ```bash
    $ git init
    warning: templates not found in /home/ja/share/git-core/templates
    hint: Using 'master' as the name for the initial branch. This default branch name
    hint: is subject to change. To configure the initial branch name to use in all
    hint: of your new repositories, which will suppress this warning, call:
    hint:
    hint:   git config --global init.defaultBranch <name>
    hint:
    hint: Names commonly chosen instead of 'master' are 'main', 'trunk' and
    hint: 'development'. The just-created branch can be renamed via this command:
    hint:
    hint:   git branch -m <name>
    Initialized empty Git repository in /tmp/new/.git/
    ```

    解决方案：

    ```bash
    git config --global init.defaultBranch master
    ```

48. 强制拉取远程分支代码

    > git reset --hard origin/master

49. 创建一个无 commit 分支并推送到远程

    ```bash
    // 切换到新的分支
    // 说明：git checkout --orphan 的核心用途是 以类似git init的状态创建新的非父分支，也就是创建一个无提交记录的分支。
    git checkout --orphan latest_branch

    // 缓存所有文件
    git add -A

    // 提交跟踪过的文件
    git commit -am "commit message"

    // 删除master分支
    git branch -D master

    // 重命名当前分支为master
    git branch -m master

    // 提交到远程master分支
    git push -f origin master
    ```

50. 忽略所有目录的`node_modules`

    `gitignore`中写

    ```js
    **/node_modules
    ```

51. 报错`git@github.com: Permission denied (publickey).`

    原因：没有配置正确的 ssh 密钥，重新配置即可

    1. 通过运行 `ls -al ~/.ssh` 命令，确认你是否已经有 SSH 密钥。如果你没有密钥，可以通过运行 `ssh-keygen` 命令来生成。
    2. 运行 `cat ~/.ssh/id_rsa.pub` 命令，并将输出复制到 GitHub 帐户的 SSH 密钥设置中。
    3. `ssh -T git@github.com`检查远程仓库的访问权限

       > Hi lanfengqiuqian! You've successfully authenticated, but GitHub does not provide shell access.

52. log 和 reflog 的区别

    `git reflog` 可以查看所有分支的所有操作记录（包括已经`被删除的 commit` 记录和 `reset` 的操作）

    例如执行 `git reset --hard HEAD~1`，退回到上一个版本，用`git log`则是看不出来被删除的`commitid`，用`git reflog`则可以看到被删除的`commitid`，我们就可以买后悔药，恢复到被删除的那个版本

53. 基于远程分支创建本地分支

    ```shell
    # 更新远程分支
    git fetch origin

    # 如果有新创建的，那么会输出  * [new branch]      feat/230818 -> origin/feat/230818

    # 列出所有本地和远程分支
    git branch -a

    # 基于远程分支创建本地分支
    git checkout -b feat/230818 origin/feat/230818
    ```

54. git pull 报错`refusing to merge unrelated histories`

    原因：因为两个根本不相干的 git 库， 一个是本地库， 一个是远端库， 然后本地要去推送到远端， 远端觉得这个本地库跟自己不相干， 所以告知无法合并

    ```
    // 方案1
    git clone远程仓库到本地，将需要推送的内容放到该仓库下 ， 然后提交上去 ， 这样算是一次update操作

    // 方案2
    git pull origin master --allow-unrelated-historie
    ```

55. 测试是否能连接上 github

    > ssh -T git@github.com

    能成功的话，会返回`Hi username! You've successfully authenticated, but GitHub does not provide shell access.`

56. 报错：`detected dubious ownership`

    原因：意味着 Git 认为当前仓库的所有权存在疑问。可以通过将该目录添加到安全目录列表来解决这个问题

    假如我的项目位置是`/www/wwwroot/bad_back`

    ```shell
    # 添加配置
    git config --global --add safe.directory /www/wwwroot/bad_back

    # 确认配置已添加
    git config --global --get-all safe.directory
    ```

    再次尝试应该就可以了

57. 执行`git commit`命令之后，校验失败，导致代码丢失了

日志如下

```shell
PS D:\code\tuyeqiu> git commit -m "7.22 update"

> arco-design-pro-vue@1.0.0 lint-staged
> npx lint-staged

✔ Preparing lint-staged...
⚠ Running tasks for staged files...
❯ package.json — 44 files
❯ *.{js,ts,jsx,tsx} — 24 files
✔ prettier --write
✖ eslint --fix [FAILED]
❯ *.vue — 17 files
✔ prettier --write
✖ eslint --fix [KILLED]
✔ *.{less,css} — 1 file
↓ Skipped because of errors from tasks.
✖ error: Your local changes to the following files would be overwritten by merge:
src/auto-imports.d.ts
Please commit your changes or stash them before you merge.
Aborting
Index was not unstashed.
↓
✖ lint-staged failed due to a git error.

✖ lint-staged failed due to a git error.
Any lost modifications can be restored from a git stash:

> git stash list
stash@{0}: automatic lint-staged backup
> git stash apply --index stash@{0}


✖ eslint --fix:

D:\code\tuyeqiu\src\api\interceptor.ts
5:10 warning 'getToken' is defined but never used @typescript-eslint/no-unused-vars

D:\code\tuyeqiu\src\constant\city.js
3:7 warning 'originData' is assigned a value but never used @typescript-eslint/no-unused-vars

D:\code\tuyeqiu\src\store\modules\user\index.ts
76:9 warning Unexpected console statement no-console

D:\code\tuyeqiu\src\utils\tools.js
9:10 warning Unexpected unnamed function func-names
14:22 error Use the rest parameters instead of 'arguments' prefer-rest-params
54:43 error Unary operator '++' used no-plusplus
63:43 error Unary operator '++' used no-plusplus
65:45 error Unary operator '++' used no-plusplus
92:41 warning Unexpected console statement no-console

✖ 9 problems (4 errors, 5 warnings)


✖ eslint --fix failed without output (KILLED).
```

从日志中可以看到`Please commit your changes or stash them before you merge.`

代码没有恢复，但是在`stash`中存着，不要担心

58. git 绑定多个远程仓库

    1. 使用`git remote set-url`，不推荐

    2. 使用`git remote add`命令

       添加远程仓库，使用`origin-gitlab`作为新仓库别名，和之前的`origin区别开`

       > git remote add origin-gitlab git@gitlab:OTT/GxLive_APK.git

       查看配置的远程仓库，会发现有 4 个输出结果（2 个 fetch，2 个 push）

       > git remote -v

       查看当前分支有关联的远程分支

       > git branch -vv
       >
       > - dev 27437bf [origin/dev] <Apk> Release v1.3.20.

       这个时候直接调用`git pull`会拉取`origin/dev`分支的代码

       可以执行如下命令修改本地`dev`分支追踪的远程分支

       > git branch --set-upstream dev origin-gitlab/dev

59. `.gitignore`不生效

    原因是 `.gitignore` 只能忽略那些原来没有被`track`的文件，如果某些文件已经被纳入了版本管理中，则修改`.gitignore`是无效的。

    解决方法就是先把`本地缓存删除`（改变成`未track状态`），然后再提交。

    ```shell
    git rm -r --cached .

    git add .

    git commit -m 'update .gitignore'
    ```

60. cherry-pcik操作

    使用场景：需要将一个分支的某几次提交合并到另外一个分支

    `注意`：如果是整个分支合并直接用`merge`即可，这里指的是其中几次提交合并过去

    多次的话，需要按照commit的从早到晚的顺序

    > $ git cherry-pick commitHash

61. windows安装TORTOISESVN之后无法使用命令行

    安装的时候需要勾选安装命令行工具

    <https://blog.51cto.com/u_15932540/5994370>

    vscode集成svn：<https://blog.csdn.net/guihui666666/article/details/126280980>

62. TORTOISESVN没有显示绿色小图标

    <https://blog.csdn.net/missingzlp/article/details/132782312?utm_medium=distribute.pc_relevant.none-task-blog-2~default~baidujs_baidulandingword~default-0-132782312-blog-79608751.235^v43^control&spm=1001.2101.3001.4242.1&utm_relevant_index=3>