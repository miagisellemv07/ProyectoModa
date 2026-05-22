import { useEffect, useState } from "react";

const API_PRODUCTOS = "http://127.0.0.1:8000/api/productos";
const API_TIENDAS = "http://127.0.0.1:8000/api/tiendas";
const STORAGE_URL = "http://127.0.0.1:8000/storage/";

function obtenerToken() {
  return localStorage.getItem("token");
}

function cerrarSesionExpirada() {
  localStorage.removeItem("token");
  localStorage.removeItem("user");
  window.location.href = "/login";
}

function headersAuth() {
  return {
    Accept: "application/json",
    Authorization: `Bearer ${obtenerToken()}`,
  };
}

async function mostrarError(respuesta, mensajeDefault) {
  const data = await respuesta.json().catch(() => ({}));

  if (respuesta.status === 401 || data.error === "Unauthorized") {
    cerrarSesionExpirada();
    return;
  }

  if (data.errors) {
    const errores = Object.values(data.errors).flat().join("\n");
    alert(errores);
    return;
  }

  alert(data.message || data.error || data.msg || mensajeDefault);
}

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
    const respuesta = await fetch(API_PRODUCTOS, {
      headers: headersAuth(),
    });

    const data = await respuesta.json();

    if (!respuesta.ok) {
      if (respuesta.status === 401 || data.error === "Unauthorized") {
        cerrarSesionExpirada();
        return;
      }

      setProductos([]);
      return;
    }

    const propios = (data.data || []).filter(
      (producto) =>
        producto.tienda?.emprendedor?.usuario?.email === user?.email
    );

    setProductos(propios);
  } catch (error) {
    console.log(error);
    setProductos([]);
  } finally {
    setCargando(false);
  }
}

  async function obtenerTiendas() {
  try {
    const respuesta = await fetch(API_TIENDAS, {
      headers: headersAuth(),
    });

    const data = await respuesta.json();

    if (!respuesta.ok) {
      if (respuesta.status === 401 || data.error === "Unauthorized") {
        cerrarSesionExpirada();
        return;
      }

      setTiendas([]);
      return;
    }

    const propias = (data.data || []).filter(
      (tienda) =>
        tienda.emprendedor?.usuario?.email === user?.email
    );

    setTiendas(propias);
  } catch (error) {
    console.log(error);
    setTiendas([]);
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
      return `http://127.0.0.1:8000/${producto.imagen}`;
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
      headers: headersAuth(),
      body: crearFormData(),
    });

    if (!respuesta.ok) {
      await mostrarError(
        respuesta,
        "No se pudo guardar el producto. Revisa los datos."
      );
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
      headers: headersAuth(),
      body: datos,
    });

    if (!respuesta.ok) {
      await mostrarError(
        respuesta,
        "No se pudo actualizar el producto. Revisa los datos."
      );
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
    const respuesta = await fetch(`${API_PRODUCTOS}/${id}`, {
      method: "DELETE",
      headers: headersAuth(),
    });

    if (!respuesta.ok) {
      await mostrarError(respuesta, "No se pudo eliminar el producto.");
      return;
    }

    obtenerProductos();
  } catch (error) {
    console.log(error);
    alert("Error al conectar con Laravel.");
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