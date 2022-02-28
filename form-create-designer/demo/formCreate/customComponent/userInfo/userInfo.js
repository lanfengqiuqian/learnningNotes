/*
 * @Date: 2022-02-23 15:56:48
 * @LastEditors: Lq
 * @LastEditTime: 2022-02-25 14:20:32
 * @FilePath: \itr-btit-fe-adminpc\src\views\formCreate\customComponent\userINfo.js
 */
const label = '用户信息';
const name = 'user-info';
let i = 1;
const uniqueId = () => `uni${i++}`;

const userInfo = {
    icon: 'el-icon-ship',
    label,
    name,
    rule() {
        return {
            type: name,
            field: 'userinfo-demo',
            // field: uniqueId(),
            title: label,
            info: '',
            effect: {
                fetch: ''
            },
            props: {
                nameLabel: '姓名标签',
                ageLabel: 12,
                idcardLabel: '身份证标签',
            },
            on: {
                change: function (el) {
                    console.log('user-info 发生变化', el);
                }
            }
        };
    },
    props() {
        return [{
            type: 'input',
            field: 'nameLabel',
            title: '姓名标签',
            props: {
                nameLabel: '张三'
            },
        }, {
            type: 'number',
            field: 'ageLabel',
            title: '年龄标签',
            props: {
                value: 12,
                disabled: true
            },
        }, {
            type: 'input',
            field: 'idcardLabel',
            title: '身份证标签',
            props: {
                placeholder: '请输入身份证号码',
                suffixIcon: 'el-icon-delete'
            },
        }, {
            type: 'select',
            field: 'city',
            title: '城市',
            value: '',
            options: [],
            effect: {
                fetch: {
                    action: 'http://datavmap-public.oss-cn-hangzhou.aliyuncs.com/areas/csv/100000_province.json',
                    to: 'options',
                    method: 'GET',
                    parse(res) {
                        return res.rows.map(row => {
                            return {
                                label: row.name,
                                value: row.adcode
                            }
                        })
                    }
                }
            }
        }];
    }
};

export default userInfo;