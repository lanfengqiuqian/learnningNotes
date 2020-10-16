<!--
 * @Date: 2020-08-31 15:08:26
 * @LastEditors: Lq
 * @LastEditTime: 2020-10-15 17:39:33
 * @FilePath: /learnningNotes/react/index.md
-->
#### 一些概念
1. 可控组件和不可控组件：可以通过对于控制state来控制这个组件。
    1. 关键区别：值是否和state对应。  
        比如：`Input`的`value`属性便是控制输入框的内容的，我们要对于这个进行初始化显示或者其他的操作，就可以将`value`进行控制来达到控制这个组件的目的。
    2. 好处：复合React数据流，修改和使用组件中的数据方便（只需要改动state，而不需要对于dom进行操作）
    3. 案例
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
    4. 不可控组件的状态无法控制，只能在打印数据的时候从dom节点中获取，二可控组件的数据变化会更新到state，也就是说状态的变换是一直保持同步的。
    5. 可控组件虽然代码量大一些，但是更推荐使用。

2. state的更新`可能`是异步的

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