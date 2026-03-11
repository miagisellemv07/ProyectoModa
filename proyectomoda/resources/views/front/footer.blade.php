<footer class="pt-5 pb-4" id="contacto">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4">
                <h4 class="fw-bold mb-3">Virtuality Emprendedores Mall</h4>
                <p class="mb-0">
                    Una tienda en línea donde distintos negocios pueden publicar sus productos
                    y los clientes pueden descubrir nuevas opciones en un solo lugar.
                </p>
            </div>

            <div class="col-lg-4">
                <h5 class="fw-bold mb-3">Enlaces</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="mb-2"><a href="#productos">Productos</a></li>
                    <li class="mb-2"><a href="#categorias">Categorías</a></li>
                    <li class="mb-2"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h5 class="fw-bold mb-3">Contacto</h5>
                <p class="mb-2"><i class="fas fa-envelope me-2"></i> contacto@virtualitymall.com</p>
                <p class="mb-2"><i class="fas fa-phone me-2"></i> +52 656 000 0000</p>
                <p class="mb-0"><i class="fas fa-location-dot me-2"></i> Ciudad Juárez, Chihuahua</p>
            </div>
        </div>

        <hr class="my-4 border-light opacity-25">

        <div class="text-center">
            <small>&copy; {{ date('Y') }} Virtuality Emprendedores Mall. Todos los derechos reservados.</small>
        </div>
    </div>
</footer>