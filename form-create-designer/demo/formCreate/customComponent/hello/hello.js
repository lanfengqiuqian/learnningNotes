/*
 * @Date: 2022-02-23 15:56:48
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-25 18:15:52
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\customComponent\hello\hello.js
 */
const label = 'hello组件';
const name = 'my-hello';
let i = 1;
const uniqueId = () => `uni${i++}`;

const hello = {
    icon: 'el-icon-ship',
    label,
    name,
    rule() {
        return {
            type: name,
            field: uniqueId(),
            title: label,
            info: '',
            effect: {
                fetch: ''
            },
            props: {
                title: '自定义组件呀',
                name: '张三',
                age: 12,
                content: '这里是内容'
            },
            on: {
                clickJHandle: () => {
                    console.log('配置中接收了')
                }
            }
        };
    },
    props() {
        return [{
            type: 'input',
            field: 'title',
            title: '自定义标题',
            props: {
                title: '自定义组件呀'
            }
        }, {
            type: 'input',
            field: 'name',
            title: '自定义姓名',
            props: {
                name: '张三'
            }
        }, {
            type: 'number',
            field: 'age',
            title: '自定义年龄',
            props: {
                age: 12
            }
        }, {
            type: 'input',
            field: 'content',
            title: '自定义内容',
            props: {
                content: '这里是内容'
            }
        }, ];
    }
};

export default hello;