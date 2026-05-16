function AdminTiendas() {
  return (
    <>
      <div className="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">

        <div>
          <h2 className="fw-bold m-0 text-dark">
            Tiendas
          </h2>

          <p className="text-muted m-0">
            Vista exclusiva para administradores.
          </p>
        </div>

      </div>


      <div className="user-card">

        <h4 className="fw-bold mb-3">
          Módulo de Tiendas
        </h4>

        <p className="mb-0">
          Aquí el administrador podrá administrar las tiendas registradas.
        </p>

      </div>
    </>
  );
}

export default AdminTiendas;