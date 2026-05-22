import { useEffect, useState } from "react";
import { apiFetch } from "../../api";

const API_TIENDAS = "/tiendas";
const API_EMPRENDEDORES = "/emprendedores";

function AdminTiendas() {
  const [tiendas, setTiendas] = useState([]);
  const [emprendedores, setEmprendedores] = useState([]);
  const [cargando, setCargando] = useState(true);

  const [modal, setModal] = useState(null);
  const [seleccionada, setSeleccionada] = useState(null);

  const [form, setForm] = useState({
    nombre: "",
    logo: "",
    descripcion: "",
    categoria: "",
    emprendedor_id: "",
  });

  useEffect(() => {
    obtenerTiendas();
    obtenerEmprendedores();
  }, []);

  async function obtenerTiendas() {
    setCargando(true);

    try {
      const respuesta = await apiFetch(API_TIENDAS);
      const data = await respuesta.json();

      const sinDuplicados = [];

      (data.data || []).forEach((tienda) => {
        const clave = `${tienda.nombre}-${tienda.categoria}-${tienda.logo}-${tienda.emprendedor?.usuario?.email}`;

        const existe = sinDuplicados.some((item) => {
          const claveItem = `${item.nombre}-${item.categoria}-${item.logo}-${item.emprendedor?.usuario?.email}`;
          return claveItem === clave;
        });

        if (!existe) {
          sinDuplicados.push(tienda);
        }
      });

      setTiendas(sinDuplicados);
    } catch (error) {
      console.log(error);
      alert("Error al cargar las tiendas.");
    }

    setCargando(false);
  }

  async function obtenerEmprendedores() {
    try {
      const respuesta = await apiFetch(API_EMPRENDEDORES);
      const data = await respuesta.json();

      const lista = data.emprendedores || [];
      const sinDuplicados = [];

      lista.forEach((emp) => {
        const email = emp.usuario?.email || emp.email;

        const existe = sinDuplicados.some((item) => {
          const itemEmail = item.usuario?.email || item.email;
          return itemEmail === email;
        });

        if (!existe) {
          sinDuplicados.push(emp);
        }
      });

      setEmprendedores(sinDuplicados);
    } catch (error) {
      console.log(error);
      alert("Error al cargar los emprendedores.");
    }
  }

  function obtenerIdEmprendedor(emp) {
    return emp.emprendedor?.id || emp.id;
  }

  function obtenerNombreEmprendedor(emp) {
    return `${emp.usuario?.nombre || emp.nombre || ""} ${emp.usuario?.apellido || emp.apellido || ""}`;
  }

  function obtenerMarcaEmprendedor(emp) {
    return emp.nombre_marca || emp.emprendedor?.nombre_marca || "";
  }

  function abrirNuevo() {
    setSeleccionada(null);

    setForm({
      nombre: "",
      logo: "",
      descripcion: "",
      categoria: "",
      emprendedor_id: "",
    });

    setModal("nuevo");
  }

  function abrirVer(tienda) {
    setSeleccionada(tienda);
    setModal("ver");
  }

  function abrirEditar(tienda) {
    setSeleccionada(tienda);

    setForm({
      nombre: tienda.nombre || "",
      logo: tienda.logo || "",
      descripcion: tienda.descripcion || "",
      categoria: tienda.categoria || "",
      emprendedor_id: tienda.emprendedor_id || "",
    });

    setModal("editar");
  }

  function cerrarModal() {
    setModal(null);
    setSeleccionada(null);
  }

  function cambiarCampo(e) {
    setForm({
      ...form,
      [e.target.name]: e.target.value,
    });
  }

  async function guardarNueva(e) {
    e.preventDefault();

    try {
      const respuesta = await apiFetch(API_TIENDAS, {
        method: "POST",
        body: JSON.stringify(form),
      });

      if (!respuesta.ok) {
        alert("No se pudo crear la tienda. Revisa los datos.");
        return;
      }

      cerrarModal();
      obtenerTiendas();
    } catch (error) {
      console.log(error);
      alert("Error al conectar con el servidor.");
    }
  }

  async function guardarEdicion(e) {
    e.preventDefault();

    try {
      const respuesta = await apiFetch(`${API_TIENDAS}/${seleccionada.id}`, {
        method: "PUT",
        body: JSON.stringify(form),
      });

      if (!respuesta.ok) {
        alert("No se pudo actualizar la tienda. Revisa los datos.");
        return;
      }

      cerrarModal();
      obtenerTiendas();
    } catch (error) {
      console.log(error);
      alert("Error al conectar con el servidor.");
    }
  }

  async function eliminar(id) {
    const confirmar = window.confirm("¿Eliminar tienda?");

    if (!confirmar) return;

    try {
      const respuesta = await apiFetch(`${API_TIENDAS}/${id}`, {
        method: "DELETE",
      });

      if (!respuesta.ok) {
        alert("No se pudo eliminar la tienda.");
        return;
      }

      obtenerTiendas();
    } catch (error) {
      console.log(error);
      alert("Error al conectar con el servidor.");
    }
  }

  return (
    <>
      <div className="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 className="fw-bold m-0">Tiendas</h2>
          <p className="text-muted m-0">Administración de tiendas</p>
        </div>

        <button className="btn btn-accent" onClick={abrirNuevo}>
          <i className="fas fa-plus"></i> Nueva tienda
        </button>
      </div>

      <div className="table-card">
        <div className="table-responsive">
          <table className="table align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Logo</th>
                <th>Emprendedor</th>
                <th width="220">Acciones</th>
              </tr>
            </thead>

            <tbody>
              {cargando && (
                <tr>
                  <td colSpan="6" className="text-center text-muted">
                    Cargando...
                  </td>
                </tr>
              )}

              {!cargando && tiendas.length === 0 && (
                <tr>
                  <td colSpan="6" className="text-center text-muted">
                    No hay tiendas registradas.
                  </td>
                </tr>
              )}

              {!cargando &&
                tiendas.map((tienda) => (
                  <tr key={tienda.id}>
                    <td>{tienda.id}</td>
                    <td>{tienda.nombre}</td>
                    <td>{tienda.categoria}</td>
                    <td>{tienda.logo}</td>
                    <td>
                      {tienda.emprendedor?.usuario?.nombre}{" "}
                      {tienda.emprendedor?.usuario?.apellido}
                    </td>

                    <td className="d-flex gap-2">
                      <button
                        className="btn btn-sm btn-info text-white"
                        onClick={() => abrirVer(tienda)}
                      >
                        Ver
                      </button>

                      <button
                        className="btn btn-sm btn-warning text-dark"
                        onClick={() => abrirEditar(tienda)}
                      >
                        Editar
                      </button>

                      <button
                        className="btn btn-sm btn-danger"
                        onClick={() => eliminar(tienda.id)}
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
            {modal === "ver" && seleccionada && (
              <>
                <div className="mb-4">
                  <h2 className="fw-bold m-0">Detalle de la tienda</h2>
                  <p className="text-muted m-0">
                    Información completa del registro
                  </p>
                </div>

                <p>
                  <strong>ID:</strong> {seleccionada.id}
                </p>
                <p>
                  <strong>Nombre:</strong> {seleccionada.nombre}
                </p>
                <p>
                  <strong>Categoría:</strong> {seleccionada.categoria}
                </p>
                <p>
                  <strong>Logo:</strong> {seleccionada.logo}
                </p>
                <p>
                  <strong>Descripción:</strong> {seleccionada.descripcion}
                </p>
                <p>
                  <strong>Emprendedor:</strong>{" "}
                  {seleccionada.emprendedor?.usuario?.nombre}{" "}
                  {seleccionada.emprendedor?.usuario?.apellido}
                </p>
                <p>
                  <strong>Marca:</strong>{" "}
                  {seleccionada.emprendedor?.nombre_marca || "Sin marca"}
                </p>

                <button className="btn btn-secondary" onClick={cerrarModal}>
                  Volver
                </button>
              </>
            )}

            {(modal === "nuevo" || modal === "editar") && (
              <>
                <div className="mb-4">
                  <h2 className="fw-bold m-0">
                    {modal === "nuevo" ? "Crear tienda" : "Editar tienda"}
                  </h2>

                  <p className="text-muted m-0">
                    {modal === "nuevo"
                      ? "Formulario de alta de tiendas"
                      : "Actualiza la información de la tienda"}
                  </p>
                </div>

                <form onSubmit={modal === "nuevo" ? guardarNueva : guardarEdicion}>
                  <div className="mb-3">
                    <label className="form-label">Nombre</label>
                    <input
                      type="text"
                      name="nombre"
                      className="form-control"
                      value={form.nombre}
                      onChange={cambiarCampo}
                    />
                  </div>

                  <div className="mb-3">
                    <label className="form-label">Logo</label>
                    <input
                      type="text"
                      name="logo"
                      className="form-control"
                      value={form.logo}
                      onChange={cambiarCampo}
                      placeholder="Ejemplo: logo.png o URL del logo"
                    />
                  </div>

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

                  <div className="mb-3">
                    <label className="form-label">Categoría</label>
                    <input
                      type="text"
                      name="categoria"
                      className="form-control"
                      value={form.categoria}
                      onChange={cambiarCampo}
                    />
                  </div>

                  <div className="mb-3">
                    <label className="form-label">Emprendedor asignado</label>
                    <select
                      name="emprendedor_id"
                      className="form-select"
                      value={form.emprendedor_id}
                      onChange={cambiarCampo}
                    >
                      <option value="">Seleccione un emprendedor</option>

                      {emprendedores.map((emp) => (
                        <option
                          key={obtenerIdEmprendedor(emp)}
                          value={obtenerIdEmprendedor(emp)}
                        >
                          {obtenerNombreEmprendedor(emp)} -{" "}
                          {obtenerMarcaEmprendedor(emp)}
                        </option>
                      ))}
                    </select>
                  </div>

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

export default AdminTiendas;