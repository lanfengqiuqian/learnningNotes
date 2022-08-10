/*
 * @Date: 2022-08-10 12:01:11
 * @LastEditors: Lq
 * @LastEditTime: 2022-08-10 18:25:39
 * @FilePath: \learnningNotes\chorme\extensions\background.js
 */
//background.js
chrome.runtime.onInstalled.addListener(() => {
    DBdata("clear");//清除插件保存的本地数据
});
//插件用的数据都存储在storage.local中
function DBdata(mode,callback,data){//操作本地存储的函数
    if(mode=="set"){//保存本地数据
        console.log('set-LocalDB');
        chrome.storage.local.set({LocalDB: data});
    }else if(mode=="get"){//获取
        chrome.storage.local.get('LocalDB', function(response) {
            typeof callback == 'function' ? callback(response) : null;
        });
    }else if(mode=="clear"){//清空
        chrome.storage.local.clear();
    }
}
chrome.runtime.onConnect.addListener(function(port) {//接收到popup
    port.onMessage.addListener(function(receivedMsg) {//监听popup发来的内容receivedMsg
        if(receivedMsg.fromPopup&&receivedMsg.fromPopup=='getDB'){//如果接收到了getDB，这里读取数据并返回相当于初始化popup页面
            DBdata('get',function(res){
                port.postMessage(res.LocalDB);//发送到popup
            });
        }else{//如果不是，则说明是收到来自popup手动点击设置的数据，存入以用于popup打开时展示
            DBdata('set','',receivedMsg)
        }
    })
});
chrome.runtime.onMessage.addListener(function(senderRequest, sender, sendResponse) {//接收到content
	sendResponse({msg: '接收到content'});
    if(senderRequest.fromContent&&senderRequest.fromContent=='getDB'){//接收到fromContent:getDB
        DBdata('get',function(res){//从本地取数据
            if(res.LocalDB){
                var LocalDB=res.LocalDB;
                switch(LocalDB.Direct){
                	//如果是存入的TEST按钮
                    case 'TEST':
                        chrome.tabs.query({
                            active: true, 
                            currentWindow: true
                        }, function(tabs){
                            chrome.tabs.sendMessage(tabs[0].id, {LocalDB: LocalDB}, function(res) {
                                console.log('接收content的回调', res);
                            });//发送到content		
                        });
                        break;
                    
                    //如果是存入的removeAD按钮
                    case 'removeAD':
                        chrome.tabs.query({active: true, currentWindow: true
                        }, function(tabs){
                            chrome.tabs.sendMessage(tabs[0].id, {LocalDB: LocalDB});//发送到content		
                        });
                        break;
                        
                    case 'checkCsdnBT':
                        //popup设置数据的时候有个step属性,在多步操作的时候就开始发挥作用了
                        if(LocalDB.step==0){
                            LocalDB.step = 1;//将step设置成1
                            chrome.storage.local.set({
                                LocalDB: LocalDB//保存到本地数据
                            },function() {
                                chrome.tabs.update(null, {//将前台页面跳转到设置的url
                                    url: 'https://www.csdn.net'
                                });
                            });
                        }else if(LocalDB.step==1){//因为csdn的地址我们也匹配了所以content在跳转到csdn之后会还是会回来，不同的是step已经是1了
                            chrome.cookies.get({//获取cookie
                                'url': "https://www.csdn.net/",
                                'name': 'BT'
                            }, function(cookie) {
                                console.log(cookie.value);//获取到的值
                                LocalDB.cookie=cookie.value;//把获取到的值放到本地数据的cookie属性里
                                LocalDB.step = 2;//将step设置成2
                                chrome.storage.local.set({//获取到cookie之后跳转到第二个页面
                                    LocalDB: LocalDB//保存到本地数据
                                },function() {
                                    chrome.tabs.update(null, {//将前台页面跳转到设置的url
                                        url: 'http://localhost/test/index.html'
                                    });
                                });
                            });
                        }else if(LocalDB.step==2){//第二步
                            chrome.tabs.query({active: true, currentWindow: true}, function(tabs){//发送到content
                                chrome.tabs.sendMessage(tabs[0].id, {LocalDB: LocalDB});		
                            });
                        }
                        break;
                        
                    default:
                        break;
                }
            }
        });
    }
});
