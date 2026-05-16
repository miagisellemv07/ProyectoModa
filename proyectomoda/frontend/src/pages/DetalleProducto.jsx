import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";

function DetalleProducto() {
  const { id } = useParams();

  const [producto, setProducto] = useState(null);
  const [resenas, setResenas] = useState([]);
  const [cargando, setCargando] = useState(true);
  const [calificacion, setCalificacion] = useState(5);
  const [comentario, setComentario] = useState("");
  const [mensaje, setMensaje] = useState("");

  useEffect(() => {
    obtenerProducto();
    obtenerResenas();
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

  async function obtenerResenas() {
    try {
      const respuesta = await fetch(
        `http://127.0.0.1:8000/api/productos/${id}/resenas`
      );

      const data = await respuesta.json();

      setResenas(data);
    } catch (error) {
      console.log(error);
    }
  }

  function obtenerImagen(producto) {
    if (producto.imagen) {
      return `http://127.0.0.1:8000/storage/${producto.imagen}`;
    }

    return "https://via.placeholder.com/600x500";
  }

  function promedioResenas() {
    if (resenas.length === 0) return 0;

    const total = resenas.reduce(
      (suma, resena) => suma + Number(resena.calificacion),
      0
    );

    return (total / resenas.length).toFixed(1);
  }

  function estrellas(numero) {
    return "★".repeat(numero) + "☆".repeat(5 - numero);
  }

  function requiereLogin() {
    const token = localStorage.getItem("token");

    if (!token) {
      window.location.href = "/login";
      return null;
    }

    return token;
  }

  async function publicarResena(e) {
    e.preventDefault();

    const token = requiereLogin();

    if (!token) return;

    try {
      const respuesta = await fetch(
        "http://127.0.0.1:8000/api/resenas",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
          body: JSON.stringify({
            producto_id: producto.id,
            calificacion: calificacion,
            comentario: comentario,
          }),
        }
      );

      const data = await respuesta.json();

      if (!respuesta.ok) {
        setMensaje("No se pudo publicar la reseña.");
        return;
      }

      setMensaje(`Reseña publicada. Ganaste +${data.puntos} puntos.`);
      setComentario("");
      setCalificacion(5);
      obtenerResenas();
    } catch (error) {
      console.log(error);
      setMensaje("Error al conectar con el servidor.");
    }
  }

  function agregarAlCarrito() {
    const token = requiereLogin();

    if (!token) return;

    alert("Producto agregado al carrito.");
  }

  function comprarAhora() {
    const token = requiereLogin();

    if (!token) return;

    alert("Compra iniciada.");
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

          <div style={{ marginTop: "25px", fontSize: "18px" }}>
            <p>
              <b>Inventario disponible:</b> {producto.stock}
            </p>

            <p>
              <b>Opiniones:</b>{" "}
              <span style={{ color: "#f4b400" }}>
                {resenas.length > 0
                  ? estrellas(Math.round(promedioResenas()))
                  : "☆☆☆☆☆"}
              </span>{" "}
              <b>{promedioResenas()}</b> / 5 ({resenas.length} reseñas)
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
              onClick={agregarAlCarrito}
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
              onClick={comprarAhora}
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

      <div
        style={{
          marginTop: "40px",
          background: "white",
          borderRadius: "30px",
          padding: "35px",
          boxShadow: "0 15px 35px rgba(0,0,0,.08)",
        }}
      >
        <h2 style={{ color: "#684b7c" }}>
          Reseñas y recompensas
        </h2>

        <p>
          Comparte tu experiencia con este producto y gana{" "}
          <b>+10 puntos</b> por participar.
        </p>

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

        <form onSubmit={publicarResena}>
          <label>
            <b>Calificación</b>
          </label>

          <select
            value={calificacion}
            onChange={(e) => setCalificacion(Number(e.target.value))}
            style={{
              display: "block",
              width: "100%",
              padding: "14px",
              borderRadius: "15px",
              border: "1px solid #ddd",
              margin: "10px 0 20px",
            }}
          >
            <option value={5}>★★★★★ Excelente</option>
            <option value={4}>★★★★ Muy bueno</option>
            <option value={3}>★★★ Bueno</option>
            <option value={2}>★★ Regular</option>
            <option value={1}>★ Malo</option>
          </select>

          <label>
            <b>Comentario</b>
          </label>

          <textarea
            value={comentario}
            onChange={(e) => setComentario(e.target.value)}
            required
            minLength={3}
            placeholder="Escribe tu opinión sobre el producto..."
            style={{
              display: "block",
              width: "100%",
              padding: "14px",
              borderRadius: "15px",
              border: "1px solid #ddd",
              margin: "10px 0 20px",
              minHeight: "120px",
            }}
          />

          <button
            type="submit"
            style={{
              padding: "15px 25px",
              border: "none",
              borderRadius: "18px",
              background:
                "linear-gradient(90deg,#e6a5c8,#9f7cd0)",
              color: "white",
              fontWeight: "bold",
              cursor: "pointer",
            }}
          >
            Publicar reseña y ganar puntos
          </button>
        </form>

        <hr style={{ margin: "35px 0" }} />

        <h3 style={{ color: "#684b7c" }}>
          Opiniones de clientes
        </h3>

        {resenas.length === 0 && (
          <p>
            Todavía no hay reseñas. Sé el primero en opinar y ganar puntos.
          </p>
        )}

        {resenas.map((resena) => (
          <div
            key={resena.id}
            style={{
              background: "#f8f5fc",
              padding: "20px",
              borderRadius: "20px",
              marginTop: "15px",
            }}
          >
            <div style={{ color: "#f4b400", fontSize: "22px" }}>
              {estrellas(Number(resena.calificacion))}
            </div>

            <p style={{ marginTop: "10px" }}>
              {resena.comentario}
            </p>

            <small>
              Cliente:{" "}
              {resena.cliente?.usuario_id?.nombre ||
                "Cliente"}{" "}
              · +{resena.puntos_ganados} puntos
            </small>
          </div>
        ))}
      </div>
    </div>
  );
}

export default DetalleProducto;