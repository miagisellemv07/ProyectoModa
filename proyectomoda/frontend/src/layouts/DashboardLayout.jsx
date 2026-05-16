import { Outlet } from "react-router-dom";
import DashboardSidebar from "../components/DashboardSidebar";
import "../styles/dashboard.css";

function DashboardLayout() {
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