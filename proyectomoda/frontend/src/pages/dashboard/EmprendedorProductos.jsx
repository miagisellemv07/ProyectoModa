import { useEffect, useState } from "react";

const API_PRODUCTOS = "/api/productos";
const API_TIENDAS = "/api/tiendas";
const STORAGE_URL = "/storage/";

function EmprendedorProductos() {
  const user = JSON.parse(localStorage.getItem("user"));

  const [productos, setProductos] = useState([]);
  const [tiendas, setTiendas] = useState([]);
  const [cargando, setCargando] = useState(true);

  const [modal, setModal] = useState(null);
  const [seleccionado, setSeleccionado] = useState(null);

  const [form, setForm] = useState({
    nombre: "",
    descripcion: "",
    precio: "",
    stock: "",
    tienda_id: "",
    imagen: null,
  });

  useEffect(() => {
    obtenerProductos();
    obtenerTiendas();
  }, []);

  async function obtenerProductos() {
    setCargando(true);

    try {
      const respuesta = await fetch(API_PRODUCTOS);
      const data = await respuesta.json();

      const propios = (data.data || []).filter(
        (producto) =>
          producto.tienda?.emprendedor?.usuario?.email === user?.email
      );

      setProductos(propios);
    } catch (error) {
      console.log(error);
    }

    setCargando(false);
  }

  async function obtenerTiendas() {
    try {
      const respuesta = await fetch(API_TIENDAS);
      const data = await respuesta.json();

      const propias = (data.data || []).filter(
        (tienda) =>
          tienda.emprendedor?.usuario?.email === user?.email
      );

      setTiendas(propias);
    } catch (error) {
      console.log(error);
    }
  }

  function obtenerImagen(producto) {
    if (!producto.imagen) {
      return "https://via.placeholder.com/400x300";
    }

    if (producto.imagen.startsWith("http")) {
      return producto.imagen;
    }

    if (producto.imagen.startsWith("storage/")) {
      return `/${producto.imagen}`;
    }

    return `${STORAGE_URL}${producto.imagen}`;
  }

  function abrirNuevo() {
    setSeleccionado(null);

    setForm({
      nombre: "",
      descripcion: "",
      precio: "",
      stock: "",
      tienda_id: "",
      imagen: null,
    });

    setModal("nuevo");
  }

  function abrirVer(producto) {
    setSeleccionado(producto);
    setModal("ver");
  }

  function abrirEditar(producto) {
    setSeleccionado(producto);

    setForm({
      nombre: producto.nombre || "",
      descripcion: producto.descripcion || "",
      precio: producto.precio || "",
      stock: producto.stock || "",
      tienda_id: producto.tienda_id || "",
      imagen: null,
    });

    setModal("editar");
  }

  function cerrarModal() {
    setModal(null);
    setSeleccionado(null);
  }

  function cambiarCampo(e) {
    const { name, value, files } = e.target;

    if (name === "imagen") {
      setForm({
        ...form,
        imagen: files[0],
      });
      return;
    }

    setForm({
      ...form,
      [name]: value,
    });
  }

  function crearFormData() {
    const datos = new FormData();

    datos.append("nombre", form.nombre);
    datos.append("descripcion", form.descripcion);
    datos.append("precio", form.precio);
    datos.append("stock", form.stock);
    datos.append("tienda_id", form.tienda_id);

    if (form.imagen) {
      datos.append("imagen", form.imagen);
    }

    return datos;
  }

  async function guardarNuevo(e) {
    e.preventDefault();

    try {
      const respuesta = await fetch(API_PRODUCTOS, {
        method: "POST",
        headers: {
          Accept: "application/json",
        },
        body: crearFormData(),
      });

      if (!respuesta.ok) {
        alert("No se pudo guardar el producto. Revisa los datos.");
        return;
      }

      cerrarModal();
      obtenerProductos();
    } catch (error) {
      console.log(error);
      alert("Error al conectar con Laravel.");
    }
  }

  async function guardarEdicion(e) {
    e.preventDefault();

    try {
      const datos = crearFormData();
      datos.append("_method", "PUT");

      const respuesta = await fetch(`${API_PRODUCTOS}/${seleccionado.id}`, {
        method: "POST",
        headers: {
          Accept: "application/json",
        },
        body: datos,
      });

      if (!respuesta.ok) {
        alert("No se pudo actualizar el producto. Revisa los datos.");
        return;
      }

      cerrarModal();
      obtenerProductos();
    } catch (error) {
      console.log(error);
      alert("Error al conectar con Laravel.");
    }
  }

  async function eliminar(id) {
    const confirmar = window.confirm(
      "¿Eliminar producto? Esta acción no se puede deshacer."
    );

    if (!confirmar) return;

    try {
      await fetch(`${API_PRODUCTOS}/${id}`, {
        method: "DELETE",
        headers: {
          Accept: "application/json",
        },
      });

      obtenerProductos();
    } catch (error) {
      console.log(error);
    }
  }

  return (
    <>
      <div className="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 className="fw-bold m-0">Productos</h2>
          <p className="text-muted m-0">Vista exclusiva para emprendedores</p>
        </div>

        <button className="btn btn-accent" onClick={abrirNuevo}>
          <i className="fas fa-plus"></i> Nuevo producto
        </button>
      </div>

      <div className="table-card">
        <div className="table-responsive">
          <table className="table align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Tienda</th>
                <th>Precio</th>
                <th>Stock</th>
                <th width="220">Acciones</th>
              </tr>
            </thead>

            <tbody>
              {cargando && (
                <tr>
                  <td colSpan="7" className="text-center text-muted">
                    Cargando...
                  </td>
                </tr>
              )}

              {!cargando && productos.length === 0 && (
                <tr>
                  <td colSpan="7" className="text-center text-muted">
                    No hay productos registrados.
                  </td>
                </tr>
              )}

              {!cargando &&
                productos.map((producto) => (
                  <tr key={producto.id}>
                    <td>{producto.id}</td>

                    <td>
                      <img
                        src={obtenerImagen(producto)}
                        alt={producto.nombre}
                        style={{
                          width: "70px",
                          height: "55px",
                          objectFit: "cover",
                          borderRadius: "10px",
                        }}
                      />
                    </td>

                    <td>{producto.nombre}</td>

                    <td>{producto.tienda?.nombre || "Sin tienda"}</td>

                    <td>${Number(producto.precio).toFixed(2)}</td>

                    <td>{producto.stock}</td>

                    <td className="d-flex gap-2">
                      <button
                        className="btn btn-sm btn-info text-white"
                        onClick={() => abrirVer(producto)}
                      >
                        Ver
                      </button>

                      <button
                        className="btn btn-sm btn-warning text-dark"
                        onClick={() => abrirEditar(producto)}
                      >
                        Editar
                      </button>

                      <button
                        className="btn btn-sm btn-danger"
                        onClick={() => eliminar(producto.id)}
                      >
                        Eliminar
                      </button>
                    </td>
                  </tr>
                ))}
            </tbody>
          </table>
        </div>
      </div>

      {modal && (
        <div className="modal-backdrop-custom">
          <div className="modal-card-custom">
            {modal === "ver" && seleccionado && (
              <>
                <div className="mb-4">
                  <h2 className="fw-bold m-0">Detalle del producto</h2>
                  <p className="text-muted m-0">
                    Información completa del producto
                  </p>
                </div>

                <img
                  src={obtenerImagen(seleccionado)}
                  alt={seleccionado.nombre}
                  style={{
                    width: "180px",
                    height: "130px",
                    objectFit: "cover",
                    borderRadius: "12px",
                    marginBottom: "15px",
                  }}
                />

                <p><strong>ID:</strong> {seleccionado.id}</p>
                <p><strong>Nombre:</strong> {seleccionado.nombre}</p>
                <p><strong>Descripción:</strong> {seleccionado.descripcion}</p>
                <p><strong>Precio:</strong> ${Number(seleccionado.precio).toFixed(2)}</p>
                <p><strong>Stock:</strong> {seleccionado.stock}</p>
                <p><strong>Tienda:</strong> {seleccionado.tienda?.nombre || "Sin tienda"}</p>

                <button className="btn btn-secondary" onClick={cerrarModal}>
                  Volver
                </button>
              </>
            )}

            {(modal === "nuevo" || modal === "editar") && (
              <>
                <div className="mb-4">
                  <h2 className="fw-bold m-0">
                    {modal === "nuevo" ? "Crear producto" : "Editar producto"}
                  </h2>

                  <p className="text-muted m-0">
                    {modal === "nuevo"
                      ? "Formulario de alta de productos"
                      : "Actualiza la información del producto"}
                  </p>
                </div>

                <form
                  onSubmit={modal === "nuevo" ? guardarNuevo : guardarEdicion}
                  encType="multipart/form-data"
                >
                  <Campo
                    label="Nombre"
                    name="nombre"
                    value={form.nombre}
                    onChange={cambiarCampo}
                  />

                  <div className="mb-3">
                    <label className="form-label">Descripción</label>
                    <textarea
                      name="descripcion"
                      className="form-control"
                      rows="4"
                      value={form.descripcion}
                      onChange={cambiarCampo}
                    />
                  </div>

                  <Campo
                    label="Precio"
                    name="precio"
                    type="number"
                    value={form.precio}
                    onChange={cambiarCampo}
                  />

                  <Campo
                    label="Stock"
                    name="stock"
                    type="number"
                    value={form.stock}
                    onChange={cambiarCampo}
                  />

                  <div className="mb-3">
                    <label className="form-label">Tienda</label>
                    <select
                      name="tienda_id"
                      className="form-select"
                      value={form.tienda_id}
                      onChange={cambiarCampo}
                    >
                      <option value="">Seleccione una tienda</option>

                      {tiendas.map((tienda) => (
                        <option key={tienda.id} value={tienda.id}>
                          {tienda.nombre}
                        </option>
                      ))}
                    </select>
                  </div>

                  <div className="mb-3">
                    <label className="form-label">Imagen del producto</label>
                    <input
                      type="file"
                      name="imagen"
                      className="form-control"
                      accept="image/png, image/jpeg, image/jpg, image/webp"
                      onChange={cambiarCampo}
                    />
                  </div>

                  {modal === "editar" && seleccionado?.imagen && (
                    <div className="mb-3">
                      <label className="form-label d-block">Imagen actual</label>
                      <img
                        src={obtenerImagen(seleccionado)}
                        alt={seleccionado.nombre}
                        style={{
                          width: "160px",
                          height: "120px",
                          objectFit: "cover",
                          borderRadius: "12px",
                        }}
                      />
                    </div>
                  )}

                  <div className="d-flex gap-2">
                    <button type="submit" className="btn btn-accent">
                      {modal === "nuevo" ? "Guardar" : "Actualizar"}
                    </button>

                    <button
                      type="button"
                      className="btn btn-secondary"
                      onClick={cerrarModal}
                    >
                      Cancelar
                    </button>
                  </div>
                </form>
              </>
            )}
          </div>
        </div>
      )}
    </>
  );
}

function Campo({ label, name, value, onChange, type = "text" }) {
  return (
    <div className="mb-3">
      <label className="form-label">{label}</label>

      <input
        type={type}
        name={name}
        className="form-control"
        value={value}
        onChange={onChange}
      />
    </div>
  );
}

export default EmprendedorProductos;