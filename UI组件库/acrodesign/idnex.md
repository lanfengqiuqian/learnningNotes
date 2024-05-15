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


### acro design pro代码提交的时候报错`TypeError: opts.node.rangeBy is not a function`

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

目前只能先将stylelint这部分禁用掉


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


### vite配置了代理，但是没有进入

在`src\api\interceptor.ts`文件中，设置了`baseURL`，将他注释掉即可

```js
// if (import.meta.env.VITE_API_BASE_URL) {
//   axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;
// }
```