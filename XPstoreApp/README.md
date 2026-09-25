# XP Store

Tienda web de videojuegos desarrollada con **Laravel 12** y **Vite 7 + Tailwind CSS 4**.
Precios en soles (S/.).

**Módulos**

- **Tienda pública:** catálogo de juegos y ficha de cada juego.
- **Usuario:** dashboard, perfil con avatar, carrito con cantidades, checkout, biblioteca ("Mis juegos"),
  reseñas de juegos comprados, wishlist, historial de compras, marketplace de ítems, tienda de
  códigos de streaming y comunidad (publicaciones, comentarios y likes).
- **Administración** (`/admin`): dashboard, videojuegos, usuarios, códigos de activación (individuales
  o por lotes), moderación de reseñas, ítems del marketplace, perfil del admin y configuración.

---

## Índice

1. [Requisitos del servidor](#1-requisitos-del-servidor)
2. [Estructura del proyecto](#2-estructura-del-proyecto)
3. [Despliegue en producción paso a paso](#3-despliegue-en-producción-paso-a-paso)
4. [Variables de entorno (.env)](#4-variables-de-entorno-env)
5. [Configuración del servidor web](#5-configuración-del-servidor-web)
6. [Permisos de carpetas](#6-permisos-de-carpetas)
7. [Actualizar una versión ya desplegada](#7-actualizar-una-versión-ya-desplegada)
8. [Desarrollo local](#8-desarrollo-local)
9. [Pendientes antes de producción](#9-pendientes-antes-de-producción)
10. [Solución de problemas](#10-solución-de-problemas)

---

## 1. Requisitos del servidor

| Componente | Versión mínima | Notas |
|---|---|---|
| PHP | 8.2 | Extensiones: `bcmath`, `ctype`, `curl`, `fileinfo`, `mbstring`, `openssl`, `pdo`, `pdo_mysql`, `tokenizer`, `xml` |
| Composer | 2.x | |
| Node.js | 20.19 o 22.12+ | Requerido por Vite 7. Solo se usa para compilar los assets. |
| MySQL / MariaDB | MySQL 8 / MariaDB 10.6 | **Obligatorio.** Una migración usa `ALTER TABLE ... MODIFY`, que no funciona en SQLite |
| Servidor web | Nginx o Apache | El *document root* debe apuntar a `public/` |

---

## 2. Estructura del proyecto

```
XPstoreApp/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/        # Dashboard, Videojuegos, Usuarios, GameCodes, Reseñas, Ítems, Perfil, Configuración
│   │   ├── Community/    # Publicaciones y comentarios
│   │   ├── Items/        # Marketplace
│   │   ├── Store/        # Catálogo público y reseñas
│   │   ├── Streaming/    # Tienda de códigos de streaming
│   │   └── User/         # Dashboard, Perfil, Carrito, Checkout, Biblioteca, Wishlist, Compras
│   ├── Http/Middleware/  # IsAdmin (alias "admin")
│   ├── Models/           # User, VideoGame, GameCode, Item, MarketItem, UserPurchase, Wishlist, ...
│   ├── Repositories/     # UserRepository
│   └── Services/         # AuthService
├── database/
│   ├── migrations/
│   └── seeders/          # DatabaseSeeder, MarketItemSeeder, StreamingCodesSeeder, GameCodesSeeder
├── resources/
│   ├── css/              # Un CSS por pantalla (ver vite.config.js)
│   ├── js/
│   └── views/            # Blade: admin, auth, cart, checkout, community, library, marketplace, ...
├── routes/web.php
└── vite.config.js        # Lista de entradas CSS/JS que compila Vite
```

**Roles:** la columna `users.role` acepta `admin` o `user`. Al iniciar sesión, `/dashboard`
redirige a `/dashboard/admin` o a `/dashboard/user` según el rol. Todas las rutas de
administración (`/admin/*` y `/dashboard/admin`) pasan por el middleware `admin`.

**Archivos subidos:** las imágenes de videojuegos (`videojuegos/`), los avatares (`avatars/`),
los ítems del marketplace (`market_items/`) y las imágenes de la comunidad (`posts/`) se guardan
en el disco `public` (`storage/app/public`). Por eso es obligatorio `php artisan storage:link`.

---

## 3. Despliegue en producción paso a paso

### 3.1 Clonar el repositorio

```bash
git clone https://github.com/Rony10-az/XPSTORE-app.git
cd XPSTORE-app/XPstoreApp
git checkout main
```

### 3.2 Instalar dependencias de PHP (sin paquetes de desarrollo)

```bash
composer install --no-dev --optimize-autoloader
```

### 3.3 Crear y configurar el `.env`

```bash
cp .env.example .env
php artisan key:generate
```

Edita `.env` con los valores de producción (ver [sección 4](#4-variables-de-entorno-env)).

> ⚠️ **Siempre ejecuta `php artisan key:generate`.** Versiones anteriores del `.env.example` traían
> una `APP_KEY` que quedó publicada en el historial de git. Si la reutilizas, cualquiera podría
> descifrar las cookies y las sesiones.

### 3.4 Crear la base de datos

```sql
CREATE DATABASE xpstore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'xpstore'@'localhost' IDENTIFIED BY 'una-contraseña-segura';
GRANT ALL PRIVILEGES ON xpstore.* TO 'xpstore'@'localhost';
FLUSH PRIVILEGES;
```

### 3.5 Ejecutar migraciones

```bash
php artisan migrate --force
```

Datos iniciales (opcional):

```bash
php artisan db:seed --force                              # admin, usuario demo, juegos, ítems del marketplace y códigos de streaming
php artisan db:seed --class=GameCodesSeeder --force      # 10 códigos de activación por juego
```

> ⚠️ El seeder crea el administrador `admin@xpstore.com` con contraseña `admin123` y el usuario
> `juan.perez@example.com` con contraseña `usuario123`. **Cambia esas contraseñas (o elimina el
> usuario demo) apenas termine el despliegue.**

### 3.6 Enlazar el almacenamiento público

```bash
php artisan storage:link
```

Sin este paso, las imágenes subidas desde el panel de administración y los avatares no se muestran.

### 3.7 Compilar los assets (CSS/JS)

```bash
npm ci
npm run build
```

Esto genera `public/build/` con el `manifest.json`. **La carpeta no se versiona en git**, así que
tienes que compilar en cada despliegue. Si no existe o está desactualizada, verás el error
`Unable to locate file in Vite manifest`.

> Si el servidor no tiene Node.js, compila en tu máquina y sube la carpeta `public/build/` completa.

### 3.8 Optimizar para producción

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

> Después de `config:cache`, Laravel ya no lee el `.env`. Si cambias el `.env`, vuelve a ejecutar
> `php artisan config:cache`.

### 3.9 Verificar

- `https://tu-dominio.com/up` debe responder **200**. Es el *health check* de Laravel.
- Inicia sesión como administrador y prueba subir una imagen de videojuego.
- Inicia sesión como usuario normal y comprueba que `/admin/videojuegos` responde **403**.

---

## 4. Variables de entorno (.env)

Valores mínimos para producción:

```dotenv
APP_NAME="XP Store"
APP_ENV=production
APP_KEY=                      # lo genera php artisan key:generate
APP_DEBUG=false               # NUNCA true en producción
APP_URL=https://tu-dominio.com
APP_LOCALE=es
APP_FALLBACK_LOCALE=es

LOG_CHANNEL=stack
LOG_STACK=daily
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=xpstore
DB_USERNAME=xpstore
DB_PASSWORD=una-contraseña-segura

SESSION_DRIVER=file           # ver nota abajo
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true    # solo si el sitio usa HTTPS

CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local

MAIL_MAILER=log               # cambia a smtp si se envían correos
```

| Variable | Por qué importa |
|---|---|
| `APP_DEBUG=false` | Con `true`, los errores muestran el código fuente y las credenciales del `.env` |
| `APP_URL` | La usan `asset()` y `Storage::url()` para armar las URLs de las imágenes |
| `SESSION_DRIVER=file` | El proyecto **no tiene migración de la tabla `sessions`**, así que `database` fallaría. Si quieres sesiones en BD, ejecuta primero `php artisan make:session-table && php artisan migrate --force` |
| `CACHE_STORE=file` | No existen las tablas `cache` ni `cache_locks`. Para usar `database`, ejecuta antes `php artisan make:cache-table && php artisan migrate --force` |
| `QUEUE_CONNECTION=sync` | La aplicación no despacha jobs y no existe la tabla `jobs`. Si en el futuro se agregan, ejecuta `php artisan make:queue-table`, cambia a `database` y configura un worker (Supervisor) |

---

## 5. Configuración del servidor web

### Nginx

```nginx
server {
    listen 80;
    server_name tu-dominio.com;
    root /var/www/XPSTORE-app/XPstoreApp/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;
    client_max_body_size 10M;     # tamaño máximo de las imágenes subidas

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ ^/index\.php(/|$) {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Para HTTPS con Let's Encrypt: `sudo certbot --nginx -d tu-dominio.com`.

### Apache

Apunta el `DocumentRoot` a `.../XPstoreApp/public` y habilita `mod_rewrite`
(`sudo a2enmod rewrite`). El archivo `public/.htaccess` ya viene incluido.

```apache
<VirtualHost *:80>
    ServerName tu-dominio.com
    DocumentRoot /var/www/XPSTORE-app/XPstoreApp/public

    <Directory /var/www/XPSTORE-app/XPstoreApp/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Hosting compartido (cPanel)

Si no puedes cambiar el *document root*, sube el proyecto fuera de `public_html` y apunta el
dominio (o un subdominio) a la carpeta `XPstoreApp/public`. **No expongas la raíz del proyecto**,
porque el `.env` quedaría accesible desde el navegador.

---

## 6. Permisos de carpetas

El usuario del servidor web (por ejemplo, `www-data`) necesita escribir en `storage/` y en
`bootstrap/cache/`:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

---

## 7. Actualizar una versión ya desplegada

```bash
cd /var/www/XPSTORE-app/XPstoreApp
php artisan down

git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm ci && npm run build

php artisan optimize:clear
php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan event:cache

php artisan up
```

---

## 8. Desarrollo local

```bash
composer install
cp .env.example .env
php artisan key:generate
# crea la base "xpstore" en MySQL y ajusta DB_USERNAME / DB_PASSWORD en .env
php artisan migrate --seed
php artisan storage:link
npm install

composer run dev     # levanta servidor, cola, logs y Vite a la vez
```

La app queda en `http://127.0.0.1:8000`.

**Al crear un CSS o JS nuevo:** agrégalo al arreglo `input` de `vite.config.js` y cárgalo en la
vista con `@vite([...])`, respetando mayúsculas y minúsculas en la ruta (por ejemplo,
`resources/css/User/...`, no `user/...`).

---

## 9. Pendientes antes de producción

Estos puntos se detectaron al revisar el código y todavía no están resueltos:

| Prioridad | Problema | Dónde | Solución sugerida |
|---|---|---|---|
| 🔴 Alta | Credenciales demo conocidas (`admin123`, `usuario123`) | `DatabaseSeeder` | Cambiarlas apenas termine el seed, o no ejecutar el seeder en producción y crear el admin a mano |
| 🟡 Baja | No existen las tablas `sessions`, `cache` ni `jobs` | `database/migrations` | Usar los drivers `file`/`sync` (ver [sección 4](#4-variables-de-entorno-env)) o crear las tablas con `make:session-table`, `make:cache-table` y `make:queue-table` |
| 🟡 Baja | Las relaciones `purchasedGames()` y `gamesInCart()` del modelo `User` apuntan a las tablas `library_items` y `cart_items`, que no existen. Hoy no se usan | `app/Models/User.php` | Eliminarlas o reemplazarlas por relaciones con `user_purchases` |
| 🟡 Baja | Las páginas "Mis compras" y "Configuración" no tienen CSS propio y se ven solo con los estilos del layout | `resources/views/user/` | Crear `purchases.css` y `settings.css`, y agregarlos a `vite.config.js` |

**Ya corregidos:** el CRUD de videojuegos y `/dashboard/admin` ahora exigen el rol `admin`;
`.env.example` ya no trae `APP_KEY`; el build de Vite incluye todos los CSS/JS; y el seeder ya no
duplica los ítems del marketplace.

---

## 10. Solución de problemas

| Error | Causa | Solución |
|---|---|---|
| `Unable to locate file in Vite manifest: resources/css/...` | Falta `public/build/`, está desactualizado o el archivo no está en `vite.config.js` | `npm run build`. Revisa también que la ruta en `@vite()` coincida exactamente, incluidas mayúsculas y minúsculas |
| Las imágenes subidas dan 404 | Falta el enlace simbólico | `php artisan storage:link` y revisar `APP_URL` |
| `500 Server Error` sin detalle | `APP_DEBUG=false` oculta el error | Revisar `storage/logs/laravel.log` |
| `No application encryption key has been specified` | Falta `APP_KEY` | `php artisan key:generate` y luego `php artisan config:cache` |
| `The stream or file ".../laravel.log" could not be opened` | Permisos | Ver [sección 6](#6-permisos-de-carpetas) |
| `Table 'sessions'` / `'cache'` / `'jobs' doesn't exist` | Driver `database` sin su tabla | Usar `SESSION_DRIVER=file`, `CACHE_STORE=file`, `QUEUE_CONNECTION=sync` o crear las tablas (ver [sección 4](#4-variables-de-entorno-env)) |
| `near "MODIFY": syntax error` al migrar | Se está usando SQLite | El proyecto requiere MySQL/MariaDB |
| `403 Acceso solo para administradores` | El usuario no tiene `role = admin` | Cambiar el rol en la tabla `users` |
| Los cambios del `.env` no se aplican | La configuración está cacheada | `php artisan config:cache` |
| `419 Page Expired` al enviar formularios | Sesión expirada o `SESSION_DOMAIN` / `APP_URL` incorrectos | Revisar el dominio y HTTPS (`SESSION_SECURE_COOKIE`) |

---

## Equipo

Proyecto del curso **Desarrollo de Aplicaciones en Internet**, Tecsup, 3.er ciclo (2025-2).
