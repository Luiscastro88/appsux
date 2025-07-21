const CACHE_NAME = 'sullana-pwa-v1';
const urlsToCache = [
  '/',
  '/login.php',
  '/css/registro.css',
  '/css/verificacion.css',
  '/img/logo.png',
  '/img/icon-192.png',
  '/img/icon-512.png'
];

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME).then(function(cache) {
      return cache.addAll(urlsToCache);
    })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request).then(function(response) {
      return response || fetch(event.request);
    })
  );
});
