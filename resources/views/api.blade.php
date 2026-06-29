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
            <h2>Cotizaciones de Hoy</h2>
            @if($todayUfv || $todayDolar)
                <p>Fecha de cotización mostrada: 
                    <strong>{{ $todayUfv ? $todayUfv->fecha : ($todayDolar ? $todayDolar->fecha : '') }}</strong>
                </p>
                <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
                    @if($todayUfv)
                        <div style="flex: 1; min-width: 200px; border: 1px solid #e5e7eb; border-radius: 6px; padding: 1rem; background-color: #f8fafc;">
                            <h3 style="margin-top: 0; font-size: 1.1rem; color: #111827;">Unidad de Fomento de Vivienda (UFV)</h3>
                            <span style="font-size: 1.5rem; font-weight: bold; color: #1d4ed8;">{{ $todayUfv->valor }}</span>
                        </div>
                    @endif
                    @if($todayDolar)
                        <div style="flex: 1; min-width: 200px; border: 1px solid #e5e7eb; border-radius: 6px; padding: 1rem; background-color: #f8fafc;">
                            <h3 style="margin-top: 0; font-size: 1.1rem; color: #111827;">Dólar Oficial</h3>
                            <div style="display: flex; gap: 1.5rem;">
                                <div>
                                    <span style="font-size: 0.85rem; color: #6b7280; display: block;">Compra</span>
                                    <span style="font-size: 1.5rem; font-weight: bold; color: #1f2937;">{{ $todayDolar->precio_compra }}</span>
                                </div>
                                <div style="border-left: 1px solid #e5e7eb; padding-left: 1.5rem;">
                                    <span style="font-size: 0.85rem; color: #6b7280; display: block;">Venta</span>
                                    <span style="font-size: 1.5rem; font-weight: bold; color: #1f2937;">{{ $todayDolar->precio_venta }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <p>No hay cotizaciones registradas actualmente.</p>
            @endif
        </section>

        <section>
            <h2>Información Histórica</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
                <div>
                    <h3 style="font-size: 1.1rem; margin-top: 0; border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; color: #111827;">Historial UFV (Últimos 10 días)</h3>
                    @if($historicalUfvs->isNotEmpty())
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
                            <thead>
                                <tr style="border-bottom: 1px solid #e5e7eb; color: #4b5563;">
                                    <th style="padding: 0.5rem 0;">Fecha</th>
                                    <th style="padding: 0.5rem 0; text-align: right;">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historicalUfvs as $ufv)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 0.5rem 0;">{{ $ufv->fecha }}</td>
                                        <td style="padding: 0.5rem 0; text-align: right; font-family: monospace; font-weight: 500; color: #111827;">{{ $ufv->valor }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay datos de UFV registrados.</p>
                    @endif
                </div>
                <div>
                    <h3 style="font-size: 1.1rem; margin-top: 0; border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; color: #111827;">Historial Dólar (Últimos 10 días)</h3>
                    @if($historicalDolars->isNotEmpty())
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
                            <thead>
                                <tr style="border-bottom: 1px solid #e5e7eb; color: #4b5563;">
                                    <th style="padding: 0.5rem 0;">Fecha</th>
                                    <th style="padding: 0.5rem 0; text-align: right;">Compra</th>
                                    <th style="padding: 0.5rem 0; text-align: right;">Venta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historicalDolars as $dolar)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 0.5rem 0;">{{ $dolar->fecha }}</td>
                                        <td style="padding: 0.5rem 0; text-align: right; font-family: monospace; font-weight: 500; color: #111827;">{{ $dolar->precio_compra }}</td>
                                        <td style="padding: 0.5rem 0; text-align: right; font-family: monospace; font-weight: 500; color: #111827;">{{ $dolar->precio_venta }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay datos de Dólar registrados.</p>
                    @endif
                </div>
            </div>
        </section>

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
                <li><code>GET /api/ufv?per_page=30</code></li>
                <li><code>GET /api/ufv/{YYYY-MM-DD}</code></li>
                <li><code>GET /api/ufv/get-month/{YYYY-MM}</code></li>
                <li><code>GET /api/ufv/get-year/{YYYY}</code></li>
            </ul>

            <h4>Dólar</h4>
            <ul>
                <li><code>GET /api/dolar?per_page=30</code></li>
                <li><code>GET /api/dolar/{YYYY-MM-DD}</code></li>
                <li><code>GET /api/dolar/get-month/{YYYY-MM}</code></li>
                <li><code>GET /api/dolar/get-year/{YYYY}</code></li>
            </ul>

            <h4>Dólar Referencial</h4>
            <ul>
                <li><code>GET /api/dolar-ref?per_page=30</code></li>
                <li><code>GET /api/dolar-ref/{YYYY-MM-DD}</code></li>
                <li><code>GET /api/dolar-ref/get-month/{YYYY-MM}</code></li>
                <li><code>GET /api/dolar-ref/get-year/{YYYY}</code></li>
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
