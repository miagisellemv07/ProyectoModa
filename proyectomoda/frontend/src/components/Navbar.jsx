function Navbar() {
  return (
    <nav className="navbar navbar-expand-lg navbar-custom py-3">
      <div className="container">
        <a className="navbar-brand" href="/">
          Virtuality <span>Mall</span>
        </a>

        <button
          className="navbar-toggler border-0 shadow-none"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarMall"
          aria-controls="navbarMall"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <i className="fas fa-bars"></i>
        </button>

        <div className="collapse navbar-collapse" id="navbarMall">
          <ul className="navbar-nav ms-auto align-items-lg-center">
            <li className="nav-item">
              <a className="nav-link" href="/">Inicio</a>
            </li>

            <li className="nav-item">
              <a className="nav-link" href="#productos">Productos</a>
            </li>

            <li className="nav-item">
              <a className="nav-link" href="#categorias">Categorías</a>
            </li>

            <li className="nav-item">
              <a className="nav-link" href="#beneficios">Beneficios</a>
            </li>

            <li className="nav-item">
              <a className="nav-link" href="#contacto">Contacto</a>
            </li>

            <li className="nav-item">
              <a className="nav-link" href="http://127.0.0.1:8000/login">
                Iniciar sesión
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  );
}

export default Navbar;