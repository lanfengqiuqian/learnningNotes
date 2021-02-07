<!--
 * @Date: 2020-08-31 15:08:26
 * @LastEditors: Lq
 * @LastEditTime: 2021-02-07 10:21:00
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

1. 定义：高阶组件（HOC：Higher order components）是复用组件逻辑的一种高级技巧。本身不是React API的一部分，是基于React的组合特性而形成的设计模式。

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

6. 不足之处

    1. 产生了许多无用的组件，加深了组件层级，性能和调试受影响
    2. 多个hoc同时其那套，劫持props，命名可能会冲突，且内部无法判断props是来源于哪个hoc


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

******************************

### shoudleComponentUpdate

1. 定义：该方法总是在重新渲染之前出发，默认总是返回true，让React执行更新


    ```js
    shouldComponentUpdate(nextProps, nextState) {
        return true;
    }
    ```
    有两个参数，第一个是将要更新的`props`，第二个是将要更新的`state`

    如果你知道什么情况下组件不需要更新的时候，可以在shouldComponentUpdate中返回false来跳过整个渲染过程

    在大部分情况下，你可以继承`React.PureComponent`以代替手写`shouldComponentUpdate()`。他用之前的props和state的浅比较腹泻了`shouldComponentUpdate()`的实现

2. 示例

    如果下面组件中只有`props.color`或者`state.count`的值改变时才需要更新，那么可以使用`shouldComponentUpdate`来进行检查

    ```js
    class CounterButton extends React.Component {
        constructor(props) {
            super(props);
            this.state = {count: 1};
        }

        shouldComponentUpdate(nextProps, nextState) {
            if (this.props.color !== nextProps.color) {
                return true;
            }
            if (this.state.count !== nextState.count) {
                return true;
            }
            return false;
        }

        render() {
            return (
                <button
                    color={this.props.color}
                    onClick={() => this.setState(state => ({count: state.count + 1}))}>
                    Count: {this.state.count}
                </button>
            );
        }
    }
    ```

    如果你的组件更复杂一些，可以使用浅比较的模式来检查props和state中的所有字段，来决定组件是否需要更新。使用继承`React.PureComponent`

    上面代码可以改成下面这种简洁的形式

    ```js
    class CounterButton extends React.PureComponent {
        constructor(props) {
            super(props);
            this.state = {count: 1};
        }

        render() {
            return (
                <button
                    color={this.props.color}
                    onClick={() => this.setState(state => ({count: state.count + 1}))}>
                    Count: {this.state.count}
                </button>
            );
        }
    }
    ```


****************************************************************

### React.memo

1. 版本：在16.6.0

2. 功能：控制何时重新渲染组件，提升性能

    和PureComponent很相似，组件只有在props发生改变的时候进行重新渲染。  
    通常来说，在组件树React组件中，只要有变化就会走一遍渲染流程，但是通过PureComponent和React.memo()，我们可以仅让某些组件进行渲染。

3. 案例

    ```js
    import React, {useState, memo} from 'react'
    export default function Memo() {
        const [count, setCount] = useState(0);
        return (
            <div>
                <h2>父组件：{count}</h2>
                <button onClick={() => setCount(count + 1)}>click</button>
                <Child name="子组件" />
            </div>
        )
    }
    function Child(props) {
        console.log('刷新了子组件')
        return <div>{props.name}</div>
    }
    ```

    在这里每次点击对于父组件的count进行改变，对于子组件是没有任何影响的，但是实际上每一次都会刷新子组件。将子组件使用memo包裹之后就能避免刷新子组件。

    ```js
    const Child = memo(function(props) {
        console.log('刷新了子组件')
        return <div>{props.name}</div>
    })
    ```

4. 结论：这个是对于React非常有用的新功能，因为我们之前只能使用类组件利用`PureComponent`带来的性能优势，而现在，我们有了`React.memo()`，就可以使用函数组件享受到这个优势了。


### 图片等静态资源存放位置：public还是assets中

1. assets

    1. 脚本和样式表被缩小并捆绑在一起以避免额外的网络请求。
    2. 缺少文件会导致编译错误，而不是用户的404错误。
    3. 结果文件名包含内容哈希，因此您无需担心浏览器缓存旧版本。

2. public

    如果你希望你的文件不被编译，比如jquery.min.js，或者压缩好的js插件等，你就可以把文件放在public文件夹中，这样还可以减少文件构建时间，可以减少构建文件的大小
   
   如果在index.html中，你可以像这样去使用它：
   
   ```HTML
   <img src="%PUBLIC_URL%/image/poster.jpeg" alt="">
   ```

3. 总结

    1. 一般情况下推荐使用assets，这样的话打包可以压缩、减少代码包体积
    2. 在引用第三方js，npm没有包的情况下、放在public更好（就是项目基本使用cdn，没怎么用node_moudles）


### hook

1. 优点

    1. 避免地狱式嵌套，可读性提高
    2. 函数式组件，比class更容易理解
    3. UI和逻辑更容易分离

2. 常用hook

    1. useState：让函数组件有状态了

    2. useEffect：让函数组件有生命周期和监听器的效果

        在没有第二个参数的时候和不用useEffct包裹的区别

        useEffect是在组件加载完成之后才会执行

        ```js
        // 先打印1，再打印2
        const Demo = () => {
            useEffect(() => {
                console.log(2);
            })
            console.log(1);
            return <div></div>
        }
        ```

    3. useContext：跨组件共享数据

        ```js
        // context.js 创建context
        import { createContext } from 'react';
        export default createContext(null);

        // 父组件 挂载redux
        import MyContext form '@/context.js';

        <MyContext.provider value={value}>
            <Child />
        </MyContext.provider>
        
        // 子组件 使用redux
        import { useContext } from 'react';
        import MyContext form '@/context.js';
        const value = useContext(MyContext);
        ```

        被`MyContext.provider`包裹的组件，只要依赖的value发生变化的时候，都会进行重新渲染，需要进行性能优化

    4. useRef

        1. 说明：

            1. useRef返回的是一个可变的ref对象（只有一个current属性的对象）
            2. 可以传参数进行初始化current属性
            3. 可以保存任何类型的值：dom、对象等任何可变值
            4. ref对象和手动创建的对象的区别

                1. ref对象在组件的整个生命周期内保持不变（一直是同一个引用），值改变之后不会触发组件的重新渲染
                2. 手动创建的对象每次渲染都会重新创建一个新的

            5. 本质上，就是一个能够保存可变值的盒子
            6. 通过获取到上一个值的形式，能够进行性能的优化

        

        2. 实际应用
        
           1. 存储普通dom

                ```js
                import React, {useRef, useEffect} from 'react';

                export default function UseRef() {
                    const domRef = useRef();

                    const click = () => {
                        console.log(domRef, domRef.current);
                    }
                    
                    return (
                        <div>
                            <h2>useRef</h2>
                            <button onClick={click}>click</button>
                            <input type="text" ref={domRef} />
                        </div>
                    )
                }
                ```

           2. 父组件调用子组件方法

                ```js
                // 父组件
                export default function UseRef() {
                    const domRef = useRef();
                    const childRef = useRef();
                    useEffect(() => {
                        console.log(domRef, domRef.current);
                    }, [])
                    const click = () => {
                        console.log(domRef, domRef.current);
                        console.log(childRef, childRef.current);
                    }
                    return (
                        <div>
                            <button onClick={click}>click</button>
                            <input type="text" ref={domRef} />
                            <Child ref={childRef} />
                        </div>
                    )
                }

                
                // 子组件
                import React, { forwardRef, useImperativeHandle } from 'react'
                const RefChild = (props, ref) => {
                    useImperativeHandle(ref, () => ({
                        say: sayHello,
                    }));
                    const sayHello = () => {
                        console.log('这里是子组件');
                    }
                    return (
                        <div>
                            <h2>子组件</h2>
                        </div>
                    )
                }
                export default forwardRef(RefChild)
                ```

                对于useImperativeHandle和forwardRef的说明

                1. 如果将ref绑定在子组件上面，必须使用`useImperativeHandle`和`forwardRef`进行包裹，如果不包裹，父组件中的`childRef`将访问不到任何值
                2. `useImperativeHandle(ref,createHandle,[deps])`可以自定义暴露给父组件的实例值。
                3. `forward`接受渲染函数作为参数

           3. 封装为hook，用于获取上一个state的值

                可以简单的实现类组件中 componentDidUpdate 获取 prevProps 的值

                ```js
                const usePrevious = state => {
                    const ref = useRef();
                    useEffect(() => {
                        ref.current = state;
                    })
                    return ref.current;
                }

                export default function UseRef() {
                    const [count, setCount] = useState(0);
                    const preCount = usePrevious(count);
                    const click = () => {
                        setCount(count + 1);
                    }
                    return (
                        <div>
                            <button onClick={click}>click</button>
                            <h2>你点击了{count}次</h2>
                            <h2>preCount：{preCount}</h2>
                        </div>
                    )
                }
                ```

            4. 处理闭包问题

                也可以用于从一些异步回调中取获取最新的state的值

                ```js
                export default function UseRef() {
                    const [count, setCount] = useState(0);
                    const ref = useRef(count);
                    useEffect(() => {
                        ref.current = count;
                    })
                    const click = () => {
                        setCount(count + 1);
                    }
                    const showCount = () => {
                        setTimeout(() => {
                            // 打印count的话会出现闭包的问题获取到的旧值
                            alert(count);
                            // 使用ref的话可以获取到最新的值
                            alert(ref.current);
                        }, 1500)
                    }
                    return (
                        <div>
                            <button onClick={click}>click</button>
                            <button onClick={showCount}>showCount</button>
                            <h2>你点击了{count}次</h2>
                            <h2>ref：{ref.current}</h2>
                        </div>
                    )
                }
                ```

    5. useReducer

        当状态更新逻辑比较复杂的时候，就应该考虑使用useReducer。因为：

        1. reducer比setState更加擅长描述“如何更新状态”。比如，reducer能够读取相关的状态、同时更新多个状态。
            1. 【组件负责发出action，reducer负责更新状态】的解耦模式，使得代码逻辑变得更加清晰，代码行为更加可预测(比如useEffect的更新时机更加稳定)。
            2. 简单来记，就是每当编写setState(prevState => newState)的时候，就应该考虑是否值得将它换成useReducer。

        2. 通过传递useReducer的dispatch，可以减少状态值的传递。

            1. useReducer总是返回相同的dispatch函数，这是彻底解耦的标志：状态更新逻辑可以任意变化，而发起actions的渠道始终不变
            2. 得益于前面的解耦模式，useEffect函数体、callback function只需要使用dispatch来发出action，而无需直接依赖状态值。因此在useEffect、useCallback、useMemo的deps数组中无需包含状态值，也减少了它们更新的需要。不但能提高可读性，而且能提升性能（useCallback、useMemo的更新往往会造成子组件的刷新）。

        **官方推荐以下场景需要useReducer更佳：**

         1. state 逻辑较复杂且包含多个子值，可以集中处理。
         2. 下一个 state 依赖于之前的state 。
         3. 想更稳定的构建自动化测试用例。
         4. 想深层级修改子组件的一些状态，使用 useReducer 还能给那些会触发深更新的组件做性能优化，因为你可以向子组件传递 dispatch 而不是回调函数 。
         5. 使用reducer有助于将读取与写入分开。

        简单demo

        ```js
        export default function UseRecuder() {
            const [state, dispatch] = useReducer((state, action) => {
                switch (action.type) {
                    case 'add':
                        return {
                            ...state,
                            name: action.data.name,
                            age: state.age + action.data.age
                        };
                    case 'sub':
                        return {
                            ...state,
                            name: action.data.name,
                            age: state.age - action.data.age
                        };
                    default:
                        return state;
                }
            }, {
                name: 'jack',
                age: 8
            })

            return (
                <div>
                    <h2>name：{state.name}</h2>
                    <h2>age：{state.age}</h2>
                    <button onClick={() => dispatch({
                        type: 'add',
                        data: {
                            name: 'add',
                            age: 1
                        }
                    })}>+</button>
                    <button onClick={() => dispatch({
                        type: 'sub',
                        data: {
                            name: 'sub',
                            age: 1
                        }
                    })}>-</button>
                </div>
            )
        }
        ```

    6. useMemo和useCallback

        useMemo简单demo

        ```js
        export default function App() {
            const [target, setTarget] = useState(0);
            const [other, setOther] = useState(0)
            const sum = () => {
                console.log('执行了sum');
                return target + 1;
            }
            return (
                <>
                <h2>{target} {sum()}</h2>
                <button onClick={() => setTarget(target + 1)}>add target</button>
                <button onClick={() => setOther(other + 1)}>add other</button>
                </>
            )
        }
        ```

        点击`add target`会执行sum函数没问题，但是点击`add other`也会执行sum函数。本来sum函数只是依赖`target`获取结果，对于`other`的变化不应该再重新计算结果，在这种情况就要使用`useMemo`进行优化了。

        ```js
        export default function App() {
            const [target, setTarget] = useState(0);
            const [other, setOther] = useState(0)
            const sum = useMemo(() => {
                console.log('执行了sum');
                return target + 1;
            }, [target])
            return (
                <>
                <h2>{target} {sum}</h2>
                <button onClick={() => setTarget(target + 1)}>add target</button>
                <button onClick={() => setOther(other + 1)}>add other</button>
                </>
            )
        }
        ```

        useCallback简单demo：常用于父组件的函数传递给子组件（由于父组件更新导致函数更新导致子组件产生不必要的更新）

        对于useMemo和useCallback使用[总结](https://blog.csdn.net/fedlover/article/details/103347989?spm=1001.2014.3001.5501)：

        1. 记忆函数

            > 利用闭包缓存上次结果  
            > 成本：额外的内存和比较逻辑  
            > 不是绝对优化，而是一种成本的交换，并非适用所有场景  

        2. hooks中的记忆函数

            > useState  
            > useEffect/useLayoutEffect
            > useReducer  
            > useRef
            > useMemo：记忆运算结果  
            > useCallback：记忆函数体
            
        3. 是否需要优化

            > 更轻量的函数组件，少了hoc等额外层级嵌套，压力很小  
            > 函数中的闭包性能很快  
            > 依赖项3频繁变动，无法达到记忆目的  
            > 慎重考虑是否使用

        4. 何时适用

            > 当计算过程或者函数体足够复杂时