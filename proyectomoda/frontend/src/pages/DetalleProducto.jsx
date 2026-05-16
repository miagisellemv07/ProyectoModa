import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";

function DetalleProducto() {
  const { id } = useParams();

  const [producto, setProducto] = useState(null);
  const [cargando, setCargando] = useState(true);

  useEffect(() => {
    obtenerProducto();
  }, []);

  async function obtenerProducto() {
    try {
      const respuesta = await fetch(
        `http://127.0.0.1:8000/api/productos/${id}`
      );

      const data = await respuesta.json();

      setProducto(data.data);
    } catch (error) {
      console.log(error);
    }

    setCargando(false);
  }

  function obtenerImagen(producto) {
    if (producto.imagen) {
      return `http://127.0.0.1:8000/storage/${producto.imagen}`;
    }

    return "https://via.placeholder.com/600x500";
  }

  function regresar() {
    window.location.href = "/productos";
  }

  if (cargando) {
    return (
      <h1 style={{ textAlign: "center", marginTop: "100px" }}>
        Cargando producto...
      </h1>
    );
  }

  if (!producto) {
    return (
      <h1 style={{ textAlign: "center", marginTop: "100px" }}>
        Producto no encontrado
      </h1>
    );
  }

  return (
    <div
      style={{
        minHeight: "100vh",
        background: "#f7f2fb",
        padding: "50px",
      }}
    >
      <button
        onClick={regresar}
        style={{
          padding: "12px 25px",
          borderRadius: "15px",
          border: "none",
          background: "white",
          color: "#8d5da8",
          fontWeight: "bold",
          marginBottom: "30px",
          cursor: "pointer",
        }}
      >
        ← Volver al catálogo
      </button>

      <div
        style={{
          display: "grid",
          gridTemplateColumns: "repeat(auto-fit, minmax(350px, 1fr))",
          gap: "40px",
          background: "white",
          borderRadius: "30px",
          padding: "40px",
          boxShadow: "0 15px 35px rgba(0,0,0,.08)",
        }}
      >
        <img
          src={obtenerImagen(producto)}
          alt={producto.nombre}
          style={{
            width: "100%",
            height: "500px",
            objectFit: "cover",
            borderRadius: "25px",
          }}
        />

        <div>
          <span
            style={{
              display: "inline-block",
              padding: "8px 18px",
              borderRadius: "30px",
              background: "#efe4f7",
              color: "#8d5da8",
              fontWeight: "bold",
              marginBottom: "20px",
            }}
          >
            {producto.tienda?.categoria || "Producto"}
          </span>

          <h1
            style={{
              fontSize: "48px",
              color: "#684b7c",
              marginBottom: "20px",
            }}
          >
            {producto.nombre}
          </h1>

          <h2
            style={{
              color: "#8d5da8",
              fontSize: "38px",
              marginBottom: "25px",
            }}
          >
            ${producto.precio} MXN
          </h2>

          <p
            style={{
              fontSize: "18px",
              lineHeight: "1.7",
              color: "#555",
            }}
          >
            {producto.descripcion}
          </p>

          <div
            style={{
              background: "#f8f5fc",
              padding: "20px",
              borderRadius: "20px",
              marginTop: "25px",
            }}
          >
            <h4>Información del vendedor</h4>

            <p>
              <b>Tienda:</b>{" "}
              {producto.tienda?.nombre || "Sin tienda"}
            </p>

            <p>
              {producto.tienda?.descripcion ||
                "Tienda registrada dentro del marketplace."}
            </p>
          </div>

          <div
            style={{
              marginTop: "25px",
              fontSize: "18px",
            }}
          >
            <p>
              <b>Inventario disponible:</b> {producto.stock}
            </p>

            <p>
              <b>Opiniones:</b>{" "}
              <span style={{ color: "#f4b400" }}>
                ★★★★★
              </span>
            </p>
          </div>

          <div
            style={{
              display: "flex",
              gap: "15px",
              flexWrap: "wrap",
              marginTop: "30px",
            }}
          >
            <button
              style={{
                flex: "1",
                padding: "16px",
                border: "none",
                borderRadius: "18px",
                background:
                  "linear-gradient(90deg,#e6a5c8,#9f7cd0)",
                color: "white",
                fontWeight: "bold",
                cursor: "pointer",
              }}
            >
              Agregar al carrito
            </button>

            <button
              style={{
                flex: "1",
                padding: "16px",
                border: "2px solid #9f7cd0",
                borderRadius: "18px",
                background: "white",
                color: "#8d5da8",
                fontWeight: "bold",
                cursor: "pointer",
              }}
            >
              Comprar ahora
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default DetalleProducto;