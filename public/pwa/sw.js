const CACHE_NAME = 'parqueo-canoto-cache-v1';
const urlsToCache = [
  '/', // La ruta principal de la app
  '/pwa/manifest.json',
  '/pwa/pwa.js',
  '/pwa/assets/icon-192.png',
  '/pwa/assets/icon-512.png'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('[SW] Cache abierto y listo para guardar assets');
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', (event) => {
  // Estrategia: Cache primero, luego red (Cache First)
  event.respondWith(
    caches.match(event.request)
      .then(response => response || fetch(event.request))
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cache => {
          if (cache !== CACHE_NAME) {
            console.log('[SW] Eliminando cache viejo:', cache);
            return caches.delete(cache);
          }
        })
      );
    })
  );
});