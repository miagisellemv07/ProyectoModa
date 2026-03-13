@extends('front.main')

@section('contenido')
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="hero-badge">Marketplace moderno y accesible</span>
                <h1 class="hero-title">Descubre productos, tiendas y nuevas oportunidades en un solo lugar.</h1>
                <p class="hero-text mb-4">
                    Virtuality Emprendedores Mall es una plataforma donde diferentes negocios pueden
                    mostrar sus productos y los clientes pueden comprar de forma sencilla, ordenada y visual.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#productos" class="btn btn-main">Explorar productos</a>

                    @auth
                        @if(auth()->user()->rol == 'admin')
                            <a href="{{ route('dashboard') }}" class="btn btn-soft">Ir al panel</a>
                        @else
                            <a href="{{ url('/') }}" class="btn btn-soft">Seguir explorando</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-soft">Iniciar sesión</a>
                    @endauth
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=900&q=80" alt="Marketplace">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="beneficios" class="section-padding">
    <div class="container">
        <h2 class="section-title text-center">Una experiencia moderna para vender y comprar</h2>
        <p class="section-subtitle text-center mx-auto">
            El sistema está pensado para que tiendas y clientes puedan interactuar de forma simple,
            visual y organizada dentro de una misma plataforma.
        </p>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card-soft text-center">
                    <div class="icon-circle mx-auto">
                        <i class="fas fa-store"></i>
                    </div>
                    <h5 class="fw-bold">Tiendas organizadas</h5>
                    <p class="mb-0 text-muted">Cada negocio puede mostrar sus productos dentro de un espacio propio.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card-soft text-center">
                    <div class="icon-circle mx-auto">
                        <i class="fas fa-bag-shopping"></i>
                    </div>
                    <h5 class="fw-bold">Compras sencillas</h5>
                    <p class="mb-0 text-muted">Los clientes pueden navegar, elegir y comprar de forma rápida.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card-soft text-center">
                    <div class="icon-circle mx-auto">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h5 class="fw-bold">Variedad de categorías</h5>
                    <p class="mb-0 text-muted">Tecnología, moda, accesorios, hogar, belleza, deporte y más.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card-soft text-center">
                    <div class="icon-circle mx-auto">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h5 class="fw-bold">Impulso para negocios</h5>
                    <p class="mb-0 text-muted">Una plataforma que ayuda a dar visibilidad y orden a cada tienda.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="productos" class="section-padding bg-white">
    <div class="container">
        <h2 class="section-title text-center">Productos destacados</h2>
        <p class="section-subtitle text-center mx-auto">
            Aquí puedes mostrar una vista previa de todo lo que puede encontrarse dentro del marketplace.
        </p>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="product-card">
                    <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=900&q=80" alt="Moda">
                    <div class="product-body">
                        <span class="category-badge">Moda</span>
                        <h5 class="fw-bold">Conjunto casual</h5>
                        <p class="text-muted mb-3">Opciones cómodas y versátiles para diferentes estilos.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">$399 MXN</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="product-card">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80" alt="Calzado">
                    <div class="product-body">
                        <span class="category-badge">Calzado</span>
                        <h5 class="fw-bold">Tenis urbanos</h5>
                        <p class="text-muted mb-3">Diseño moderno ideal para uso diario y distintos outfits.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">$850 MXN</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="product-card">
                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80" alt="Tecnología">
                    <div class="product-body">
                        <span class="category-badge">Tecnología</span>
                        <h5 class="fw-bold">Audífonos inalámbricos</h5>
                        <p class="text-muted mb-3">Un ejemplo de cómo tu plataforma puede incluir todo tipo de productos.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">$1,299 MXN</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="categorias" class="section-padding">
    <div class="container">
        <div class="cta-section">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <h2 class="section-title mb-3">Categorías para todo tipo de negocio</h2>
                    <p class="mb-0 text-muted">
                        Virtuality Emprendedores Mall puede reunir tiendas de moda, calzado, accesorios,
                        tecnología, hogar, belleza, deporte y mucho más dentro de un mismo espacio digital.
                    </p>
                </div>

                <div class="col-lg-5 text-lg-end">
                    @auth
                        @if(auth()->user()->rol == 'admin')
                            <a href="{{ route('dashboard') }}" class="btn btn-main me-2">Entrar al panel</a>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-soft">Gestionar usuarios</a>
                        @else
                            <a href="{{ url('/') }}" class="btn btn-main me-2">Seguir explorando</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-main me-2">Iniciar sesión</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>
@endsection