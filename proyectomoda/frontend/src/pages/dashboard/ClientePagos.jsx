function ClientePagos() {
  return (
    <>
      <div className="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">

        <div>
          <h2 className="fw-bold m-0 text-dark">
            Mis pagos
          </h2>

          <p className="text-muted m-0">
            Vista exclusiva para clientes.
          </p>
        </div>

      </div>


      <div className="user-card">

        <h4 className="fw-bold mb-3">
          Módulo de pagos del cliente
        </h4>

        <p className="mb-0">
          Aquí el cliente podrá revisar el historial de pagos de sus compras.
        </p>

      </div>
    </>
  );
}

export default ClientePagos;