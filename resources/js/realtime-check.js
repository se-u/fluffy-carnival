// resources/js/realtime-check.js
export function testRealtimeSubscription(jadwalIds, callback) {
    if (!window.Echo) {
        callback({ success: false, error: 'Echo not loaded' });
        return;
    }

    let subscribedCount = 0;
    let error = null;
    const timeout = setTimeout(() => {
        if (subscribedCount === 0) {
            callback({ success: false, error: 'Subscription timeout - no channels subscribed' });
        }
    }, 10000);

    jadwalIds.forEach(jadwalId => {
        const channelName = 'antrian.' + jadwalId;

        try {
            window.Echo.channel(channelName)
                .listen('.antrian.updated', (data) => {
                    // This is just a test - we don't actually need events
                    subscribedCount++;
                    if (subscribedCount === 1) {
                        clearTimeout(timeout);
                        callback({ success: true });
                    }
                })
                .error((err) => {
                    error = 'Channel subscription error: ' + (err.message || 'Unknown error');
                    clearTimeout(timeout);
                    callback({ success: false, error });
                });
        } catch (e) {
            error = 'Exception subscribing to channel: ' + e.message;
            clearTimeout(timeout);
            callback({ success: false, error });
        }
    });
}