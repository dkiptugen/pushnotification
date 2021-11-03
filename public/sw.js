
self.addEventListener('notificationclick', function(event) {
    // Android doesn't close the notification when you click on it
    // See: http://crbug.com/463146
    event.notification.close();
    // This looks to see if the current is already open and
    // focuses if it is
    let response = event.action;

    event.waitUntil(clients.matchAll({
        type: "window"
    }).then(function(clientList) {
        for (var i = 0; i < clientList.length; i++) {
            var client = clientList[i];
            if (client.url == '/' && 'focus' in client)
                return client.focus();
        }
        if (clients.openWindow)
            self.clients.openWindow(event.notification.data);
        if (response === 'view_notification')
            {

                fetch('https://alert.boxraft.net/api/click', {
                    method: 'POST',
                    body: JSON.parse('{"id":"'+event.notification.id+'"}'),
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                    .then((res) => {
                        return res.json();
                    })
                    .then((res) => {
                        console.log(res)
                    })
                    .catch((err) => {
                        console.log(err)
                    });
                self.clients.openWindow(event.notification.data);
            }

    }));

});


self.addEventListener('push', function (e) {
    //console.log("push called")

    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }

    if (e.data) {
        var msg = e.data.json();
        //console.log(msg)
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon,
            image:msg.image,
            ttl:msg.ttl,
            actions: msg.actions,
            data: msg.data.url
        }));
    }
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});
