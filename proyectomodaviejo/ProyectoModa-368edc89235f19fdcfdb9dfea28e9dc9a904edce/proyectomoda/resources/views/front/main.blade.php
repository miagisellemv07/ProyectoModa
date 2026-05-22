<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtuality Emprendedores Mall</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

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
            --sombra: 0 10px 25px rgba(0,0,0,.08);
        }

        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--crema);
            color: var(--texto);
        }

        .navbar-custom{
            background: linear-gradient(90deg, var(--rosa-suave), var(--lila-suave), var(--azul-pastel));
            box-shadow: var(--sombra);
        }

        .navbar-brand{
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--oscuro) !important;
            letter-spacing: 1px;
        }

        .navbar-brand span{
            color: #d978a6;
        }

        .nav-link{
            color: #5b4b67 !important;
            font-weight: 600;
            margin-left: 10px;
        }

        .nav-link:hover{
            color: #c86f9b !important;
        }

        .hero-section{
            min-height: 88vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #fff2f8 0%, #f2ebff 50%, #ebf6ff 100%);
            padding: 90px 0;
        }

        .hero-badge{
            display: inline-block;
            background: rgba(255,255,255,.85);
            color: #b05f8f;
            padding: 8px 18px;
            border-radius: 40px;
            font-size: .9rem;
            font-weight: 700;
            margin-bottom: 18px;
            box-shadow: 0 5px 15px rgba(0,0,0,.05);
        }

        .hero-title{
            font-size: 3.7rem;
            font-weight: 800;
            line-height: 1.1;
            color: var(--oscuro);
        }

        .hero-text{
            font-size: 1.15rem;
            color: #6f6479;
            max-width: 600px;
        }

        .btn-main{
            background: linear-gradient(90deg, var(--rosa-medio), var(--morado-suave));
            color: white;
            border: none;
            border-radius: 14px;
            padding: 14px 32px;
            font-weight: 700;
            box-shadow: 0 8px 18px rgba(155,124,195,.25);
        }

        .btn-main:hover{
            color: white;
            opacity: .95;
        }

        .btn-soft{
            background: white;
            color: var(--morado-suave);
            border: 2px solid #eadcf8;
            border-radius: 14px;
            padding: 14px 32px;
            font-weight: 700;
        }

        .btn-soft:hover{
            background: #faf4ff;
            color: var(--morado-suave);
        }

        .hero-image{
            background: white;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: var(--sombra);
        }

        .hero-image img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .section-padding{
            padding: 90px 0;
        }

        .section-title{
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--oscuro);
            margin-bottom: 16px;
        }

        .section-subtitle{
            color: #756b80;
            max-width: 720px;
            margin-bottom: 45px;
        }

        .card-soft{
            background: white;
            border-radius: 22px;
            padding: 28px;
            box-shadow: var(--sombra);
            height: 100%;
            border: none;
            transition: .3s ease;
        }

        .card-soft:hover{
            transform: translateY(-6px);
        }

        .icon-circle{
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffddeb, #e4d1f7, #d9edff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7d5d9f;
            font-size: 1.3rem;
            margin-bottom: 18px;
        }

        .product-card{
            background: white;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: var(--sombra);
            height: 100%;
            transition: .3s ease;
        }

        .product-card:hover{
            transform: translateY(-6px);
        }

        .product-card img{
            width: 100%;
            height: 280px;
            object-fit: cover;
        }

        .product-body{
            padding: 22px;
        }

        .category-badge{
            display: inline-block;
            background: #f3ebfb;
            color: #8b67ab;
            font-size: .85rem;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 20px;
            margin-bottom: 10px;
        }

        .price{
            color: #cf6e99;
            font-size: 1.1rem;
            font-weight: 800;
        }

        .cta-section{
            background: linear-gradient(135deg, #fdebf4, #f3e9fd, #e9f5ff);
            border-radius: 30px;
            padding: 55px;
            box-shadow: var(--sombra);
        }

        footer{
            background: #6e5a7f;
            color: white;
        }

        footer a{
            color: #ffe8f3;
            text-decoration: none;
        }

        footer a:hover{
            color: white;
        }

        @media (max-width: 991px){
            .hero-title{
                font-size: 2.8rem;
            }
        }

        @media (max-width: 576px){
            .hero-title{
                font-size: 2.2rem;
            }

            .section-title{
                font-size: 1.9rem;
            }
        }
        .btn-login{
    background: linear-gradient(90deg, var(--rosa-medio), var(--morado-suave));
    color: white;
    padding: 8px 18px;
    border-radius: 10px;
    font-weight: 600;
    display: inline-block;
    border: none;
}

.btn-login:hover{
    color: white;
    opacity: .92;
}
    </style>
</head>
<body>

    @include('front.navbar')

    <main>
        @yield('contenido')
    </main>

    @include('front.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>