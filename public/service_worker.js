console.log('We got here!')
self.addEventListener('push', function (e) {
    
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }
    
    console.log("data: ",e)
    

    if (e.data) {
        var msg = e.data.json();
        console.log(msg)
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon,
            actions: msg.actions,
            data: msg.data.url
        }));
    }
});

self.addEventListener('notificationclick', function(event) {   
    // Android doesn't close the notification when you click on it  
    // See: http://crbug.com/463146  
    event.notification.close();
    // This looks to see if the current is already open and  
    // focuses if it is  
    console.log("Event notification data", event.notification.data)
    if (event.action === 'view_notification') {
        // Do something...
        self.clients.openWindow(event.notification.data)
      } else {
        self.clients.openWindow(event.notification.data)
      }
  });
