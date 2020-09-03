<!--
 * @Date: 2020-08-31 15:08:26
 * @LastEditors: Lq
 * @LastEditTime: 2020-08-31 15:41:34
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

