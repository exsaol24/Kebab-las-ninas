# Kebab-las-ninas

## Guía de instalación y ejecución en local

### 1. Requisitos previos

- **PHP 8.2 o superior**
- **Composer** (gestor de dependencias de PHP)
- **Node.js y npm** (para dependencias frontend)
- **Symfony CLI** (para iniciar el servidor)
- **PostgreSQL** (o el gestor de base de datos que uses)

### 2. Clona el repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd Kebab-las-ni-as
```

### 3. Instala las dependencias de PHP

```bash
composer install
```

### 4. Instala las dependencias de JavaScript

```bash
npm install
```

### 5. Configura las variables de entorno

Copia el archivo `.env` de ejemplo (si existe) o crea uno nuevo. Configura la variable `DATABASE_URL` con los datos de tu base de datos local.

Ejemplo:
```
DATABASE_URL="postgresql://usuario:contraseña@localhost:5432/nombre_basedatos?serverVersion=16&charset=utf8"
```

### 6. Importa la base de datos

Te proporcionarán un archivo `.sql` con la estructura y datos de la base de datos. Importe ese archivo en tu gestor de base de datos:

```bash
psql -U usuario -d nombre_basedatos -f en nuestro caso es kebablasninasdefinitivo.sql
```

### 7. Compila los assets frontend

Para desarrollo:
```bash
npm run dev
```

Para producción:
```bash
npm run build
```

### 8. Inicia el servidor de Symfony

```bash
symfony serve -d
```

### 9. Accede a la aplicación

Abre tu navegador y entra a:
```
http://localhost:8000
```

---

Si tienes dudas, revisa la documentación de Symfony o contacta con el responsable del proyecto.
# Kebab-las-ninas

## Guía de instalación y ejecución en Ubuntu Server (MySQL + Apache)

### 1. Requisitos previos

- **Ubuntu Server 22.04 o superior**
- **PHP 8.2 o superior**
- **Composer** (gestor de dependencias de PHP)
- **Node.js y npm** (para dependencias frontend)
- **Symfony CLI** (opcional, para desarrollo)
- **MySQL Server**
- **Apache2**

Instala los requisitos:
```bash
sudo apt update
sudo apt install apache2 php php-cli php-mysql php-xml php-mbstring php-intl php-curl php-zip unzip composer nodejs npm mysql-server
```

### 2. Clona el repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd Kebab-las-ni-as
```

### 3. Instala las dependencias de PHP

```bash
composer install
```

### 4. Instala las dependencias de JavaScript

```bash
npm install
```

### 5. Configura las variables de entorno

Copia el archivo `.env` de ejemplo (si existe) o crea uno nuevo. Configura la variable `DATABASE_URL` con los datos de tu base de datos MySQL.

Ejemplo:
```
DATABASE_URL="mysql://usuario:contraseña@127.0.0.1:3306/nombre_basedatos?serverVersion=8.0&charset=utf8mb4"
```

### 6. Importa la base de datos

Crea la base de datos y un usuario en MySQL:
```bash
sudo mysql -u root -p
CREATE DATABASE nombre_basedatos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'usuario'@'localhost' IDENTIFIED BY 'contraseña';
GRANT ALL PRIVILEGES ON nombre_basedatos.* TO 'usuario'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```
Importa el archivo `.sql`:
```bash
mysql -u usuario -p nombre_basedatos <en nuestro caso es kebablasninasdefinitivo.sql
```

### 7. Compila los assets frontend

Para desarrollo:
```bash
npm run dev
```

Para producción:
```bash
npm run build
```

### 8. Configura Apache

Crea un VirtualHost para tu proyecto. Ejemplo:
```apache
<VirtualHost *:80>
    ServerName tu-dominio-o-ip
    DocumentRoot /ruta/absoluta/a/Kebab-las-ni-as/public

    <Directory /ruta/absoluta/a/Kebab-las-ni-as/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/kebab-error.log
    CustomLog ${APACHE_LOG_DIR}/kebab-access.log combined
</VirtualHost>
```
Habilita el sitio y el módulo rewrite:
```bash
sudo a2enmod rewrite
sudo a2ensite tu-sitio.conf
sudo systemctl reload apache2
```

### 9. Accede a la aplicación

Abre tu navegador y entra a:
```
http://<IP_DE_TU_SERVIDOR>/
```

---

Si tienes dudas, revisa la documentación de Symfony o contacta con el responsable del proyecto.