const CACHE_NAME = "kanban-pwa-cache-v1";
const urlsToCache = [
    "./",
    "./index.php",
    "../node_modules/bootstrap/dist/css/bootstrap.min.css",
    "../assets/css/style.css",
    "../assets/icons/notas-192x192.png",
    "../assets/images/orilla.jpg"
];

// Instalar el Service Worker y cachear recursos
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(urlsToCache);
        })
    );
});

// Interceptar solicitudes para servir desde el caché
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});

// Actualizar el caché cuando cambien los recursos
self.addEventListener("activate", (event) => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
