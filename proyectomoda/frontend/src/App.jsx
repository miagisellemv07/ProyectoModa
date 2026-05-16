import { BrowserRouter, Routes, Route } from "react-router-dom";

import Navbar from "./components/Navbar";
import Footer from "./components/Footer";

import Home from "./pages/Home";
import Productos from "./pages/Productos";
import DetalleProducto from "./pages/DetalleProducto";

import Login from "./pages/Login";
import Register from "./pages/Register";

import DashboardLayout from "./layouts/DashboardLayout";

import AdminClientes from "./pages/dashboard/AdminClientes";
import AdminTiendas from "./pages/dashboard/AdminTiendas";
import AdminUsuarios from "./pages/dashboard/AdminUsuarios";

import ClienteCompras from "./pages/dashboard/ClienteCompras";
import ClientePagos from "./pages/dashboard/ClientePagos";

import EmprendedorPedidos from "./pages/dashboard/EmprendedorPedidos";
import EmprendedorPagos from "./pages/dashboard/EmprendedorPagos";
import EmprendedorProductos
from "./pages/dashboard/EmprendedorProductos";

import "./styles/auth.css";

function App() {
  return (
    <BrowserRouter>

      <Routes>

        <Route
          path="/"
          element={
            <>
              <Navbar />
              <Home />
              <Footer />
            </>
          }
        />

        <Route
          path="/productos"
          element={
            <>
              <Navbar />
              <Productos />
              <Footer />
            </>
          }
        />

        <Route
          path="/productos/:id"
          element={
            <>
              <Navbar />
              <DetalleProducto />
              <Footer />
            </>
          }
        />

        <Route
          path="/login"
          element={
            <>
              <Navbar />
              <Login />
              <Footer />
            </>
          }
        />

        <Route
          path="/register"
          element={
            <>
              <Navbar />
              <Register />
              <Footer />
            </>
          }
        />

        <Route path="/dashboard" element={<DashboardLayout />}>
          <Route path="admin/clientes" element={<AdminClientes />} />
          <Route path="admin/tiendas" element={<AdminTiendas />} />
          <Route path="admin/usuarios" element={<AdminUsuarios />} />

          <Route path="cliente/compras" element={<ClienteCompras />} />
          <Route path="cliente/pagos" element={<ClientePagos />} />

          <Route path="emprendedor/pedidos" element={<EmprendedorPedidos />} />
          <Route path="emprendedor/pagos" element={<EmprendedorPagos />} />
          <Route path="emprendedor/productos" element={<EmprendedorProductos />}
/>
        </Route>

      </Routes>

    </BrowserRouter>
  );
}

export default App;