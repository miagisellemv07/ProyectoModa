function DashboardHome() {
  const user = JSON.parse(localStorage.getItem("user"));

  return (
    <>
      <div className="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
        <div>
          <h2 className="fw-bold m-0">
            Bienvenido, {user?.nombre || user?.name || "Usuario"}
          </h2>

          <p className="text-muted m-0">
            Dashboard principal del sistema Virtuality Mall
          </p>
        </div>

        <div className="text-muted small">
          Rol actual: <strong>{user?.rol}</strong>
        </div>
      </div>

      <div className="row g-4 mb-4">
        <div className="col-md-4">
          <div className="stat-card">
            <div className="stat-icon bg-accent-soft">
              <i className="fas fa-user"></i>
            </div>

            <div className="text-muted small fw-medium">
              Usuario autenticado
            </div>

            <div className="h4 fw-bold mt-1">
              {user?.nombre || user?.name || "Usuario"} {user?.apellido || ""}
            </div>
          </div>
        </div>

        <div className="col-md-4">
          <div className="stat-card">
            <div className="stat-icon bg-blue-soft">
              <i className="fas fa-envelope"></i>
            </div>

            <div className="text-muted small fw-medium">
              Correo electrónico
            </div>

            <div className="h5 fw-bold mt-1">
              {user?.email}
            </div>
          </div>
        </div>

        <div className="col-md-4">
          <div className="stat-card">
            <div className="stat-icon bg-purple-soft">
              <i className="fas fa-shield-halved"></i>
            </div>

            <div className="text-muted small fw-medium">
              Nivel de acceso
            </div>

            <div className="h4 fw-bold mt-1 text-capitalize">
              {user?.rol}
            </div>
          </div>
        </div>
      </div>

      <div className="table-card">
        <h4 className="fw-bold mb-3">
          Acciones disponibles
        </h4>

        {user?.rol === "admin" && (
          <>
            <p className="mb-2">
              Como <strong>administrador</strong> puedes acceder a:
            </p>

            <ul className="mb-0">
              <li>Home</li>
              <li>Clientes / Emprendedores</li>
              <li>Tiendas</li>
              <li>Usuarios</li>
            </ul>
          </>
        )}

        {user?.rol === "emprendedor" && (
          <>
            <p className="mb-2">
              Como <strong>emprendedor</strong> puedes acceder a:
            </p>

            <ul className="mb-0">
              <li>Home</li>
              <li>Productos</li>
              <li>Pedidos</li>
              <li>Pagos</li>
            </ul>
          </>
        )}

        {user?.rol === "cliente" && (
          <>
            <p className="mb-2">
              Como <strong>cliente</strong> puedes acceder a:
            </p>

            <ul className="mb-0">
              <li>Home</li>
              <li>Compras</li>
              <li>Pagos</li>
            </ul>
          </>
        )}

        {!user?.rol && (
          <p className="mb-0 text-danger">
            Este usuario no tiene un rol válido asignado.
          </p>
        )}
      </div>
    </>
  );
}

export default DashboardHome;