import { useEffect, useState } from "react";

function Home() {
  const [productos, setProductos] = useState([]);

  useEffect(() => {
    fetch("/api/productos")
      .then((res) => res.json())
      .then((data) => {
        setProductos((data.data || []).slice(0, 3));
      });
  }, []);

  const irAProductos = () => {
    window.location.href = "/productos";
  };

  const irALogin = () => {
    window.location.href = "/login";
  };

  function obtenerImagen(producto) {
    if (!producto.imagen) {
      return "https://via.placeholder.com/400";
    }

    if (producto.imagen.startsWith("http")) {
      return producto.imagen;
    }

    return `/storage/${producto.imagen}`;
  }

  return (
    <>
      <section className="hero-section">
        <div className="container">
          <div className="row align-items-center g-5">
            <div className="col-lg-6">
              <span className="hero-badge">
                Marketplace moderno y accesible
              </span>

              <h1 className="hero-title">
                Descubre productos, tiendas y nuevas oportunidades en un solo lugar.
              </h1>

              <p className="hero-text mb-4">
                Virtuality Emprendedores Mall es una plataforma donde diferentes negocios pueden mostrar sus productos y los clientes pueden comprar de forma sencilla.
              </p>

              <div className="d-flex flex-wrap gap-3">
                <button className="btn btn-main" onClick={irAProductos}>
                  Explorar productos
                </button>

                <button className="btn btn-soft" onClick={irALogin}>
                  Iniciar sesión
                </button>
              </div>
            </div>

            <div className="col-lg-6">
              <div className="hero-image">
                <img
                  src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b"
                  alt="Marketplace"
                />
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="section-padding" id="beneficios">
        <div className="container text-center">
          <span className="hero-badge mb-3">
            ¿Por qué elegir Virtuality Mall?
          </span>

          <h2 className="section-title">
            Una experiencia moderna para vender y comprar
          </h2>

          <p
            className="section-subtitle"
            style={{
              maxWidth: "850px",
              margin: "0 auto 60px",
            }}
          >
            Nuestro marketplace ayuda a emprendedores a mostrar productos,
            fortalecer su marca y llegar a más clientes mediante una experiencia
            visual, organizada y fácil de usar.
          </p>

          <div className="row g-4">
            <div className="col-md-6 col-lg-3">
              <div className="card-soft h-100 p-4">
                <i
                  className="bi bi-shop-window"
                  style={{ fontSize: "52px", color: "#9f7cd0" }}
                ></i>

                <h4 className="fw-bold mt-4 mb-3">
                  Tiendas organizadas
                </h4>

                <p>
                  Cada negocio tiene su propio espacio para mostrar catálogo,
                  productos, descripción y datos principales.
                </p>

                <small>
                  ✓ Más orden <br />
                  ✓ Mayor confianza
                </small>
              </div>
            </div>

            <div className="col-md-6 col-lg-3">
              <div className="card-soft h-100 p-4">
                <i
                  className="bi bi-cart3"
                  style={{ fontSize: "52px", color: "#9f7cd0" }}
                ></i>

                <h4 className="fw-bold mt-4 mb-3">
                  Compras rápidas
                </h4>

                <p>
                  Los clientes pueden explorar productos, comparar precios,
                  revisar inventario y comprar de forma sencilla.
                </p>

                <small>
                  ✓ Navegación intuitiva <br />
                  ✓ Compra sencilla
                </small>
              </div>
            </div>

            <div className="col-md-6 col-lg-3">
              <div className="card-soft h-100 p-4">
                <i
                  className="bi bi-tags"
                  style={{ fontSize: "52px", color: "#9f7cd0" }}
                ></i>

                <h4 className="fw-bold mt-4 mb-3">
                  Más categorías
                </h4>

                <p>
                  Moda, tecnología, accesorios, hogar, belleza y más productos
                  reunidos en un solo marketplace.
                </p>

                <small>
                  ✓ Mayor variedad <br />
                  ✓ Todo en un mismo sitio
                </small>
              </div>
            </div>

            <div className="col-md-6 col-lg-3">
              <div className="card-soft h-100 p-4">
                <i
                  className="bi bi-graph-up-arrow"
                  style={{ fontSize: "52px", color: "#9f7cd0" }}
                ></i>

                <h4 className="fw-bold mt-4 mb-3">
                  Impulso negocios
                </h4>

                <p>
                  La plataforma ayuda a emprendedores a ganar visibilidad,
                  proyectar confianza y crecer digitalmente.
                </p>

                <small>
                  ✓ Más alcance <br />
                  ✓ Más oportunidades
                </small>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="section-padding bg-white" id="productos">
        <div className="container">
          <div className="text-center">
            <h2 className="section-title">
              Productos destacados
            </h2>

            <p className="section-subtitle">
              Productos reales registrados en el marketplace.
            </p>
          </div>

          <div className="row g-4">
            {productos.map((producto) => (
              <div className="col-md-6 col-lg-4" key={producto.id}>
                <div className="product-card">
                  <img src={obtenerImagen(producto)} alt={producto.nombre} />

                  <div className="product-body">
                    <span className="category-badge">
                      {producto.tienda?.categoria || "Producto"}
                    </span>

                    <h4 className="fw-bold mt-2">
                      {producto.nombre}
                    </h4>

                    <p>{producto.descripcion}</p>

                    <div className="price">
                      ${producto.precio} MXN
                    </div>

                    <small>
                      Vendedor: {producto.tienda?.nombre || "Sin tienda"}
                    </small>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="section-padding" id="categorias">
        <div className="container">
          <div className="cta-section">
            <div className="row align-items-center g-4">
              <div className="col-lg-8">
                <h2>
                  Categorías para todo negocio
                </h2>

                <p>
                  Moda, tecnología, hogar y más.
                </p>
              </div>

              <div className="col-lg-4 text-lg-end">
                <button className="btn btn-main" onClick={irAProductos}>
                  Ver productos
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section
        className="bg-white"
        id="contacto"
        style={{
          padding: "80px 0",
        }}
      >
        <div className="container text-center">
          <span className="hero-badge mb-3">
            Contacto
          </span>

          <h2
            className="section-title"
            style={{
              marginBottom: "20px",
            }}
          >
            ¿Necesitas más información?
          </h2>

          <p
            className="section-subtitle"
            style={{
              maxWidth: "700px",
              margin: "0 auto",
            }}
          >
            Ponte en contacto con Virtuality Mall para conocer más sobre tiendas,
            productos y oportunidades para emprendedores.
          </p>
        </div>
      </section>
    </>
  );
}

export default Home;