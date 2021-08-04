
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
    navigator.serviceWorker.register('/assets/js/sw.js', {
        scope: '/assets/js/'

    }).then(function(registration) {
            console.log('serviceWorker installed!', registration.scope)
            initPush();
        })
        .catch((err) => {
            console.log(err)
        });
}


function initPush() {
    if (!navigator.serviceWorker.ready) {
        console.log('not ready');
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
            subscribeUser();
        });
}


function subscribeUser() {

    navigator.serviceWorker.ready.then(data => console.log(data))

    navigator.serviceWorker.ready.then(
            function (registration){

            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(

                    'BJwnak-5rLh_Fd2Mm3S0DKPcASSU64p_tfM5Q_cWHNEDN0bvFy7GENtwG38MWp8Ii2y8r6oGXG4wzNYCmvPeoJ8'
                )
            };
            console.log(subscribeOptions);

            return registration.pushManager.subscribe(subscribeOptions);
        })
        .then(function(pushSubscription){
            //console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
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

