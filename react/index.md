<!--
 * @Date: 2020-08-31 15:08:26
 * @LastEditors: Lq
 * @LastEditTime: 2020-11-02 10:49:39
 * @FilePath: /learnningNotes/react/index.md
-->
### 可控组件和不可控组件：可以通过对于控制state来控制这个组件。

1. 关键区别：值是否和state对应。  
    比如：`Input`的`value`属性便是控制输入框的内容的，我们要对于这个进行初始化显示或者其他的操作，就可以将`value`进行控制来达到控制这个组件的目的。
2. 好处：复合React数据流，修改和使用组件中的数据方便（只需要改动state，而不需要对于dom进行操作）

    | 特征 | 不受控制 | 受控 |
    | --- | --- | --- |
    | 一次性取值（例如，提交时） | ✅ | ✅ |
    | [提交时验证](https://goshakkk.name/submit-time-validation-react/) | ✅ | ✅ |
    | [即时现场验证](https://goshakkk.name/instant-form-fields-validation-react/) | ❌ | ✅ |
    | [有条件地禁用提交按钮](https://goshakkk.name/form-recipe-disable-submit-button-react/) | ❌ | ✅ |
    | 强制输入格式 | ❌ | ✅ |
    | 一个数据的多个输入 | ❌ | ✅ |
    | [动态输入](https://goshakkk.name/array-form-inputs/) | ❌ | ✅ |

  1. 案例
      ```js
      // 可控组件
      class ConstrolInput extends React.Component {
        constructor(props) {
          super(props);        
          this.state = {value: "Hello world"};

          this.handleSubmit = this.handleSubmit.bind(this);
          this.handleChange = this.handleChange.bind(this);
        }
        handleSubmit(event) {
          event.preventDefault(); 
          alert(this.state.value);
        }
        handleChange(event) {
          this.setSate({value: event.target.value});
        }
        render() {
          return (
            <form onSubmit={this.handleSubmit}>
              <input defaultValue={this.state.value} onChange={this.handleChange} />
              <button type="submit">Alert</button>
            </form>
          );
        }
      }
      ```

      ```js
      // 不可控组件
      class UnconstrolInput extends React.Component {
        constructor(props) {
          super(props);
          this.handleSubmit = this.handleSubmit.bind(this);
        }

        handleSubmit(event) {
          event.preventDefault();
          var input = this.refs.input;
          alert(input.value);
        }

        render() {
          return (
            <form onSubmit={this.handleSubmit}>
              <input defaultValue="Hello world" ref="input" />
              <button type="submit">Alert</button>
            </form>
          );
        }
      }
      ```
  2. 不可控组件的状态无法控制，只能在打印数据的时候从dom节点中获取，二可控组件的数据变化会更新到state，也就是说状态的变换是一直保持同步的。
  3. 可控组件虽然代码量大一些，但是更推荐使用。
  4. 如果对于表单只是最基本的需求的话，那么可以使用非受控组件的方式。


*******************

### state的更新`可能`是异步的

出于性能的考虑，react可能会把多个setState()调用合并成一个调用

因为`this.props`和`this.state`可能会异步更新，所以不能依赖他们的值来更新下一个状态

```js
this.setState({
    counter: this.state.counter + this.porps.increment
})
```

解决方案：`this.setState()`参数放一个函数，该函数的参数接受一个旧的state和props

```js
this.setState((state, props) => {
    counter: state.counter + porps.increment
})
```

*****************

### 必须谨慎的对待jsx回调函数中的`this`

class方法默认不会绑定`this`，如果你忘记了绑定`this.handleClick`并把它传入了onClick，当你调用这个函数的时候`this`的值为`undefined`

如下面输出的`this`，当你要访问state的时候也会失败

```js
clickHandler = () => {
    console.log('this is:', this); // this is undefined
    cosnole.log(this.state); // TypeError: Cannot read property 'state' of undefined
}
render() {
    return (
        <div>
            <h2>这是一个类组件</h2>
            <button onClick={this.clickHandler}>click</button>
        </div>
    )
}
```
解决方案：
1. 使用箭头函数
2. 手动绑定this  


    ```js
    clickHandler = () => {
        console.log('this is:', this);
        console.log(this.state.name);
    }
    clickHandler2() {
        console.log('this is:', this);
        console.log(this.state.name);
    }
    render() {
        return (
            <div>
                <h2>这是一个类组件</h2>
                <button onClick={this.clickHandler}>click</button> // 成功
                <button onClick={() => this.clickHandler2()}>click</button> // 成功
                <button onClick={this.clickHandler2}>click</button> // 报错
                <button onClick={this.clickHandler2.bind(this)}>click</button> // 成功
            </div>
        )
    }
    ```

****************************************************************

### 在使用input元素的时候，可以使用name属性来确定是哪一个元素。


```js
const inputHandle = (e) => {
    setForm({
        ...form,
        [e.target.name]: e.target.value
    })
}

<input type="text" placeholder="请输入" name="gender" value={form.gender} onChange={inputHandle} />
```

********************

### 在指定了受控组件的value之后，正常情况下是不能够编辑的，如果仍然是可编辑的状态，说明可能是将value置为了undefined或null

```js
// 不可编辑
<input type="text" placeholder="请输入" name="gender" value={form.gender} />
// 可编辑
<input type="text" placeholder="请输入" name="gender" value={null} />
<input type="text" placeholder="请输入" name="gender" value={undefined} />
```

********************

### 一个组件返回多个元素

正常情况下，React组件返回的jsx只能是由`一个`最外层的元素包裹着一个或多个元素，但是在如下场景中可能就不适用了

```js
class Table extends React.Component {
    render() {
        return (
            <table>
                <tr>
                <Columns />
                </tr>
            </table>
        );
    }
}
```

在这个案例中，Columns组件希望返回的是多个`<td>`元素，而不是由一个`<div>`包裹的多个`<td>`

```js
class Columns extends React.Component {
    render() {
        return (
        <div>
            <td>Hello</td>
            <td>World</td>
        </div>
        );
    }
}
```

`Fragments`就能够解决这个问题：但是只支持`key`属性，暂时不支持其他属性，因为在dom树上不会实际上不会渲染这个元素

```js
class Columns extends React.Component {
  render() {
    return (
      <React.Fragment>
        <td>Hello</td>
        <td>World</td>
      </React.Fragment>
    );
  }
}

```

`Fragments`的短语法形式：但是不支持属性和key，如果要使用key，请使用`<React.Fragment>`


```js
class Columns extends React.Component {
  render() {
    return (
      <>
        <td>Hello</td>
        <td>World</td>
      </>
    );
  }
}
```


*****************

### 高阶组件

1. 定义：高阶组件（HOC）是复用组件逻辑的一种高级技巧。本身不是React API的一部分，是基于React的组合特性而形成的设计模式。

2. 特点：是一个函数，参数是组件，返回值也是组件

    ```js
    const EnhancedComponent = higherOrderComponent(WrappedComponent);
    ```

3. 对比

    组件是将props转换为UI，而高阶组件是将组件转换为另一个组件。

    HOC在React的第三方库很常见，就像Redux的`connect`函数

4. 一些约定
   
   1. 不要去改变传进来的组件，而应该使用组合的方式，通过将组件包装在容器组件中实现功能

   2. 将不相关的props传递给被包裹的组件，保证HOC的灵活性和可复用性

        HOC为组件添加特性，自身不应该大幅改变约定。HOC返回的组件于元组件应保持类似的接口。

        ```js
        render() {
            // 过滤掉非此 HOC 额外的 props，且不要进行透传
            const { extraProp, ...passThroughProps } = this.props;

            // 将 props 注入到被包装的组件中。
            // 通常为 state 的值或者实例方法。
            const injectedProp = someStateOrInstanceMethod;

            // 将 props 传递给被包装组件
            return (
                <WrappedComponent
                injectedProp={injectedProp}
                {...passThroughProps}
                />
            );
        }
        ```

5. 注意事项

    1. 不要在render方法中使用HOC

        性能方面：会导致子树的每次渲染都会进行卸载和重新挂载的操作  
        数据方面：会导致该组件及其所有子组件的状态丢失

        应该在组件之外创建HOC，这样的话组件只会创建一次，所以每次render的时候都会是同一个组件。

    2. Refs不会被传递

        Refs实际上不是prop，就像key一样，如果将ref添加到HOC的返回组件中，则ref引用指向容器组件，而不是被包装的组件。


********************************

### 深入JSX

1. 本质

    实际上，JSX仅仅只是`React.createElement(component, props, ...chaildren)`函数的语法糖

    ```js
    // 一个JSX
    <MyButton color="blue" shadowSize={2}>
        click
    </MyButton>

    // 编译后的函数
    React.createElement(
        MyButton,
        {color: 'blue', shadowSize: 2},
        'click'
    )
    ```

2. React必须在作用于内

    可以发现，虽然我们写的代码中没有直接使用到`React`这个变量，但是一定需要引入，否则会报错

    ```js
    // 没有使用到React，但是需要引入
    import React from 'react';

    export default function index() {
        return (
            <div>
                hello
            </div>
        )
    }
    ```

    如果你不使用 JavaScript 打包工具而是直接通过`<script>`标签加载 React，则必须将 React 挂载到全局变量中。

3. 使用点语法

    当在一个模块中导出许多React组件时，比较方便

    ```js
    import React from 'react';

    const MyComponents = {
        DatePicker: function DatePicker(props) {
            return <div>Imagine a {props.color} datepicker here.</div>;
        }
    }

    function BlueDatePicker() {
        return <MyComponents.DatePicker color="blue" />;
    }
    ```

4. props默认值为true

    但是一般建议给值，因为容易和es6对象简写混淆  
    `{foo}`是`{foo: foo}`的简写，而不是`{foo: true}`

    下面两者等价
    ```js
    <MyTextBox autocomplete />

    <MyTextBox autocomplete={true} />
    ```

5. 属性展开

    1. 如果已经有了props对象，可以使用展开运算符来传递整个props对象

        下面两者等价
        ```js
        function App1() {
            return <Greeting firstName="Ben" lastName="Hector" />;
        }

        function App2() {
            const props = {firstName: 'Ben', lastName: 'Hector'};
            return <Greeting {...props} />;
        }
        ```

    2. 或者只保留当前组件需要的props，并使用展开运算符将其他的props传递下去

        ```js
        const Button = props => {
            const { kind, ...other } = props;
            const className = kind === "primary" ? "PrimaryButton" : "SecondaryButton";
            return <button className={className} {...other} />;
        };

        const App = () => {
            return (
                <div>
                <Button kind="primary" onClick={() => console.log("clicked!")}>
                    Hello World!
                </Button>
                </div>
            );
        };
        ```

        但是也容易将不必要的props传递给不相关的组件，或者将无效的HTML属性传递给DOM，应该谨慎使用该语法

****************************************************************

### JSX中的子元素

概念：包含在开始标签和结束标签之间的JSX表达式的内容将作为特定属性`props.children`传递给外层组件，有几种不同的方法来传递子元素

1. 字符串字面量

    ```js
    <MyComponent>Hello world!</MyComponent>
    ```

    关于空格和空行  
    
    1. jsx会移除行收尾的空格以及空行
    2. 与标签相邻的空行均会被删除
    3. 文本字符串之间的新行会被压缩为一个空格

    下面几种写法等价
    ```js
    <div>Hello World</div>

    <div> Hello World </div>

    <div>
    Hello World
    </div>

    <div>
    Hello
    World
    </div>

    <div>

    Hello World
    </div>
    ```

2. 能够混合使用

    1. 将字符串字面量和JSX子元素一起使用

    2. 将存储在数组中的一组元素作为子元素

        ```js
        return ([
            // 不要忘记设置 key :)
            <li key="A">First item</li>,
            <li key="B">Second item</li>,
            <li key="C">Third item</li>,
        ])
        ```

3. 将js表达式作为子元素

    js表达式可以被包裹在`{}`中组作为子元素

    ```js
    return (
        <div>
            {todos.map((message) => <Item key={message} message={message} />)}
        </div>
    )
    ```

4. 函数作为子元素：确保返回值能够使一个可理解的jsx

    ```js
    <Repeat numTimes={10}>
        {(index) => <div key={index}>This is item {index} in the list</div>}
    </Repeat>
    ```

5. boolean、null、undefined将会被忽略

    false | true | null | undefined 都是合法的子元素，但是他们不会被渲染

    下面结果相同
    ```js
    <div />

    <div></div>

    <div>{false}</div>

    <div>{null}</div>

    <div>{undefined}</div>

    <div>{true}</div>
    ```

    但是如果是数字`0`则会被渲染，所以需要进行转换

    ```js
    // 错误写法
    <div>{arr.length && "hello"}</div>

    // 正确写法
    <div>{Boolean(arr.length) && "hello"}</div>
    ```