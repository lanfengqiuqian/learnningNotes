<!--
 * @Date: 2020-08-19 19:05:10
 * @LastEditors: Lq
 * @LastEditTime: 2020-11-13 11:24:31
 * @FilePath: /learnningNotes/git/index.md
-->
1. 查看所有分支
    `git branch`
2. 删除某一个分支
    `git branch -d 分支名称`
3. 强制删除某一个分支
    `git branch -D 分支名称`
4. 查看远程仓库地址
    `git remote -v`
5. 查看全局配置
    `git config -l`
6. 全局配置文件位置
    `.git/config`
7. 配置用户名和邮箱
    `git config --global user.name "John Doe"`
    `git config --global user.email johndoe@example.com`
8. 查看提交日志（获取hash码）
    `git log`
9. 回到之前某一次提交
    `git reset --hard 上一次提交的hash码`
10. 回到上一次提交
    `git reset --hard HEAD^`
11. 回到n次之前提交
    `git reset --hard HEAD^n`
12. 撤回`git add`的提交
    `git reset 文件名`
13. 克隆大文件
    `git clone --depth=1 http://xxx/mp.git`
14. 关联远程仓库
    `git remote add origin git@github.com:lenve/test.git`
15. 删除关联的远程仓库，一般情况下是origin，如果不是需要换
    `git remote rm origin`