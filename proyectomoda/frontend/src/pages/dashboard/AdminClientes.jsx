import { useEffect, useState } from "react";
import { apiFetch } from "../../api";

const API_URL = "/emprendedores";

function AdminClientes() {
  const [emprendedores, setEmprendedores] = useState([]);
  const [cargando, setCargando] = useState(true);

  const [modal, setModal] = useState(null);
  const [seleccionado, setSeleccionado] = useState(null);

  const [form, setForm] = useState({
    nombre: "",
    apellido: "",
    email: "",
    tel: "",
    nombre_marca: "",
    password: "",
    password_confirmation: "",
  });

  useEffect(() => {
    obtenerEmprendedores();
  }, []);

  async function obtenerEmprendedores() {
    setCargando(true);

    try {
      const respuesta = await apiFetch(API_URL);
      const data = await respuesta.json();

      const sinDuplicados = [];

      (data.emprendedores || []).forEach((emprendedor) => {
        const email = emprendedor.usuario?.email || emprendedor.email;

        const existe = sinDuplicados.some((item) => {
          const itemEmail = item.usuario?.email || item.email;
          return itemEmail === email;
        });

        if (!existe) {
          sinDuplicados.push(emprendedor);
        }
      });

      setEmprendedores(sinDuplicados);
    } catch (error) {
      console.log(error);
    }

    setCargando(false);
  }

  function abrirNuevo() {
    setForm({
      nombre: "",
      apellido: "",
      email: "",
      tel: "",
      nombre_marca: "",
      password: "",
      password_confirmation: "",
    });

    setSeleccionado(null);
    setModal("nuevo");
  }

  function abrirVer(emprendedor) {
    setSeleccionado(emprendedor);
    setModal("ver");
  }

  function abrirEditar(emprendedor) {
    setSeleccionado(emprendedor);

    setForm({
      nombre: emprendedor.usuario?.nombre || emprendedor.nombre || "",
      apellido: emprendedor.usuario?.apellido || emprendedor.apellido || "",
      email: emprendedor.usuario?.email || emprendedor.email || "",
      tel: emprendedor.usuario?.tel || emprendedor.tel || "",
      nombre_marca:
        emprendedor.nombre_marca ||
        emprendedor.emprendedor?.nombre_marca ||
        "",
      password: "",
      password_confirmation: "",
    });

    setModal("editar");
  }

  function cerrarModal() {
    setModal(null);
    setSeleccionado(null);
  }

  function cambiarCampo(e) {
    setForm({
      ...form,
      [e.target.name]: e.target.value,
    });
  }

  async function guardarNuevo(e) {
    e.preventDefault();

    try {
      const respuesta = await apiFetch(API_URL, {
        method: "POST",
        body: JSON.stringify(form),
      });

      if (!respuesta.ok) {
        alert("No se pudo guardar. Revisa los datos.");
        return;
      }

      cerrarModal();
      obtenerEmprendedores();
    } catch (error) {
      console.log(error);
      alert("Error al conectar con el servidor.");
    }
  }

  async function guardarEdicion(e) {
    e.preventDefault();

    const id = seleccionado?.usuario?.id || seleccionado?.id;

    try {
      const datos = { ...form };

      if (!datos.password) {
        delete datos.password;
        delete datos.password_confirmation;
      }

      const respuesta = await apiFetch(`${API_URL}/${id}`, {
        method: "PUT",
        body: JSON.stringify(datos),
      });

      if (!respuesta.ok) {
        alert("No se pudo actualizar. Revisa los datos.");
        return;
      }

      cerrarModal();
      obtenerEmprendedores();
    } catch (error) {
      console.log(error);
      alert("Error al conectar con el servidor.");
    }
  }

  async function eliminar(emprendedor) {
    const id = emprendedor.usuario?.id || emprendedor.id;

    const confirmar = window.confirm(
      "¿Eliminar emprendedor? Esta acción no se puede deshacer."
    );

    if (!confirmar) return;

    try {
      const respuesta = await apiFetch(`${API_URL}/${id}`, {
        method: "DELETE",
      });

      if (!respuesta.ok) {
        alert("No se pudo eliminar el emprendedor.");
        return;
      }

      obtenerEmprendedores();
    } catch (error) {
      console.log(error);
      alert("Error al conectar con el servidor.");
    }
  }

  return (
    <>
      <div className="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
          <h2 className="fw-bold m-0">Emprendedores</h2>
          <p className="text-muted m-0">CRUD exclusivo de emprendedores</p>
        </div>

        <button className="btn btn-accent" onClick={abrirNuevo}>
          <i className="fas fa-plus"></i> Nuevo emprendedor
        </button>
      </div>

      <div className="table-card">
        <div className="table-responsive">
          <table className="table align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre completo</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Marca</th>
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

              {!cargando && emprendedores.length === 0 && (
                <tr>
                  <td colSpan="6" className="text-center text-muted">
                    No hay emprendedores registrados
                  </td>
                </tr>
              )}

              {!cargando &&
                emprendedores.map((emprendedor) => (
                  <tr key={emprendedor.usuario?.id || emprendedor.id}>
                    <td>{emprendedor.usuario?.id || emprendedor.id}</td>

                    <td>
                      {emprendedor.usuario?.nombre || emprendedor.nombre}{" "}
                      {emprendedor.usuario?.apellido || emprendedor.apellido}
                    </td>

                    <td>{emprendedor.usuario?.email || emprendedor.email}</td>

                    <td>{emprendedor.usuario?.tel || emprendedor.tel}</td>

                    <td>
                      {emprendedor.nombre_marca ||
                        emprendedor.emprendedor?.nombre_marca}
                    </td>

                    <td className="d-flex gap-2">
                      <button
                        className="btn btn-info btn-sm text-white"
                        onClick={() => abrirVer(emprendedor)}
                      >
                        Ver
                      </button>

                      <button
                        className="btn btn-warning btn-sm"
                        onClick={() => abrirEditar(emprendedor)}
                      >
                        Editar
                      </button>

                      <button
                        onClick={() => eliminar(emprendedor)}
                        className="btn btn-danger btn-sm"
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
                  <h2 className="fw-bold m-0">Detalle del emprendedor</h2>
                  <p className="text-muted m-0">
                    Información completa del registro
                  </p>
                </div>

                <p>
                  <strong>ID:</strong>{" "}
                  {seleccionado.usuario?.id || seleccionado.id}
                </p>
                <p>
                  <strong>Nombre:</strong>{" "}
                  {seleccionado.usuario?.nombre || seleccionado.nombre}
                </p>
                <p>
                  <strong>Apellido:</strong>{" "}
                  {seleccionado.usuario?.apellido || seleccionado.apellido}
                </p>
                <p>
                  <strong>Email:</strong>{" "}
                  {seleccionado.usuario?.email || seleccionado.email}
                </p>
                <p>
                  <strong>Teléfono:</strong>{" "}
                  {seleccionado.usuario?.tel || seleccionado.tel}
                </p>
                <p>
                  <strong>Marca:</strong>{" "}
                  {seleccionado.nombre_marca ||
                    seleccionado.emprendedor?.nombre_marca}
                </p>
                <p>
                  <strong>Rol:</strong> Emprendedor
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
                    {modal === "nuevo"
                      ? "Crear emprendedor"
                      : "Editar emprendedor"}
                  </h2>

                  <p className="text-muted m-0">
                    {modal === "nuevo"
                      ? "Formulario de registro de emprendedores"
                      : "Actualiza la información del emprendedor"}
                  </p>
                </div>

                <form
                  onSubmit={modal === "nuevo" ? guardarNuevo : guardarEdicion}
                >
                  <Campo
                    label="Nombre"
                    name="nombre"
                    value={form.nombre}
                    onChange={cambiarCampo}
                  />

                  <Campo
                    label="Apellido"
                    name="apellido"
                    value={form.apellido}
                    onChange={cambiarCampo}
                  />

                  <Campo
                    label="Correo"
                    name="email"
                    type="email"
                    value={form.email}
                    onChange={cambiarCampo}
                  />

                  <Campo
                    label="Teléfono"
                    name="tel"
                    value={form.tel}
                    onChange={cambiarCampo}
                  />

                  <Campo
                    label="Nombre de la marca"
                    name="nombre_marca"
                    value={form.nombre_marca}
                    onChange={cambiarCampo}
                  />

                  <Campo
                    label={
                      modal === "editar"
                        ? "Contraseña (dejar vacío para no cambiar)"
                        : "Contraseña"
                    }
                    name="password"
                    type="password"
                    value={form.password}
                    onChange={cambiarCampo}
                  />

                  <Campo
                    label="Confirmar contraseña"
                    name="password_confirmation"
                    type="password"
                    value={form.password_confirmation}
                    onChange={cambiarCampo}
                  />

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

export default AdminClientes;