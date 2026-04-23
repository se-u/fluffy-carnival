import { createServer } from 'http';
import { Server } from 'socket.io';

const PORT = 6001;
const REST_PORT = 6002;

// HTTP server for REST API (Laravel emits here)
const restServer = createServer((req, res) => {
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'POST, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

  if (req.method === 'OPTIONS') {
    res.writeHead(200);
    res.end();
    return;
  }

  if (req.method === 'POST' && req.url === '/emit') {
    let body = '';
    req.on('data', chunk => { body += chunk; });
    req.on('end', () => {
      try {
        const { channel, event, data } = JSON.parse(body);
        console.log(`[REST] Emitting to ${channel}: ${event}`, data);
        if (global.io) {
          global.io.to(channel).emit(event, data);
        }
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ success: true }));
      } catch (e) {
        res.writeHead(400, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ error: e.message }));
      }
    });
    return;
  }

  res.writeHead(404);
  res.end();
});

restServer.listen(REST_PORT, () => {
  console.log(`REST API server running on port ${REST_PORT}`);
});

// Socket.IO server
const io = new Server({
  cors: {
    origin: '*',
    methods: ['GET', 'POST']
  }
});

// Store io globally for REST API to use
global.io = io;

// Handle socket connections
io.on('connection', (socket) => {
  console.log(`[WS] Client connected: ${socket.id}`);

  socket.on('join', (channel) => {
    console.log(`[WS] Client ${socket.id} joining: ${channel}`);
    socket.join(channel);
  });

  socket.on('disconnect', () => {
    console.log(`[WS] Client disconnected: ${socket.id}`);
  });
});

// Attach Socket.IO to a separate HTTP server for WebSocket
const wsServer = createServer();
io.attach(wsServer);

wsServer.listen(PORT, () => {
  console.log(`Socket.IO WebSocket server running on port ${PORT}`);
});
