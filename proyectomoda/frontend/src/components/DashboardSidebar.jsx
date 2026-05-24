import { Link } from "react-router-dom";

function DashboardSidebar() {
  const user = JSON.parse(localStorage.getItem("user"));
  const rol = user?.rol;

  function cerrarSesion() {
    localStorage.removeItem("token");
    localStorage.removeItem("user");

    // HashRouter
    window.location.href = "/#/login";
  }

  return (
    <nav id="sidebar">
      <div className="sidebar-header">
        <h4 className="mb-0 fw-bold sidebar-title">
          VIRTUALITY <span className="fw-light text-white">MALL</span>
        </h4>

        <small className="text-white-50">
          Panel de {rol || "usuario"}
        </small>
      </div>

      {rol === "admin" && (
        <>
          <Link to="/dashboard/admin" className="nav-link">
            <i className="fas fa-house"></i> Home
          </Link>

          <Link to="/dashboard/admin/clientes" className="nav-link">
            <i className="fas fa-user-tie"></i> Clientes / Emprendedores
          </Link>

          <Link to="/dashboard/admin/tiendas" className="nav-link">
            <i className="fas fa-store"></i> Tiendas
          </Link>

          <Link to="/dashboard/admin/usuarios" className="nav-link">
            <i className="fas fa-users-cog"></i> Usuarios
          </Link>
        </>
      )}

      {rol === "emprendedor" && (
        <>
          <Link to="/dashboard/emprendedor" className="nav-link">
            <i className="fas fa-house"></i> Home
          </Link>

          <Link to="/dashboard/emprendedor/productos" className="nav-link">
            <i className="fas fa-box-open"></i> Productos
          </Link>

          <Link to="/dashboard/emprendedor/pedidos" className="nav-link">
            <i className="fas fa-shopping-cart"></i> Pedidos
          </Link>

          <Link to="/dashboard/emprendedor/pagos" className="nav-link">
            <i className="fas fa-credit-card"></i> Pagos
          </Link>
        </>
      )}

      {rol === "cliente" && (
        <>
          <Link to="/dashboard/cliente" className="nav-link">
            <i className="fas fa-house"></i> Home
          </Link>

          <Link to="/dashboard/cliente/compras" className="nav-link">
            <i className="fas fa-bag-shopping"></i> Compras
          </Link>

          <Link to="/dashboard/cliente/pagos" className="nav-link">
            <i className="fas fa-wallet"></i> Pagos
          </Link>
        </>
      )}

      <hr className="mx-4 opacity-25" />

      {/* HashRouter */}
      <a href="/#/" className="nav-link">
        <i className="fas fa-external-link-alt"></i> Ver sitio web
      </a>

      <button
        type="button"
        onClick={cerrarSesion}
        className="nav-link text-warning w-100 text-start border-0 bg-transparent"
      >
        <i className="fas fa-sign-out-alt"></i> Cerrar sesión
      </button>
    </nav>
  );
}

export default DashboardSidebar;