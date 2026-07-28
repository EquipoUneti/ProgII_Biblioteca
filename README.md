# 📚 BibliotecaHub - Sistema de Control de Existencias (Inventario)

BibliotecaHub es un sistema web premium diseñado en Laravel para facilitar la gestión del catálogo de libros y el control preciso de existencias mediante transacciones seguras de entradas y salidas de inventario.

---

## 🛠️ Requisitos Previos

Antes de comenzar, asegúrate de tener instalado en tu equipo:
- **PHP** (versión 8.1 o superior)
- **Composer** (gestor de dependencias de PHP)
- **Git** (opcional, para control de versiones)

---

## 🚀 Guía de Instalación Rápida (Con base de datos local SQLite)

Sigue estos sencillos pasos en tu terminal (PowerShell o CMD) para levantar el proyecto desde cero:

### 1. Descargar Dependencias de Laravel
Instala todas las librerías del framework ejecutando:
```bash
composer install
```

### 2. Configurar la Base de Datos SQLite
Para que no necesites configurar MySQL, el sistema viene preconfigurado para usar SQLite. Asegúrate de tener el archivo de base de datos creado:

- **En Windows (PowerShell):**
  ```powershell
  New-Item -Path "database\database.sqlite" -ItemType File -Force
  ```
- **En Mac/Linux:**
  ```bash
  touch database/database.sqlite
  ```

*Nota: El archivo `.env` ya viene configurado con `DB_CONNECTION=sqlite` por defecto.*

### 3. Generar la Clave Única de Seguridad
Crea la clave de cifrado de la aplicación ejecutando:
```bash
php artisan key:generate
```

### 4. Crear las Tablas de la Base de Datos (Migraciones)
Genera la estructura de tablas para libros y movimientos ejecutando:
```bash
php artisan migrate
```

---

## 💻 Ejecución del Sistema

Para levantar el servidor de desarrollo local y acceder al panel de control:

1. Ejecuta el servidor:
   ```bash
   php artisan serve
   ```
2. Abre tu navegador e ingresa a la siguiente dirección:
   **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 📖 Funcionalidades Principales

1. **Gestión de Libros (Catálogo):** CRUD completo para añadir, listar, actualizar o eliminar libros con validación única de código ISBN.
2. **Entradas y Salidas de Stock:** 
   - Registro de entradas (incrementa el stock).
   - Registro de salidas (disminuye el stock).
3. **Consistencia Transaccional:** La aplicación utiliza transacciones de base de datos (`DB::transaction()`) combinadas con bloqueos de fila (`lockForUpdate()`) para garantizar que **el stock de un libro nunca disminuya a menos de cero**, bloqueando cualquier salida si no hay suficientes unidades disponibles.
