function EmprendedorProductos() {
  return (
    <>
      <div className="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">

        <div>
          <h2 className="fw-bold m-0 text-dark">
            Productos
          </h2>

          <p className="text-muted m-0">
            Vista exclusiva para emprendedores.
          </p>
        </div>

      </div>



      <div className="user-card mb-4">

        <h4 className="fw-bold mb-3">
          Módulo de Productos
        </h4>

        <p className="mb-0">
          Aquí el emprendedor podrá gestionar sus productos.
        </p>

      </div>



      <div className="user-card">

        <h4 className="fw-bold mb-4">
          Agregar producto
        </h4>


        <form>

          <div className="mb-3">

            <label className="form-label fw-bold">
              Nombre del producto
            </label>

            <input
              type="text"
              className="form-control"
              placeholder="Ejemplo: Vestido elegante"
            />

          </div>



          <div className="mb-3">

            <label className="form-label fw-bold">
              Descripción
            </label>

            <textarea
              className="form-control"
              rows="3"
              placeholder="Describe el producto"
            />

          </div>



          <div className="mb-3">

            <label className="form-label fw-bold">
              Precio
            </label>

            <input
              type="number"
              className="form-control"
              placeholder="399.99"
            />

          </div>



          <div className="mb-3">

            <label className="form-label fw-bold">
              Stock
            </label>

            <input
              type="number"
              className="form-control"
              placeholder="20"
            />

          </div>



          <div className="mb-3">

            <label className="form-label fw-bold">
              ID de tienda
            </label>

            <input
              type="number"
              className="form-control"
              placeholder="Ejemplo: 1"
            />

          </div>



          <div className="mb-4">

            <label className="form-label fw-bold">
              Imagen del producto
            </label>

            <input
              type="file"
              className="form-control"
            />

          </div>



          <button
            type="submit"
            className="btn btn-accent"
          >
            Guardar producto
          </button>

        </form>

      </div>
    </>
  );
}

export default EmprendedorProductos;