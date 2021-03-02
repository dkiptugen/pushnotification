
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


self.addEventListener('push', function (e) {
    console.log("push called")
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }    
    console.log("Event notification data")
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


addEventListener('fetch', event => {
    event.waitUntil(async function() {
      // Exit early if we don't have access to the client.
      // Eg, if it's cross-origin.
      if (!event.clientId) return;
  
      // Get the client.
      const client = await clients.get(event.clientId);
      // Exit early if we don't get the client.
      // Eg, if it closed.
      if (!client) return;
  
      // Send a message to the client.
      client.postMessage({
        msg: "Hey I just got a fetch from you!",
        url: event.request.url
      });
  
    }());
  });

  navigator.serviceWorker.addEventListener('message', event => {
    console.log(event.data.msg, event.data.url);
  });