import { Link } from "react-router-dom";

function Navbar() {
  return (
    <nav className="navbar navbar-expand-lg navbar-custom py-3">

      <div className="container">

        <Link
          className="navbar-brand"
          to="/"
        >
          Virtuality <span>Mall</span>
        </Link>


        <button
          className="navbar-toggler border-0 shadow-none"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarMall"
        >
          <i className="fas fa-bars"></i>
        </button>


        <div
          className="collapse navbar-collapse"
          id="navbarMall"
        >

          <ul className="navbar-nav ms-auto align-items-lg-center">

            <li className="nav-item">
              <Link className="nav-link" to="/">
                Inicio
              </Link>
            </li>


            <li className="nav-item">
              <a className="nav-link" href="#productos">
                Productos
              </a>
            </li>


            <li className="nav-item">
              <a className="nav-link" href="#categorias">
                Categorías
              </a>
            </li>


            <li className="nav-item">
              <a className="nav-link" href="#beneficios">
                Beneficios
              </a>
            </li>


            <li className="nav-item">
              <a className="nav-link" href="#contacto">
                Contacto
              </a>
            </li>


            <li className="nav-item">

              <Link
                className="nav-link"
                to="/login"
              >
                Iniciar sesión
              </Link>

            </li>


            <li className="nav-item">

              <Link
                className="nav-link"
                to="/register"
              >
                Registrarse
              </Link>

            </li>

          </ul>

        </div>

      </div>

    </nav>
  );
}

export default Navbar;