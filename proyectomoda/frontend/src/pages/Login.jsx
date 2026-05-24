import { useState } from "react";
import { Link } from "react-router-dom";
import { apiFetch } from "../api";

function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  async function iniciarSesion(e) {
    e.preventDefault();
    setError("");

    try {
      const respuesta = await apiFetch("/login", {
        method: "POST",
        body: JSON.stringify({
          email: email,
          password: password,
        }),
      });

      const data = await respuesta.json();

      if (!respuesta.ok) {
        setError("Correo o contraseña incorrectos");
        return;
      }

      localStorage.setItem("token", data.token);
      localStorage.setItem("user", JSON.stringify(data.user));

      if (data.user.rol === "admin") {
        window.location.href = "/#/dashboard/admin";
        return;
      }

      if (data.user.rol === "cliente") {
        window.location.href = "/#/dashboard/cliente";
        return;
      }

      if (data.user.rol === "emprendedor") {
        window.location.href = "/#/dashboard/emprendedor";
        return;
      }

      window.location.href = "/#/";
    } catch (error) {
      console.log(error);
      setError("No se pudo conectar con Laravel");
    }
  }

  return (
    <div className="container">
      <div className="login-wrapper">
        <div className="login-card">
          <div className="login-header">
            <div className="icon-circle">
              <i className="fas fa-user-lock"></i>
            </div>

            <h2>Iniciar Sesión</h2>

            <p>
              Bienvenido a Virtuality Emprendedores Mall
            </p>
          </div>

          <div className="login-body">
            <form onSubmit={iniciarSesion}>
              {error && (
                <div className="alert alert-danger">
                  {error}
                </div>
              )}

              <div className="mb-3">
                <label className="form-label">
                  Correo electrónico
                </label>

                <input
                  type="email"
                  className="form-control"
                  placeholder="ejemplo@correo.com"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  required
                />
              </div>

              <div className="mb-3">
                <label className="form-label">
                  Contraseña
                </label>

                <input
                  type="password"
                  className="form-control"
                  placeholder="Ingresa tu contraseña"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  required
                />
              </div>

              <div className="mb-4 d-flex justify-content-between flex-wrap">
                <div className="form-check">
                  <input
                    className="form-check-input"
                    type="checkbox"
                  />

                  <label className="form-check-label">
                    Recordarme
                  </label>
                </div>

                <a href="#" className="login-link">
                  ¿Olvidaste tu contraseña?
                </a>
              </div>

              <button type="submit" className="btn btn-login">
                Entrar al sistema
              </button>

              <div className="text-center mt-4">
                <Link
                  to="/register"
                  className="login-link"
                >
                  Crear cuenta
                </Link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Login;