import { Link, useNavigate } from "react-router-dom";

function Navbar() {

  const navigate = useNavigate();

  const user =
    JSON.parse(
      localStorage.getItem("user")
    );

  function irASeccion(id){

    if(window.location.pathname !== "/"){

      navigate("/");

      setTimeout(()=>{

        const seccion =
          document.getElementById(id);

        if(seccion){

          seccion.scrollIntoView({
            behavior:"smooth",
            block:"start"
          });

        }

      },200);

      return;

    }

    const seccion =
      document.getElementById(id);

    if(seccion){

      seccion.scrollIntoView({
        behavior:"smooth",
        block:"start"
      });

    }

  }

  function obtenerPanel(){

    if(!user)
      return "/login";

    if(user.rol==="admin")
      return "/dashboard/admin";

    if(user.rol==="cliente")
      return "/dashboard/cliente";

    if(user.rol==="emprendedor")
      return "/dashboard/emprendedor";

    return "/";

  }

  function cerrarSesion(){

    localStorage.removeItem("token");
    localStorage.removeItem("user");

    window.location.href="/";

  }

return(

<nav
className="navbar navbar-expand-lg navbar-custom py-3"
>

<div className="container">

<Link
className="navbar-brand"
to="/"
>

Virtuality <span>Mall</span>

</Link>



<button

className="
navbar-toggler
border-0
shadow-none"

type="button"

data-bs-toggle="collapse"

data-bs-target="#navbarMall"

>

<i className="fas fa-bars"></i>

</button>



<div
className="collapse navbar-collapse"
id="navbarMall"
>

<ul
className="
navbar-nav
ms-auto
align-items-lg-center
gap-lg-2"
>

<li className="nav-item">

<Link
className="nav-link"
to="/"
>

Inicio

</Link>

</li>



<li className="nav-item">

<Link
className="nav-link"
to="/productos"
>

Productos

</Link>

</li>



<li className="nav-item">

<button

type="button"

className="
nav-link
border-0
bg-transparent"

onClick={
()=>irASeccion("categorias")
}

>

Categorías

</button>

</li>



<li className="nav-item">

<button

type="button"

className="
nav-link
border-0
bg-transparent"

onClick={
()=>irASeccion("beneficios")
}

>

Beneficios

</button>

</li>



<li className="nav-item">

<button

type="button"

className="
nav-link
border-0
bg-transparent"

onClick={
()=>irASeccion("contacto")
}

>

Contacto

</button>

</li>



{

!user && (

<>

<li className="nav-item">

<Link
className="nav-link"
to="/login"
>

Iniciar sesión

</Link>

</li>



<li className="nav-item">

<Link
className="nav-link"
to="/register"
>

Registrarse

</Link>

</li>

</>

)

}



{

user && (

<>

{/* BOTON CARRITO */}

<li className="nav-item">

<Link

to="/carrito"

style={{

display:"flex",

alignItems:"center",

gap:"8px",

padding:"10px 18px",

background:"white",

borderRadius:"14px",

textDecoration:"none",

color:"#684b7c",

fontWeight:"bold",

boxShadow:
"0 5px 15px rgba(0,0,0,.08)"

}}

>

<i
className="
bi
bi-cart3"
></i>

Carrito

</Link>

</li>



<li className="nav-item">

<Link
className="nav-link"
to={obtenerPanel()}
>

Mi panel

</Link>

</li>



<li className="nav-item">

<button

type="button"

onClick={
cerrarSesion
}

className="
nav-link
border-0
bg-transparent"

>

Salir

</button>

</li>

</>

)

}

</ul>

</div>

</div>

</nav>

)

}

export default Navbar;