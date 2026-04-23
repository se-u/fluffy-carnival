import { io } from 'socket.io-client';

class SocketClient {
  constructor() {
    this.socket = null;
    this.connected = false;
  }

  connect() {
    if (this.socket) return;

    const host = import.meta.env.VITE_SOCKETIO_HOST || '127.0.0.1';
    const port = import.meta.env.VITE_SOCKETIO_PORT || 6001;

    console.log('[SocketIO] Connecting to:', `http://${host}:${port}`);

    this.socket = io(`http://${host}:${port}`, {
      transports: ['websocket', 'polling'],
      reconnection: true,
      reconnectionAttempts: 5,
      reconnectionDelay: 1000,
    });

    this.socket.on('connect', () => {
      console.log('[SocketIO] Connected!');
      this.connected = true;
    });

    this.socket.on('disconnect', () => {
      console.log('[SocketIO] Disconnected');
      this.connected = false;
    });

    this.socket.on('connect_error', (error) => {
      console.error('[SocketIO] Connection error:', error);
    });
  }

  join(channel) {
    if (this.socket) {
      this.socket.emit('join', channel);
      console.log('[SocketIO] Joined channel:', channel);
    }
  }

  on(event, callback) {
    if (this.socket) {
      this.socket.on(event, callback);
    }
  }

  off(event) {
    if (this.socket) {
      this.socket.off(event);
    }
  }
}

const socketClient = new SocketClient();
export default socketClient;
