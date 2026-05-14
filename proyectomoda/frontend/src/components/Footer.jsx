function Footer() {
  return (
    <footer className="pt-5 pb-4" id="contacto">
      <div className="container">
        <div className="row gy-4">
          <div className="col-lg-4">
            <h4 className="fw-bold mb-3">
              Virtuality Emprendedores Mall
            </h4>

            <p className="mb-0">
              Una tienda en línea donde distintos negocios pueden publicar sus productos
              y los clientes pueden descubrir nuevas opciones en un solo lugar.
            </p>
          </div>

          <div className="col-lg-4">
            <h5 className="fw-bold mb-3">Enlaces</h5>

            <ul className="list-unstyled">
              <li className="mb-2">
                <a href="/">Inicio</a>
              </li>
              <li className="mb-2">
                <a href="#productos">Productos</a>
              </li>
              <li className="mb-2">
                <a href="#categorias">Categorías</a>
              </li>
              <li className="mb-2">
                <a href="http://127.0.0.1:8000/dashboard">Dashboard</a>
              </li>
            </ul>
          </div>

          <div className="col-lg-4">
            <h5 className="fw-bold mb-3">Contacto</h5>

            <p className="mb-2">
              <i className="fas fa-envelope me-2"></i>
              contacto@virtualitymall.com
            </p>

            <p className="mb-2">
              <i className="fas fa-phone me-2"></i>
              +52 656 000 0000
            </p>

            <p className="mb-0">
              <i className="fas fa-location-dot me-2"></i>
              Ciudad Juárez, Chihuahua
            </p>
          </div>
        </div>

        <hr className="my-4 border-light opacity-25" />

        <div className="text-center">
          <small>
            © 2026 Virtuality Emprendedores Mall. Todos los derechos reservados.
          </small>
        </div>
      </div>
    </footer>
  );
}

export default Footer;