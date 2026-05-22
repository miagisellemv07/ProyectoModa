<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BitCorp API | Documentación Oficial</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --sidebar-bg: #ffffff;
            --content-bg: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --code-bg: #1e293b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--content-bg);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* Lateral Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            width: 280px;
            padding: 0;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .brand-logo {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .nav-links {
            padding: 1.5rem 0;
        }

        .nav-link {
            padding: 0.75rem 1.5rem;
            color: var(--text-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background-color: #f1f5f9;
        }

        .nav-link.active {
            color: var(--primary-color);
            background-color: #eef2ff;
            border-left-color: var(--primary-color);
        }

        /* Main Content */
        main {
            margin-left: 280px;
            padding: 2rem 3rem;
            min-height: 100vh;
        }

        .doc-section {
            padding-top: 4rem;
            margin-top: -2rem;
            margin-bottom: 4rem;
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Badges */
        .badge-method {
            padding: 0.4rem 0.8rem;
            font-weight: 700;
            font-size: 0.75rem;
            border-radius: 6px;
            text-transform: uppercase;
            min-width: 70px;
            text-align: center;
        }

        .badge-get { background-color: #dcfce7; color: #166534; }
        .badge-post { background-color: #dbeafe; color: #1e40af; }
        .badge-put { background-color: #fef9c3; color: #854d0e; }
        .badge-delete { background-color: #fee2e2; color: #991b1b; }

        /* API Cards */
        .api-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .api-header {
            padding: 1.25rem 1.5rem;
            background-color: #fff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .api-endpoint {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.95rem;
        }

        .api-body {
            padding: 1.5rem;
        }

        .code-block-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #2d2d2d;
            padding: 0.5rem 1rem;
            border-radius: 8px 8px 0 0;
            color: #ccc;
            font-size: 0.8rem;
            font-weight: 500;
        }

        pre[class*="language-"] {
            margin-top: 0 !important;
            border-radius: 0 0 8px 8px !important;
            font-size: 0.85rem !important;
        }

        /* Glassmorphism utility */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            .sidebar:hover {
                width: 280px;
            }
            main {
                margin-left: 70px;
                padding: 2rem 1.5rem;
            }
            .nav-link span {
                display: none;
            }
            .sidebar:hover .nav-link span {
                display: inline;
            }
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="brand-logo">
                <i class="bi bi-cpu-fill"></i>
                <span>BitCorp API</span>
            </a>
        </div>
        <div class="nav-links">
            <a href="#intro" class="nav-link active">
                <i class="bi bi-house-door"></i>
                <span>Introducción</span>
            </a>
            <div class="px-4 py-2 small text-uppercase text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 0.05rem;">
                Endpoints de Usuario
            </div>
            <a href="#post-register" class="nav-link">
                <i class="bi bi-person-plus"></i>
                <span>Registrar Usuario</span>
            </a>
            <a href="#post-login" class="nav-link">
                <i class="bi bi-shield-lock"></i>
                <span>Autenticación (Login)</span>
            </a>
            <a href="#get-user" class="nav-link">
                <i class="bi bi-person-badge"></i>
                <span>Ver Perfil</span>
            </a>
            <a href="#put-user" class="nav-link">
                <i class="bi bi-pencil-square"></i>
                <span>Actualizar Cuenta</span>
            </a>
            <a href="#get-suscripciones" class="nav-link">
    <i class="bi bi-list-check"></i>
    <span>Listar Suscripciones</span>
</a>
            <a href="#delete-user" class="nav-link">
                <i class="bi bi-person-x"></i>
                <span>Eliminar Cuenta</span>
            </a>
            <a href="#put-tienda" class="nav-link">
    <i class="bi bi-pencil-square"></i>
    <span>Actualizar Tienda</span>
</a>
            <a href="#post-tienda" class="nav-link">
    <i class="bi bi-shop"></i>
    <span>Registrar Tienda</span>
</a>
            <div class="px-4 py-2 mt-3 small text-uppercase text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 0.05rem;">
                Guía de Errores
            </div>
            <a href="#errors" class="nav-link">
                <i class="bi bi-exclamation-triangle"></i>
                <span>Formatos de Error</span>
            </a>
        </div>
    </nav>

    <main>
        <div class="container-fluid">
            
            <section id="intro" class="doc-section">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="display-6 fw-bold mb-4">Documentación de la API</h1>
                        <p class="lead text-muted">
                            Bienvenido a la documentación técnica de <strong>BitCorp</strong>. Nuestra API está diseñada bajo los estándares RESTful, utilizando JWT para la autenticación y JSON para el intercambio de datos.
                        </p>
                        <div class="alert alert-info border-0 shadow-sm glass">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Todas las peticiones deben incluir el header <code>Accept: application/json</code>.
                        </div>
                    </div>
                </div>
            </section>

            <hr class="my-5 border-secondary-subtle">

            <section id="post-register" class="doc-section">
                <h2 class="section-title"><i class="bi bi-person-plus-fill text-primary"></i>Registrar Usuario</h2>
                <div class="api-card">
                    <div class="api-header">
                        <span class="badge-method badge-post">POST</span>
                        <span class="api-endpoint">/api/users</span>
                    </div>
                    <div class="api-body">
                        <p>Crea una nueva cuenta de usuario en el sistema.</p>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Request Body</h6>
                                <div class="code-block-header">JSON Payload</div>
                                <pre><code class="language-json">{
    "nombre": "Adminn",
    "apellido": "Test",
    "email": "adminn@gmail.com",
    "password": "password123",
    "tel": "1234567890",
    "rol": "admin"
}</code></pre>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Response (201 Created)</h6>
                                <div class="code-block-header">JSON Response</div>
                                <pre><code class="language-json">{
    "data": {
        "nombre": "Adminn",
        "apellido": "Test",
        "email": "adminn@gmail.com",
        "tel": "1234567890",
        "rol": "admin",
        "updated_at": "2026-04-26T16:18:58.000000Z",
        "created_at": "2026-04-26T16:18:58.000000Z",
        "id": 6
    },
    "status": "success"
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

           <section id="post-login" class="doc-section">
    <h2 class="section-title"><i class="bi bi-shield-lock-fill text-primary"></i>Autenticación</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/login</span>
        </div>
        <div class="api-body">
            <p>Inicia sesión en el sistema para obtener el token de acceso y los datos del usuario.</p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body</h6>
                    <div class="code-block-header">JSON Payload</div>
                    <pre><code class="language-json">{
    "email": "adminn@gmail.com",
    "password": "123456"
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <div class="code-block-header">JSON Response</div>
                    <pre><code class="language-json">{
    "token": "eeyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzc3MjIxODUzLCJleHAiOjE3NzcyMjU0NTMsIm5iZiI6MTc3NzIyMTg1MywianRpIjoiV1pVZkZvenlyemp1RGpDcCIsInN1YiI6IjYiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.VZtPrXaCDVIsnDWBrIxABIX2DT2xjrJuizqZyPDxkBg",
    "user": {
        "id": 6,
        "nombre": "Adminn",
        "apellido": "Test",
        "email": "adminn@gmail.com",
        "tel": "1234567890",
        "rol": "admin",
        "created_at": "2026-04-26T16:18:58.000000Z",
        "updated_at": "2026-04-26T16:18:58.000000Z"
    },
    "expires_in": 3600
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>

          <section id="get-users" class="doc-section">
    <h2 class="section-title"><i class="bi bi-people-fill text-success"></i>Listar Usuarios</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-get">GET</span>
            <span class="api-endpoint">/api/users</span>
        </div>
        <div class="api-body">
            <p>Obtiene una lista de todos los usuarios registrados en el sistema.</p>
            <p class="small text-muted"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <div class="code-block-header">JSON Response</div>
                    <pre><code class="language-json">{
    "data": [
        {
  "data": [
    {
      "id": 1,
      "nombre": "Alondra",
      "apellido": "Salas",
      "email": "alondra@gmail.com",
      "tel": "6561234567",
      "rol": "emprendedor",
      "created_at": null,
      "updated_at": null
    },
    {
      "id": 2,
      "nombre": "Carlos",
      "apellido": "Ramirez",
      "email": "carlos@gmail.com",
      "tel": "6561111111",
      "rol": "cliente",
      "created_at": null,
      "updated_at": null
    },
    {
      "id": 3,
      "nombre": "Admin",
      "apellido": "Sistema",
      "email": "admin@gmail.com",
      "tel": "6560000000",
      "rol": "admin",
      "created_at": null,
      "updated_at": null
    },
    {
      "id": 4,
      "nombre": "Mia",
      "apellido": "Minjarez",
      "email": "mia@gmail.com",
      "tel": "6569876543",
      "rol": "cliente",
      "created_at": "2026-04-26T16:16:33.000000Z",
      "updated_at": "2026-04-26T16:16:33.000000Z"
    },
    {
      "id": 5,
      "nombre": "Luis",
      "apellido": "Torres",
      "email": "luis@gmail.com",
      "tel": "6562222222",
      "rol": "emprendedor",
      "created_at": "2026-04-26T16:16:34.000000Z",
      "updated_at": "2026-04-26T16:16:34.000000Z"
    },
    {
      "id": 6,
      "nombre": "Adminn",
      "apellido": "Test",
      "email": "adminn@gmail.com",
      "tel": "1234567890",
      "rol": "admin",
      "created_at": "2026-04-26T16:18:58.000000Z",
      "updated_at": "2026-04-26T16:18:58.000000Z"
    }
  ],
  "status": "success"
}
    ],
    "status": "success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>

            <section id="post-emprendedor" class="doc-section">
    <h2 class="section-title"><i class="bi bi-briefcase-fill text-primary"></i>Registrar Emprendedor</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/emprendedores</span>
        </div>
        <div class="api-body">
            <p>Crea un nuevo registro de emprendedor asociado a un ID de usuario existente.</p>
            <p class="small text-muted"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body</h6>
                    <div class="code-block-header">JSON Payload</div>
                    <pre><code class="language-json">{
    "usuario_id": 1,
    "nombre_marca": "Mi Marca"
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (201 Created)</h6>
                    <div class="code-block-header">JSON Response</div>
                    <pre><code class="language-json">{
    "success": true,
    "msg": "Emprendedore created successfully",
    "emprendedore": {
        "usuario_id": 1,
        "nombre_marca": "Mi Marca",
        "updated_at": "2026-04-26T17:36:38.000000Z",
        "created_at": "2026-04-26T17:36:38.000000Z",
        "id": 5
    }
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="post-tienda" class="doc-section">
    <h2 class="section-title"><i class="bi bi-shop text-primary"></i>Registrar Tienda</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/tiendas</span>
        </div>
        <div class="api-body">
            <p>Crea una nueva tienda asociada a un ID de emprendedor existente.</p>
            <p class="small text-muted"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body</h6>
                    <div class="code-block-header">JSON Payload</div>
                    <pre><code class="language-json">{
    "emprendedor_id": 1,
    "nombre": "Mi tienda",
    "logo": "logo.png",
    "descripcion": "Venta de ropa",
    "categoria": "Ropa"
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (201 Created)</h6>
                    <div class="code-block-header">JSON Response</div>
                    <pre><code class="language-json">{
    "data": {
        "emprendedor_id": 1,
        "nombre": "Mi tienda",
        "logo": "logo.png",
        "descripcion": "Venta de ropa",
        "categoria": "Ropa",
        "updated_at": "2026-04-26T17:39:43.000000Z",
        "created_at": "2026-04-26T17:39:43.000000Z",
        "id": 5
    },
    "status": "success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>

            <section id="delete-user" class="doc-section">
                <h2 class="section-title"><i class="bi bi-person-x-fill text-danger"></i>Eliminar Cuenta</h2>
                <div class="api-card">
                    <div class="api-header">
                        <span class="badge-method badge-delete">DELETE</span>
                        <span class="api-endpoint">/api/user</span>
                    </div>
                    <div class="api-body">
                        <p class="text-danger fw-bold">Esta acción es irreversible.</p>
                        <p>Elimina permanentemente la cuenta del usuario autenticado.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h6 class="fw-bold mb-3">Response (204 No Content)</h6>
                                <div class="border p-3 bg-light rounded text-center text-muted">
                                    <em>La respuesta no contiene cuerpo de mensaje.</em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="get-tiendas" class="doc-section">
    <h2 class="section-title"><i class="bi bi-shop-window text-success"></i>Listar Tiendas</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-get">GET</span>
            <span class="api-endpoint">/api/tiendas</span>
        </div>
        <div class="api-body">
            <p>Obtiene la lista de todas las tiendas registradas, incluyendo la información del emprendedor asociado.</p>
            <p class="small text-muted"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <div class="code-block-header">JSON Response</div>
                    <pre><code class="language-json">{
    "data": [
        {
  "data": [
    {
      "id": 1,
      "emprendedor_id": 1,
      "nombre": "Moda Salas",
      "logo": "logo1.png",
      "descripcion": "Tienda de ropa",
      "categoria": "Ropa",
      "created_at": null,
      "updated_at": null,
      "emprendedor": {
        "id": 1,
        "usuario_id": 1,
        "nombre_marca": "Moda Salas",
        "created_at": null,
        "updated_at": null
      }
    },
    {
      "id": 2,
      "emprendedor_id": 2,
      "nombre": "Torres Store",
      "logo": "logo2.png",
      "descripcion": "Tienda deportiva",
      "categoria": "Deportes",
      "created_at": null,
      "updated_at": null,
      "emprendedor": {
        "id": 2,
        "usuario_id": 5,
        "nombre_marca": "Ropa Torres",
        "created_at": null,
        "updated_at": null
      }
    },
    {
      "id": 3,
      "emprendedor_id": 3,
      "nombre": "Moda Salas",
      "logo": "logo1.png",
      "descripcion": "Tienda de ropa",
      "categoria": "Ropa",
      "created_at": "2026-04-26T16:16:34.000000Z",
      "updated_at": "2026-04-26T16:16:34.000000Z",
      "emprendedor": {
        "id": 3,
        "usuario_id": 1,
        "nombre_marca": "Moda Salas",
        "created_at": "2026-04-26T16:16:34.000000Z",
        "updated_at": "2026-04-26T16:16:34.000000Z"
      }
    },
    {
      "id": 4,
      "emprendedor_id": 4,
      "nombre": "Torres Store",
      "logo": "logo2.png",
      "descripcion": "Tienda deportiva",
      "categoria": "Deportes",
      "created_at": "2026-04-26T16:16:34.000000Z",
      "updated_at": "2026-04-26T16:16:34.000000Z",
      "emprendedor": {
        "id": 4,
        "usuario_id": 5,
        "nombre_marca": "Ropa Torres",
        "created_at": "2026-04-26T16:16:34.000000Z",
        "updated_at": "2026-04-26T16:16:34.000000Z"
      }
    },
    {
      "id": 5,
      "emprendedor_id": 1,
      "nombre": "Mi tienda",
      "logo": "logo.png",
      "descripcion": "Venta de ropa",
      "categoria": "Ropa",
      "created_at": "2026-04-26T17:39:43.000000Z",
      "updated_at": "2026-04-26T17:39:43.000000Z",
      "emprendedor": {
        "id": 1,
        "usuario_id": 1,
        "nombre_marca": "Moda Salas",
        "created_at": null,
        "updated_at": null
      }
    }
  ],
  "status": "success"
}
    ],
    "status": "success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="put-tienda" class="doc-section">
    <h2 class="section-title"><i class="bi bi-pencil-square text-warning"></i>Actualizar Tienda</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-put">PUT</span>
            <span class="api-endpoint">/api/tiendas/{id}</span>
        </div>
        <div class="api-body">
            <p>Actualiza la información de una tienda específica identificada por su ID.</p>
            <p class="small text-muted"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body</h6>
                    <div class="code-block-header">JSON Payload</div>
                    <pre><code class="language-json">{
    "emprendedor_id": 1,
    "nombre": "Tienda actualizada",
    "logo": "nuevo.png",
    "descripcion": "Nueva descripción",
    "categoria": "Accesorios"
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <div class="code-block-header">JSON Response</div>
                    <pre><code class="language-json">{
    "data": {
        "id": 1,
        "emprendedor_id": 1,
        "nombre": "Tienda actualizada",
        "logo": "nuevo.png",
        "descripcion": "Nueva descripción",
        "categoria": "Accesorios",
        "created_at": null,
        "updated_at": "2026-04-26T18:24:09.000000Z"
    },
    "status": "success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="post-suscripcion" class="doc-section">
    <h2 class="section-title"><i class="bi bi-credit-card-2-front-fill text-info"></i>Crear Suscripción</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/suscripciones</span>
        </div>
        <div class="api-body">
            <p>Crea una nueva suscripción asociada a una tienda específica.</p>
            <p class="small text-muted"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body</h6>
                    <div class="code-block-header">JSON Payload</div>
                    <pre><code class="language-json">{
    "tienda_id": 5,
    "precio_mensual": 200,
    "fecha_inicio": "2026-04-26",
    "fecha_fin": "2026-05-26",
    "estado": "activa"
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (201 Created)</h6>
                    <div class="code-block-header">JSON Response</div>
                    <pre><code class="language-json">{
    "data": {
        "tienda_id": 5,
        "precio_mensual": 200,
        "fecha_inicio": "2026-04-26",
        "fecha_fin": "2026-05-26",
        "estado": "activa",
        "updated_at": "2026-04-26T18:41:24.000000Z",
        "created_at": "2026-04-26T18:41:24.000000Z",
        "id": 5
    },
    "status": "success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="get-suscripciones" class="doc-section">
    <h2 class="section-title"><i class="bi bi-list-check text-success"></i>Listar Suscripciones</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-get">GET</span>
            <span class="api-endpoint">/api/suscripciones</span>
        </div>
        <div class="api-body">
            <p>Obtiene la lista de todas las suscripciones registradas, incluyendo los detalles de la tienda asociada.</p>
            <p class="small text-muted"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <div class="code-block-header">JSON Response</div>
                    <pre><code class="language-json">{
    "data": [
        {
            "id": 5,
            "tienda_id": 5,
            "precio_mensual": "200.00",
            "fecha_inicio": "2026-04-26",
            "fecha_fin": "2026-05-26",
            "estado": "activa",
            "created_at": "2026-04-26T18:41:24.000000Z",
            "updated_at": "2026-04-26T18:41:24.000000Z",
            "tienda": {
                "id": 5,
                "emprendedor_id": 1,
                "nombre": "Mi tienda",
                "logo": "logo.png",
                "descripcion": "Venta de ropa",
                "categoria": "Ropa"
            }
        }
    ],
    "status": "success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="delete-tienda" class="doc-section">
    <h2 class="section-title"><i class="bi bi-trash-fill text-danger"></i>Eliminar Tienda</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-delete">DELETE</span>
            <span class="api-endpoint">/api/tiendas/{id}</span>
        </div>
        <div class="api-body">
            <p>Elimina permanentemente una tienda del sistema.</p>
            <p class="small text-muted"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <div class="code-block-header">JSON Response</div>
                    <pre><code class="language-json">{
    
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="verify-delete-tienda" class="doc-section">
    <h2 class="section-title"><i class="bi bi-list-check text-success"></i>Verificar Eliminación</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-get">GET</span>
            <span class="api-endpoint">/api/tiendas</span>
        </div>
        <div class="api-body">
            <p>Se realiza una petición GET para listar todas las tiendas y verificar que el ID especificado ya no se encuentra en el conjunto de datos.</p>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <div class="code-block-header">JSON Response (Extracto)</div>
                    <pre><code class="language-json">{
  {
  "data": [
    {
      "id": 2,
      "emprendedor_id": 2,
      "nombre": "Torres Store",
      "logo": "logo2.png",
      "descripcion": "Tienda deportiva",
      "categoria": "Deportes",
      "created_at": null,
      "updated_at": null,
      "emprendedor": {
        "id": 2,
        "usuario_id": 5,
        "nombre_marca": "Ropa Torres",
        "created_at": null,
        "updated_at": null
      }
    },
    {
      "id": 3,
      "emprendedor_id": 3,
      "nombre": "Moda Salas",
      "logo": "logo1.png",
      "descripcion": "Tienda de ropa",
      "categoria": "Ropa",
      "created_at": "2026-04-26T16:16:34.000000Z",
      "updated_at": "2026-04-26T16:16:34.000000Z",
      "emprendedor": {
        "id": 3,
        "usuario_id": 1,
        "nombre_marca": "Moda Salas",
        "created_at": "2026-04-26T16:16:34.000000Z",
        "updated_at": "2026-04-26T16:16:34.000000Z"
      }
    },
    {
      "id": 4,
      "emprendedor_id": 4,
      "nombre": "Torres Store",
      "logo": "logo2.png",
      "descripcion": "Tienda deportiva",
      "categoria": "Deportes",
      "created_at": "2026-04-26T16:16:34.000000Z",
      "updated_at": "2026-04-26T16:16:34.000000Z",
      "emprendedor": {
        "id": 4,
        "usuario_id": 5,
        "nombre_marca": "Ropa Torres",
        "created_at": "2026-04-26T16:16:34.000000Z",
        "updated_at": "2026-04-26T16:16:34.000000Z"
      }
    },
    {
      "id": 5,
      "emprendedor_id": 1,
      "nombre": "Mi tienda",
      "logo": "logo.png",
      "descripcion": "Venta de ropa",
      "categoria": "Ropa",
      "created_at": "2026-04-26T17:39:43.000000Z",
      "updated_at": "2026-04-26T17:39:43.000000Z",
      "emprendedor": {
        "id": 1,
        "usuario_id": 1,
        "nombre_marca": "Moda Salas",
        "created_at": null,
        "updated_at": null
      }
    }
  ],
  "status": "success"
}
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="get-suscripcion-id" class="doc-section">
    <h2 class="section-title"><i class="bi bi-eye-fill text-primary"></i>Ver Suscripción Específica</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-get">GET</span>
            <span class="api-endpoint">/api/suscripciones/{id}</span>
        </div>
        <div class="api-body">
            <p>Obtiene los detalles de una suscripción seleccionada por su identificador único.</p>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <div class="code-block-header">JSON Response</div>
                    <pre><code class="language-json">{
    "data": {
        "id": 2,
        "tienda_id": 2,
        "precio_mensual": "199.99",
        "fecha_inicio": "2025-02-01",
        "fecha_fin": "2025-03-01",
        "estado": "activo",
        "created_at": null,
        "updated_at": null
    },
    "status": "Success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="update-suscripcion" class="doc-section">
    <h2 class="section-title"><i class="bi bi-pencil-square text-warning"></i>Actualizar Suscripción</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-put">PUT</span>
            <span class="api-endpoint">/api/suscripciones/{id}</span>
        </div>
        <div class="api-body">
            <p>Actualiza los datos de una suscripción existente mediante su ID.</p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body (JSON)</h6>
                    <pre><code class="language-json">{
    "tienda_id": 2,
    "precio_mensual": 199.99,
    "fecha_inicio": "2025-02-01",
    "fecha_fin": "2025-03-01",
    "estado": "actualizado"
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <pre><code class="language-json">{
    "data": {
        "id": 2,
        "tienda_id": 2,
        "precio_mensual": "199.99",
        "fecha_inicio": "2025-02-01",
        "fecha_fin": "2025-03-01",
        "estado": "actualizado",
        "updated_at": "2026-04-26T..."
    },
    "status": "Success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="post-producto" class="doc-section">
    <h2 class="section-title"><i class="bi bi-box-seam-fill text-primary"></i>Crear Producto</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/productos</span>
        </div>
        <div class="api-body">
            <p>Registra un nuevo producto vinculado a una tienda existente mediante su <code>tienda_id</code>.</p>
            <p class="small text-muted"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body (JSON)</h6>
                    <pre><code class="language-json">{
    "nombre": "Playera",
    "descripcion": "Playera de algodón",
    "precio": 250,
    "stock": 15,
    "tienda_id": 2
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (201 Created)</h6>
                    <pre><code class="language-json">{
    "data": {
        "id": 5,
        "nombre": "Playera",
        "descripcion": "Playera de algodón",
        "precio": 250,
        "stock": 15,
        "tienda_id": 2,
        "created_at": "2026-04-26T19:18:48.000000Z"
    },
    "status": "success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="get-productos" class="doc-section">
    <h2 class="section-title"><i class="bi bi-list-ul text-success"></i>Listar Productos</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-get">GET</span>
            <span class="api-endpoint">/api/productos</span>
        </div>
        <div class="api-body">
            <p>Obtiene la lista de todos los productos disponibles, incluyendo los detalles de la tienda a la que pertenecen.</p>
            <p class="small text-muted"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <div class="code-block-header">JSON Response</div>
                    <pre><code class="language-json">{
  "data": [
    {
      "id": 2,
      "nombre": "Playera",
      "descripcion": "Playera deportiva",
      "precio": "199.99",
      "stock": 30,
      "tienda_id": 2,
      "created_at": null,
      "updated_at": null,
      "tienda": {
        "id": 2,
        "emprendedor_id": 2,
        "nombre": "Torres Store",
        "logo": "logo2.png",
        "descripcion": "Tienda deportiva",
        "categoria": "Deportes",
        "created_at": null,
        "updated_at": null
      }
    },
    {
      "id": 4,
      "nombre": "Playera",
      "descripcion": "Playera deportiva",
      "precio": "199.99",
      "stock": 30,
      "tienda_id": 2,
      "created_at": "2026-04-26T16:16:34.000000Z",
      "updated_at": "2026-04-26T16:16:34.000000Z",
      "tienda": {
        "id": 2,
        "emprendedor_id": 2,
        "nombre": "Torres Store",
        "logo": "logo2.png",
        "descripcion": "Tienda deportiva",
        "categoria": "Deportes",
        "created_at": null,
        "updated_at": null
      }
    },
    {
      "id": 5,
      "nombre": "Playera",
      "descripcion": "Playera de algodón",
      "precio": "250.00",
      "stock": 15,
      "tienda_id": 2,
      "created_at": "2026-04-26T19:18:48.000000Z",
      "updated_at": "2026-04-26T19:18:48.000000Z",
      "tienda": {
        "id": 2,
        "emprendedor_id": 2,
        "nombre": "Torres Store",
        "logo": "logo2.png",
        "descripcion": "Tienda deportiva",
        "categoria": "Deportes",
        "created_at": null,
        "updated_at": null
      }
    }
  ],
  "status": "success"

    ],
    "status": "success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="get-producto-id" class="doc-section">
    <h2 class="section-title"><i class="bi bi-info-circle-fill text-info"></i>Obtener Producto</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-get">GET</span>
            <span class="api-endpoint">/api/productos/2</span>
        </div>
        <div class="api-body">
            <p>Obtiene los detalles de un producto específico, incluyendo la información de su tienda vinculada.</p>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <div class="code-block-header">JSON Response</div>
                    <pre><code class="language-json">{
    "data": {
        "id": 2,
        "nombre": "Playera",
        "descripcion": "Playera deportiva",
        "precio": "199.99",
        "stock": 30,
        "tienda_id": 2,
        "tienda": {
            "id": 2,
            "nombre": "Torres Store",
            "categoria": "Deportes"
        }
    },
    "status": "Success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="put-producto" class="doc-section">
    <h2 class="section-title"><i class="bi bi-pencil-square text-warning"></i>Actualizar Producto</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-put">PUT</span>
            <span class="api-endpoint">/api/productos/{id}</span>
        </div>
        <div class="api-body">
            <p>Modifica los atributos de un producto existente, como el nombre, precio o stock.</p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body (JSON)</h6>
                    <pre><code class="language-json">{
    "nombre": "Sudadera nva",
    "descripcion": "Sudadera mejorada",
    "precio": 550,
    "stock": 10,
    "tienda_id": 2
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <pre><code class="language-json">{
    "data": {
        "id": 2,
        "nombre": "Sudadera nva",
        "precio": 550,
        "updated_at": "2026-04-26T19:37:35.000000Z"
    },
    "status": "success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="delete-producto" class="doc-section">
    <h2 class="section-title"><i class="bi bi-trash-fill text-danger"></i>Eliminar Producto</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-delete">DELETE</span>
            <span class="api-endpoint">/api/productos/2</span>
        </div>
        <div class="api-body">
            <p>Elimina permanentemente un producto del sistema.</p>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <pre><code class="language-json">{
    "status": "Success",
    "message": "Registro eliminado correctamente"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="pagos-api" class="doc-section">
    <h2 class="section-title"><i class="bi bi-credit-card text-success"></i>Pagos de Suscripciones</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/pagos</span>
        </div>
        <div class="api-body">
            <p>Registra un nuevo pago asociado a una suscripción existente.</p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body (JSON)</h6>
                    <pre><code class="language-json">{
    "suscripcion_id": 2,
    "monto": 200,
    "metodo_pago": "tarjeta",
    "fecha_pago": "2026-04-24"
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (201 Created)</h6>
                    <pre><code class="language-json">{
    "data": {
        "id": 5,
        "suscripcion_id": 2,
        "monto": 200,
        "metodo_pago": "tarjeta",
        "fecha_pago": "2026-04-24"
    },
    "status": "success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="pagos-api" class="doc-section">
    <h2 class="section-title"><i class="bi bi-credit-card text-success"></i> Gestión de Pagos</h2>
    
    <div class="api-card mb-4">
        <div class="api-header">
            <span class="badge-method badge-get">GET</span>
            <span class="api-endpoint">/api/pagos</span>
        </div>
        <div class="api-body">
            <p>Obtiene el listado completo de todos los pagos registrados en el sistema.</p>
            <h6 class="fw-bold mt-3">Response (200 OK)</h6>
            <pre><code class="language-json">{
    "data": [
        {
            "id": 5,
            "suscripcion_id": null,
            "monto": "200.00",
            "metodo_pago": "tarjeta",
            "fecha_pago": "2026-04-24"
        }
    ],
    "status": "success"
}</code></pre>
        </div>
    </div>

    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/pagos</span>
        </div>
        <div class="api-body">
            <p>Registra un nuevo pago en el sistema.</p>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold">Request Body</h6>
                    <pre><code class="language-json">{
    "suscripcion_id": 1,
    "monto": 200,
    "metodo_pago": "tarjeta",
    "fecha_pago": "2026-04-24"
}</code></pre>
                
</section>
<section id="pagos-gestión-avanzada" class="doc-section">
    <h2 class="section-title"><i class="bi bi-credit-card text-success"></i> Gestión de Pagos</h2>

    <div class="api-card mb-4">
        <div class="api-header">
            <span class="badge-method badge-put">PUT</span>
            <span class="api-endpoint">/api/pagos/{id}</span>
        </div>
        <div class="api-body">
            <p>Actualiza la información de un pago existente. Ejemplo: Actualizar pago con <strong>ID 5</strong>.</p>
            <div class="row mt-3">
                <div class="col-md-6">
                    <h6 class="fw-bold">Request Body (JSON)</h6>
                    <pre><code class="language-json">{
    "suscripcion_id": 2,
    "monto": 300,
    "metodo_pago": "efectivo",
    "fecha_pago": "2026-04-24"
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Response (200 OK)</h6>
                    <pre><code class="language-json">{
    "data": {
        "id": 5,
        "suscripcion_id": 2,
        "monto": 300,
        "metodo_pago": "efectivo",
        "fecha_pago": "2026-04-24",
        "created_at": "2026-04-26T19:54:28.000000Z",
        "updated_at": "2026-04-26T20:07:40.000000Z"
    },
    "status": "success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>

    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-delete">DELETE</span>
            <span class="api-endpoint">/api/pagos/{id}</span>
        </div>
        <div class="api-body">
            <p>Elimina un registro de pago del sistema de forma permanente.</p>
            <div class="mt-3">
                <h6 class="fw-bold">Response (200 OK)</h6>
                <pre><code class="language-json">{
    "status": "Success",
    "message": "Registro eliminado correctamente"
}</code></pre>
            </div>
        </div>
    </div>
</section>
<section id="emprendedores-api" class="doc-section">
    <h2 class="section-title"><i class="bi bi-person-badge text-info"></i> Emprendedores</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-get">GET</span>
            <span class="api-endpoint">/api/emprendedores</span>
        </div>
        <div class="api-body">
            <p>Obtiene el listado detallado de todos los emprendedores registrados, incluyendo la información de sus perfiles de usuario y nombres de marca.</p>
            
            <h6 class="fw-bold mt-4">Response (200 OK)</h6>
            <pre><code class="language-json">{
  "success": true,
  "message": "Emprendedores retrieved successfully",
  "emprendedores": [
    {
      "id": 1,
      "usuario_id": {
        "id": 1,
        "nombre": "Alondra",
        "apellido": "Salas",
        "email": "alondra@gmail.com",
        "tel": "6561234567",
        "rol": "emprendedor",
        "created_at": null,
        "updated_at": null
      },
      "nombre_marca": "Moda Salas",
      "created_at": null,
      "updated_at": null
    },
    {
      "id": 2,
      "usuario_id": {
        "id": 5,
        "nombre": "Luis",
        "apellido": "Torres",
        "email": "luis@gmail.com",
        "tel": "6562222222",
        "rol": "emprendedor",
        "created_at": "2026-04-26T16:16:34.000000Z",
        "updated_at": "2026-04-26T16:16:34.000000Z"
      },
      "nombre_marca": "Ropa Torres",
      "created_at": null,
      "updated_at": null
    },
    {
      "id": 3,
      "usuario_id": {
        "id": 1,
        "nombre": "Alondra",
        "apellido": "Salas",
        "email": "alondra@gmail.com",
        "tel": "6561234567",
        "rol": "emprendedor",
        "created_at": null,
        "updated_at": null
      },
      "nombre_marca": "Moda Salas",
      "created_at": "2026-04-26T16:16:34.000000Z",
      "updated_at": "2026-04-26T16:16:34.000000Z"
    },
    {
      "id": 4,
      "usuario_id": {
        "id": 5,
        "nombre": "Luis",
        "apellido": "Torres",
        "email": "luis@gmail.com",
        "tel": "6562222222",
        "rol": "emprendedor",
        "created_at": "2026-04-26T16:16:34.000000Z",
        "updated_at": "2026-04-26T16:16:34.000000Z"
      },
      "nombre_marca": "Ropa Torres",
      "created_at": "2026-04-26T16:16:34.000000Z",
      "updated_at": "2026-04-26T16:16:34.000000Z"
    },
    {
      "id": 5,
      "usuario_id": {
        "id": 1,
        "nombre": "Alondra",
        "apellido": "Salas",
        "email": "alondra@gmail.com",
        "tel": "6561234567",
        "rol": "emprendedor",
        "created_at": null,
        "updated_at": null
      },
      "nombre_marca": "Mi Marca",
      "created_at": "2026-04-26T17:36:38.000000Z",
      "updated_at": "2026-04-26T17:36:38.000000Z"
    }
  ]
}</code></pre>
        </div>
    </div>
</section>
<section id="emprendedor-post" class="doc-section">
    <h2 class="section-title"><i class="bi bi-person-plus text-primary"></i> Registrar Emprendedor</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/emprendedores</span>
        </div>
        <div class="api-body">
            <p>Registra un nuevo emprendedor en el sistema asociándolo a un usuario existente.</p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body (JSON)</h6>
                    <pre><code class="language-json">{
    "usuario_id": 1,
    "nombre_marca": "Mi Nueva Marca"
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (201 Created)</h6>
                    <pre><code class="language-json">{
    "success": true,
    "msg": "Emprendedore created successfully",
    "emprendedore": {
        "id": 6,
        "usuario_id": 1,
        "nombre_marca": "Mi Nueva Marca",
        "created_at": "2026-04-26T21:06:47.000000Z"
    }
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="update-emprendedor" class="doc-section">
    <h2 class="section-title"><i class="bi bi-pencil-square text-warning"></i> Actualizar Emprendedor</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-put">PUT</span>
            <span class="api-endpoint">/api/emprendedores/{id}</span>
        </div>
        <div class="api-body">
            <p>Actualiza la información de marca de un emprendedor existente.</p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body (JSON)</h6>
                    <pre><code class="language-json">{
    "nombre_marca": "Nueva Marca Editada"
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <pre><code class="language-json">{
    "success": true,
    "msg": "Emprendedore updated successfully",
    "emprendedore": {
        "id": 1,
        "usuario_id": 1,
        "nombre_marca": "Nueva Marca Editada",
        "updated_at": "2026-04-26T21:08:55.000000Z"
    }
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="emprendedores-api" class="doc-section">
    <h2 class="section-title"><i class="bi bi-person-badge text-info"></i> Gestión de Emprendedores</h2>
    
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-delete">DELETE</span>
            <span class="api-endpoint">/api/emprendedores/6</span>
        </div>
        <div class="api-body">
            <p>Elimina permanentemente el registro del emprendedor con ID 6.</p>
            <h6 class="fw-bold">Response (200 OK)</h6>
            <pre><code class="language-json">{
    "success": true,
    "msg": "Emprendedore deleted successfully"
}</code></pre>
        </div>
    </div>
</section>
<section id="clientes-api" class="doc-section">
    <h2 class="section-title"><i class="bi bi-people text-primary"></i> Gestión de Clientes</h2>
    
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-get">GET</span>
            <span class="api-endpoint">/api/clientes</span>
        </div>
        <div class="api-body">
            <p>Obtiene el listado completo de todos los clientes registrados en el sistema.</p>
            
            <h6 class="fw-bold mt-4">Response (200 OK)</h6>
            <pre><code class="language-json">{
  "success": true,
  "message": "Clientes retrieved successfully",
  "clientes": [
    {
      "id": 1,
      "usuario_id": null,
      "direccion": "Av Tecnologico",
      "created_at": null,
      "updated_at": null
    },
    {
      "id": 2,
      "usuario_id": null,
      "direccion": "Av Juarez",
      "created_at": null,
      "updated_at": null
    },
    {
      "id": 3,
      "usuario_id": null,
      "direccion": "Av Tecnologico",
      "created_at": "2026-04-26T16:16:34.000000Z",
      "updated_at": "2026-04-26T16:16:34.000000Z"
    },
    {
      "id": 4,
      "usuario_id": null,
      "direccion": "Av Juarez",
      "created_at": "2026-04-26T16:16:34.000000Z",
      "updated_at": "2026-04-26T16:16:34.000000Z"
    }
  ]
}</code></pre>
        </div>
    </div>
</section>
<section id="cliente-post" class="doc-section">
    <h2 class="section-title"><i class="bi bi-person-plus text-primary"></i> Registrar Cliente</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/clientes</span>
        </div>
        <div class="api-body">
            <p>Registra un nuevo cliente en el sistema.</p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body (JSON)</h6>
                    <pre><code class="language-json">{
    "usuario_id": 1,
    "direccion": "Av. Tecnologico #123"
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (201 Created)</h6>
                    <pre><code class="language-json">{
  "success": true,
  "msg": "Cliente created successfully",
  "cliente": {
    "usuario_id": 1,
    "direccion": "Av. Tecnologico #123",
    "updated_at": "2026-04-26T21:29:42.000000Z",
    "created_at": "2026-04-26T21:29:42.000000Z",
    "id": 5
  }
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="delete-cliente" class="doc-section">
    <h2 class="section-title"><i class="bi bi-trash text-danger"></i> Eliminar Cliente</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-delete">DELETE</span>
            <span class="api-endpoint">/api/clientes/2</span>
        </div>
        <div class="api-body">
            <p>Elimina permanentemente un registro de cliente del sistema mediante su ID.</p>
            
            <div class="mt-4">
                <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                <pre><code class="language-json">{
    "success": true,
    "msg": "Cliente deleted successfully"
}</code></pre>
            </div>
        </div>
    </div>
</section>
<section id="carritos-api" class="doc-section">
    <h2 class="section-title"><i class="bi bi-cart-plus text-success"></i> Gestión de Carritos</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/carritos</span>
        </div>
        <div class="api-body">
            <p>Agrega un nuevo producto al carrito de compras del cliente.</p>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Request Body (JSON)</h6>
                    <pre><code class="language-json">{
    "cliente_id": 1,
    "producto_id": 5,
    "cantidad": 1,
    "precio_unitario": 100.00,
    "subtotal": 100.00
}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                    <pre><code class="language-json">{
  "data": {
    "cliente_id": 1,
    "producto_id": 5,
    "cantidad": 1,
    "precio_unitario": 100,
    "subtotal": 100,
    "updated_at": "2026-04-26T21:46:22.000000Z",
    "created_at": "2026-04-26T21:46:22.000000Z",
    "id": 5
  },
  "status": "success"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="get-carritos-api" class="doc-section">
    <h2 class="section-title"><i class="bi bi-cart-check text-success"></i> Consultar Carritos</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-get">GET</span>
            <span class="api-endpoint">/api/carritos</span>
        </div>
        <div class="api-body">
            <p>Obtiene todos los registros del carrito, incluyendo los datos completos del cliente y del producto relacionado.</p>
            
            <h6 class="fw-bold mt-4">Response (200 OK)</h6>
            <pre><code class="language-json">{
  "data": [
    {
      "id": 5,
      "cliente_id": 1,
      "producto_id": 5,
      "cantidad": 1,
      "precio_unitario": "100.00",
      "subtotal": "100.00",
      "created_at": "2026-04-26T21:46:22.000000Z",
      "updated_at": "2026-04-26T21:46:22.000000Z",
      "cliente": {
        "id": 1,
        "usuario_id": 2,
        "direccion": "Nueva Dirección Av. Juarez #456",
        "created_at": null,
        "updated_at": "2026-04-26T21:37:41.000000Z"
      },
      "producto": {
        "id": 5,
        "nombre": "Playera",
        "descripcion": "Playera de algodón",
        "precio": "250.00",
        "stock": 15,
        "tienda_id": 2,
        "created_at": "2026-04-26T19:18:48.000000Z",
        "updated_at": "2026-04-26T19:18:48.000000Z"
      }
    }
  ],
  "status": "success"
}</code></pre>
        </div>
    </div>
</section>
<section id="update-carrito" class="doc-section">
    <h2 class="section-title"><i class="bi bi-pencil-square text-warning"></i> Editar Carrito</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-put">PUT</span>
            <span class="api-endpoint">/api/carritos/{id}</span>
        </div>
        <div class="api-body">
            <p>Actualiza la cantidad y los cálculos de un ítem existente en el carrito.</p>
            <h6 class="fw-bold mt-2">Request Body (JSON)</h6>
            <pre><code class="language-json">{
    "cliente_id": 1,
    "producto_id": 5,
    "cantidad": 1,
    "precio_unitario": 100.00,
    "subtotal": 100.00
}</code></pre>
            <h6 class="fw-bold mt-3">Response (200 OK)</h6>
            <pre><code class="language-json">{
  "data": {
    "id": 5,
    "cliente_id": 1,
    "producto_id": 5,
    "cantidad": 1,
    "precio_unitario": 100,
    "subtotal": 100,
    "created_at": "2026-04-26T21:46:22.000000Z",
    "updated_at": "2026-04-26T22:14:24.000000Z"
  },
  "status": "success"
}</code></pre>
        </div>
    </div>
</section>
<section id="delete-carrito" class="doc-section">
    <h2 class="section-title"><i class="bi bi-trash text-danger"></i> Eliminar Carrito</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-delete">DELETE</span>
            <span class="api-endpoint">/api/carritos/5</span>
        </div>
        <div class="api-body">
            <p>Elimina un registro específico del carrito de compras de forma permanente.</p>
            
            <h6 class="fw-bold mt-3">Response (200 OK)</h6>
            <pre><code class="language-json">{
    "message": "Eliminado correctamente"
}</code></pre>
        </div>
    </div>
</section>
<section id="create-ordenitem" class="doc-section">
    <h2 class="section-title"><i class="bi bi-plus-circle text-success"></i> Crear Item de Orden</h2>
    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/ordenitems</span>
        </div>
        <div class="api-body">
            <p>Registra un nuevo producto como parte de una orden existente.</p>
            
            <h6 class="fw-bold mt-2">Request Body (JSON)</h6>
            <pre><code class="language-json">{
    "orden_id": 1,
    "producto_id": 5,
    "tienda_id": 2,
    "cantidad": 2,
    "precio_unitario": 100.00,
    "subtotal": 200.00
}</code></pre>

            <h6 class="fw-bold mt-3">Response (201 Created)</h6>
            <pre><code class="language-json">{
  "success": true,
  "msg": "Orden item created successfully",
  "item": {
    "orden_id": 1,
    "producto_id": 5,
    "tienda_id": 2,
    "cantidad": 2,
    "precio_unitario": 100,
    "subtotal": 200,
    "updated_at": "2026-04-26T22:57:05.000000Z",
    "created_at": "2026-04-26T22:57:05.000000Z",
    "id": 5
  }
}</code></pre>
        </div>
    </div>
</section>
<section id="ordenitems-api" class="doc-section">
    <h2 class="section-title"><i class="bi bi-list-check text-info"></i> Gestión de Items de Orden</h2>
    
    <div class="api-card">
        <span class="badge-method badge-get">GET</span> <code>/api/ordenitems</code>
        <p>Lista todos los items de orden registrados.</p>
    </div>

    <div class="api-card mt-3">
        <span class="badge-method badge-put">PUT</span> <code>/api/ordenitems/{id}</code>
        <p>Actualiza un ítem específico. Asegúrate de usar el ID correcto obtenido del GET.</p>
        <pre><code class="language-json">{
    "cantidad": 3,
    "subtotal": 300.00
}</code></pre>
    </div>

    <div class="api-card mt-3">
        <span class="badge-method badge-delete">DELETE</span> <code>/api/ordenitems/{id}</code>
        <p>Elimina el ítem con el ID especificado.</p>
    </div>
</section>
<section id="delete-ordenitem" class="doc-section">
    <h3 class="section-title">
        <span class="badge-method badge-delete">DELETE</span> <code>/api/ordenitems/5</code>
    </h3>
    <div class="api-card">
        <p>Elimina permanentemente un ítem de la orden mediante su identificador único (ID).</p>
        
        <h6 class="fw-bold mt-3">Parámetros de URL</h6>
        <ul>
            <li><code>id</code> (requerido): El ID numérico del ítem a eliminar.</li>
        </ul>

        <h6 class="fw-bold mt-3">Respuesta Exitosa (200 OK)</h6>
        <pre><code class="language-json">{
    "success": true,
    "msg": "Orden item deleted successfully"
}</code></pre>
    </div>
</section>

            <section id="errors" class="doc-section">
                <h2 class="section-title"><i class="bi bi-exclamation-triangle-fill text-secondary"></i>Formatos de Error</h2>
                <div class="api-card">
                    <div class="api-header">
                        <span class="fw-bold">Estándar BitCorp</span>
                    </div>
                    <div class="api-body">
                        <p>En caso de error en la validación, la API retornará un código <strong>422 Unprocessable Entity</strong> con el siguiente formato:</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="code-block-header">JSON Response</div>
                                <pre><code class="language-json">{
    "error": "Validación fallida",
    "message": "Los datos enviados no son correctos para los estándares de BitCorp.",
    "details": {
        "email": [
            "El correo electrónico ya ha sido registrado."
        ],
        "password": [
            "La contraseña debe tener al menos 8 caracteres."
        ]
    }
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="mt-5 py-4 border-top text-center text-muted small">
                &copy; <script>document.write(new Date().getFullYear())</script> BitCorp API System. Todos los derechos reservados.
            </footer>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>
    
    <script>
        // Active link switching on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.doc-section');
            const navLinks = document.querySelectorAll('.nav-link');

            window.addEventListener('scroll', () => {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (pageYOffset >= sectionTop - 100) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href').includes(current)) {
                        link.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>