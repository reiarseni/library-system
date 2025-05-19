# Sistema de Gestión de Biblioteca

Este sistema de gestión de biblioteca es una aplicación web completa desarrollada con Laravel, diseñada para optimizar todas las operaciones de una biblioteca moderna. Ofrece una interfaz intuitiva y atractiva para administrar libros, autores, géneros, préstamos y usuarios con diferentes niveles de acceso.

<!-- Imagen del sistema -->

## Características Principales

### Gestión de Libros
- Catálogo completo con información detallada de cada libro
- Seguimiento en tiempo real de copias disponibles
- Asociación con múltiples autores y géneros
- Búsqueda avanzada con filtros por autor, género y disponibilidad
- Visualización de estado de disponibilidad con indicadores de color

### Gestión de Préstamos
- Registro de préstamos y devoluciones
- Historial completo de préstamos por libro y usuario
- Control automático de disponibilidad de libros
- Validación para evitar préstamos de libros no disponibles

### Sistema de Usuarios y Roles
- Dos roles principales: Administrador y Usuario
- Panel de administración exclusivo para administradores
- Interfaz de usuario adaptada según el rol
- Protección de rutas basada en roles

### Panel de Administración (Filament)
- Gestión completa de usuarios y roles
- Administración de libros, autores, géneros y racks
- Estadísticas y reportes de préstamos
- Interfaz moderna y responsive

### Interfaz de Usuario
- Diseño moderno y responsive con Bootstrap 5
- Navegación intuitiva con indicadores visuales
- Búsqueda de libros en tiempo real
- Dashboard personalizado con accesos rápidos

## Tecnologías Utilizadas

- **Backend**: Laravel 10.x
- **Frontend**: Bootstrap 5, Livewire, Alpine.js
- **Admin Panel**: Filament
- **Base de Datos**: MySQL/PostgreSQL
- **Autenticación**: Laravel Breeze

## Estructura del Sistema

- **Modelos**: Book, Author, Genre, Borrow, BorrowBook, Rack, User
- **Componentes Livewire**: BookSearch para búsqueda reactiva
- **Middleware**: CheckRole para control de acceso basado en roles
- **Vistas**: Layouts, dashboard, búsqueda, errores personalizados

## Capturas de Pantalla

### Dashboard
<!-- Captura de pantalla del dashboard -->

### Búsqueda de Libros
<!-- Captura de pantalla de la búsqueda de libros -->

### Panel de Administración
<!-- Captura de pantalla del panel de administración -->

## Guía de Implementación en Producción

### 1. Requisitos del Servidor

- PHP 8.1 o superior
- Composer 2.0 o superior
- MySQL 8.0 o PostgreSQL 13.0 o superior
- Servidor web (Apache/Nginx)
- Extensiones PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- Mínimo 2GB de RAM

### 2. Preparación del Entorno

```bash
# Clonar el repositorio
git clone https://github.com/reiarseni/library-system.git
cd library-system

# Instalar dependencias
composer install --optimize-autoloader --no-dev

# Configurar variables de entorno
cp .env.example .env
```

### 3. Configuración del Archivo .env

```
APP_NAME="Sistema de Gestión de Biblioteca"
APP_ENV=production
APP_KEY=base64:tu-clave-generada
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario_db
DB_PASSWORD=contraseña_segura

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=smtp.tu-proveedor.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@dominio.com
MAIL_PASSWORD=tu-contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=biblioteca@tu-dominio.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Generación de Clave de Aplicación

```bash
php artisan key:generate
```

### 5. Configuración de la Base de Datos

```bash
# Ejecutar migraciones
php artisan migrate --force

# Cargar datos iniciales
php artisan db:seed
```

### 6. Optimización para Producción

```bash
# Optimizar la aplicación
php artisan optimize
php artisan view:cache
php artisan route:cache
php artisan config:cache

# Compilar assets con Vite
npm install
npm run build
```

### 7. Configuración del Servidor Web

#### Para Nginx:

```nginx
server {
    listen 80;
    server_name tu-dominio.com www.tu-dominio.com;
    root /ruta/a/library-system/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.png { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### Para Apache (archivo .htaccess ya incluido en /public)

### 8. Configuración de Permisos

```bash
# Establecer permisos adecuados
chown -R www-data:www-data /ruta/a/library-system
chmod -R 755 /ruta/a/library-system
chmod -R 775 /ruta/a/library-system/storage
chmod -R 775 /ruta/a/library-system/bootstrap/cache
```

### 9. Configuración de HTTPS (Recomendado)

```bash
# Instalar Certbot para Let's Encrypt
sudo apt-get update
sudo apt-get install certbot python3-certbot-nginx

# Obtener certificado SSL
sudo certbot --nginx -d tu-dominio.com -d www.tu-dominio.com
```

### 10. Programar Tareas Cron

Añadir al crontab del servidor:

```
* * * * * cd /ruta/a/library-system && php artisan schedule:run >> /dev/null 2>&1
```

### 11. Configuración de Respaldos

```bash
# Configurar respaldos automáticos
php artisan backup:run

# Programar respaldos diarios (añadir a config/backup.php)
```

### 12. Usuarios Iniciales

Después de la instalación, podrás acceder con los siguientes usuarios:

- **Administrador:**
  - Email: admin@biblioteca.com
  - Contraseña: password123
  - Rol: admin

- **Usuario Regular:**
  - Email: user@biblioteca.com
  - Contraseña: password123
  - Rol: user

### 13. Verificación Final

1. Acceder a https://tu-dominio.com/login
2. Iniciar sesión con las credenciales de administrador
3. Verificar acceso al panel de administración en /admin
4. Comprobar la búsqueda de libros y otras funcionalidades
5. Verificar que los usuarios con rol "user" no puedan acceder a /admin

### 14. Mantenimiento

```bash
# Actualizar dependencias periódicamente
composer update --optimize-autoloader --no-dev

# Limpiar caché cuando sea necesario
php artisan optimize:clear

# Monitorear logs
tail -f storage/logs/laravel.log
```

## Soporte y Contribuciones

Para reportar problemas o contribuir al desarrollo, por favor crea un issue en el repositorio GitHub o contacta al equipo de desarrollo.

## Comando rápido para inicializar la base de datos

```bash
php artisan migrate:fresh --seed
```

## Credenciales de acceso

### Administrador:
- Email: admin@biblioteca.com
- Contraseña: password123
- Rol: admin

### Usuario Regular:
- Email: user@biblioteca.com
- Contraseña: password123
- Rol: user
  
## Licencia

Este proyecto está licenciado bajo [MIT License](LICENSE).

## Referencias

### Instalar composer
https://www.hostinger.com/es/tutoriales/como-instalar-composer


### Instalar Nodejs en Ubuntu
https://www.hostinger.com/es/tutoriales/instalar-node-js-ubuntu/#Consejos_para_utilizar_Nodejs_en_Ubuntu
