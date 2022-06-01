/*
 * @Date: 2022-02-23 15:56:48
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-24 14:37:43
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\customComponent\tag.js
 */
const label = '手动引入-tag';
const name = 'el-tag';
let i = 1;
const uniqueId = () => `uni${i++}`;

const tag = {
    icon: 'el-icon-bicycle',
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
                type: "danger",
                size: 'small', // 尺寸 medium / small / mini
                color: 'red', // 背景色
                effect: 'light', // 主题
            },
        };
    },
    props() {
        return [{
            type: 'input',
            field: 'type',
            title: '标签类型',
            props: {
                type: 'danger'
            }
        }, {
            type: 'input',
            field: 'size',
            title: '标签尺寸',
            props: {
                size: 'small'
            }
        }, {
            type: 'input',
            field: 'color',
            title: '标签背景色',
            props: {
                color: 'red'
            }
        }, {
            type: 'input',
            field: 'effect',
            title: '标签主题',
            props: {
                effect: 'light'
            }
        }, ];
    }
};

export default tag;