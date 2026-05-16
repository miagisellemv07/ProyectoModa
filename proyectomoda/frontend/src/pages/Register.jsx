import { Link } from "react-router-dom";

function Register() {
  return (

    <div className="container">

      <div className="register-wrapper">

        <div className="register-card">

          <div className="register-header">

            <div className="icon-circle">
              <i className="fas fa-user-plus"></i>
            </div>

            <h2>Crear cuenta</h2>

            <p>
              Regístrate en Virtuality Emprendedores Mall
            </p>

          </div>


          <div className="register-body">

            <form>

              <div className="row">

                <div className="col-md-6 mb-3">

                  <label className="form-label">
                    Nombre
                  </label>

                  <input
                    className="form-control"
                    placeholder="Ingresa tu nombre"
                  />

                </div>


                <div className="col-md-6 mb-3">

                  <label className="form-label">
                    Apellido
                  </label>

                  <input
                    className="form-control"
                    placeholder="Ingresa tu apellido"
                  />

                </div>

              </div>



              <div className="mb-3">

                <label className="form-label">
                  Correo
                </label>

                <input
                  className="form-control"
                  placeholder="correo@ejemplo.com"
                />

              </div>



              <div className="mb-3">

                <label className="form-label">
                  Teléfono
                </label>

                <input
                  className="form-control"
                />

              </div>



              <div className="mb-3">

                <label className="form-label">
                  Dirección
                </label>

                <input
                  className="form-control"
                />

              </div>



              <div className="row">

                <div className="col-md-6">

                  <label className="form-label">
                    Contraseña
                  </label>

                  <input
                    type="password"
                    className="form-control"
                  />

                </div>



                <div className="col-md-6">

                  <label className="form-label">
                    Confirmar contraseña
                  </label>

                  <input
                    type="password"
                    className="form-control"
                  />

                </div>

              </div>



              <button
                className="btn btn-register mt-4"
              >
                Registrarme
              </button>


              <div className="text-center mt-4">

                <Link
                  to="/login"
                  className="register-link"
                >
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