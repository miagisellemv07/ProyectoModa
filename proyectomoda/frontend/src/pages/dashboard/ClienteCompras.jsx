import { useEffect, useState } from "react";

function ClienteCompras() {
  const [compras, setCompras] = useState([]);

  useEffect(() => {
    obtener();
  }, []);

  async function obtener() {
    const token = localStorage.getItem("token");

    const r = await fetch("/api/cliente/compras", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    const data = await r.json();
    setCompras(data.data || []);
  }

  function imagenProducto(producto) {
    if (!producto?.imagen) return "https://via.placeholder.com/90";

    const imagen = producto.imagen.replace(/^\/+/, "");

    if (imagen.startsWith("http")) return imagen;
    if (imagen.startsWith("storage/")) return `/${imagen}`;

    return `/storage/${imagen}`;
  }

  return (
    <div>
      <h1 style={{ marginBottom: "25px" }}>Mis compras</h1>

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
                <p>Precio unitario: ${Number(item.precio_unitario).toFixed(2)} MXN</p>
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