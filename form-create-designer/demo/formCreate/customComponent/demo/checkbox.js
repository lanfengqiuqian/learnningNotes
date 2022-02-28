/*
 * @Date: 2022-02-23 15:56:48
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-24 14:34:49
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\customComponent\checkbox.js
 */
import FcDesigner from '@form-create/designer';

const label = ' 复制的的组件';
const name = 'checkbox';
let i = 1;
const uniqueId = () => `uni${i++}`;

const checkbox = {
    icon: 'el-icon-setting',
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
            props: {},
            options: [
                { value: '1', label: '选项1' },
                { value: '2', label: '选项2' },
            ]
        };
    },
    props() {
        return [
            //生成`checkbox`组件的`options`配置规则
            FcDesigner.makeOptionsRule('options'),
            {
                type: 'switch',
                field: 'type',
                title: '按钮类型',
                props: { activeValue: 'button', inactiveValue: 'default' }
            }, { type: 'switch', field: 'disabled', title: '是否禁用' }, {
                type: 'inputNumber',
                field: 'min',
                title: '可被勾选的 checkbox 的最小数量'
            }, { type: 'inputNumber', field: 'max', title: '可被勾选的 checkbox 的最大数量' }, {
                type: 'input',
                field: 'textColor',
                title: '按钮形式的 Checkbox 激活时的文本颜色'
            }, { type: 'input', field: 'fill', title: '按钮形式的 Checkbox 激活时的填充色和边框色' }];
    }
};

export default checkbox;