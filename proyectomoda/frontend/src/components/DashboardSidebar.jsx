import { Link } from "react-router-dom";

function DashboardSidebar() {
  return (
    <nav id="sidebar">
      <div className="sidebar-header">
        <h4 className="mb-0 fw-bold sidebar-title">
          VIRTUALITY <span className="fw-light text-white">MALL</span>
        </h4>

        <small className="text-white-50">
          Panel de usuario
        </small>
      </div>

      <a href="#" className="nav-link">
        <i className="fas fa-house"></i> Home
      </a>

      <Link to="/admin/clientes" className="nav-link">
        <i className="fas fa-user-tie"></i> Clientes / Emprendedores
      </Link>

      <Link to="/admin/tiendas" className="nav-link">
        <i className="fas fa-store"></i> Tiendas
      </Link>

      <Link to="/admin/usuarios" className="nav-link">
        <i className="fas fa-users-cog"></i> Usuarios
      </Link>

      <Link to="/emprendedor/productos" className="nav-link">
        <i className="fas fa-box-open"></i> Productos
      </Link>

      <Link to="/emprendedor/pedidos" className="nav-link">
        <i className="fas fa-shopping-cart"></i> Pedidos
      </Link>

      <Link to="/emprendedor/pagos" className="nav-link">
        <i className="fas fa-credit-card"></i> Pagos
      </Link>

      <Link to="/cliente/compras" className="nav-link">
        <i className="fas fa-bag-shopping"></i> Compras
      </Link>

      <Link to="/cliente/pagos" className="nav-link">
        <i className="fas fa-wallet"></i> Pagos
      </Link>

      <hr className="mx-4 opacity-25" />

      <Link to="/" className="nav-link">
        <i className="fas fa-external-link-alt"></i> Ver sitio web
      </Link>

      <button
        type="button"
        className="nav-link text-warning w-100 text-start border-0 bg-transparent"
      >
        <i className="fas fa-sign-out-alt"></i> Cerrar sesión
      </button>
    </nav>
  );
}

export default DashboardSidebar;