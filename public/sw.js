
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
            if (client.url === '/' && 'focus' in client)
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

            self.clients.openWindow(event.notification.data)
        }

    }));

});


self.addEventListener('push', function (notifications) {
    console.log("push called")

    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }
    console.log(self.registration.getNotifications());
    const promiseChain = self.registration.getNotifications()
        .then(notifications => {
           return notifications[notifications.length-1];


        })
        .then((currentNotification) => {
            // notifications.waitUntil(
               return self.registration.showNotification(currentNotification.title, {
                body: currentNotification.body,
                icon: currentNotification.icon,
                image:currentNotification.image,
                actions: currentNotification.action,
                data: currentNotification.data.url,
                vibrate:currentNotification.data.vibrate,
                requireInteraction:true,
                id:currentNotification.data.id
            });
        //);

        });



});


self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});
