import { useEffect, useState } from "react";
import { apiFetch } from "../../api";

function ClientePagos() {
  const [pagos, setPagos] = useState([]);
  const [mensaje, setMensaje] = useState("");

  useEffect(() => {
    obtener();
  }, []);

  function cerrarSesionExpirada() {
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    window.location.href = "/#/login";
  }

  async function obtener() {
    try {
      const respuesta = await apiFetch("/cliente/pagos");
      const data = await respuesta.json();

      if (!respuesta.ok) {
        if (respuesta.status === 401) {
          cerrarSesionExpirada();
          return;
        }

        setMensaje(data.message || data.error || "No se pudieron cargar tus pagos.");
        return;
      }

      setPagos(data.data || []);
    } catch (error) {
      console.log(error);
      setMensaje("Error al conectar con el servidor.");
    }
  }

  return (
    <div>
      <h1 style={{ marginBottom: "25px" }}>Mis pagos</h1>

      {mensaje && (
        <div
          style={{
            background: "white",
            padding: "15px",
            borderRadius: "15px",
            marginBottom: "20px",
            color: "#684b7c",
            fontWeight: "bold",
          }}
        >
          {mensaje}
        </div>
      )}

      {pagos.length === 0 && <p>Sin pagos</p>}

      {pagos.map((pago) => (
        <div
          key={pago.id}
          style={{
            background: "white",
            padding: "25px",
            borderRadius: "20px",
            marginBottom: "20px",
            boxShadow: "0 10px 25px rgba(0,0,0,.08)",
            display: "grid",
            gridTemplateColumns: "1fr 1fr 1fr",
            gap: "20px",
          }}
        >
          <div>
            <small>Orden</small>
            <h3>{pago.orden?.numero_orden || "Sin orden"}</h3>
          </div>

          <div>
            <small>Método</small>
            <h3>{pago.metodo_pago}</h3>
          </div>

          <div>
            <small>Monto</small>
            <h3 style={{ color: "#8d5da8" }}>
              ${Number(pago.monto).toFixed(2)} MXN
            </h3>
          </div>

          <div>
            <small>Estado</small>
            <p>{pago.estado}</p>
          </div>

          <div>
            <small>Fecha</small>
            <p>{pago.fecha_pago}</p>
          </div>
        </div>
      ))}
    </div>
  );
}

export default ClientePagos;