### arco-init Project init failed! Error: spawnSync pnpm.cmd ENOENT

原因：`pnpm`安装`node_modules`

解决方案

```
// 1. 检查是否安装了pnpm
> pnpm -v
> npm install -g pnpm

// 2. 重新安装依赖
> pnpm i

// 3. 如果还不行，删除node_modules重新安装
```

### acro design pro 代码提交的时候报错`TypeError: opts.node.rangeBy is not a function`

```js
PS C:\Users\feng.lan\code\hello-arco-pro> git commit -m "init"

> arco-design-pro-vue@1.0.0 lint-staged
> npx lint-staged

✔ Preparing lint-staged...
⚠ Running tasks for staged files...
  ❯ package.json — 19 files
    ❯ *.{js,ts,jsx,tsx} — 3 files
      ✔ prettier --write
      ✖ eslint --fix [KILLED]
    ❯ *.vue — 10 files
      ✖ stylelint --fix [FAILED]
      ◼ prettier --write
      ◼ eslint --fix
    ❯ *.{less,css} — 1 file
      ✔ stylelint --fix
      ✖ prettier --write [KILLED]
↓ Skipped because of errors from tasks.
✔ Reverting to original state because of errors...
✔ Cleaning up temporary files...

✖ stylelint --fix:
TypeError: opts.node.rangeBy is not a function
    at new Warning (C:\Users\feng.lan\code\hello-arco-pro\node_modules\.pnpm\postcss@8.4.38\node_modules\postcss\lib\warning.js:9:29)
    at Result.warn (C:\Users\feng.lan\code\hello-arco-pro\node_modules\.pnpm\postcss@8.4.38\node_modules\postcss\lib\result.js:26:19)
    at reportUnknownRuleNames (C:\Users\feng.lan\code\hello-arco-pro\node_modules\.pnpm\stylelint@14.16.1\node_modules\stylelint\lib\reportUnknownRuleNames.js:70:16)
    at C:\Users\feng.lan\code\hello-arco-pro\node_modules\.pnpm\stylelint@14.16.1\node_modules\stylelint\lib\lintPostcssResult.js:72:7
    at Array.map (<anonymous>)
    at lintPostcssResult (C:\Users\feng.lan\code\hello-arco-pro\node_modules\.pnpm\stylelint@14.16.1\node_modules\stylelint\lib\lintPostcssResult.js:71:19)
    at lintSource (C:\Users\feng.lan\code\hello-arco-pro\node_modules\.pnpm\stylelint@14.16.1\node_modules\stylelint\lib\lintSource.js:111:8)
    at async C:\Users\feng.lan\code\hello-arco-pro\node_modules\.pnpm\stylelint@14.16.1\node_modules\stylelint\lib\standalone.js:210:27
    at async Promise.all (index 0)
    at async standalone (C:\Users\feng.lan\code\hello-arco-pro\node_modules\.pnpm\stylelint@14.16.1\node_modules\stylelint\lib\standalone.js:253:22)

✖ eslint --fix failed without output (KILLED).

✖ prettier --write failed without output (KILLED).
husky - pre-commit hook exited with code 1 (error)
```

参考了如下`issue`，但是还没解决我的问题

```
https://github.com/arco-design/arco-design-pro-vue/issues/302
https://github.com/stylelint/stylelint/issues/5756
https://github.com/arco-design/arco-design-pro-vue/issues/235
```

目前只能先将 stylelint 这部分禁用掉

```js
// package.json文件中去掉"stylelint --fix",
  "lint-staged": {
    "*.{js,ts,jsx,tsx}": [
      "prettier --write",
      "eslint --fix"
    ],
    "*.vue": [
      "prettier --write",
      "eslint --fix"
    ],
    "*.{less,css}": [
      "prettier --write"
    ]
  },
```

### vite 配置了代理，但是没有进入

在`src\api\interceptor.ts`文件中，设置了`baseURL`，将他注释掉即可

```js
// if (import.meta.env.VITE_API_BASE_URL) {
//   axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;
// }
```

### arco-cli 无法初始化项目报错 Error: Failed to copy project content

背景：安装了`arco-cli`之后使用`arco init xxx`初始化项目之后报错

```shell
正在初始化项目于 D:\code\tuyeqiu
√ 获取项目模板成功
× 模板内容拷贝失败
Error: spawnSync npm.cmd EINVAL
    at Object.spawnSync (node:internal/child_process:1117:20)
    at spawnSync (node:child_process:876:24)
    at module.exports (C:\Users\25776\.arco_template_cache\1717049377945\node_modules\arco-design-pro-vue\.arco-cli\init.js:18:31)
    at C:\Users\25776\AppData\Roaming\nvm\node_global\pnpm-global\5\node_modules\.pnpm\arco-cli-create-project@1.0.2\node_modules\arco-cli-create-project\lib\index.js:129:23
    at Generator.next (<anonymous>)
    at fulfilled (C:\Users\25776\AppData\Roaming\nvm\node_global\pnpm-global\5\node_modules\.pnpm\arco-cli-create-project@1.0.2\node_modules\arco-cli-create-project\lib\index.js:5:58)
    at process.processTicksAndRejections (node:internal/process/task_queues:95:5) {
  errno: -4071,
  code: 'EINVAL',
  syscall: 'spawnSync npm.cmd',
  path: 'npm.cmd',
  spawnargs: [
    'run',
    'gen:vite',
    '--',
    '--projectPath=D:\\code\\tuyeqiu',
    '--simple'
  ]
}
Error: EBUSY: resource busy or locked, rmdir 'C:\Users\25776\.arco_template_cache\1717049377945\node_modules\arco-design-pro-vue'
node:fs:1222
  return handleErrorFromBinding(ctx);
         ^

Error: EBUSY: resource busy or locked, rmdir 'C:\Users\25776\.arco_template_cache\1717049377945\node_modules\arco-design-pro-vue'
    at Object.rmdirSync (node:fs:1222:10)
    at rmdirSync (C:\Users\25776\AppData\Roaming\nvm\node_global\pnpm-global\5\node_modules\.pnpm\fs-extra@9.1.0\node_modules\fs-extra\lib\remove\rimraf.js:264:13)
    at rimrafSync (C:\Users\25776\AppData\Roaming\nvm\node_global\pnpm-global\5\node_modules\.pnpm\fs-extra@9.1.0\node_modules\fs-extra\lib\remove\rimraf.js:243:7)
    at C:\Users\25776\AppData\Roaming\nvm\node_global\pnpm-global\5\node_modules\.pnpm\fs-extra@9.1.0\node_modules\fs-extra\lib\remove\rimraf.js:279:39
    at Array.forEach (<anonymous>)
    at rmkidsSync (C:\Users\25776\AppData\Roaming\nvm\node_global\pnpm-global\5\node_modules\.pnpm\fs-extra@9.1.0\node_modules\fs-extra\lib\remove\rimraf.js:279:26)
    at rmdirSync (C:\Users\25776\AppData\Roaming\nvm\node_global\pnpm-global\5\node_modules\.pnpm\fs-extra@9.1.0\node_modules\fs-extra\lib\remove\rimraf.js:269:7)
    at rimrafSync (C:\Users\25776\AppData\Roaming\nvm\node_global\pnpm-global\5\node_modules\.pnpm\fs-extra@9.1.0\node_modules\fs-extra\lib\remove\rimraf.js:243:7)
    at C:\Users\25776\AppData\Roaming\nvm\node_global\pnpm-global\5\node_modules\.pnpm\fs-extra@9.1.0\node_modules\fs-extra\lib\remove\rimraf.js:279:39
    at Array.forEach (<anonymous>) {
  errno: -4082,
  syscall: 'rmdir',
  code: 'EBUSY',
  path: 'C:\\Users\\25776\\.arco_template_cache\\1717049377945\\node_modules\\arco-design-pro-vue'
}
```

方案：尝试切换`node版本`，本来我的是`18.20.3`，切换为`16.20.2`之后可以了

也可以参考 git 的 issue：[https://github.com/arco-design/arco-cli/issues/39](https://github.com/arco-design/arco-cli/issues/39)

### 初始化项目之后安装依赖报错

pnpm 需要 node`18`的版本，要切换`18`，而不是`16`

`总结`：初始化需要 16 的版本，安装依赖需要 18 的版本
