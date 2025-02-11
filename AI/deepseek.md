## 官网

### deepseek

<https://deepseek.com/>

### ollama

官网：<https://ollama.com/>

第三方文档：<https://github.com/datawhalechina/handy-ollama/tree/main?tab=readme-ov-file>

### ollama模型

<https://ollama.com/library/deepseek-r1:1.5b>

## 本地化部署

<https://zhuanlan.zhihu.com/p/20928680882>

这里面下载的都比较慢，推荐下载一个迅雷，会快很多

1. 到官网下载安装包，安装
2. 安装后会启动一个终端，执行命令拉取你要安装的模型
3. 安装图形化界面工具

chatbox使用deepseek：<https://zhuanlan.zhihu.com/p/21032551781>

### 端口

ollama默认运行的地址：`http://127.0.0.1:11434`

如果找不到的话，可以点击任务栏的`ollama`图标，查看日志，比如`server.log`，里面找一下

### 检测是否已经启动了

浏览器输入`http://localhost:11434/`，如果有输出说明启动了


### 在 JavaScript 中使用 Ollama API

<https://github.com/datawhalechina/handy-ollama/blob/main/docs/C4/4.%20%E5%9C%A8%20JavaScript%20%E4%B8%AD%E4%BD%BF%E7%94%A8%20Ollama%20API.md>


### 前端调用提示跨域

如果是`windows`修改系统环境变量，增加`OLLAMA_ORIGINS`为`*`，然后重启`ollama`，如果重启不行的话就重启电脑（我是重启电脑才可以的）

重启命令：`ollama stop deepseek-r1:1.5b`，`ollama server deepseek-r1:1.5b`

### 最简单的前端调用本地api demo

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeepSeek Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .chat-container {
            width: 80%;
            max-width: 600px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .chat-header {
            background: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 1.2em;
        }
        .chat-body {
            padding: 15px;
            height: 300px;
            overflow-y: auto;
            border-bottom: 1px solid #ddd;
        }
        .chat-message {
            margin-bottom: 10px;
        }
        .chat-message.user {
            text-align: right;
        }
        .chat-message.bot {
            text-align: left;
        }
        .chat-input {
            display: flex;
            padding: 10px;
        }
        .chat-input input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }
        .chat-input button {
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .chat-input button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">DeepSeek Chat</div>
        <div class="chat-body" id="chat-body">
            <!-- Chat messages will be displayed here -->
        </div>
        <div class="chat-input">
            <input type="text" id="chat-input" placeholder="Type your message...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script>
        const chatBody = document.getElementById("chat-body");
        const inputElement = document.getElementById("chat-input");

        // Function to send message
        async function sendMessage() {
            const message = inputElement.value.trim();
            if (!message) return;

            // Display user message
            const userMessage = document.createElement("div");
            userMessage.className = "chat-message user";
            userMessage.textContent = message;
            chatBody.appendChild(userMessage);
            chatBody.scrollTop = chatBody.scrollHeight;

            // Call Ollama API to get bot response
            try {
                const response = await fetch("http://localhost:11434/api/generate", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        model: "deepseek-r1:1.5b",
                        prompt: message,
                        stream: true // Enable streaming
                    })
                });
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                // Handle streaming response
                const reader = response.body.getReader();
                const decoder = new TextDecoder("utf-8");
                let partialText = "";

                reader.read().then(function processText({ done, value }) {
                    if (done) {
                        // Finalize and display the complete message
                        if (partialText.trim() !== "") {
                            const botMessage = document.createElement("div");
                            botMessage.className = "chat-message bot";
                            botMessage.textContent = partialText.trim();
                            chatBody.appendChild(botMessage);
                            chatBody.scrollTop = chatBody.scrollHeight;
                        }
                        return;
                    }

                    partialText += decoder.decode(value, { stream: true });
                    const lines = partialText.split("\n");
                    partialText = lines.pop(); // Keep the last partial line

                    lines.forEach(line => {
                        const data = JSON.parse(line);
                        if (data.response) {
                            const botMessage = document.createElement("span");
                            botMessage.className = "chat-message bot";
                            botMessage.textContent = data.response;
                            chatBody.appendChild(botMessage);
                            chatBody.scrollTop = chatBody.scrollHeight;
                        }
                    });

                    return reader.read().then(processText);
                });
            } catch (error) {
                console.error("Error:", error);
                const errorMessage = document.createElement("div");
                errorMessage.className = "chat-message bot";
                errorMessage.textContent = "Error: Unable to connect to the server.";
                chatBody.appendChild(errorMessage);
                chatBody.scrollTop = chatBody.scrollHeight;
            }

            // Clear input field
            inputElement.value = "";
        }

        // Listen for Enter key press
        inputElement.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                sendMessage();
            }
        });
    </script>
</body>
</html>
```