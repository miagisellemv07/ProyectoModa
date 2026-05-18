import { useEffect, useState } from "react";

function Carrito() {
  const [items, setItems] = useState([]);
  const [mensaje, setMensaje] = useState("");
  const [mostrarCheckout, setMostrarCheckout] = useState(false);

  const user = JSON.parse(localStorage.getItem("user"));

  useEffect(() => {
    obtenerCarrito();
  }, []);

  function token() {
    return localStorage.getItem("token");
  }

  async function obtenerCarrito() {
    try {
      const respuesta = await fetch("http://127.0.0.1:8000/api/carritos", {
        headers: {
          Authorization: `Bearer ${token()}`,
        },
      });

      const data = await respuesta.json();

      if (!respuesta.ok) {
        if (respuesta.status === 401) {
          localStorage.removeItem("token");
          localStorage.removeItem("user");
          window.location.href = "/login";
          return;
        }

        setMensaje(data.message || data.error || "No se pudo cargar el carrito.");
        return;
      }

      setItems(data.data || []);
    } catch (error) {
      console.log(error);
      setMensaje("Error al conectar con el carrito.");
    }
  }

  async function cambiarCantidad(item, cantidad) {
    let nuevaCantidad = Number(cantidad);

    if (!nuevaCantidad || nuevaCantidad < 1) {
      nuevaCantidad = 1;
    }

    if (item.producto?.stock && nuevaCantidad > item.producto.stock) {
      nuevaCantidad = item.producto.stock;
    }

    setItems(
      items.map((productoCarrito) =>
        productoCarrito.id === item.id
          ? {
              ...productoCarrito,
              cantidad: nuevaCantidad,
              subtotal: Number(productoCarrito.precio_unitario) * nuevaCantidad,
            }
          : productoCarrito
      )
    );

    try {
      const respuesta = await fetch(
        `http://127.0.0.1:8000/api/carritos/${item.id}`,
        {
          method: "PUT",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token()}`,
          },
          body: JSON.stringify({
            cantidad: nuevaCantidad,
          }),
        }
      );

      if (!respuesta.ok) {
        obtenerCarrito();
      }
    } catch (error) {
      console.log(error);
      obtenerCarrito();
    }
  }

  async function eliminarItem(id) {
    try {
      await fetch(`http://127.0.0.1:8000/api/carritos/${id}`, {
        method: "DELETE",
        headers: {
          Authorization: `Bearer ${token()}`,
        },
      });

      setItems(items.filter((item) => item.id !== id));
    } catch (error) {
      console.log(error);
      setMensaje("Error al eliminar producto.");
    }
  }

  function subtotal() {
    return items.reduce((suma, item) => suma + Number(item.subtotal), 0);
  }

  function impuestos() {
    return subtotal() * 0.16;
  }

  function total() {
    return subtotal() + impuestos();
  }

  function obtenerImagen(item) {
    if (item.producto?.imagen) {
      return `http://127.0.0.1:8000/storage/${item.producto.imagen}`;
    }

    return "https://via.placeholder.com/120";
  }

  function finalizarCompra() {
    setMostrarCheckout(true);

    setTimeout(() => {
      const checkout = document.getElementById("checkout");

      if (checkout) {
        checkout.scrollIntoView({
          behavior: "smooth",
        });
      }
    }, 100);
  }

  function pagarPaypalDemo() {
    setMensaje("PayPal todavía no está conectado. Ese será el siguiente paso.");
  }

  return (
    <div
      style={{
        minHeight: "100vh",
        background: "#f7f2fb",
        padding: "50px",
      }}
    >
      <h1
        style={{
          color: "#684b7c",
          marginBottom: "30px",
          fontSize: "42px",
        }}
      >
        Carrito de compra
      </h1>

      {mensaje && (
        <div
          style={{
            background: "white",
            color: "#684b7c",
            padding: "18px",
            borderRadius: "18px",
            marginBottom: "25px",
            fontWeight: "bold",
          }}
        >
          {mensaje}
        </div>
      )}

      {items.length === 0 && (
        <div
          style={{
            background: "white",
            padding: "30px",
            borderRadius: "25px",
          }}
        >
          Tu carrito está vacío.
        </div>
      )}

      {items.map((item) => (
        <div
          key={item.id}
          style={{
            background: "white",
            borderRadius: "25px",
            padding: "25px",
            marginBottom: "20px",
            display: "grid",
            gridTemplateColumns: "120px 1fr 220px",
            gap: "25px",
            alignItems: "center",
            boxShadow: "0 10px 25px rgba(0,0,0,.08)",
          }}
        >
          <img
            src={obtenerImagen(item)}
            alt={item.producto?.nombre}
            style={{
              width: "120px",
              height: "120px",
              objectFit: "cover",
              borderRadius: "18px",
            }}
          />

          <div>
            <h3
              style={{
                marginBottom: "8px",
                color: "#3f3151",
                fontSize: "28px",
              }}
            >
              {item.producto?.nombre}
            </h3>

            <p>
              Precio unitario: ${Number(item.precio_unitario).toFixed(2)} MXN
            </p>

            <div
              style={{
                display: "flex",
                alignItems: "center",
                gap: "12px",
              }}
            >
              <button
                type="button"
                onClick={() => cambiarCantidad(item, item.cantidad - 1)}
                style={{
                  width: "46px",
                  height: "46px",
                  border: "none",
                  borderRadius: "14px",
                  background: "#efe4f7",
                  color: "#684b7c",
                  fontSize: "24px",
                  fontWeight: "bold",
                  cursor: "pointer",
                }}
              >
                -
              </button>

              <input
                type="number"
                min="1"
                max={item.producto?.stock || 999}
                value={item.cantidad}
                onChange={(e) => cambiarCantidad(item, e.target.value)}
                style={{
                  width: "90px",
                  height: "46px",
                  textAlign: "center",
                  borderRadius: "14px",
                  border: "1px solid #ddd",
                  fontWeight: "bold",
                  fontSize: "18px",
                }}
              />

              <button
                type="button"
                onClick={() => cambiarCantidad(item, item.cantidad + 1)}
                style={{
                  width: "46px",
                  height: "46px",
                  border: "none",
                  borderRadius: "14px",
                  background: "#efe4f7",
                  color: "#684b7c",
                  fontSize: "24px",
                  fontWeight: "bold",
                  cursor: "pointer",
                }}
              >
                +
              </button>

              <small style={{ color: "#777" }}>
                Stock: {item.producto?.stock || "N/D"}
              </small>
            </div>
          </div>

          <div style={{ textAlign: "right" }}>
            <p style={{ marginBottom: "5px", color: "#777" }}>Subtotal</p>

            <h3
              style={{
                color: "#8d5da8",
                fontSize: "30px",
                marginBottom: "20px",
              }}
            >
              ${Number(item.subtotal).toFixed(2)}
            </h3>

            <button
              onClick={() => eliminarItem(item.id)}
              style={{
                border: "none",
                background: "#ffe3e3",
                color: "#b00020",
                padding: "12px 18px",
                borderRadius: "14px",
                cursor: "pointer",
                fontWeight: "bold",
              }}
            >
              Eliminar
            </button>
          </div>
        </div>
      ))}

      {items.length > 0 && (
        <div
          style={{
            background: "white",
            padding: "30px",
            borderRadius: "25px",
            textAlign: "right",
            marginTop: "30px",
            boxShadow: "0 10px 25px rgba(0,0,0,.08)",
          }}
        >
          <h2
            style={{
              color: "#3f3151",
              fontSize: "34px",
              marginBottom: "20px",
            }}
          >
            Total: ${total().toFixed(2)} MXN
          </h2>

          <button
            onClick={finalizarCompra}
            style={{
              padding: "16px 28px",
              border: "none",
              borderRadius: "18px",
              background: "linear-gradient(90deg,#e6a5c8,#9f7cd0)",
              color: "white",
              fontWeight: "bold",
              cursor: "pointer",
              fontSize: "16px",
            }}
          >
            Finalizar compra
          </button>
        </div>
      )}

      {mostrarCheckout && items.length > 0 && (
        <div
          id="checkout"
          style={{
            marginTop: "60px",
            background: "white",
            borderRadius: "30px",
            padding: "45px",
            boxShadow: "0 15px 35px rgba(0,0,0,.08)",
          }}
        >
          <h1
            style={{
              color: "#3f3151",
              fontSize: "42px",
              marginBottom: "40px",
            }}
          >
            Finalizar pedido
          </h1>

          <div
            style={{
              display: "grid",
              gridTemplateColumns: "1.2fr .8fr",
              gap: "45px",
            }}
          >
            <div>
              <h2 style={{ color: "#684b7c", marginBottom: "25px" }}>
                Información de contacto
              </h2>

              <div
                style={{
                  display: "grid",
                  gridTemplateColumns: "1fr 1fr",
                  gap: "25px",
                  marginBottom: "25px",
                }}
              >
                <div>
                  <small style={{ fontWeight: "bold", color: "#777" }}>
                    NOMBRE
                  </small>
                  <p style={{ fontSize: "18px" }}>{user?.nombre || "Cliente"}</p>
                </div>

                <div>
                  <small style={{ fontWeight: "bold", color: "#777" }}>
                    APELLIDO
                  </small>
                  <p style={{ fontSize: "18px" }}>{user?.apellido || ""}</p>
                </div>
              </div>

              <div style={{ marginBottom: "25px" }}>
                <small style={{ fontWeight: "bold", color: "#777" }}>
                  CORREO ELECTRÓNICO
                </small>
                <p style={{ fontSize: "18px" }}>{user?.email || "Sin correo"}</p>
              </div>

              <div style={{ marginBottom: "40px" }}>
                <small style={{ fontWeight: "bold", color: "#777" }}>
                  TELÉFONO
                </small>
                <p style={{ fontSize: "18px" }}>{user?.tel || "Sin teléfono"}</p>
              </div>

              <h2 style={{ color: "#684b7c", marginBottom: "25px" }}>
                Método de pago
              </h2>

              <div
                style={{
                  border: "2px solid #efe4f7",
                  borderRadius: "25px",
                  padding: "30px",
                  textAlign: "center",
                  maxWidth: "360px",
                }}
              >
                <i
                  className="bi bi-paypal"
                  style={{
                    fontSize: "70px",
                    color: "#0070ba",
                  }}
                ></i>

                <h3 style={{ marginTop: "15px", color: "#3f3151" }}>
                  Pagar con PayPal
                </h3>

                <button
                  onClick={pagarPaypalDemo}
                  style={{
                    marginTop: "20px",
                    padding: "14px 25px",
                    border: "none",
                    borderRadius: "16px",
                    background: "#0070ba",
                    color: "white",
                    fontWeight: "bold",
                    cursor: "pointer",
                  }}
                >
                  Continuar con PayPal
                </button>

                <p
                  style={{
                    marginTop: "15px",
                    color: "#777",
                    fontSize: "14px",
                  }}
                >
                  PayPal todavía no está conectado. Este botón es visual por ahora.
                </p>
              </div>
            </div>

            <div>
              <h2 style={{ color: "#684b7c", marginBottom: "25px" }}>
                Resumen del pedido
              </h2>

              {items.map((item) => (
                <div
                  key={item.id}
                  style={{
                    display: "grid",
                    gridTemplateColumns: "70px 1fr auto",
                    gap: "15px",
                    alignItems: "center",
                    marginBottom: "18px",
                  }}
                >
                  <div style={{ position: "relative" }}>
                    <img
                      src={obtenerImagen(item)}
                      alt={item.producto?.nombre}
                      style={{
                        width: "70px",
                        height: "70px",
                        objectFit: "cover",
                        borderRadius: "14px",
                      }}
                    />

                    <span
                      style={{
                        position: "absolute",
                        top: "-8px",
                        right: "-8px",
                        background: "#684b7c",
                        color: "white",
                        width: "26px",
                        height: "26px",
                        borderRadius: "50%",
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "center",
                        fontSize: "13px",
                        fontWeight: "bold",
                      }}
                    >
                      {item.cantidad}
                    </span>
                  </div>

                  <div>
                    <b>{item.producto?.nombre}</b>
                    <p style={{ margin: 0, color: "#777" }}>
                      Producto del marketplace
                    </p>
                  </div>

                  <b>${Number(item.subtotal).toFixed(2)}</b>
                </div>
              ))}

              <hr style={{ margin: "25px 0" }} />

              <div style={{ display: "flex", justifyContent: "space-between" }}>
                <p>Subtotal</p>
                <p>${subtotal().toFixed(2)} MXN</p>
              </div>

              <div style={{ display: "flex", justifyContent: "space-between" }}>
                <p>Impuestos estimados</p>
                <p>${impuestos().toFixed(2)} MXN</p>
              </div>

              <div style={{ display: "flex", justifyContent: "space-between" }}>
                <p>Envío</p>
                <p>Gratis</p>
              </div>

              <hr style={{ margin: "25px 0" }} />

              <div
                style={{
                  display: "flex",
                  justifyContent: "space-between",
                  alignItems: "center",
                }}
              >
                <h2>Total</h2>
                <h2 style={{ color: "#8d5da8" }}>${total().toFixed(2)} MXN</h2>
              </div>

              <p
                style={{
                  marginTop: "20px",
                  color: "#777",
                  fontSize: "14px",
                }}
              >
                Tus productos serán procesados después de confirmar el pago.
              </p>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

export default Carrito;