const WebSocket = require("ws");

const server = new WebSocket.Server({ port: 8080 });

const clients = new Map();

server.on("connection", (socket) => {
  let userName;

  socket.on("message", (message) => {
    const data = JSON.parse(message);
    if (data.type === "username") {
      userName = data.username;
      clients.set(userName, socket);
      console.log(`${userName} connected`);
      broadcastNotification(`${userName} has joined the chat`);
      broadcastUserCount();
    } else if (data.type === "message") {
      console.log(`Received message from ${userName}: ${data.message}`);
      broadcastMessage(userName, data.message);
    }
  });

  socket.on("close", () => {
    console.log(`${userName} disconnected`);
    clients.delete(userName);
    broadcastNotification(`${userName} has left the chat`);
    broadcastUserCount();
  });

  socket.on("error", (error) => {
    console.error("WebSocket error:", error);
  });

  function broadcastMessage(username, message) {
    clients.forEach((client, name) => {
      if (client.readyState === WebSocket.OPEN) {
        client.send(JSON.stringify({ type: "message", username, message }));
      }
    });
  }

  function broadcastNotification(message) {
    clients.forEach((client) => {
      if (client.readyState === WebSocket.OPEN) {
        client.send(JSON.stringify({ type: "notification", message }));
      }
    });
  }

  function broadcastUserCount() {
    const userCount = clients.size;
    clients.forEach((client) => {
      if (client.readyState === WebSocket.OPEN) {
        client.send(JSON.stringify({ type: "user_count", count: userCount }));
      }
    });
  }
});

console.log("WebSocket server is running on ws://localhost:8080");
