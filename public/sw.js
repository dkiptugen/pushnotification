

console.log('tis a test')

// inside service worker script
self.addEventListener('error', function(e) {
    console.log(e.filename, e.lineno, e.colno, e.message);
  });