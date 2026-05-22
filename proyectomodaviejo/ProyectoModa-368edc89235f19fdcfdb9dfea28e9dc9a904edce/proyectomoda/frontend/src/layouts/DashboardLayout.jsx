import { Navigate, Outlet } from "react-router-dom";
import DashboardSidebar from "../components/DashboardSidebar";
import "../styles/dashboard.css";

function DashboardLayout() {
  const token = localStorage.getItem("token");
  const user = localStorage.getItem("user");

  if (!token || !user) {
    return <Navigate to="/login" replace />;
  }

  return (
    <div id="wrapper">
      <DashboardSidebar />

      <main id="content">
        <Outlet />
      </main>
    </div>
  );
}

export default DashboardLayout;