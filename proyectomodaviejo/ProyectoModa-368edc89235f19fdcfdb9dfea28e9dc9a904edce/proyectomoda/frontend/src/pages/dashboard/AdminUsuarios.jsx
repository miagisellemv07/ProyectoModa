import { useEffect, useState } from "react";

const API_USUARIOS = "http://127.0.0.1:8000/api/users";

function obtenerToken() {
  return localStorage.getItem("token");
}

function cerrarSesionExpirada() {
  localStorage.removeItem("token");
  localStorage.removeItem("user");
  window.location.href = "/login";
}

function headersJson() {
  return {
    "Content-Type": "application/json",
    Accept: "application/json",
    Authorization: `Bearer ${obtenerToken()}`,
  };
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

  alert(data.message || data.error || data.msg || mensajeDefault);
}

function AdminUsuarios() {
  const [usuarios, setUsuarios] = useState([]);
  const [cargando, setCargando] = useState(true);

  const [modal, setModal] = useState(null);
  const [seleccionado, setSeleccionado] = useState(null);

  const [form, setForm] = useState({
    nombre: "",
    apellido: "",
    email: "",
    tel: "",
    rol: "",
    password: "",
    password_confirmation: "",
  });

  useEffect(() => {
    obtenerUsuarios();
  }, []);

  async function obtenerUsuarios() {
  setCargando(true);

  try {
    const respuesta = await fetch(API_USUARIOS, {
      headers: headersAuth(),
    });

    const data = await respuesta.json();

    if (!respuesta.ok) {
      if (respuesta.status === 401 || data.error === "Unauthorized") {
        cerrarSesionExpirada();
        return;
      }

      setUsuarios([]);
      return;
    }

    setUsuarios(data.data || []);
  } catch (error) {
    console.log(error);
  }

  setCargando(false);
}

  function abrirNuevo() {
    setSeleccionado(null);

    setForm({
      nombre: "",
      apellido: "",
      email: "",
      tel: "",
      rol: "",
      password: "",
      password_confirmation: "",
    });

    setModal("nuevo");
  }

  function abrirVer(usuario) {
    setSeleccionado(usuario);
    setModal("ver");
  }

  function abrirEditar(usuario) {
    setSeleccionado(usuario);

    setForm({
      nombre: usuario.nombre || "",
      apellido: usuario.apellido || "",
      email: usuario.email || "",
      tel: usuario.tel || "",
      rol: usuario.rol || "",
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
    const respuesta = await fetch(API_USUARIOS, {
      method: "POST",
      headers: headersJson(),
      body: JSON.stringify(form),
    });

    if (!respuesta.ok) {
      await mostrarError(respuesta, "No se pudo guardar. Revisa los datos.");
      return;
    }

    cerrarModal();
    obtenerUsuarios();
  } catch (error) {
    console.log(error);
    alert("Error al conectar con Laravel.");
  }
}

  async function guardarEdicion(e) {
  e.preventDefault();

  try {
    const datos = { ...form };

    if (!datos.password) {
      delete datos.password;
      delete datos.password_confirmation;
    }

    const respuesta = await fetch(`${API_USUARIOS}/${seleccionado.id}`, {
      method: "PUT",
      headers: headersJson(),
      body: JSON.stringify(datos),
    });

    if (!respuesta.ok) {
      await mostrarError(respuesta, "No se pudo actualizar. Revisa los datos.");
      return;
    }

    cerrarModal();
    obtenerUsuarios();
  } catch (error) {
    console.log(error);
    alert("Error al conectar con Laravel.");
  }
}

  async function eliminar(id) {
  const confirmar = window.confirm(
    "¿Eliminar usuario? Esta acción no se puede deshacer."
  );

  if (!confirmar) return;

  try {
    const respuesta = await fetch(`${API_USUARIOS}/${id}`, {
      method: "DELETE",
      headers: headersAuth(),
    });

    if (!respuesta.ok) {
      await mostrarError(respuesta, "No se pudo eliminar el usuario.");
      return;
    }

    obtenerUsuarios();
  } catch (error) {
    console.log(error);
  }
}

  return (
    <>
      <div className="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 className="fw-bold m-0">Usuarios</h2>
          <p className="text-muted m-0">CRUD de usuarios del sistema</p>
        </div>

        <button className="btn btn-accent" onClick={abrirNuevo}>
          <i className="fas fa-plus"></i> Nuevo usuario
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
                <th>Rol</th>
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

              {!cargando && usuarios.length === 0 && (
                <tr>
                  <td colSpan="6" className="text-center text-muted">
                    No hay usuarios registrados.
                  </td>
                </tr>
              )}

              {!cargando &&
                usuarios.map((usuario) => (
                  <tr key={usuario.id}>
                    <td>{usuario.id}</td>

                    <td>
                      {usuario.nombre} {usuario.apellido}
                    </td>

                    <td>{usuario.email}</td>

                    <td>{usuario.tel}</td>

                    <td>
                      <span className="badge bg-secondary text-capitalize">
                        {usuario.rol}
                      </span>
                    </td>

                    <td className="d-flex gap-2">
                      <button
                        className="btn btn-sm btn-info text-white"
                        onClick={() => abrirVer(usuario)}
                      >
                        Ver
                      </button>

                      <button
                        className="btn btn-sm btn-warning text-dark"
                        onClick={() => abrirEditar(usuario)}
                      >
                        Editar
                      </button>

                      <button
                        className="btn btn-sm btn-danger"
                        onClick={() => eliminar(usuario.id)}
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
                  <h2 className="fw-bold m-0">Detalle del usuario</h2>
                  <p className="text-muted m-0">
                    Información completa del registro
                  </p>
                </div>

                <p><strong>ID:</strong> {seleccionado.id}</p>
                <p><strong>Nombre:</strong> {seleccionado.nombre}</p>
                <p><strong>Apellido:</strong> {seleccionado.apellido}</p>
                <p><strong>Email:</strong> {seleccionado.email}</p>
                <p><strong>Teléfono:</strong> {seleccionado.tel}</p>
                <p><strong>Rol:</strong> {seleccionado.rol}</p>

                <button className="btn btn-secondary" onClick={cerrarModal}>
                  Volver
                </button>
              </>
            )}

            {(modal === "nuevo" || modal === "editar") && (
              <>
                <div className="mb-4">
                  <h2 className="fw-bold m-0">
                    {modal === "nuevo" ? "Crear usuario" : "Editar usuario"}
                  </h2>

                  <p className="text-muted m-0">
                    {modal === "nuevo"
                      ? "Formulario de registro manual"
                      : "Modificar información del usuario"}
                  </p>
                </div>

                <form onSubmit={modal === "nuevo" ? guardarNuevo : guardarEdicion}>
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

                  <div className="mb-3">
                    <label className="form-label">Rol</label>
                    <select
                      name="rol"
                      className="form-select"
                      value={form.rol}
                      onChange={cambiarCampo}
                    >
                      <option value="">Seleccione un rol</option>
                      <option value="admin">Admin</option>
                      <option value="emprendedor">Emprendedor</option>
                      <option value="cliente">Cliente</option>
                    </select>
                  </div>

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

export default AdminUsuarios;