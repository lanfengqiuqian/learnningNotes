/*
 * @Date: 2022-02-25 14:32:52
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-25 15:25:07
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\customComponent\demo\fetch.js
 */
import FcDesigner from '@form-create/designer';

const label = '测试远端数据';
const name = 'fetch-data';
let i = 1;
const uniqueId = () => `uni${i++}`;

const tag = {
    icon: 'el-icon-bicycle',
    label,
    name,
    rule() {
        return {
            type: 'select',
            field: 'city',
            title: '城市',
            value: '',
            options: [],
        };
    },
    props() {
        return [FcDesigner.makeOptionsRule('options')];
    }
};

export default tag;