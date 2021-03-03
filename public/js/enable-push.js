
initSW();

function initSW() {
    if (!"serviceWorker" in navigator) {
        //service worker isn't supported
        return;
    }

    //don't use it here if you use service worker
    //for other stuff.
    if (!"PushManager" in window) {
        //push isn't supported
        return;
    }

    //register the service worker
    navigator.serviceWorker.register('/notifications/sw.js')
        .then(function(registration) {
            console.log('serviceWorker installed!', registration.scope)
            initPush();
        })
        .catch((err) => {
            console.log(err)
        });
}


function initPush() {
    if (!navigator.serviceWorker.ready) {
        return;
    }

    new Promise(function (resolve, reject) {
        const permissionResult = Notification.requestPermission(function (result) {
            resolve(result);
        });

        if (permissionResult) {
            permissionResult.then(resolve, reject);
        }
    })
        .then((permissionResult) => {
            if (permissionResult !== 'granted') {
                throw new Error('Permission not granted!');
            }
console.log("subscribe to user")
            subscribeUser();
        });
}

function subscribeUser() {
    console.log("subscribe to user2")

    navigator.serviceWorker.ready.then(data => console.log(data))
    navigator.serviceWorker.ready
        .then((registration) => {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(
                    //'{{env('VAPID_PUBLIC_KEY')}}'
                    'BK-EjpXz65Cj_ux5UGXwO0KS1DBDemXRn0PU3dEga7pIQBGVvA4Nef7xSHnU2VK_3cBmgeJ_AEhDovZwdTBrhbI'
                )
            };

            return registration.pushManager.subscribe(subscribeOptions);
        })
        .then((pushSubscription) => {
            console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
            storePushSubscription(pushSubscription);
        });
}


function urlBase64ToUint8Array(base64String) {
    var padding = '='.repeat((4 - base64String.length % 4) % 4);
    var base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function storePushSubscription(pushSubscription) {
    //const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
    console.log("subscribe to user3")

    fetch('/notifications/api/push', {
        method: 'POST',
        body: JSON.stringify(pushSubscription),
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
}