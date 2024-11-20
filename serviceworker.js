const CACHE_NAME = "kanban-pwa-cache-v3";
const urlsToCache = [
    "./",
    "./index.php",
    "../node_modules/bootstrap/dist/css/bootstrap.min.css",
    "../assets/css/style.css",
    "../assets/icons/notas-192x192.png",
    "../assets/images/orilla.jpg",
    "./pages/kanban.php", // Añadido para almacenar kanban.php
    "./offline.html" // Página de respaldo para modo offline
];

// Instalar el Service Worker y cachear recursos iniciales
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(urlsToCache);
        })
    );
});

// Interceptar solicitudes y manejar recursos dinámicos
self.addEventListener("fetch", (event) => {
    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // Guardar la respuesta en caché
                const responseClone = response.clone();
                caches.open(CACHE_NAME).then((cache) => {
                    cache.put(event.request, responseClone);
                });
                return response;
            })
            .catch(() => {
                // Si la red no está disponible, servir desde la caché
                return caches.match(event.request).then((cachedResponse) => {
                    // Si no se encuentra el archivo, mostrar offline.html
                    return (
                        cachedResponse || caches.match("./offline.html")
                    );
                });
            })
    );
});

// Actualizar el caché y limpiar versiones antiguas
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
