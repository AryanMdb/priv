self.addEventListener('push', function (event) {
    console.log('Push event received:', event);

    if (!event.data) {
        console.log('No push data available');
        return;
    }

    const data = event.data.json();
    console.log('Push Data:', data);

    const options = {
        body: data.message,
        icon: "/images/favicon.png",
        vibrate: [200, 100, 200],
        tag: "push-notification",
        actions: [
            { action: "open", title: "Open App" }
        ]
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

self.addEventListener('notificationclick', function (event) {
    console.log('Notification click received:', event);

    event.notification.close();
    event.waitUntil(
        clients.openWindow('/')
    );
});

