import { useEffect, useState } from "react";

function ClientePagos() {
  const [pagos, setPagos] = useState([]);

  useEffect(() => {
    obtener();
  }, []);

  async function obtener() {
    const token = localStorage.getItem("token");

    const r = await fetch("http://127.0.0.1:8000/api/cliente/pagos", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    const data = await r.json();
    setPagos(data.data || []);
  }

  return (
    <div>
      <h1 style={{ marginBottom: "25px" }}>Mis pagos</h1>

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