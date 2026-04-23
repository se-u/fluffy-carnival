<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Test</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Courier New', monospace; background: #1a1a2e; color: #eee; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        h1 { color: #00ff88; margin-bottom: 20px; }
        h2 { color: #00aaff; margin: 20px 0 10px; font-size: 16px; }
        .card { background: #16213e; border-radius: 10px; padding: 20px; margin-bottom: 20px; border: 1px solid #0f3460; }
        .status { display: flex; gap: 20px; margin-bottom: 15px; }
        .status-item { display: flex; align-items: center; gap: 8px; }
        .status-dot { width: 12px; height: 12px; border-radius: 50%; background: #ff4444; }
        .status-dot.connected { background: #00ff88; }
        .status-dot.pending { background: #ffaa00; }
        #log { background: #0a0a1a; border-radius: 8px; padding: 15px; min-height: 300px; max-height: 400px; overflow-y: auto; font-size: 13px; line-height: 1.6; }
        .log-entry { border-bottom: 1px solid #1a1a2e; padding: 8px 0; }
        .log-entry:last-child { border-bottom: none; }
        .log-time { color: #666; margin-right: 10px; }
        .log-type { margin-right: 10px; padding: 2px 8px; border-radius: 4px; font-size: 11px; }
        .log-type.connect { background: #00aa00; color: white; }
        .log-type.message { background: #0066aa; color: white; }
        .log-type.error { background: #aa0000; color: white; }
        .log-type.info { background: #666; color: white; }
        .config-item { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #0f3460; }
        .config-item:last-child { border-bottom: none; }
        .config-key { color: #00aaff; }
        .config-value { color: #00ff88; word-break: break-all; }
        button { background: #00aaff; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 14px; margin-right: 10px; margin-top: 10px; }
        button:hover { background: #0088cc; }
        button:disabled { background: #666; cursor: not-allowed; }
        button.connect { background: #00aa00; }
        button.disconnect { background: #aa0000; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔌 WebSocket Debug Test</h1>

        <div class="card">
            <h2>Status</h2>
            <div class="status">
                <div class="status-item">
                    <div class="status-dot" id="wsStatus"></div>
                    <span id="wsStatusText">Disconnected</span>
                </div>
                <div class="status-item">
                    <span>Ready State:</span>
                    <span id="readyState">-</span>
                </div>
            </div>
            <button class="connect" id="btnConnect" onclick="connectWS()">Connect</button>
            <button class="disconnect" id="btnDisconnect" onclick="disconnectWS()" disabled>Disconnect</button>
            <button onclick="clearLog()">Clear Log</button>
        </div>

        <div class="card">
            <h2>Configuration</h2>
            <div id="config"></div>
        </div>

        <div class="card">
            <h2>Event Log</h2>
            <div id="log"></div>
        </div>
    </div>

    <!-- Load Echo via Vite built file -->
    <script src="http://127.0.0.1:8000/build/assets/app-DsNQHC8A.js"></script>

    <script>
        let ws = null;
        const log = document.getElementById('log');
        const wsStatus = document.getElementById('wsStatus');
        const wsStatusText = document.getElementById('wsStatusText');
        const readyStateEl = document.getElementById('readyState');
        const btnConnect = document.getElementById('btnConnect');
        const btnDisconnect = document.getElementById('btnDisconnect');
        const configEl = document.getElementById('config');

        function logMsg(type, msg) {
            const time = new Date().toLocaleTimeString();
            const entry = document.createElement('div');
            entry.className = 'log-entry';
            entry.innerHTML = `<span class="log-time">${time}</span><span class="log-type ${type}">${type.toUpperCase()}</span>${msg}`;
            log.appendChild(entry);
            log.scrollTop = log.scrollHeight;
        }

        function updateStatus(state, text) {
            wsStatus.className = 'status-dot ' + (state === 'connected' ? 'connected' : (state === 'pending' ? 'pending' : ''));
            wsStatusText.textContent = text;
        }

        function clearLog() {
            log.innerHTML = '';
            logMsg('info', 'Log cleared');
        }

        // Show config
        function showConfig() {
            const key = 'pnPSsb26WCmGOJ28Mp9Ag2mI8vedamDjTYemD7eG07Q55rPjxjus0TbM1fc1v3ud8';
            const host = window.location.hostname;
            const port = 8080; // atau 8090

            configEl.innerHTML = `
                <div class="config-item"><span class="config-key">WebSocket URL</span><span class="config-value">ws://${host}:${port}/app/${key}</span></div>
                <div class="config-item"><span class="config-key">window.location.hostname</span><span class="config-value">${host}</span></div>
                <div class="config-item"><span class="config-key">Echo exists</span><span class="config-value">${typeof window.Echo !== 'undefined' ? 'YES' : 'NO'}</span></div>
                <div class="config-item"><span class="config-key">Pusher exists</span><span class="config-value">${typeof window.Pusher !== 'undefined' ? 'YES' : 'NO'}</span></div>
            `;
        }

        function connectWS() {
            const key = 'pnPSsb26WCmGOJ28Mp9Ag2mI8vedamDjTYemD7eG07Q55rPjxjus0TbM1fc1v3ud8';
            const host = window.location.hostname;
            const port = 8090; // Reverb port

            if (ws) {
                ws.close();
            }

            logMsg('info', `Connecting to ws://${host}:${port}/app/${key}`);

            ws = new WebSocket(`ws://${host}:${port}/app/${key}?protocol=7&client=js&version=8.5.0`);

            ws.onopen = function() {
                logMsg('connect', '✅ WebSocket Connected!');
                updateStatus('connected', 'Connected');
                readyStateEl.textContent = ws.readyState + ' (OPEN)';
                btnConnect.disabled = true;
                btnDisconnect.disabled = false;
            };

            ws.onerror = function(error) {
                logMsg('error', '❌ WebSocket Error: ' + JSON.stringify(error));
                updateStatus('error', 'Error');
                readyStateEl.textContent = 'ERROR';
            };

            ws.onclose = function(event) {
                logMsg('info', `🔴 WebSocket Closed: code=${event.code}, reason=${event.reason || 'none'}`);
                updateStatus('', 'Disconnected');
                readyStateEl.textContent = ws.readyState + ' (CLOSED)';
                btnConnect.disabled = false;
                btnDisconnect.disabled = true;
            };

            ws.onmessage = function(event) {
                logMsg('message', '📨 Message: ' + event.data);
            };

            updateStatus('pending', 'Connecting...');
            readyStateEl.textContent = ws.readyState + ' (CONNECTING)';
        }

        function disconnectWS() {
            if (ws) {
                ws.close(1000, 'User disconnected');
            }
        }

        // Subscribe to test-hello channel
        function subscribeTestChannel() {
            if (typeof window.Echo !== 'undefined') {
                logMsg('info', 'Subscribing to test-hello channel...');

                Echo.channel('test-hello')
                    .listen('TestHello', function(data) {
                        logMsg('message', '📢 TestHello event: ' + JSON.stringify(data));
                    });

                logMsg('info', 'Subscribed! Waiting for events...');
            } else {
                logMsg('error', 'Echo not loaded - cannot subscribe');
            }
        }

        // On load
        window.onload = function() {
            logMsg('info', 'Page loaded');
            showConfig();

            // Wait for Echo to initialize, then subscribe
            setTimeout(function() {
                if (typeof window.Echo !== 'undefined') {
                    logMsg('info', 'Echo is available - subscribing to channel');
                    subscribeTestChannel();
                } else {
                    logMsg('error', 'Echo not loaded yet - try connecting manually after seeing connected status');
                }
            }, 2000);
        };
    </script>
</body>
</html>
