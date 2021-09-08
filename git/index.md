<!--
 * @Date: 2020-08-19 19:05:10
 * @LastEditors: Lq
 * @LastEditTime: 2021-09-06 12:18:21
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