const check = () => {
    if (!('serviceWorker' in navigator)) {
        throw new Error('No Service Worker support!')
    }
    if (!('PushManager' in window)) {
        throw new Error('No Push API Support!')
    }
}
const registerServiceWorker = async () => {
    const swRegistration = await navigator.serviceWorker.register('https://alert.boxraft.net/assets/js/ServiceWorker.js',{ scope: '/assets/js/' }); //notice the file name
    return swRegistration;
}

const requestNotificationPermission = async () => {
    const permission = await window.Notification.requestPermission();
    // value of permission can be 'granted', 'default', 'denied'
    // granted: user has accepted the request
    // default: user has dismissed the notification permission popup by clicking on x
    // denied: user has denied the request.
    if(permission !== 'granted'){
        throw new Error('Permission not granted for Notification');
    }
}

const showLocalNotification = (title, body,swRegistration) => {
    const options = {
        renotify: true,
        close: true,
        body: 'With only 12 months to the next General Election, six deputy governors at the Coast have to decide whether to chart their own new political path, stick with their bosses or retire from politics.',
        icon: 'http://localhost/web-notification/assets/img/logo.jpg',
        image: 'http://localhost/web-notification/assets/img/logo.jpg',
        data: 'https://www.standardmedia.co.ke/national/article/2001419729/tough-decisions-deputy-governors-have-to-make-ahead-of-next-general-election'
        // here you can ad
        // ,,d more properties like icon, image, vibrate, etc.
    };
     swRegistration.showNotification('<h1>Tough decisions deputy governors have to make ahead of next General Election</h1>', options);


}
function askPermission() {
    return new Promise(function(resolve, reject) {
        const permissionResult = Notification.requestPermission(function(result) {
            resolve(result);
        });

        if (permissionResult) {
            permissionResult.then(resolve, reject);
        }
    })
        .then(function(permissionResult) {
            if (permissionResult !== 'granted') {
                throw new Error('We weren\'t granted permission.');
            }
        });
}
const main =  async ()=> {
    check();
    const swRegistration = await registerServiceWorker();
    const permission =  await requestNotificationPermission(askPermission());
    showLocalNotification('This is title', 'this is the message', swRegistration);
}

main();
