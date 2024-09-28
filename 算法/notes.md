[toc]

## 为什么要学算法

1. 是计算机世界的基本规则
2. 构架你的思维模式
3. 想理解框架源码的必备知识
4. vue 和 react 的虚拟 dom 就是两棵树的 diff
5. react16 的 fiber 架构，就是这棵树改成了链表
6. jsx 解析用的是栈
7. 缓存模块用的是链表
8. vue3 的虚拟 dom diff，使用的是最长递增子序列

## 时间复杂度和空间复杂度

1. 时间复杂度：算法执行了多少次
2. 空间复杂度：占用的内存空间

以 leetcode 上【两数之和】的算法为例

```js
// 这个是空间复杂度低，为O(1)
// 时间复杂度高，为O(n)
var twoSum = function (nums, target) {
  for (let i = 0; i < nums.length; i++) {
    for (let j = 0; j < nums.length; j++) {
      if (i === j) break;
      if (nums[i] + nums[j] === target) {
        return [i, j];
      }
    }
  }
};

// 这个是时间复杂度低，为O(1)
// 空间复杂度高，为O(n)
var twoSum = function (nums, target) {
  let obj = {};
  for (let i = 0; i < nums.length; i++) {
    let num = nums[i];
    let t = target - nums[i];
    if (num in obj) {
      return [i, obj[num]];
    } else {
      obj[t] = i;
    }
  }
};
```

## 数据结构

### 数组

### 链表

#### 构造链表

```js
class Node {
  constructor(val) {
    this.val = val;
    this.next = null;
    0;
  }
}

class LinkNodeList {
  constructor() {
    this.head = null;
    this.length = 0;
  }
  append(val) {
    let node = new Node(val);
    let p = this.head;
    if (this.head) {
      // 找到链表最后一个节点，把这个节点的next属性赋值为node
      while (p.next) {
        p = p.next;
      }
      p.next = node;
    } else {
      // 如果没有head节点，链表是空的，要把创建的节点，赋值给head
      this.head = node;
    }
    this.length++;
  }
  print() {
    let p = this.head;
    let ret = "";
    if (this.head) {
      do {
        ret += p.val + "=>";
        p = p.next;
      } while (p.next);
      ret += p.val;
      console.log(ret);
    } else {
      console.log("empty");
    }
  }
}

let linkList = new LinkNodeList();
linkList.append(1);
linkList.append(2);
linkList.append(3);
linkList.append(4);
linkList.print();
console.log(linkList.length);
```

#### 移除链表中符合条件的元素

```js
// head = [1,2,3,4,5,6] val = 6
var removeElements = function (head, val) {
  if (head === null) {
    return head;
  }
  head.next = removeElements(head.next, val);
  return head.val === val ? head.next : head;
};

removeElements([1, 2, 3, 4, 5, 6], 6);
```

#### 环形链表（141）

```js
var hasCycle = function (head) {
  // let cache = new Set();
  // while(head) {
  //   if (cache.has(head)) {
  //     return true;
  //   } else {
  //     cache.add(head);
  //     head = head.next;
  //   }
  // }
  // return false;

  let fast = head;
  let slow = head;
  while (fast && fast.next) {
    fast = fast.next.next;
    slow = slow.next;
    if (fast === slow) return true;
  }
  return false;
};
```

#### lru 缓存（16.25）

```js
/**
 * @param {number} capacity
 */
var LRUCache = function (capacity) {
  this.cache = new Map();
  this.max = capacity;
};

/**
 * @param {number} key
 * @return {number}
 */
LRUCache.prototype.get = function (key) {
  if (this.cache.has(key)) {
    const tmp = this.cache.get(key);
    this.cache.delete(key);
    this.cache.set(key, tmp);
    return tmp;
  } else {
    return -1;
  }
};

// 3=>3,1=>1

/**
 * @param {number} key
 * @param {number} value
 * @return {void}
 */
LRUCache.prototype.put = function (key, value) {
  if (this.cache.has(key)) {
    this.cache.delete(key);
    this.cache.set(key, value);
  } else {
    if (this.cache.size === this.max) {
      this.cache.delete(this.cache.keys().next().value);
    }
    this.cache.set(key, value);
  }
};

/**
 * Your LRUCache object will be instantiated and called as such:
 * var obj = new LRUCache(capacity)
 * var param_1 = obj.get(key)
 * obj.put(key,value)
 */
```

### 位运算

#### 常用运算符

1. 左移：`<<`，乘以 2
   如`8<<1`结果为 16，`8<<2`为 32
2. 右移：`>>`，除以 2，`小数位会丢失`
   如`8>>1`结果为 4，`7>>1`结果为 3，`6>>1`结果为 3
3. 按位与：`&`，都为 1 则为 1，否则为 0
   如`001 & 101`结果为`001`
4. 按位或：`|`，都为 0 则为 0，否则为 1
   如`001 | 101`结果为`101`
5. 按位异或：`^`，两数不同则为 1，否则为 0（前端用的比较少）
   如`001 | 101`结果为`100`

#### 权限

文件系统权限

读：`100`，写：`010`，执行`001`

```js
const NONE = 0; // 000
const READ = 4; // 100
const WRITE = 2; // 010
const EXCUTE = 1; // 001

let init = NONE;
// 赋予读
init = init | READ; // 100
// 赋予写
init = init | WRITE; // 110

// 判断是否有读权限
const hasRead = (init & READ) === READ; // true
// 判断是否有执行权限
const hasExcute = (init & EXCUTE) === EXCUTE; // false

// 删除读权限
init = init ^ READ; // 010
// 判断是否有读权限
const hasRead2 = (init & READ) === READ; // false
console.log(hasRead, hasExcute, hasRead2); // true false false
```

1. `&`常用于校验
2. `|`常用于授权

#### 2 的幂（231）

```js
/**
 * 解释
 * 2的幂的数，只有首位是1，其他都是零，如100000
 * 那么假设是n，那么n-1，则首位是0，其他所有都是1，如011111
 * 则&的结果都是0
 */
/**
 * @param {number} n
 * @return {boolean}
 */
var isPowerOfTwo = function (n) {
  return n > 0 && (n & (n - 1)) === 0;
};
```

#### 只出现一次的数字（136）

```js
// 相同的数字，位运算都相同，使用^可以进行抵消，没有抵消的数字就是要的
/**
 * @param {number[]} nums
 * @return {number}
 */
var singleNumber = function (nums) {
  let ret = 0;
  nums.forEach((item) => {
    ret ^= item;
  });
  return ret;
};
```

### 树结构

#### 前中后序遍历

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {number[]}
 */
var postorderTraversal = function (root) {
  const arr = [];
  dfs(root);
  return arr;
  function dfs(root) {
    if (!root) return;
    // 操作放在这里就是前序
    // arr.push(root.val);
    dfs(root.left);
    // 操作放在这里就是中序
    // arr.push(root.val);
    dfs(root.right);
    // 操作放在这里就是后序
    arr.push(root.val);
  }
};
```

#### 树的最大深度（104）

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {number}
 */
var maxDepth = function (root) {
  if (root === null) return 0;
  return Math.max(maxDepth(root.left), maxDepth(root.right)) + 1;
};
```

#### 翻转二叉树（144）

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val) {
 *     this.val = val;
 *     this.left = this.right = null;
 * }
 */
/**
 * @param {TreeNode} root
 * @return {TreeNode}
 */
var mirrorTree = function (root) {
  if (root === null) return null;
  [root.left, root.right] = [mirrorTree(root.right), mirrorTree(root.left)];
  return root;
};
```

### 栈

#### 有效的括号（20）

```js
/**
 * @param {string} s
 * @return {boolean}
 */
var isValid = function (s) {
  const stack = [];
  const mapping = {
    "(": ")",
    "[": "]",
    "{": "}",
  };
  for (let i = 0; i < s.length; i++) {
    const item = s[i];
    if (mapping[item]) {
      stack.push(item);
    } else {
      if (mapping[stack.pop()] !== item) {
        return false;
      }
    }
  }
  if (stack.length !== 0) return false;
  return true;
};
```

#### 简化路径（71）

```js
/**
 * @param {string} path
 * @return {string}
 */
var simplifyPath = function (path) {
  const stack = [];
  const pathArr = path.split("/");
  for (let i = 0; i < pathArr.length; i++) {
    // 有几种情况：字母，点，点点，空字符
    const item = pathArr[i];
    if (item === "" || item === ".") {
    } else if (item === "..") {
      stack.pop();
    } else {
      stack.push(item);
    }
  }
  return "/" + stack.join("/");
};
```

## 算法

### 排序算法

```js
// 冒泡排序，复杂度O(n^2)
//
// 优点是逻辑简单，缺点是复杂度高
function bubbleSort(arr) {
  for (let i = 0; i < arr.length - 1; i++) {
    for (let j = 0; j < arr.length - 1 - i; j++) {
      if (arr[j] > arr[j + 1]) {
        [arr[j], arr[j + 1]] = [arr[j + 1], arr[j]];
      }
    }
  }
  return arr;
}

// 快速排序，复杂度O(nlogn)
// 优点是速度快，缺点是稳定性不好，取决于选取的基准值
function quickSort(arr) {
  if (arr.length === 0) return [];
  const flag = arr[0];
  const left = [];
  const right = [];
  for (let i = 1; i < arr.length; i++) {
    if (arr[i] < flag) {
      left.push(arr[i]);
    } else {
      right.push(arr[i]);
    }
  }
  return [...quickSort(left), flag, ...quickSort(right)];
}

// 双指针快速排序
// 时间复杂度同上，空间复杂度从nlogn变成n
function quickSort(arr) {
  return quickSort1(arr, 0, arr.length - 1);
}

function quickSort1(arr, start, end) {
  if (start >= end) return arr;
  const index = quick(arr, start, end);
  quickSort1(arr, start, index - 1);
  quickSort1(arr, index + 1, end);
  return arr;
}

function quick(arr, start, end) {
  const flag = arr[start];
  const init = start;
  start++;
  while (start <= end) {
    while (arr[end] > flag) end--;
    while (arr[start] < flag) start++;
    if (start <= end) {
      [arr[start], arr[end]] = [arr[end], arr[start]];
      start++;
      end--;
    }
  }
  [arr[init], arr[start - 1]] = [arr[start - 1], arr[init]];
  return start - 1;
}
```

#### 三数之和（007）

```js
/**
 * @param {number[]} nums
 * @return {number[][]}
 */
var threeSum = function (nums) {
  if (nums.length < 3) return [];
  const ret = [];
  nums.sort((a, b) => a - b);
  for (let i = 0; i < nums.length - 1; i++) {
    const current = nums[i];
    if (current === nums[i - 1]) continue;
    let left = i + 1;
    let right = nums.length - 1;
    while (left < right) {
      if (i === left) {
        left++;
      }
      if (i === right) {
        right--;
      }
      const sum = current + nums[left] + nums[right];
      if (sum === 0) {
        ret.push([current, nums[left], nums[right]]);
        left++;
        right--;
        while (left < right && nums[left] === nums[left - 1]) left++;
        while (left < right && nums[right] === nums[right + 1]) right--;
      } else if (sum > 0) {
        right--;
      } else {
        left++;
      }
    }
  }
  return ret;
};
```

#### leftpad 优化

```js
// function leftpad(str, length, ch) {
//     return new Array(length - str.length).fill(ch).join('') + str
// }

/**
 * 思路
 * 第一次0
 * 第二次00
 * 第三次0000
 * 第四次00000000
 */
function leftpad(str, length, ch) {
  let len = length - str.length;
  let total = "";
  while (true) {
    // if (len%2 === 1) {
    if (len & 1) {
      total += ch;
    }
    if (len === 1) {
      return total + str;
    }
    ch += ch;
    // len = parseInt(len / 2);
    len = len >> 1;
  }
}
console.log(leftpad("hello", 10, "0"));
```

### 回溯

#### 全排列（46）

```js
/**
 * @param {number[]} nums
 * @return {number[][]}
 */
var permute = function (nums) {
  const ret = [];
  backtrack(ret, [], nums);
  return ret;
};

function backtrack(ret, temp, nums) {
  if (temp.length === nums.length) {
    return ret.push([...temp]);
  }

  for (let i = 0; i < nums.length; i++) {
    if (temp.includes(nums[i])) continue;
    temp.push(nums[i]);
    backtrack(ret, temp, nums);
    temp.pop();
  }
}

console.log(permute([1, 2, 3]));
```

#### 单词搜索（79）

```js
/**
 * @param {character[][]} board
 * @param {string} word
 * @return {boolean}
 */
var exist = function (board, word) {
  // 终止条件
  if (board.length === 0) return false;
  if (word.length === 0) return true;
  // 开始循环查找
  const row = board.length;
  const col = board[0].length;

  for (let i = 0; i < row; i++) {
    for (let j = 0; j < col; j++) {
      // 每一个字母都可以作为起点搜索
      // 0是当前查找字符串的起始位置
      const ret = find(i, j, 0);
      if (ret) return true;
    }
  }
  return false;

  function find(i, j, index) {
    if (i < 0 || i >= row) return false;
    if (j < 0 || j >= col) return false;
    const s = board[i][j];
    // 判断当前元素是否是要找的
    if (s !== word[index]) return false;
    // 判断是否是最后一个元素了
    if (index === word.length - 1) return true;
    // 把当前字母的位置置为null，以便重新找到自己
    board[i][j] = null;
    // 接下来找下一个
    // 递归自身
    const ret =
      find(i - 1, j, index + 1) ||
      find(i + 1, j, index + 1) ||
      find(i, j - 1, index + 1) ||
      find(i, j + 1, index + 1);
    // 回撤
    board[i][j] = s;
    return ret;
  }
};
```

### 贪心算法

没反例

每一步都选择当前最优解，跟之前的选择没关系

#### 柠檬水找零（860）

```js
/**
 * @param {number[]} bills
 * @return {boolean}
 */
var lemonadeChange = function (bills) {
  let fiveNum = 0;
  let tenNum = 0;
  for (let bill of bills) {
    if (bill === 5) {
      fiveNum++;
    } else if (bill === 10) {
      if (fiveNum > 0) {
        fiveNum--;
        tenNum++;
      } else {
        return false;
      }
    } else {
      if (fiveNum > 0 && tenNum > 0) {
        fiveNum--;
        tenNum--;
      } else if (fiveNum > 2) {
        fiveNum -= 3;
      } else {
        return false;
      }
    }
  }
  return true;
};
```

#### 跳跃游戏（55）

```js
/**
 * @param {number[]} nums
 * @return {boolean}
 */
var canJump = function (nums) {
  let maxIndex = 0;
  for (let i = 0; i <= maxIndex; i++) {
    maxIndex = Math.max(maxIndex, i + nums[i]);
    if (maxIndex >= nums.length - 1) return true;
  }
  return false;
};
```

#### 分发饼干（455）

```js
/**
 * @param {number[]} g
 * @param {number[]} s
 * @return {number}
 */
var findContentChildren = function (g, s) {
  s.sort((a, b) => a - b);
  g.sort((a, b) => a - b);
  let count = 0;
  let sIndex = s.length - 1;
  for (let i = g.length - 1; i >= 0; i--) {
    if (sIndex >= 0 && s[sIndex] >= g[i]) {
      count++;
      sIndex--;
    }
  }
  return count;
};
```

### 动态规划

取极值

每一步的状态是前一步推导而来

走每一步都保存一个不同状态的最优解

#### 硬币找零（322）

```js
/**
 * @param {number[]} coins
 * @param {number} amount
 * @return {number}
 */
var coinChange = function (coins, amount) {
  if (amount === 0) return 0;
  const dp = Array(amount + 1).fill(Infinity);
  dp[0] = 0;
  for (let i = 1; i < dp.length; i++) {
    for (let j = 0; j < coins.length; j++) {
      if (i - coins[j] < 0) continue;
      dp[i] = Math.min(dp[i], dp[i - coins[j]] + 1);
    }
  }
  return dp[amount] === Infinity ? -1 : dp[amount];
};

// 输入：coins = [1, 2, 5], amount = 11
// 输出：3

console.log(coinChange([1, 2, 5], 11));
```

#### 最长递增子序列（300）

```js
// 动态规划解法
/**
 * @param {number[]} nums
 * @return {number}
 */
var lengthOfLIS = function (nums) {
  if (nums.length === 0) return 0;
  let dp = Array(nums.length).fill(1);
  dp[0] = 1;
  for (let i = 1; i < dp.length; i++) {
    for (let j = 0; j < i; j++) {
      if (nums[j] < nums[i]) {
        dp[i] = Math.max(dp[i], dp[j] + 1);
      }
    }
  }
  return Math.max(...dp);
};

// 贪心算法解法（时间复杂度更低 nlogn）

// 输入：nums = [10,9,2,5,3,7,101,18]
// 输出：4
console.log(lengthOfLIS([10, 9, 2, 5, 3, 7, 101, 18]));
```

## 刷题思路

150 题左右

### 数据结构

1. 链表

```js
while (head) {
  head = head.next;
}
return head;

// 哨兵，头结点不需要判空
let dummny = {
  next: head,
};
return dummny.next;
```

2. 数组
3. 树：前端最重要的数据结构

二叉树

```js
function walk(treeNode) {
  // 终止条件
  if (!treeNode.val) return;
  // 处理treeNode
  walk(treeNode.left);
  walk(treeNode.right);
}
// 前序遍历
const arr = [];
function dfs(root) {
  if (!root) return [];
  arr.push(root.val);
  dfs(root.left);
  dfs(root.right);
}
dfs(root);
return arr;

// 前序遍历的另一种写法
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {number[]}
 */
var preorderTraversal = function (root) {
  if (!root) return [];
  const ret = [];
  const stack = [root];
  while (stack.length) {
    const cur = stack.pop();
    cur.val !== null && ret.push(cur.val);
    cur.right && stack.push(cur.right);
    cur.left && stack.push(cur.left);
  }
  return ret;
};
```

### 算法思想

1. 二分（搜索）
   有序的数组里找一个元素，如果整体复杂度高可以考虑先排序

```js
let left = 0;
let right = ret.length - 1;
while (left < right) {
  const mid = (right + left) >> 1;
  if (ret[mid] > nums[i]) {
    right = mid - 1;
  } else {
    left = mid;
  }
}
```

2. 双指针（快慢指针，头尾指针）
   1. 链表数组用的多

```js
let fast = head;
let slow = head;
while (fast && fast.next) {
  // 怎么走看需求
}
```

3. 递归和回溯（画递归树）

```js
function backtrack(数据， 路径缓存) {
  循环：每次取下一个值
    标记
    backtrack(数据， 路径缓存);
    取消标记
}
```

4. 动态规划
   你要清楚，结果是怎么推导出来的
1. 暴力解
1. 画图
1. 研究优化，加备忘录
1. 得出递推公式

```js
找零问题：11块钱，从1,2,5这3种零钱找出最小的张数
dp[11] = Min(dp[11-1], dp[11-2], dp[11-5])几个的最优解 + 1
// 边界条件
// 循环需要的结果数组
  // 递推公式
  // 循环组合类型
  // dp[n] n的钱数下，返回零钱的最优解
```

5. 贪心
   没有公式
6. bfs（广度优先）、dfs（深度优先）
7. 其他
   1. 位运算
   2. 图
   3. 哈希表

### 题型

1. 盛水
2. 炒股
3. 打劫

## 开始刷题

### 数组

#### 26. 删除有序数组的重复项

快慢指针

```js
/**
 * @param {number[]} nums
 * @return {number}
 */
var removeDuplicates = function (nums) {
  let slow = 0;
  let fast = 0;
  while (fast < nums.length) {
    if (nums[slow] !== nums[fast]) {
      slow++;
      nums[slow] = nums[fast];
    }
    fast++;
  }
  return slow + 1;
};
```

#### 27. 移除元素

快慢指针和单指针都可以

```js
/**
 * @param {number[]} nums
 * @param {number} val
 * @return {number}
 */
var removeElement = function (nums, val) {
  let slow = 0;
  let fast = 0;
  while (fast < nums.length) {
    if (nums[fast] !== val) {
      nums[slow] = nums[fast];
      slow++;
    }
    fast++;
  }
  return slow;
};

/**
 * @param {number[]} nums
 * @param {number} val
 * @return {number}
 */
var removeElement = function (nums, val) {
  let index = 0;
  for (let i = 0; i < nums.length; i++) {
    if (nums[i] !== val) {
      nums[index] = nums[i];
      index++;
    }
  }
  return index;
};
```

#### 283. 移动零

快慢指针

```js
/**
 * @param {number[]} nums
 * @return {void} Do not return anything, modify nums in-place instead.
 */
var moveZeroes = function (nums) {
  let slow = 0;
  let fast = 0;
  while (fast < nums.length) {
    if (nums[fast] !== 0) {
      [nums[fast], nums[slow]] = [nums[slow], nums[fast]];
      slow++;
    }
    fast++;
  }
};
```

#### 344. 反转字符串

头尾指针

```js
/**
 * @param {character[]} s
 * @return {void} Do not return anything, modify s in-place instead.
 */
var reverseString = function (s) {
  let left = 0;
  let right = s.length - 1;
  while (left < right) {
    [s[left], s[right]] = [s[right], s[left]];
    left++;
    right--;
  }
};
```

#### 167. 两数之和 II - 输入有序数组

头尾指针

```js
/**
 * @param {number[]} numbers
 * @param {number} target
 * @return {number[]}
 */
var twoSum = function (numbers, target) {
  let left = 0;
  let right = numbers.length - 1;
  while (left < right) {
    const num = numbers[left] + numbers[right];
    if (num === target) {
      return [left + 1, right + 1];
    } else if (num > target) {
      right--;
    } else {
      left++;
    }
  }
};
```

#### 977. 有序数组的平方

头尾指针

```js
/**
 * @param {number[]} nums
 * @return {number[]}
 */
var sortedSquares = function (nums) {
  let left = 0;
  let right = nums.length - 1;
  const arr = Array(nums.length);
  let k = nums.length - 1;
  while (left <= right) {
    const l = nums[left] * nums[left];
    const r = nums[right] * nums[right];
    if (l >= r) {
      arr[k] = l;
      left++;
    } else {
      arr[k] = r;
      right--;
    }
    k--;
  }
  return arr;
};
```

#### 209. 长度最小的子数组

头尾指针

```js
// 暴力解法
/**
 * @param {number} target
 * @param {number[]} nums
 * @return {number}
 */
var minSubArrayLen = function (target, nums) {
  const len = nums.length;
  let result = len + 1;
  for (let i = 0; i < len; i++) {
    let sum = 0;
    for (let j = i; j < len; j++) {
      sum += nums[j];
      if (sum >= target) {
        const l = j - i + 1;
        result = Math.min(l, result);
        break;
      }
    }
  }
  return result === len + 1 ? 0 : result;
};

// 头尾指针
/**
 * @param {number} target
 * @param {number[]} nums
 * @return {number}
 */
var minSubArrayLen = function (target, nums) {
  let fast = 0;
  let slow = 0;
  let sum = 0;
  let result = nums.length + 1;
  while (fast < nums.length) {
    sum += nums[fast];
    fast++;
    while (sum >= target) {
      result = Math.min(result, fast - slow);
      sum -= nums[slow];
      slow++;
    }
  }
  return result === nums.length + 1 ? 0 : result;
};
```

### 链表

#### 206. 反转链表

```js
/**
 * Definition for singly-linked list.
 * function ListNode(val, next) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.next = (next===undefined ? null : next)
 * }
 */
/**
 * @param {ListNode} head
 * @return {ListNode}
 */
var reverseList = function (head) {
  if (!head || !head.next) return head;
  let pre = null;
  let cur = head;
  while (cur) {
    let next = cur.next;
    cur.next = pre;
    pre = cur;
    cur = next;
  }
  return pre;
};
```

#### 19. 删除链表的第 N 个节点

快慢指针

```js
/**
 * Definition for singly-linked list.
 * function ListNode(val, next) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.next = (next===undefined ? null : next)
 * }
 */
/**
 * @param {ListNode} head
 * @param {number} n
 * @return {ListNode}
 */
var removeNthFromEnd = function (head, n) {
  let dummy = new ListNode(null, head);
  let fast = dummy;
  let slow = dummy;
  while (n) {
    fast = fast.next;
    n--;
  }
  while (fast.next !== null) {
    fast = fast.next;
    slow = slow.next;
  }
  slow.next = slow.next.next;
  return dummy.next;
};
```

#### 21. 合并 2 个有序链表

```js
/**
 * Definition for singly-linked list.
 * function ListNode(val, next) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.next = (next===undefined ? null : next)
 * }
 */
/**
 * @param {ListNode} list1
 * @param {ListNode} list2
 * @return {ListNode}
 */
var mergeTwoLists = function (list1, list2) {
  let dummy = new ListNode();
  let cur = dummy;

  while (list1 && list2) {
    if (list1.val < list2.val) {
      cur.next = list1;
      list1 = list1.next;
    } else {
      cur.next = list2;
      list2 = list2.next;
    }
    cur = cur.next;
  }
  cur.next = list1 || list2;
  return dummy.next;
};
```

#### 876. 链表的中间节点

快慢指针

```js
/**
 * Definition for singly-linked list.
 * function ListNode(val, next) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.next = (next===undefined ? null : next)
 * }
 */
/**
 * @param {ListNode} head
 * @return {ListNode}
 */
var middleNode = function (head) {
  let fast = head;
  let slow = head;
  while (fast && fast.next) {
    fast = fast.next.next;
    slow = slow.next;
  }
  return slow;
};
```

#### 234. 回文链表

```js
/**
 * Definition for singly-linked list.
 * function ListNode(val, next) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.next = (next===undefined ? null : next)
 * }
 */
/**
 * @param {ListNode} head
 * @return {boolean}
 */
var isPalindrome = function (head) {
  let fast = head;
  let slow = head;
  let pre;
  while (fast && fast.next) {
    fast = fast.next.next;
    let next = slow.next;
    slow.next = pre;
    pre = slow;
    slow = next;
  }
  if (fast) {
    slow = slow.next;
  }
  while (slow && pre) {
    if (slow.val !== pre.val) {
      return false;
    }
    slow = slow.next;
    pre = pre.next;
  }
  return true;
};
```

#### 92. 反转链表 II

```js
/**
 * Definition for singly-linked list.
 * function ListNode(val, next) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.next = (next===undefined ? null : next)
 * }
 */
/**
 * @param {ListNode} head
 * @param {number} left
 * @param {number} right
 * @return {ListNode}
 */
var reverseBetween = function (head, left, right) {
  let dummy = new ListNode(null, head);
  let tmp = dummy;
  for (let i = 0; i < left - 1; i++) {
    tmp = tmp.next;
  }
  let pre = tmp.next;
  let cur = pre.next;

  for (let i = 0; i < right - left; i++) {
    let next = cur.next;
    cur.next = pre;
    pre = cur;
    cur = next;
  }
  tmp.next.next = cur;
  tmp.next = pre;
  return dummy.next;
};
```

#### 142. 环形链表 II

```js
/**
 * Definition for singly-linked list.
 * function ListNode(val) {
 *     this.val = val;
 *     this.next = null;
 * }
 */

/**
 * @param {ListNode} head
 * @return {ListNode}
 */
var detectCycle = function (head) {
  if (!head) return null;

  let fast = head;
  let slow = head;
  while (fast !== null) {
    if (!fast.next) return null;
    fast = fast.next.next;
    slow = slow.next;
    if (fast === slow) {
      let cur = head;
      while (cur !== slow) {
        cur = cur.next;
        slow = slow.next;
      }
      return cur;
    }
  }
};
```

#### 160. 相交链表

```js
/**
 * Definition for singly-linked list.
 * function ListNode(val) {
 *     this.val = val;
 *     this.next = null;
 * }
 */

/**
 * @param {ListNode} headA
 * @param {ListNode} headB
 * @return {ListNode}
 */
var getIntersectionNode = function (headA, headB) {
  while (headA) {
    let tmpB = headB;
    while (headB) {
      if (headA === headB) return headA;
      headB = headB.next;
    }
    headB = tmpB;
    headA = headA.next;
  }
  return null;
};
```

```js
/**
 * Definition for singly-linked list.
 * function ListNode(val) {
 *     this.val = val;
 *     this.next = null;
 * }
 */

/**
 * @param {ListNode} headA
 * @param {ListNode} headB
 * @return {ListNode}
 */
var getIntersectionNode = function (headA, headB) {
  let curA = headA;
  let curB = headB;
  while (curA !== curB) {
    curA = curA ? curA.next : headB;
    curB = curB ? curB.next : headA;
  }
  return curA;
};
```

### 树

#### 100. 相同的树

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} p
 * @param {TreeNode} q
 * @return {boolean}
 */
var isSameTree = function (p, q) {
  if (!p && !q) return true;
  if (!p || !q) return false;
  if (p.val !== q.val) return false;
  return isSameTree(p.left, q.left) && isSameTree(p.right, q.right);
};
```

#### 101. 对称二叉树

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {boolean}
 */
var isSymmetric = function (root) {
  function contrast(left, right) {
    if (!left && !right) return true;
    if (!left || !right) return false;
    if (left.val !== right.val) return false;
    return contrast(left.left, right.right) && contrast(left.right, right.left);
  }
  return contrast(root.left, root.right);
};
```

#### 111. 二叉树的最小深度

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {number}
 */
var minDepth = function (root) {
  if (!root) return 0;
  if (!root.left && !root.right) return 1;
  if (!root.left && root.right) return minDepth(root.right) + 1;
  if (root.left && !root.right) return minDepth(root.left) + 1;
  return Math.min(minDepth(root.left), minDepth(root.right)) + 1;
};
```

#### 114. 二叉树展开为链表

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {void} Do not return anything, modify root in-place instead.
 */
var flatten = function (root) {
  const ret = [];
  walk(root);
  function walk(root) {
    if (root) {
      ret.push(root);
      root.left && walk(root.left);
      root.right && walk(root.right);
    }
  }
  for (let i = 1; i < ret.length; i++) {
    const pre = ret[i - 1];
    const cur = ret[i];
    pre.left = null;
    pre.right = cur;
  }
};
```

#### 617. 合并二叉树

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root1
 * @param {TreeNode} root2
 * @return {TreeNode}
 */
var mergeTrees = function (root1, root2) {
  function walk(root1, root2) {
    if (!root1) return root2;
    if (!root2) return root1;

    root1.val += root2.val;
    root1.left = walk(root1.left, root2.left);
    root1.right = walk(root1.right, root2.right);
    return root1;
  }
  return walk(root1, root2);
};
```

#### 236. 二叉树的最近公共祖先

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val) {
 *     this.val = val;
 *     this.left = this.right = null;
 * }
 */
/**
 * @param {TreeNode} root
 * @param {TreeNode} p
 * @param {TreeNode} q
 * @return {TreeNode}
 */
var lowestCommonAncestor = function (root, p, q) {
  if (!root) return null;

  if (root === p || root === q) return root;

  const left = lowestCommonAncestor(root.left, p, q);
  const right = lowestCommonAncestor(root.right, p, q);

  if (left && right) return root;

  return left || right;
};
```

#### 543. 二叉树的直径

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {number}
 */
var diameterOfBinaryTree = function (root) {
  let len = 0;

  function walk(root) {
    const leftLen = root.left ? walk(root.left) : 0;
    const rightLen = root.right ? walk(root.right) : 0;
    len = Math.max(len, leftLen + rightLen);
    return Math.max(leftLen, rightLen) + 1;
  }
  walk(root);
  return len;
};
```

#### 572. 另一棵树的子树

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @param {TreeNode} subRoot
 * @return {boolean}
 */
var isSubtree = function (root, subRoot) {
  if (!subRoot) return true;
  if (!root) return false;
  if (root.val === subRoot.val) {
    if (isSameTree(root, subRoot)) return true;
  }
  return isSubtree(root.left, subRoot) || isSubtree(root.right, subRoot);
};

function isSameTree(p, q) {
  if (!p && !q) return true;
  if (!p || !q) return false;
  if (p.val !== q.val) return false;
  return isSameTree(p.left, q.left) && isSameTree(p.right, q.right);
}
```

#### 257. 二叉树所有路径

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {string[]}
 */
var binaryTreePaths = function (root) {
  const ret = [];
  function walk(node, path) {
    if (!node) return;
    path.push(node.val);
    if (!node.left && !node.right) {
      ret.push(path.join("->"));
      return;
    }

    walk(node.left, [...path]);
    walk(node.right, [...path]);
  }

  walk(root, []);
  return ret;
};
```

#### 222. 完全二叉树的节点个数

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {number}
 */
var countNodes = function (root) {
  function walk(node) {
    if (node === null) return 0;
    return walk(node.left) + walk(node.right) + 1;
  }
  return walk(root);
};
```

#### 102. 二叉树的层序遍历

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {number[][]}
 */
var levelOrder = function (root) {
  if (root === null) return [];

  const ret = [];
  const queue = [root];

  while (queue.length) {
    const curQueue = [];
    let len = queue.length;

    while (len) {
      const cur = queue.shift();
      cur.left && queue.push(cur.left);
      cur.right && queue.push(cur.right);
      curQueue.push(cur.val);
      len--;
    }

    ret.push(curQueue);
  }

  return ret;
};
```

#### 107. 二叉树的层序遍历 2

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {number[][]}
 */
var levelOrderBottom = function (root) {
  if (root === null) return [];

  const ret = [];
  const queue = [root];

  while (queue.length) {
    const curQueue = [];
    let len = queue.length;

    while (len) {
      const cur = queue.shift();
      cur.left && queue.push(cur.left);
      cur.right && queue.push(cur.right);
      curQueue.push(cur.val);
      len--;
    }

    ret.unshift(curQueue);
  }

  return ret;
};
```

#### 199. 二叉树的右视图

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {number[]}
 */
var rightSideView = function (root) {
  if (root === null) return [];

  const ret = [];
  const queue = [root];

  while (queue.length) {
    let len = queue.length;

    while (len) {
      const cur = queue.shift();
      cur.left && queue.push(cur.left);
      cur.right && queue.push(cur.right);

      if (len === 1) {
        ret.push(cur.val);
      }
      len--;
    }
  }

  return ret;
};
```

#### 116. 填充每个节点的下一个右侧节点指针

```js
/**
 * // Definition for a _Node.
 * function _Node(val, left, right, next) {
 *    this.val = val === undefined ? null : val;
 *    this.left = left === undefined ? null : left;
 *    this.right = right === undefined ? null : right;
 *    this.next = next === undefined ? null : next;
 * };
 */

/**
 * @param {_Node} root
 * @return {_Node}
 */
var connect = function (root) {
  if (root === null) return root;

  const queue = [root];

  while (queue.length) {
    let len = queue.length;
    const curArr = [];

    while (len) {
      const cur = queue.shift();
      curArr.push(cur);

      cur.left && queue.push(cur.left);
      cur.right && queue.push(cur.right);

      len--;
    }

    for (let i = 0; i < curArr.length; i++) {
      curArr[i].next = curArr[i + 1] || null;
    }
  }

  return root;
};
```

#### 429. n 叉树的层序遍历

```js
/**
 * // Definition for a _Node.
 * function _Node(val,children) {
 *    this.val = val;
 *    this.children = children;
 * };
 */

/**
 * @param {_Node|null} root
 * @return {number[][]}
 */
var levelOrder = function (root) {
  if (root === null) return [];

  const ret = [];
  const queue = [root];

  while (queue.length) {
    let len = queue.length;
    const curArr = [];

    while (len) {
      const cur = queue.shift();
      curArr.push(cur.val);
      const ch = cur.children;
      if (!ch) return;
      for (let i = 0; i < ch.length; i++) {
        const item = ch[i];
        item && queue.push(item);
      }
      len--;
    }
    ret.push(curArr);
  }
  return ret;
};
```

#### 515. 在每个树行中找最大值

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {number[]}
 */
var largestValues = function (root) {
  if (root === null) return [];

  const ret = [];
  const queue = [root];

  while (queue.length) {
    let len = queue.length;
    let max = -Infinity;

    while (len) {
      const cur = queue.shift();
      max = Math.max(max, cur.val);
      cur.left && queue.push(cur.left);
      cur.right && queue.push(cur.right);

      len--;
    }

    ret.push(max);
  }

  return ret;
};
```

#### 112. 路径总和

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @param {number} targetSum
 * @return {boolean}
 */
var hasPathSum = function (root, targetSum) {
  if (root === null) return false;

  if (!root.left && !root.right) {
    return root.val === targetSum;
  }

  const offset = targetSum - root.val;
  return hasPathSum(root.left, offset) || hasPathSum(root.right, offset);
};
```

#### 404. 左叶子之和

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {number}
 */
var sumOfLeftLeaves = function (root) {
  let total = 0;
  function travese(node) {
    if (node === null) return;
    if (node.left && !node.left.left && !node.left.right)
      total += node.left.val;

    node.left && travese(node.left);
    node.right && travese(node.right);
  }
  travese(root);
  return total;
};
```

#### 98. 验证二叉搜索树

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {boolean}
 */
var isValidBST = function (root) {
  let pre = -Infinity;
  function travese(node) {
    if (node === null) return true;

    const left = travese(node.left);
    if (pre >= node.val) return false;
    pre = node.val;
    const right = travese(node.right);

    return left && right;
  }
  return travese(root);
};
```

#### 99. 恢复二叉搜索树

先存储排序数组，找到不符合升序条件的数的位置，然后交换他们的值

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @return {void} Do not return anything, modify root in-place instead.
 */
var recoverTree = function (root) {
  const arr = [];
  function travese(node) {
    if (node === null) return;

    travese(node.left);
    // todo
    arr.push(node);
    travese(node.right);
  }
  travese(root);

  let first;
  let second;
  for (let i = 0; i < arr.length; i++) {
    if (arr[i].val > arr[i + 1].val) {
      if (!first) {
        first = arr[i];
      }
      second = arr[i + 1];
    }
  }
  [first.val, second.val] = [second.val, first.val];
};
```

#### 108. 将有序数组转化为二叉搜索树

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {number[]} nums
 * @return {TreeNode}
 */
var sortedArrayToBST = function (nums) {
  if (nums.length === 0) return null;

  const mid = Math.floor(nums.length / 2);
  const root = new TreeNode(nums[mid]);
  root.left = sortedArrayToBST(nums.slice(0, mid));
  root.right = sortedArrayToBST(nums.slice(mid + 1));

  return root;
};
```

#### 654. 最大二叉树

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {number[]} nums
 * @return {TreeNode}
 */
var constructMaximumBinaryTree = function (nums) {
  if (nums.length === 0) return null;

  const max = Math.max(...nums);
  const index = nums.indexOf(max);
  const root = new TreeNode(max);
  root.left = constructMaximumBinaryTree(nums.slice(0, index));
  root.right = constructMaximumBinaryTree(nums.slice(index + 1));

  return root;
};
```

#### 109. 有序链表转换为二叉搜索树

先转换为数组，然后使用 108 题的方法

```js
/**
 * Definition for singly-linked list.
 * function ListNode(val, next) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.next = (next===undefined ? null : next)
 * }
 */
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {ListNode} head
 * @return {TreeNode}
 */
var sortedListToBST = function (head) {
  const arr = [];
  let node = head;
  while (node) {
    arr.push(node.val);
    node = node.next;
  }
  return sortedArrayToBST(arr);
};

var sortedArrayToBST = function (nums) {
  if (nums.length === 0) return null;

  const mid = Math.floor(nums.length / 2);
  const root = new TreeNode(nums[mid]);
  root.left = sortedArrayToBST(nums.slice(0, mid));
  root.right = sortedArrayToBST(nums.slice(mid + 1));

  return root;
};
```

通过链表快慢指针找中间节点

```js
/**
 * Definition for singly-linked list.
 * function ListNode(val, next) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.next = (next===undefined ? null : next)
 * }
 */
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {ListNode} head
 * @return {TreeNode}
 */
var sortedListToBST = function (head) {
  function travese(head, tail) {
    if (head === tail) return null;

    let fast = head;
    let slow = head;
    while (fast !== tail && fast.next !== tail) {
      fast = fast.next.next;
      slow = slow.next;
    }
    const root = new TreeNode(slow.val);
    root.left = travese(head, slow);
    root.right = travese(slow.next, tail);
    return root;
  }
  return travese(head, null);
};
```

#### 230. 二叉搜索树中第 K 小的元素

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @param {number} k
 * @return {number}
 */
var kthSmallest = function (root, k) {
  const arr = [];
  function travese(root) {
    root.left && travese(root.left);
    arr.push(root.val);
    root.right && travese(root.right);
  }
  travese(root);
  return arr[k - 1];
};
```

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @param {number} k
 * @return {number}
 */
var kthSmallest = function (root, k) {
  let count = 0;
  const stack = [];

  while (root || stack.length) {
    while (root) {
      stack.push(root);
      root = root.left;
    }
    root = stack.pop();
    count++;
    if (count === k) {
      return root.val;
    }
    root = root.right;
  }
};
```

#### 700. 二叉搜索树中的搜索

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @param {number} val
 * @return {TreeNode}
 */
var searchBST = function (root, val) {
  function travese(root) {
    if (root === null) return null;
    if (root.val === val) return root;
    if (root.val > val) return travese(root.left);
    if (root.val < val) return travese(root.right);
  }
  return travese(root);
};
```

#### 701. 二叉搜索树中的插入操作

```js
/**
 * Definition for a binary tree node.
 * function TreeNode(val, left, right) {
 *     this.val = (val===undefined ? 0 : val)
 *     this.left = (left===undefined ? null : left)
 *     this.right = (right===undefined ? null : right)
 * }
 */
/**
 * @param {TreeNode} root
 * @param {number} val
 * @return {TreeNode}
 */
var insertIntoBST = function (root, val) {
  if (root === null) {
    return new TreeNode(val);
  }
  if (root.val > val) {
    root.left = insertIntoBST(root.left, val);
  } else {
    root.right = insertIntoBST(root.right, val);
  }
  return root;
};
```

### 栈

#### 225. 用队列实现栈

```js
var MyStack = function () {
  // 队列只有push和shift操作：后面进，前面出
  // 主操作
  this.queue1 = [];
  // 备份
  this.queue2 = [];
};

/**
 * @param {number} x
 * @return {void}
 */
MyStack.prototype.push = function (x) {
  this.queue1.push(x);
};

/**
 * @return {number}
 */
MyStack.prototype.pop = function () {
  // queue1为空
  while (this.queue1.length > 1) {
    this.queue2.push(this.queue1.shift());
  }
  const tmp = this.queue1.shift();
  [this.queue1, this.queue2] = [this.queue2, this.queue1];
  return tmp;
};

/**
 * @return {number}
 */
MyStack.prototype.top = function () {
  const tmp = this.pop();
  this.push(tmp);
  return tmp;
};

/**
 * @return {boolean}
 */
MyStack.prototype.empty = function () {
  return !this.queue1.length && !this.queue2.length;
};

/**
 * Your MyStack object will be instantiated and called as such:
 * var obj = new MyStack()
 * obj.push(x)
 * var param_2 = obj.pop()
 * var param_3 = obj.top()
 * var param_4 = obj.empty()
 */
```

#### 232. 用栈实现队列

```js
var MyQueue = function () {
  // 栈有push和pop
  // 要实现push和shift
  this.stack1 = [];
  this.stack2 = [];
};

/**
 * @param {number} x
 * @return {void}
 */
MyQueue.prototype.push = function (x) {
  this.stack1.push(x);
};

/**
 * @return {number}
 */
MyQueue.prototype.pop = function () {
  while (this.stack1.length > 1) {
    this.stack2.push(this.stack1.pop());
  }
  const tmp = this.stack1.pop();
  while (this.stack2.length) {
    this.stack1.push(this.stack2.pop());
  }
  return tmp;
};

/**
 * @return {number}
 */
MyQueue.prototype.peek = function () {
  const tmp = this.pop();
  while (this.stack1.length) {
    this.stack2.push(this.stack1.pop());
  }
  this.stack1.push(tmp);
  while (this.stack2.length) {
    this.stack1.push(this.stack2.pop());
  }
  return tmp;
};

/**
 * @return {boolean}
 */
MyQueue.prototype.empty = function () {
  return !this.stack1.length && !this.stack2.length;
};

/**
 * Your MyQueue object will be instantiated and called as such:
 * var obj = new MyQueue()
 * obj.push(x)
 * var param_2 = obj.pop()
 * var param_3 = obj.peek()
 * var param_4 = obj.empty()
 */
```

```js
var MyQueue = function () {
  // 栈有push和pop
  // 要实现push和shift
  this.stackIn = [];
  this.stackOut = [];
};

/**
 * @param {number} x
 * @return {void}
 */
MyQueue.prototype.push = function (x) {
  this.stackIn.push(x);
};

/**
 * @return {number}
 */
MyQueue.prototype.pop = function () {
  if (this.stackOut.length) return this.stackOut.pop();
  while (this.stackIn.length) {
    this.stackOut.push(this.stackIn.pop());
  }
  return this.stackOut.pop();
};

/**
 * @return {number}
 */
MyQueue.prototype.peek = function () {
  const tmp = this.pop();
  this.stackOut.push(tmp);
  return tmp;
};

/**
 * @return {boolean}
 */
MyQueue.prototype.empty = function () {
  return !this.stackIn.length && !this.stackOut.length;
};

/**
 * Your MyQueue object will be instantiated and called as such:
 * var obj = new MyQueue()
 * obj.push(x)
 * var param_2 = obj.pop()
 * var param_3 = obj.peek()
 * var param_4 = obj.empty()
 */
```

#### 150. 逆波兰表达式求值

```js
/**
 * @param {string[]} tokens
 * @return {number}
 */
var evalRPN = function (tokens) {
  const stack = [];
  while (tokens.length) {
    const t = tokens.shift();
    let tmp;
    switch (t) {
      case "+":
        stack.push(stack.pop() + stack.pop());
        break;
      case "-":
        tmp = stack.pop();
        stack.push(stack.pop() - tmp);
        break;
      case "*":
        stack.push(stack.pop() * stack.pop());
        break;
      case "/":
        tmp = stack.pop();
        const ret = stack.pop() / tmp;

        stack.push(ret > 0 ? Math.floor(ret) : Math.ceil(ret));
        break;
      default:
        stack.push(Number(t));
    }
  }
  return stack.pop();
};
```

#### 151. 反转字符串中的单词

```js
/**
 * @param {string} s
 * @return {string}
 */
var reverseWords = function (s) {
  const arr = [];
  let str = "";
  for (let i = 0; i < s.length; i++) {
    const cur = s[i];
    if (cur === " ") {
      if (str.length > 0) {
        arr.unshift(str);
        str = "";
      }
    } else if (i === s.length - 1) {
      str += cur;
      arr.unshift(str);
    } else {
      str += cur;
    }
  }
  return arr.join(" ");
};
```

### 二分思想 

#### 704. 二分查找（作为二分的案例讲注意点）

```js
/**
 * @param {number[]} nums
 * @param {number} target
 * @return {number}
 */
var search = function (nums, target) {
  let left = 0;
  // 这里如果用Length - 1的话是可以访问到的，下面要用<=
  // 这里如果用length的话，下面要用<
  let right = nums.length - 1;
  while (left <= right) {
    // 这里要注意两个很大的数导致相加越界的情况
    // let mid = left + Math.ceil((right - left) / 2)
    let mid = Math.ceil((left + right) / 2);
    const midNum = nums[mid];
    if (midNum === target) {
      return mid;
    } else if (midNum > target) {
      right = mid - 1;
    } else {
      left = mid + 1;
    }
  }
  return -1;
};
```


#### 153. 寻找旋转排序数组中的最小值

```js
/**
 * @param {number[]} nums
 * @return {number}
 */
var findMin = function(nums) {
    let left = 0;
    let right = nums.length - 1;
    while (left <= right) {
        const mid = (left + right) >> 1;
        if (nums[mid] > nums[right]) {
            left = mid + 1;
        } else if (nums[mid] < nums[right]) {
            right = mid;
        } else {
            right--;
        }
    }
    return nums[left];
};
```

#### 69. x的平方根

```js
/**
 * @param {number} x
 * @return {number}
 */
var mySqrt = function(x) {
    let left = 0;
    let right = x;
    while (left <= right) {
        const mid = (left + right) >> 1;
        const midNum = mid * mid;
        if (midNum > x) {
            right = mid - 1;
        } else if (midNum < x) { 
            left = mid + 1;
        } else {
            return mid;
        }
    }
    return left - 1;
};
```