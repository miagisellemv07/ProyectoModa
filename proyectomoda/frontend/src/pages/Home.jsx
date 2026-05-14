function Home() {
  return (
    <>

      {/* HERO */}
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
                Virtuality Emprendedores Mall es una plataforma donde diferentes
                negocios pueden mostrar sus productos y los clientes pueden comprar
                de forma sencilla, ordenada y visual.
              </p>

              <div className="d-flex flex-wrap gap-3">

                <button className="btn btn-main">
                  Explorar productos
                </button>

                <button className="btn btn-soft">
                  Iniciar sesión
                </button>

              </div>
            </div>

            <div className="col-lg-6">
              <div className="hero-image">
                <img
                  src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=900&q=80"
                  alt="Marketplace"
                />
              </div>
            </div>

          </div>
        </div>
      </section>

      {/* BENEFICIOS */}
      <section className="section-padding" id="beneficios">
        <div className="container text-center">

          <h2 className="section-title">
            Una experiencia moderna para vender y comprar
          </h2>

          <p className="section-subtitle mx-auto">
            El sistema está pensado para que tiendas y clientes puedan interactuar
            de forma simple, visual y organizada dentro de una misma plataforma.
          </p>

          <div className="row g-4">

            <div className="col-md-6 col-lg-3">
              <div className="card-soft">

                <div className="icon-circle mx-auto">
                  <i className="fas fa-store"></i>
                </div>

                <h4 className="fw-bold mb-3">
                  Tiendas organizadas
                </h4>

                <p>
                  Cada negocio puede mostrar sus productos dentro de un espacio propio.
                </p>

              </div>
            </div>

            <div className="col-md-6 col-lg-3">
              <div className="card-soft">

                <div className="icon-circle mx-auto">
                  <i className="fas fa-bag-shopping"></i>
                </div>

                <h4 className="fw-bold mb-3">
                  Compras sencillas
                </h4>

                <p>
                  Los clientes pueden navegar, elegir y comprar de forma rápida.
                </p>

              </div>
            </div>

            <div className="col-md-6 col-lg-3">
              <div className="card-soft">

                <div className="icon-circle mx-auto">
                  <i className="fas fa-tags"></i>
                </div>

                <h4 className="fw-bold mb-3">
                  Variedad de categorías
                </h4>

                <p>
                  Tecnología, moda, accesorios, hogar, belleza, deporte y más.
                </p>

              </div>
            </div>

            <div className="col-md-6 col-lg-3">
              <div className="card-soft">

                <div className="icon-circle mx-auto">
                  <i className="fas fa-chart-line"></i>
                </div>

                <h4 className="fw-bold mb-3">
                  Impulso para negocios
                </h4>

                <p>
                  Una plataforma que ayuda a dar visibilidad y orden a cada tienda.
                </p>

              </div>
            </div>

          </div>
        </div>
      </section>

      {/* PRODUCTOS */}
      <section className="section-padding bg-white" id="productos">
        <div className="container">

          <div className="text-center">
            <h2 className="section-title">
              Productos destacados
            </h2>

            <p className="section-subtitle mx-auto">
              Aquí puedes mostrar una vista previa de todo lo que puede encontrarse dentro del marketplace.
            </p>
          </div>

          <div className="row g-4">

            <div className="col-md-6 col-lg-4">
              <div className="product-card">

                <img
                  src="https://images.unsplash.com/photo-1483985988355-763728e1935b"
                  alt=""
                />

                <div className="product-body">

                  <span className="category-badge">
                    Moda
                  </span>

                  <h4 className="fw-bold mt-2">
                    Conjunto casual
                  </h4>

                  <p>
                    Opciones cómodas y versátiles para diferentes estilos.
                  </p>

                  <div className="price">
                    $399 MXN
                  </div>

                </div>
              </div>
            </div>

            <div className="col-md-6 col-lg-4">
              <div className="product-card">

                <img
                  src="https://images.unsplash.com/photo-1542291026-7eec264c27ff"
                  alt=""
                />

                <div className="product-body">

                  <span className="category-badge">
                    Calzado
                  </span>

                  <h4 className="fw-bold mt-2">
                    Tenis urbanos
                  </h4>

                  <p>
                    Diseño moderno ideal para uso diario y distintos outfits.
                  </p>

                  <div className="price">
                    $850 MXN
                  </div>

                </div>
              </div>
            </div>

            <div className="col-md-6 col-lg-4">
              <div className="product-card">

                <img
                  src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e"
                  alt=""
                />

                <div className="product-body">

                  <span className="category-badge">
                    Tecnología
                  </span>

                  <h4 className="fw-bold mt-2">
                    Audífonos inalámbricos
                  </h4>

                  <p>
                    Un ejemplo de cómo tu plataforma puede incluir todo tipo de productos.
                  </p>

                  <div className="price">
                    $1,299 MXN
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="section-padding" id="categorias">
        <div className="container">

          <div className="cta-section">

            <div className="row align-items-center g-4">

              <div className="col-lg-8">
                <h2 className="section-title mb-3">
                  Categorías para todo tipo de negocio
                </h2>

                <p className="mb-0 hero-text">
                  Virtuality Emprendedores Mall puede reunir tiendas de moda,
                  calzado, accesorios, tecnología, hogar, belleza, deporte y mucho más.
                </p>
              </div>

              <div className="col-lg-4 text-lg-end">
                <button className="btn btn-main">
                  Iniciar sesión
                </button>
              </div>

            </div>

          </div>
        </div>
      </section>

    </>
  );
}

export default Home;