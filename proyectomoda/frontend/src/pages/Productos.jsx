import { useEffect, useState } from "react";

function Productos() {

  const [productos, setProductos] = useState([]);
  const [cargando, setCargando] = useState(true);
  const [busqueda, setBusqueda] = useState("");

  useEffect(() => {
    obtenerProductos();
  }, []);

  async function obtenerProductos() {

    try {

      const respuesta =
        await fetch(
          "http://127.0.0.1:8000/api/productos"
        );

      const data =
        await respuesta.json();

      setProductos(data.data);

    }
    catch(error){
      console.log(error);
    }

    setCargando(false);

  }

  function obtenerImagen(producto){

    if(producto.imagen){
      return `http://127.0.0.1:8000/storage/${producto.imagen}`;
    }

    return "https://via.placeholder.com/400x300";

  }

  const filtrados =
    productos.filter(p =>
      p.nombre
      ?.toLowerCase()
      .includes(
        busqueda.toLowerCase()
      )
    );

  if(cargando){

    return(
      <h1
      style={{
        textAlign:"center",
        marginTop:"100px"
      }}>
        Cargando...
      </h1>
    )

  }

  return (

<div
style={{
minHeight:"100vh",
background:"#f7f2fb",
padding:"40px"
}}
>

<h1
style={{
textAlign:"center",
fontSize:"50px",
color:"#684b7c"
}}
>
Productos
</h1>


<input

placeholder="Buscar producto..."

value={busqueda}

onChange={
e=>setBusqueda(e.target.value)
}

style={{

width:"100%",
padding:"15px",
borderRadius:"15px",
border:"1px solid #ddd",
marginBottom:"40px"

}}
/>



<div
style={{

display:"grid",

gridTemplateColumns:
"repeat(auto-fit,minmax(320px,1fr))",

gap:"30px"

}}
>

{

filtrados.map(producto=>(

<div

key={producto.id}

style={{

background:"white",

borderRadius:"25px",

overflow:"hidden",

boxShadow:
"0 10px 25px rgba(0,0,0,.08)"

}}

>

<img

src={
obtenerImagen(producto)
}

alt={
producto.nombre
}

style={{

width:"100%",
height:"250px",
objectFit:"cover"

}}

/>


<div
style={{
padding:"25px"
}}
>

<h2>

{producto.nombre}

</h2>


<p>

{producto.descripcion}

</p>


<h1
style={{
color:"#8d5da8"
}}
>

$

{producto.precio}

MXN

</h1>



<div
style={{
background:"#f8f5fc",
padding:"15px",
borderRadius:"15px",
marginTop:"15px"
}}
>

<b>
Vendedor:
</b>

{" "}

{

producto.tienda
?.nombre

||

"Sin tienda"

}

<br/>

<small>

{

producto.tienda
?.descripcion

}

</small>

</div>



<p
style={{
marginTop:"15px"
}}
>

Stock:

<b>

{" "}

{producto.stock}

</b>

</p>



<button

style={{

width:"100%",

padding:"15px",

border:"none",

borderRadius:"15px",

background:
"linear-gradient(90deg,#e6a5c8,#9f7cd0)",

color:"white",

fontWeight:"bold",

marginTop:"20px",

cursor:"pointer"

}}

>

Agregar al carrito

</button>



</div>

</div>

))

}

</div>

</div>

)

}

export default Productos;