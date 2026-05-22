<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Virtuality Emprendedores Mall</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root{
            --rosa-suave: #f8d9e8;
            --rosa-medio: #e9a9c4;
            --lila-suave: #d9c7f2;
            --morado-suave: #9b7cc3;
            --azul-pastel: #cfe7ff;
            --azul-medio: #9ecbf3;
            --crema: #fff9fc;
            --texto: #4f4459;
            --oscuro: #5d4b69;
            --blanco: #ffffff;
            --success-soft: #daf7e8;
            --warning-soft: #fff1cc;
            --info-soft: #dff1ff;
            --purple-soft: #efe4ff;
            --shadow: 0 10px 25px rgba(0,0,0,.08);
        }

        body{
            font-family: 'Inter', sans-serif;
            background: var(--crema);
            color: var(--texto);
            margin: 0;
        }

        #wrapper{
            display: flex;
            min-height: 100vh;
        }

        #sidebar{
            width: 270px;
            background: linear-gradient(180deg, #6e5a7f, #8f73b6, #9ecbf3);
            color: white;
            padding: 1.5rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: var(--shadow);
        }

        .sidebar-header{
            padding: 0 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.18);
        }

        #sidebar .nav-link{
            color: rgba(255,255,255,.92);
            padding: .9rem 1.5rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: .3s;
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active{
            background: rgba(255,255,255,.12);
            border-left-color: #ffdceb;
            color: white;
        }

        #content{
            margin-left: 270px;
            flex: 1;
            padding: 2rem;
        }

        .stat-card,
        .table-card,
        .user-card{
            background: white;
            border-radius: 22px;
            box-shadow: var(--shadow);
            padding: 1.5rem;
            border: none;
        }

        .stat-card{
            height: 100%;
        }

        .stat-icon{
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .bg-accent-soft{ background: #ffe2ef; color: #d26b9b; }
        .bg-blue-soft{ background: var(--info-soft); color: #4a8fcb; }
        .bg-green-soft{ background: var(--success-soft); color: #38a169; }
        .bg-purple-soft{ background: var(--purple-soft); color: #8a5fc2; }

        .badge-status{
            font-size: .8rem;
            padding: .45rem .9rem;
            border-radius: 50px;
            font-weight: 600;
        }

        .table thead th{
            color: #7c7086;
            font-size: .9rem;
            font-weight: 700;
            border-bottom: 1px solid #f0e7f5;
        }

        .table tbody td{
            vertical-align: middle;
        }

        .btn-accent{
            background: linear-gradient(90deg, var(--rosa-medio), var(--morado-suave));
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: .7rem 1.25rem;
        }

        .btn-accent:hover{
            color: white;
            opacity: .95;
        }

        .avatar{
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f8d9e8, #d9c7f2, #cfe7ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--oscuro);
            margin-right: .8rem;
        }

        .form-control,
        .form-select{
            border-radius: 12px;
            border: 1px solid #eadff5;
            box-shadow: none !important;
        }

        .form-control:focus,
        .form-select:focus{
            border-color: #c9a7e7;
        }

        @media (max-width: 991px){
            #sidebar{
                position: relative;
                width: 100%;
                height: auto;
            }

            #content{
                margin-left: 0;
            }

            #wrapper{
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div id="wrapper">
    @include('dash.nav')

    <main id="content">
        @yield('contenido')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('script')
</body>
</html>