# 📘 API de cotizaciones

**UFV · Dólar · Dólar Referencial**
Laravel 12

## 1. Descripción General

Esta API provee endpoints REST para la gestión y consulta de **indicadores económicos diarios**:

* **UFV (Unidad de Fomento de Vivienda)**
* **Dólar**
* **Dólar Referencial**

Permite:

* CRUD completo por fecha
* Consulta por **día**, **mes** y **año**
* Inserción masiva
* Seguridad por **API Key** para operaciones de escritura

La arquitectura sigue el patrón **Controller → Service → Model**, manteniendo la lógica de negocio desacoplada de los controladores.

---

## 2. Tecnologías

* PHP 8.3+
* Laravel 12
* Eloquent ORM
* API RESTful
* Middleware personalizado para autenticación por API Key

---

## 3. Estructura del Proyecto

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── UfvController.php
│   │   ├── DolarController.php
│   │   └── DolarRefController.php
│   ├── Middleware/
│   │   └── CheckApiKey.php
│   └── Requests/
│       ├── StoreUfvRequest.php
│       └── UpdateUfvRequest.php
│
├── Models/
│   ├── Ufv.php
│   ├── Dolar.php
│   └── DolarRef.php
│
├── Services/
│   ├── UfvService.php
│   ├── DolarService.php
│   └── DolarRefService.php
│
routes/
└── api.php
```

---

## 4. Seguridad

Las operaciones **POST, PUT y DELETE** están protegidas mediante un middleware que valida una **API Key**.

### Header requerido

```http
X-API-KEY: secreto123
```

El middleware se aplica solo a los métodos sensibles:

```php
new Middleware(CheckApiKey::class, only: ['store', 'update', 'destroy'])
```

---

## 5. Endpoints Disponibles

### Base URL

```text
http://localhost:8000/api
```

---

## 6. UFV

### 6.1 Listar todas las UFVs

```http
GET /ufv
```

### 6.2 Obtener UFV por fecha

```http
GET /ufv/{fecha}
```

Ejemplo:

```http
GET /ufv/2025-12-10
```

---

### 6.3 Crear una UFV

```http
POST /ufv
```

Headers:

```http
Content-Type: application/json
X-API-KEY: secreto123
```

Body:

```json
{
  "fecha": "2025-12-15",
  "valor": 2.50000
}
```

---

### 6.4 Crear múltiples UFVs

```http
POST /ufv
```

```json
[
  { "fecha": "2025-12-11", "valor": 2.50000 },
  { "fecha": "2025-12-12", "valor": 2.51000 }
]
```

---

### 6.5 Actualizar UFV

```http
PUT /ufv/{fecha}
```

```json
{
  "valor": 2.55000
}
```

---

### 6.6 Eliminar UFV

```http
DELETE /ufv/{fecha}
```

---

### 6.7 Obtener UFVs por día

```http
GET /ufv/obtener-day/{fecha}
```

---

### 6.8 Obtener UFVs por mes

```http
GET /ufv/obtener-month/{YYYY-MM}
```

Ejemplo:

```http
GET /ufv/obtener-month/2025-12
```

---

### 6.9 Obtener UFVs por año

```http
GET /ufv/obtener-year/{YYYY}
```

---

## 7. Dólar

Endpoints equivalentes a UFV:

```text
GET    /dolar
GET    /dolar/{fecha}
POST   /dolar
PUT    /dolar/{fecha}
DELETE /dolar/{fecha}

GET /dolar/obtener-day/{fecha}
GET /dolar/obtener-month/{YYYY-MM}
GET /dolar/obtener-year/{YYYY}
```

### Estructura de datos

```json
{
  "fecha": "2025-12-10",
  "precio_compra": 6.85,
  "precio_venta": 6.96
}
```

---

## 8. Dólar Referencial

Endpoints:

```text
GET    /dolar-ref
GET    /dolar-ref/{fecha}
POST   /dolar-ref
PUT    /dolar-ref/{fecha}
DELETE /dolar-ref/{fecha}

GET /dolar-ref/obtener-day/{fecha}
GET /dolar-ref/obtener-month/{YYYY-MM}
GET /dolar-ref/obtener-year/{YYYY}
```

---

## 9. Lógica de Negocio (Services)

Toda la lógica está encapsulada en **Services**:

* Inserción simple y masiva
* Consultas por rango temporal
* Valores por defecto cuando no existe registro (`show`)

Ejemplo:

```php
public function show($fecha): Ufv
{
    return Ufv::where('fecha', $fecha)->first()
        ?? new Ufv(['fecha' => $fecha, 'valor' => 0]);
}
```

Esto garantiza respuestas consistentes sin lanzar errores innecesarios.

---

## 10. Convenciones

* La **fecha** es la clave principal lógica (`YYYY-MM-DD`)
* Las respuestas son siempre **JSON**
* Los timestamps se gestionan automáticamente
* Inserciones masivas usan `insert()` por rendimiento

---

## 11. Pruebas Manuales

Incluye archivos `.http` compatibles con **VS Code REST Client** para pruebas rápidas:

```text
/http_requests/ufv.http
/http_requests/dolar.http
/http_requests/dolar_ref.http
```