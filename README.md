# 🏍️ Tienda de Motos - Sistema de Login

Bienvenido al proyecto **admin_motos**, una aplicación web sencilla que permite a los usuarios iniciar sesión para explorar, agregar o comprar motocicletas. Este proyecto simula una tienda en línea de motos con autenticación básica de usuarios.

## 🚀 Funcionalidades

* Registro e inicio de sesión de usuarios.
* Catálogo de motos con imagen, precio y descripción.
* Búsqueda de motos por nombre o categoría.
* Simulación de carrito de compras.
* Sistema básico de administración (opcional).

## 🔐 ¿Cómo funciona el login?

El sistema de autenticación funciona de la siguiente manera:

1. El usuario se registra proporcionando su correo y contraseña.
2. Los datos se almacenan en una base de datos (por ejemplo, MySQL o SQLite).
3. Al iniciar sesión, se verifica que los datos coincidan con los de la base.
4. Si los datos son correctos, el usuario es redirigido al catálogo de motos.
5. Si los datos son incorrectos, se muestra un mensaje de error.

> La contraseña puede ser almacenada en forma encriptada (ej. usando bcrypt) para mayor seguridad.

## 🧰 Tecnologías usadas

* Frontend: HTML, CSS, JavaScript
* Backend: PHP / Node.js / Python Flask (según lo que uses)
* Base de datos: MySQL / SQLite
* Control de versiones: Git

## 📦 Instalación

1. Clona el repositorio:

   ```bash
   git clone https://github.com/tuusuario/admin_motos.git
   cd admin_motos
Instala las dependencias necesarias (dependiendo del backend que uses):

Si usas PHP:
Asegúrate de tener un servidor como XAMPP o Laragon. Coloca los archivos en la carpeta htdocs y arranca Apache y MySQL.

Si usas Node.js:
bash
Copiar
Editar
npm install
node app.js
Si usas Python Flask:
bash
Copiar
Editar
pip install -r requirements.txt
python app.py
Crea la base de datos (MySQL o SQLite):

Puedes usar un script SQL proporcionado (database.sql) para crear las tablas necesarias.

Asegúrate de configurar las credenciales de conexión en el archivo de configuración del backend.

Accede desde tu navegador:
Copiar
Editar
http://localhost:puerto

📁 Estructura del proyecto

Copiar

Editar

admin_motos/

├── backend/# Código del servidor (PHP/Node/Flask)

├── frontend/# Archivos HTML, CSS y JS

├── database/          # Scripts y archivos de base de datos

├── images/            # Imágenes de las motos

└── README.md

✅ Pendientes y mejoras
Validación avanzada en el formulario de login/registro.

Implementación de roles (usuario/admin).

Historial de compras.

Integración de pagos simulada o real.

Diseño responsive para móviles.

📄 Licencia
Este proyecto es de código abierto y puede ser utilizado con fines educativos o comerciales según la licencia MIT.

yaml
Copiar
Editar

---



