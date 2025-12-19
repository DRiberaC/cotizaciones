<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>API de Cotizaciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #f8fafc;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #111827;
            color: #ffffff;
            padding: 2rem;
        }

        main {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        h1,
        h2 {
            margin-top: 0;
        }

        section {
            background: #ffffff;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
        }

        code {
            background: #f1f5f9;
            padding: .25rem .5rem;
            border-radius: 4px;
            display: inline-block;
            margin: .25rem 0;
        }

        ul {
            padding-left: 1.2rem;
        }

        a.repo-link {
            display: inline-block;
            margin-top: 0.5rem;
            padding: 0.5rem 0.75rem;
            background-color: #f1f5f9;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            color: #1d4ed8;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        a.repo-link:hover {
            background-color: #e0e7ff;
            border-color: #c7d2fe;
            color: #1e3a8a;
        }

        footer {
            text-align: center;
            color: #6b7280;
            padding: 2rem 1rem;
            font-size: .9rem;
        }
    </style>
</head>

<body>

    <header>
        <h1>API de Cotizaciones</h1>
        <p>UFV · Dólar · Dólar Referencial</p>
    </header>

    <main>

        <section>
            <h2>Descripción</h2>
            <p>
                Esta API proporciona acceso REST a indicadores económicos diarios,
                permitiendo consultar y administrar valores de:
            </p>
            <ul>
                <li>Unidad de Fomento de Vivienda (UFV)</li>
                <li>Dólar</li>
                <li>Dólar Referencial</li>
            </ul>
            <p>
                Desarrollada en <strong>Laravel 12</strong>, con arquitectura basada en
                servicios y controladores.
            </p>
        </section>

        <section>
            <h2>Base URL</h2>
            <code>{{ url('/api') }}</code>
        </section>

        <section>
            <h2>Endpoints Principales</h2>

            <h4>UFV</h4>
            <ul>
                <li><code>GET /api/ufv</code></li>
                <li><code>GET /api/ufv/{fecha}</code></li>
                <li><code>GET /api/ufv/obtener-day/{fecha}</code></li>
                <li><code>GET /api/ufv/obtener-month/{YYYY-MM}</code></li>
                <li><code>GET /api/ufv/obtener-year/{YYYY}</code></li>
            </ul>

            <h4>Dólar</h4>
            <ul>
                <li><code>GET /api/dolar</code></li>
                <li><code>GET /api/dolar/{fecha}</code></li>
                <li><code>GET /api/dolar/obtener-day/{fecha}</code></li>
                <li><code>GET /api/dolar/obtener-month/{YYYY-MM}</code></li>
                <li><code>GET /api/dolar/obtener-year/{YYYY}</code></li>
            </ul>

            <h4>Dólar Referencial</h4>
            <ul>
                <li><code>GET /api/dolar-ref</code></li>
                <li><code>GET /api/dolar-ref/{fecha}</code></li>
                <li><code>GET /api/dolar-ref/obtener-day/{fecha}</code></li>
                <li><code>GET /api/dolar-ref/obtener-month/{YYYY-MM}</code></li>
                <li><code>GET /api/dolar-ref/obtener-year/{YYYY}</code></li>
            </ul>
        </section>

        <section>
            <h2>Seguridad</h2>
            <p>
                Las operaciones de creación, actualización y eliminación
                requieren autenticación mediante API Key.
            </p>
            <code>X-API-KEY: ********</code>
        </section>

        <section>
            <h2>Documentación</h2>
            <p>
                La documentación completa de la API, incluyendo descripción de endpoints,
                ejemplos de request/response, validaciones y configuración de seguridad,
                se encuentra disponible en el repositorio oficial del proyecto.
            </p>

            <a href="https://github.com/DRiberaC/cotizaciones" class="repo-link" target="_blank" rel="noopener">
                Ver repositorio en GitHub
            </a>

            <p style="margin-top: 0.75rem;">
                Consulte el archivo <strong>README.md</strong> para más detalles sobre el uso e implementación.
            </p>
        </section>


    </main>

    <footer>
        API de Cotizaciones
    </footer>

</body>

</html>
