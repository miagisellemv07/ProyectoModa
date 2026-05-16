import { Link } from "react-router-dom";

function Login() {
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

            <form>

              <div className="mb-3">

                <label className="form-label">
                  Correo electrónico
                </label>

                <input
                  type="email"
                  className="form-control"
                  placeholder="ejemplo@correo.com"
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


              <button className="btn btn-login">

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