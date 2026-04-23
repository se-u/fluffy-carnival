<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Realtime Debug</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Courier New', monospace; background: #1a1a2e; color: #eee; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { color: #00ff88; margin-bottom: 20px; }
        .card { background: #16213e; border-radius: 10px; padding: 20px; margin-bottom: 20px; border: 1px solid #0f3460; }
        .status { display: flex; gap: 20px; margin-bottom: 15px; }
        .status-dot { width: 12px; height: 12px; border-radius: 50%; background: #ff4444; }
        .status-dot.connected { background: #00ff88; }
        #log { background: #0a0a1a; border-radius: 8px; padding: 15px; min-height: 200px; max-height: 300px; overflow-y: auto; font-size: 13px; }
        .log-entry { border-bottom: 1px solid #1a1a2e; padding: 8px 0; }
        .log-entry:last-child { border-bottom: none; }
        input { width: 100%; padding: 12px; border: 1px solid #0f3460; border-radius: 8px; background: #0a0a1a; color: #fff; margin-bottom: 10px; }
        button { background: #00aaff; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; }
        button:hover { background: #0088cc; }
        button.delete { background: #aa0000; }
        button.done { background: #00aa00; }
        ul { list-style: none; }
        li { display: flex; justify-content: space-between; align-items: center; padding: 12px; border-bottom: 1px solid #0f3460; }
        li.done { text-decoration: line-through; color: #666; }
        .config-item { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #0f3460; }
        .config-key { color: #00aaff; }
        .config-value { color: #00ff88; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Todo Realtime Debug</h1>

        <div class="card">
            <h2 style="color:#00aaff;margin-bottom:10px;">Status</h2>
            <div class="status">
                <div class="status-dot" id="statusDot"></div>
                <span id="statusText">Disconnected</span>
            </div>
            <div id="config"></div>
        </div>

        <div class="card">
            <h2 style="color:#00aaff;margin-bottom:10px;">Add Todo</h2>
            <input type="text" id="todoInput" placeholder="Type todo and press Enter...">
            <button onclick="addTodo()">Add</button>
        </div>

        <div class="card">
            <h2 style="color:#00aaff;margin-bottom:10px;">Todos</h2>
            <ul id="todoList"></ul>
        </div>

        <div class="card">
            <h2 style="color:#00aaff;margin-bottom:10px;">Event Log</h2>
            <div id="log"></div>
        </div>
    </div>

    <script src="http://127.0.0.1:8000/build/assets/app-DsNQHC8A.js"></script>
    <script>
        const log = document.getElementById('log');
        const statusDot = document.getElementById('statusDot');
        const statusText = document.getElementById('statusText');
        const todoList = document.getElementById('todoList');
        const todoInput = document.getElementById('todoInput');
        const configEl = document.getElementById('config');

        function logMsg(msg) {
            const time = new Date().toLocaleTimeString();
            const entry = document.createElement('div');
            entry.className = 'log-entry';
            entry.innerHTML = `<span style="color:#666">${time}</span> ${msg}`;
            log.appendChild(entry);
            log.scrollTop = log.scrollHeight;
        }

        function updateStatus(state, text) {
            statusDot.className = 'status-dot' + (state === 'connected' ? ' connected' : '');
            statusText.textContent = text;
        }

        // Show config
        configEl.innerHTML = `
            <div class="config-item"><span class="config-key">Echo exists</span><span class="config-value">${typeof window.Echo !== 'undefined' ? 'YES' : 'NO'}</span></div>
            <div class="config-item"><span class="config-key">wsHost</span><span class="config-value">${window.location.hostname}</span></div>
            <div class="config-item"><span class="config-key">wsPort</span><span class="config-value">8090</span></div>
            <div class="config-item"><span class="config-key">Echo connected</span><span class="config-value">${window.Echo?.connector?.state || 'unknown'}</span></div>
        `;

        // Render todos
        function renderTodos(todos) {
            todoList.innerHTML = '';
            todos.forEach(todo => {
                const li = document.createElement('li');
                li.className = todo.is_done ? 'done' : '';
                li.innerHTML = `
                    <span>${todo.content}</span>
                    <div>
                        <button class="done" onclick="toggleTodo(${todo.id})">${todo.is_done ? 'Undo' : 'Done'}</button>
                        <button class="delete" onclick="deleteTodo(${todo.id})">X</button>
                    </div>
                `;
                todoList.appendChild(li);
            });
        }

        // Add todo
        function addTodo() {
            const content = todoInput.value.trim();
            if (!content) return;
            fetch('/todo', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ content })
            }).then(() => {
                todoInput.value = '';
            });
        }

        // Toggle todo
        function toggleTodo(id) {
            fetch('/todo/' + id + '/toggle', { method: 'POST', 'X-CSRF-TOKEN': '{{ csrf_token() }}' });
        }

        // Delete todo
        function deleteTodo(id) {
            fetch('/todo/' + id, { method: 'DELETE', 'X-CSRF-TOKEN': '{{ csrf_token() }}' });
        }

        // Subscribe to todos channel
        if (typeof window.Echo !== 'undefined') {
            logMsg('Subscribing to todos channel...');
            updateStatus('pending', 'Connecting...');

            const channel = Echo.channel('todos');

            channel.listen('.todo.created', (data) => {
                logMsg('📢 todo.created: ' + JSON.stringify(data));
            });

            channel.listen('.todo.updated', (data) => {
                logMsg('📢 todo.updated: ' + JSON.stringify(data));
            });

            channel.listen('.todo.deleted', (data) => {
                logMsg('📢 todo.deleted: ' + JSON.stringify(data));
            });

            channel.on('subscription_succeeded', () => {
                logMsg('✅ Subscription confirmed!');
                updateStatus('connected', 'Connected');
            });

            channel.on('pusher:subscription_error', (error) => {
                logMsg('❌ Subscription error: ' + JSON.stringify(error));
                updateStatus('', 'Error');
            });
        } else {
            logMsg('❌ Echo not loaded!');
        }

        // SSE fallback for debugging
        const eventSource = new EventSource('/todo/stream');
        eventSource.onmessage = function(event) {
            const data = JSON.parse(event.data);
            if (data.type === 'init') {
                renderTodos(data.todos);
                logMsg('📥 SSE init received with ' + data.todos.length + ' todos');
            } else if (data.type === 'ping') {
                logMsg('📍 SSE ping (SSE working)');
            }
        };
        eventSource.onerror = function() {
            logMsg('❌ SSE error');
        };
    </script>
</body>
</html>
