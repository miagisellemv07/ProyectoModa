import { useState } from "react";
import { Link } from "react-router-dom";

function Register() {
  const [form, setForm] = useState({
    nombre: "",
    apellido: "",
    email: "",
    tel: "",
    direccion: "",
    password: "",
    password_confirmation: "",
  });

  const [error, setError] = useState("");

  function cambiarCampo(e) {
    setForm({
      ...form,
      [e.target.name]: e.target.value,
    });
  }

  async function registrar(e) {
    e.preventDefault();
    setError("");

    try {
      const respuesta = await fetch("http://127.0.0.1:8000/api/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(form),
      });

      const data = await respuesta.json();

      if (!respuesta.ok) {
        setError("No se pudo registrar. Revisa los datos.");
        return;
      }

      localStorage.setItem("token", data.token);
      localStorage.setItem("user", JSON.stringify(data.user));

      window.location.href = "/dashboard/cliente";
    } catch (error) {
      console.log(error);
      setError("No se pudo conectar con Laravel");
    }
  }

  return (
    <div className="container">
      <div className="register-wrapper">
        <div className="register-card">
          <div className="register-header">
            <div className="icon-circle">
              <i className="fas fa-user-plus"></i>
            </div>

            <h2>Crear cuenta</h2>

            <p>Regístrate en Virtuality Emprendedores Mall</p>
          </div>

          <div className="register-body">
            <form onSubmit={registrar}>
              {error && (
                <div className="alert alert-danger">
                  {error}
                </div>
              )}

              <div className="row">
                <div className="col-md-6 mb-3">
                  <label className="form-label">Nombre</label>

                  <input
                    name="nombre"
                    className="form-control"
                    placeholder="Ingresa tu nombre"
                    value={form.nombre}
                    onChange={cambiarCampo}
                    required
                  />
                </div>

                <div className="col-md-6 mb-3">
                  <label className="form-label">Apellido</label>

                  <input
                    name="apellido"
                    className="form-control"
                    placeholder="Ingresa tu apellido"
                    value={form.apellido}
                    onChange={cambiarCampo}
                    required
                  />
                </div>
              </div>

              <div className="mb-3">
                <label className="form-label">Correo</label>

                <input
                  type="email"
                  name="email"
                  className="form-control"
                  placeholder="correo@ejemplo.com"
                  value={form.email}
                  onChange={cambiarCampo}
                  required
                />
              </div>

              <div className="mb-3">
                <label className="form-label">Teléfono</label>

                <input
                  name="tel"
                  className="form-control"
                  value={form.tel}
                  onChange={cambiarCampo}
                />
              </div>

              <div className="mb-3">
                <label className="form-label">Dirección</label>

                <input
                  name="direccion"
                  className="form-control"
                  value={form.direccion}
                  onChange={cambiarCampo}
                />
              </div>

              <div className="row">
                <div className="col-md-6">
                  <label className="form-label">Contraseña</label>

                  <input
                    type="password"
                    name="password"
                    className="form-control"
                    value={form.password}
                    onChange={cambiarCampo}
                    required
                  />
                </div>

                <div className="col-md-6">
                  <label className="form-label">
                    Confirmar contraseña
                  </label>

                  <input
                    type="password"
                    name="password_confirmation"
                    className="form-control"
                    value={form.password_confirmation}
                    onChange={cambiarCampo}
                    required
                  />
                </div>
              </div>

              <button className="btn btn-register mt-4">
                Registrarme
              </button>

              <div className="text-center mt-4">
                <Link to="/login" className="register-link">
                  ¿Ya tienes cuenta?
                </Link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Register;