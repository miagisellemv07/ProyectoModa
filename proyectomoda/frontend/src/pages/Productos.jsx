import { useEffect, useState } from "react";
import { apiFetch, getImageUrl } from "../api";

function Productos() {
  const [productos, setProductos] = useState([]);
  const [cargando, setCargando] = useState(true);
  const [busqueda, setBusqueda] = useState("");
  const [mensaje, setMensaje] = useState("");

  useEffect(() => {
    obtenerProductos();
  }, []);

  async function obtenerProductos() {
    try {
      const respuesta = await apiFetch("/productos");
      const data = await respuesta.json();

      setProductos(data.data || []);
    } catch (error) {
      console.log(error);
      setMensaje("Error al cargar los productos.");
    }

    setCargando(false);
  }

  function obtenerImagen(producto) {
    return getImageUrl(producto?.imagen, "https://via.placeholder.com/400x300");
  }

  function verDetalle(producto) {
    window.location.href = `/#/productos/${producto.id}`;
  }

  function requiereLogin() {
    const token = localStorage.getItem("token");

    if (!token) {
      window.location.href = "/#/login";
      return null;
    }

    return token;
  }

  function cerrarSesionExpirada() {
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    window.location.href = "/#/login";
  }

  async function agregarAlCarrito(producto) {
    const token = requiereLogin();

    if (!token) return;

    try {
      const respuesta = await apiFetch("/carritos", {
        method: "POST",
        body: JSON.stringify({
          producto_id: Number(producto.id),
          cantidad: 1,
        }),
      });

      const data = await respuesta.json();

      if (!respuesta.ok) {
        if (respuesta.status === 401 || data.error === "Unauthorized") {
          cerrarSesionExpirada();
          return;
        }

        setMensaje(data.message || data.error || "No se pudo agregar al carrito.");
        return;
      }

      window.location.href = "/#/carrito";
    } catch (error) {
      console.log(error);
      setMensaje(
        "Error al conectar con el carrito. Inicia sesión otra vez si tu sesión expiró."
      );
    }
  }

  const filtrados = productos.filter((p) =>
    p.nombre?.toLowerCase().includes(busqueda.toLowerCase())
  );

  if (cargando) {
    return (
      <h1
        style={{
          textAlign: "center",
          marginTop: "100px",
        }}
      >
        Cargando...
      </h1>
    );
  }

  return (
    <div
      style={{
        minHeight: "100vh",
        background: "#f7f2fb",
        padding: "40px",
      }}
    >
      <h1
        style={{
          textAlign: "center",
          fontSize: "50px",
          color: "#684b7c",
        }}
      >
        Productos
      </h1>

      {mensaje && (
        <div
          style={{
            background: "#efe4f7",
            color: "#684b7c",
            padding: "15px",
            borderRadius: "15px",
            marginBottom: "20px",
            fontWeight: "bold",
          }}
        >
          {mensaje}
        </div>
      )}

      <input
        placeholder="Buscar producto..."
        value={busqueda}
        onChange={(e) => setBusqueda(e.target.value)}
        style={{
          width: "100%",
          padding: "15px",
          borderRadius: "15px",
          border: "1px solid #ddd",
          marginBottom: "40px",
        }}
      />

      <div
        style={{
          display: "grid",
          gridTemplateColumns: "repeat(auto-fit,minmax(320px,1fr))",
          gap: "30px",
        }}
      >
        {filtrados.map((producto) => (
          <div
            key={producto.id}
            style={{
              background: "white",
              borderRadius: "25px",
              overflow: "hidden",
              boxShadow: "0 10px 25px rgba(0,0,0,.08)",
            }}
          >
            <img
              src={obtenerImagen(producto)}
              alt={producto.nombre}
              style={{
                width: "100%",
                height: "250px",
                objectFit: "cover",
              }}
            />

            <div
              style={{
                padding: "25px",
              }}
            >
              <h2>{producto.nombre}</h2>

              <p>{producto.descripcion}</p>

              <h1
                style={{
                  color: "#8d5da8",
                }}
              >
                ${producto.precio} MXN
              </h1>

              <div
                style={{
                  background: "#f8f5fc",
                  padding: "15px",
                  borderRadius: "15px",
                  marginTop: "15px",
                }}
              >
                <b>Vendedor:</b> {producto.tienda?.nombre || "Sin tienda"}

                <br />

                <small>{producto.tienda?.descripcion}</small>
              </div>

              <p
                style={{
                  marginTop: "15px",
                }}
              >
                Stock: <b>{producto.stock}</b>
              </p>

              <button
                onClick={() => agregarAlCarrito(producto)}
                style={{
                  width: "100%",
                  padding: "15px",
                  border: "none",
                  borderRadius: "15px",
                  background: "linear-gradient(90deg,#e6a5c8,#9f7cd0)",
                  color: "white",
                  fontWeight: "bold",
                  marginTop: "20px",
                  cursor: "pointer",
                }}
              >
                Agregar al carrito
              </button>

              <button
                onClick={() => verDetalle(producto)}
                style={{
                  width: "100%",
                  padding: "15px",
                  border: "2px solid #9f7cd0",
                  borderRadius: "15px",
                  background: "white",
                  color: "#8d5da8",
                  fontWeight: "bold",
                  marginTop: "12px",
                  cursor: "pointer",
                }}
              >
                Ver detalle
              </button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

export default Productos;