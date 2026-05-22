import { useEffect, useState } from "react";
import { apiFetch, getImageUrl } from "../../api";

function ClienteCompras() {
  const [compras, setCompras] = useState([]);
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
      const respuesta = await apiFetch("/cliente/compras");
      const data = await respuesta.json();

      if (!respuesta.ok) {
        if (respuesta.status === 401) {
          cerrarSesionExpirada();
          return;
        }

        setMensaje(data.message || data.error || "No se pudieron cargar tus compras.");
        return;
      }

      setCompras(data.data || []);
    } catch (error) {
      console.log(error);
      setMensaje("Error al conectar con el servidor.");
    }
  }

  function imagenProducto(producto) {
    return getImageUrl(producto?.imagen, "https://via.placeholder.com/90");
  }

  return (
    <div>
      <h1 style={{ marginBottom: "25px" }}>Mis compras</h1>

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

      {compras.length === 0 && <p>Sin compras</p>}

      {compras.map((compra) => (
        <div
          key={compra.id}
          style={{
            background: "white",
            padding: "25px",
            borderRadius: "20px",
            marginBottom: "25px",
            boxShadow: "0 10px 25px rgba(0,0,0,.08)",
          }}
        >
          <div
            style={{
              display: "flex",
              justifyContent: "space-between",
              gap: "20px",
              marginBottom: "20px",
            }}
          >
            <div>
              <h3>Orden: {compra.numero_orden}</h3>
              <p>Estado: {compra.estado}</p>
            </div>

            <h3 style={{ color: "#8d5da8" }}>
              Total: ${Number(compra.total).toFixed(2)} MXN
            </h3>
          </div>

          {compra.items?.map((item) => (
            <div
              key={item.id}
              style={{
                display: "grid",
                gridTemplateColumns: "90px 1fr auto",
                gap: "18px",
                alignItems: "center",
                borderTop: "1px solid #eee",
                paddingTop: "15px",
                marginTop: "15px",
              }}
            >
              <img
                src={imagenProducto(item.producto)}
                alt={item.producto?.nombre}
                style={{
                  width: "90px",
                  height: "90px",
                  borderRadius: "15px",
                  objectFit: "cover",
                }}
              />

              <div>
                <h4>{item.producto?.nombre || "Producto"}</h4>
                <p>Cantidad: {item.cantidad}</p>
                <p>
                  Precio unitario: ${Number(item.precio_unitario).toFixed(2)} MXN
                </p>
              </div>

              <h4 style={{ color: "#684b7c" }}>
                ${Number(item.subtotal).toFixed(2)} MXN
              </h4>
            </div>
          ))}
        </div>
      ))}
    </div>
  );
}

export default ClienteCompras;