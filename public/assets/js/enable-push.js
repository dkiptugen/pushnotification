
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
    navigator.serviceWorker.register('https://alert.boxraft.net/assets/js/sw.js', {
        scope: '/assets/js/sw.js',
    }).then(function(registration) {
            console.log('serviceWorker installed!', registration.scope)
            initPush();
        })
        .catch((err) => {
            console.log(err)
        });
}
document.getElementById('allow-push-notification').onclick(function(){
    const options = {
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(
            //'{{env('VAPID_PUBLIC_KEY')}}'
            'BLJAdIBMZxy5j8rwYAGeOPWvS8DYL_FnnpYD8tij5Osvg37H__D0UQZGpGzst2gnb2TEoJ7yxWCxrGwGt5_ym4I'
        )
    };
    serviceWorkerRegistration.pushManager.subscribe(options)
        .then(function(pushSubscription) {
            console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
            storePushSubscription(pushSubscription);
        });

})
function initPush() {
    if (!navigator.serviceWorker.ready) {
        return;
    }

    if (Notification.permission === 'granted') {
        //do something
    }
    else if (Notification.permission === 'default') {
        document.body.innerHTML += '<div id="allow-push-notification-bar" class="allow-push-notification-bar card shadow" style="position: fixed; bottom:50px; right:50px; z-index:1;">\n' +
            '    <div class="content">\n' +
            '        <div class="text " style="margin-bottom: 2rem;">\n' +
            '            Want to get notification from us?\n' +
            '        </div>\n' +
            '        <div class="buttons-more" style="text-align: right;">\n' +
            '            <button type="button" class="ok-button button-1" id="allow-push-notification">\n' +
            '                Yes\n' +
            '            </button>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div>';
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
                document.body.innerHTML += '<div id="allow-push-notification-bar" class="allow-push-notification-bar card shadow" style="position: fixed; bottom:50px; right:50px; z-index:1;">\n' +
                    '    <div class="content">\n' +
                    '        <div class="text " style="margin-bottom: 2rem;">\n' +
                    '            Want to get notification from us?\n' +
                    '        </div>\n' +
                    '        <div class="buttons-more" style="text-align: right;">\n' +
                    '            <button type="button" class="ok-button button-1" id="allow-push-notification">\n' +
                    '                Yes\n' +
                    '            </button>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>';
                throw Error('Permission not granted!');
            }
            subscribeUser();
        });
}


function subscribeUser() {

   // navigator.serviceWorker.ready.then(data => console.log(data))
    navigator.serviceWorker.ready
        .then((registration) => {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(
                    //'{{env('VAPID_PUBLIC_KEY')}}'
                    'BLJAdIBMZxy5j8rwYAGeOPWvS8DYL_FnnpYD8tij5Osvg37H__D0UQZGpGzst2gnb2TEoJ7yxWCxrGwGt5_ym4I'
                )
            };
            console.log(subscribeOptions);

            return registration.pushManager.subscribe(subscribeOptions);
        }, function(error) {
            // During development it often helps to log errors to the
            // console. In a production environment it might make sense to
            // also report information about errors back to the
            // application server.
            console.log(error);
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


    fetch('https://alert.boxraft.net/api/subscribe', {
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

