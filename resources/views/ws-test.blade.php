<!DOCTYPE html>
<html>
<head>
    <title>WebSocket Test</title>
</head>
<body>
    <h1>WebSocket Test</h1>

    <h3>Test 1: Public Echo Server (wss://echo.websocket.org)</h3>
    <div id="status1">Ready</div>
    <button onclick="testPublic()">Test Public WS</button>
    <div id="log1"></div>

    <h3>Test 2: Reverb Server (ws://127.0.0.1:8090)</h3>
    <div id="status2">Ready</div>
    <button onclick="testReverb()">Test Reverb WS</button>
    <div id="log2"></div>

    <script>
        function testPublic() {
            document.getElementById('status1').innerHTML = '<b style="color:yellow">Connecting...</b>';
            document.getElementById('log1').innerHTML = '';

            try {
                const ws = new WebSocket('wss://echo.websocket.org');
                ws.onopen = function() {
                    document.getElementById('status1').innerHTML = '<b style="color:green">Connected!</b>';
                    document.getElementById('log1').innerHTML += '<div style="color:green">Connected!</div>';
                    ws.send('Hello');
                };
                ws.onerror = function(error) {
                    document.getElementById('status1').innerHTML = '<b style="color:red">Error!</b>';
                    document.getElementById('log1').innerHTML += '<div style="color:red">Error: ' + typeof error + '</div>';
                };
                ws.onmessage = function(event) {
                    document.getElementById('log1').innerHTML += '<div>Echo: ' + event.data + '</div>';
                    ws.close();
                };
                ws.onclose = function() {
                    document.getElementById('status1').innerHTML = 'Closed';
                };
            } catch(e) {
                document.getElementById('status1').innerHTML = '<b style="color:red">Exception!</b>';
                document.getElementById('log1').innerHTML += '<div>Exception: ' + e.message + '</div>';
            }
        }

        function testReverb() {
            document.getElementById('status2').innerHTML = '<b style="color:yellow">Connecting...</b>';
            document.getElementById('log2').innerHTML = '';

            try {
                const ws = new WebSocket('ws://localhost:8090/app/pnPSsb26WCmGOJ28Mp9Ag2mI8vedamDjTYemD7eG07Q55rPjxjus0TbM1fc1v3ud8?protocol=7&client=js&version=8.5.0');

                ws.onopen = function() {
                    document.getElementById('status2').innerHTML = '<b style="color:green">Connected!</b>';
                    document.getElementById('log2').innerHTML += '<div>Connected!</div>';
                };
                ws.onerror = function(error) {
                    document.getElementById('status2').innerHTML = '<b style="color:red">Error! readyState: ' + ws.readyState + '</b>';
                    document.getElementById('log2').innerHTML += '<div>Error - readyState is ' + ws.readyState + '</div>';
                    console.error('WS Error:', error);
                };
                ws.onmessage = function(event) {
                    document.getElementById('log2').innerHTML += '<div>Msg: ' + event.data + '</div>';
                };
                ws.onclose = function(event) {
                    document.getElementById('status2').innerHTML = '<b style="color:orange">Closed</b>';
                    document.getElementById('log2').innerHTML += '<div>Closed - Code: ' + event.code + ', Reason: ' + event.reason + '</div>';
                };

                // Check readyState periodically
                const checkState = setInterval(() => {
                    document.getElementById('log2').innerHTML += '<div>readyState: ' + ws.readyState + '</div>';
                    if (ws.readyState !== 0) {
                        clearInterval(checkState);
                    }
                }, 100);

            } catch(e) {
                document.getElementById('status2').innerHTML = '<b style="color:red">Exception!</b>';
                document.getElementById('log2').innerHTML += '<div>Exception: ' + e.message + '</div>';
            }
        }
    </script>
</body>
</html>
