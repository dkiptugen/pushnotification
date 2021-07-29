self.addEventListener("install", function() {
    console.log("install");
});
self.addEventListener("activate", function() {
    console.log("activate");
});
self.addEventListener('notificationclick', function(event) {
    // Android doesn't close the notification when you click on it
    // See: http://crbug.com/463146
    event.notification.close();
    // This looks to see if the current is already open and
    // focuses if it is
if (event.action === 'view_notification') {
    // Do something...
    self.clients.openWindow(event.notification.data)
} else {
    self.clients.openWindow(event.notification.data)
}
});


self.addEventListener('push', function (e) {
    console.log("push called")
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        console.log('Not Granted');
        //notifications aren't supported or permission not granted!
        return;
    }

    console.log(e);
    if (e.data) {
        //console.log(e.data);
        //var msg = e.data.json();
        var msg = JSON.parse(e.data);
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon,
            actions: msg.actions,
            data: msg.data.url
        }));
    }
});

