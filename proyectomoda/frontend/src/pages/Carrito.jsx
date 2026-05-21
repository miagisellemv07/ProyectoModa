import { useEffect, useState } from "react";
import { PayPalButtons, PayPalScriptProvider } from "@paypal/react-paypal-js";

function Carrito() {
  const [items, setItems] = useState([]);
  const [mensaje, setMensaje] = useState("");
  const [mostrarCheckout, setMostrarCheckout] = useState(false);
  const [paypalOptions, setPaypalOptions] = useState(null);

  const user = JSON.parse(localStorage.getItem("user"));

  useEffect(() => {
    obtenerCarrito();
  }, []);

  useEffect(() => {
    if (mostrarCheckout && total() > 0) {
      obtenerConfigPaypal();
    }
  }, [mostrarCheckout, items]);

  function token() {
    return localStorage.getItem("token");
  }

  function cerrarSesionExpirada() {
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    window.location.href = "/login";
  }

  async function obtenerCarrito() {
    try {
      const respuesta = await fetch("/api/carritos", {
        headers: {
          Authorization: `Bearer ${token()}`,
        },
      });

      const data = await respuesta.json();

      if (!respuesta.ok) {
        if (respuesta.status === 401) {
          cerrarSesionExpirada();
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

  async function obtenerConfigPaypal() {
    try {
      const respuesta = await fetch(
        `/api/paypal/${total().toFixed(2)}`,
        {
          headers: {
            Authorization: `Bearer ${token()}`,
          },
        }
      );

      const data = await respuesta.json();

      if (!respuesta.ok) {
        if (respuesta.status === 401) {
          cerrarSesionExpirada();
          return;
        }

        setMensaje(data.message || data.error || "No se pudo cargar PayPal.");
        return;
      }

      setPaypalOptions({
        "client-id": data.client_id,
        currency: data.currency || "MXN",
        intent: "capture",
      });
    } catch (error) {
      console.log(error);
      setMensaje("No se pudo cargar PayPal.");
    }
  }

  async function cambiarCantidad(item, cantidad) {
    let nuevaCantidad = Number(cantidad);

    if (!nuevaCantidad || nuevaCantidad < 1) nuevaCantidad = 1;

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
        `/api/carritos/${item.id}`,
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

      if (!respuesta.ok) obtenerCarrito();
    } catch (error) {
      console.log(error);
      obtenerCarrito();
    }
  }

  async function eliminarItem(id) {
    try {
      const respuesta = await fetch(`/api/carritos/${id}`, {
        method: "DELETE",
        headers: {
          Authorization: `Bearer ${token()}`,
        },
      });

      if (!respuesta.ok) {
        if (respuesta.status === 401) {
          cerrarSesionExpirada();
          return;
        }

        setMensaje("Error al eliminar producto.");
        return;
      }

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

  function obtenerImagenProducto(producto) {
    if (!producto?.imagen) {
      return "https://via.placeholder.com/400x300";
    }

    const imagen = producto.imagen.replace(/^\/+/, "");

    if (imagen.startsWith("http")) {
      return imagen;
    }

    if (imagen.startsWith("storage/")) {
      return `/${imagen}`;
    }

    return `/storage/${imagen}`;
  }

  function obtenerImagen(item) {
    return obtenerImagenProducto(item.producto);
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

  async function vaciarCarritoVisual() {
    setItems([]);
    setMostrarCheckout(false);
  }

  return (
    <div style={{ minHeight: "100vh", background: "#f7f2fb", padding: "50px" }}>
      <h1 style={{ color: "#684b7c", marginBottom: "30px", fontSize: "42px" }}>
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
        <div style={{ background: "white", padding: "30px", borderRadius: "25px" }}>
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
            <h3 style={{ marginBottom: "8px", color: "#3f3151", fontSize: "28px" }}>
              {item.producto?.nombre}
            </h3>

            <p>Precio unitario: ${Number(item.precio_unitario).toFixed(2)} MXN</p>

            <div style={{ display: "flex", alignItems: "center", gap: "12px" }}>
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

            <h3 style={{ color: "#8d5da8", fontSize: "30px", marginBottom: "20px" }}>
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
          <h2 style={{ color: "#3f3151", fontSize: "34px", marginBottom: "20px" }}>
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
          <h1 style={{ color: "#3f3151", fontSize: "42px", marginBottom: "40px" }}>
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
                  <small style={{ fontWeight: "bold", color: "#777" }}>NOMBRE</small>
                  <p style={{ fontSize: "18px" }}>{user?.nombre || "Cliente"}</p>
                </div>

                <div>
                  <small style={{ fontWeight: "bold", color: "#777" }}>APELLIDO</small>
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
                <small style={{ fontWeight: "bold", color: "#777" }}>TELÉFONO</small>
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
                  maxWidth: "430px",
                }}
              >
                <h3 style={{ color: "#3f3151", marginBottom: "10px" }}>
                  Pagar con PayPal
                </h3>

                <p style={{ color: "#777", fontSize: "14px", marginBottom: "20px" }}>
                  Puedes pagar de forma segura usando PayPal, tarjeta de crédito o débito.
                </p>

                {paypalOptions ? (
                  <PayPalScriptProvider options={paypalOptions}>
                    <PayPalButtons
                      style={{
                        layout: "vertical",
                        shape: "pill",
                        color: "gold",
                        label: "paypal",
                      }}
                      createOrder={async () => {
                        const respuesta = await fetch(
                          "/api/paypal/create-order",
                          {
                            method: "POST",
                            headers: {
                              "Content-Type": "application/json",
                              Authorization: `Bearer ${token()}`,
                            },
                            body: JSON.stringify({
                              amount: total().toFixed(2),
                            }),
                          }
                        );

                        const data = await respuesta.json();

                        if (!respuesta.ok || !data.id) {
                          if (respuesta.status === 401) {
                            cerrarSesionExpirada();
                            return;
                          }

                          setMensaje("No se pudo crear la orden de PayPal.");
                          throw new Error("No se pudo crear la orden de PayPal.");
                        }

                        return data.id;
                      }}
                      onApprove={async (data) => {
                        const respuesta = await fetch(
                          "/api/paypal/capture-order",
                          {
                            method: "POST",
                            headers: {
                              "Content-Type": "application/json",
                              Authorization: `Bearer ${token()}`,
                            },
                            body: JSON.stringify({
                              orderID: data.orderID,
                            }),
                          }
                        );

                        const resultado = await respuesta.json();

                        if (!respuesta.ok) {
                          if (respuesta.status === 401) {
                            cerrarSesionExpirada();
                            return;
                          }

                          setMensaje("No se pudo capturar el pago.");
                          return;
                        }

                        if (resultado.status === "COMPLETED") {
                          const guardarCompra = await fetch(
                            "/api/finalizar-compra",
                            {
                              method: "POST",
                              headers: {
                                "Content-Type": "application/json",
                                Authorization: `Bearer ${token()}`,
                              },
                              body: JSON.stringify({
                                paypal_order_id: data.orderID,
                                paypal_status: resultado.status,
                                total: total().toFixed(2),
                              }),
                            }
                          );

                          const compra = await guardarCompra.json();

                          if (!guardarCompra.ok) {
                            setMensaje(
                              compra.message ||
                                "El pago pasó, pero no se pudo guardar la compra."
                            );
                            return;
                          }

                          setMensaje("Compra finalizada correctamente ✔");
                          await vaciarCarritoVisual();
                        } else {
                          setMensaje("El pago no se completó correctamente.");
                        }
                      }}
                      onError={(error) => {
                        console.log(error);
                        setMensaje("Error con PayPal.");
                      }}
                    />
                  </PayPalScriptProvider>
                ) : (
                  <p>Cargando PayPal...</p>
                )}
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
                <p>IVA (16%)</p>
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

              <p style={{ marginTop: "20px", color: "#777", fontSize: "14px" }}>
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