import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import socketClient from './socket-client';

// Initialize socket connection
socketClient.connect();
window.socketClient = socketClient;
