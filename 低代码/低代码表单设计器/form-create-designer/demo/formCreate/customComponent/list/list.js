/*
 * @Date: 2022-02-23 15:56:48
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-25 15:37:04
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\customComponent\list\list.js
 */
import FcDesigner from '@form-create/designer';

const label = '列表渲染';
const name = 'list';
let i = 1;
const uniqueId = () => `uni${i++}`;

const userInfo = {
    icon: 'el-icon-more',
    label,
    name,
    rule() {
        return {
            type: name,
            field: uniqueId(),
            title: label,
            info: '这里是提示信息',
            props: {
                listData: [],
            },
        };
    },
    props() {
        return [FcDesigner.makeOptionsRule('props.listData')];
    }
};

export default userInfo;