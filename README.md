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

Obtiene un listado paginado de UFVs, ordenado por fecha descendente.

```http
GET /ufv?per_page=25
```

Parámetros opcionales:

| Parámetro | Tipo | Descripción | Default | Min | Max |
|---|---|---|---|---|---|
| `per_page` | int | Cantidad de registros por página | 25 | 1 | 100 |

Respuesta Paginada (LengthAwarePaginator):

```json
{
    "current_page": 1,
    "data": [
        { "fecha": "2025-12-15", "valor": 2.51000 },
        { "fecha": "2025-12-14", "valor": 2.50800 }
    ],
    "first_page_url": "http://localhost:8000/api/ufv?page=1",
    "from": 1,
    "last_page": 10,
    "last_page_url": "http://localhost:8000/api/ufv?page=10",
    "links": [ ... ],
    "next_page_url": "http://localhost:8000/api/ufv?page=2",
    "path": "http://localhost:8000/api/ufv",
    "per_page": 25,
    "prev_page_url": null,
    "to": 25,
    "total": 300
}
```

### 6.2 Obtener UFV por fecha

```http
GET /ufv/{YYYY-MM-DD}
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
PUT /ufv/{YYYY-MM-DD}
```

```json
{
  "valor": 2.55000
}
```

---

### 6.6 Eliminar UFV

```http
DELETE /ufv/{YYYY-MM-DD}
```

---

### 6.8 Obtener UFVs por mes

```http
GET /ufv/get-month/{YYYY-MM}
```

Ejemplo:

```http
GET /ufv/get-month/2025-12
```

---

### 6.9 Obtener UFVs por año

```http
GET /ufv/get-year/{YYYY}
```

---

## 7. Dólar

Endpoints equivalentes a UFV:

```text
GET    /dolar
GET    /dolar/{YYYY-MM-DD}
POST   /dolar
PUT    /dolar/{YYYY-MM-DD}
DELETE /dolar/{YYYY-MM-DD}

GET /dolar/get-month/{YYYY-MM}
GET /dolar/get-year/{YYYY}
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
GET    /dolar-ref/{YYYY-MM-DD}
POST   /dolar-ref
PUT    /dolar-ref/{YYYY-MM-DD}
DELETE /dolar-ref/{YYYY-MM-DD}

GET /dolar-ref/get-month/{YYYY-MM}
GET /dolar-ref/get-year/{YYYY}
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
* Inserciones masivas usan upsert() para actualizar en caso de conflicto por fecha

---

## 11. Pruebas Manuales

Incluye archivos `.http` compatibles con **VS Code REST Client** para pruebas rápidas:

```text
/http_requests/ufv.http
/http_requests/dolar.http
/http_requests/dolar_ref.http
```