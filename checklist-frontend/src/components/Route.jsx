import { createBrowserRouter, createRoutesFromElements, Route, Routes } from "react-router-dom";
import Login from "./Login";
import Dashboard from "./Pages/Dashboard";
import LoginLayout from "./Layouts/Loginlayout";
import DashboardLayout from "./Layouts/DashboardLayout";
import Changepassword from "./Pages/Changepasswod";
import User from "./Pages/User";
import { lazy, Suspense } from "react";
import { Admin } from "./Pages/Admin/Admin";



const router = createBrowserRouter(
  createRoutesFromElements(
    <>
      <Route path='/' element={<LoginLayout />}>
        <Route index element={<Login />} />
      </Route>

      <Route element={<DashboardLayout />}>

        <Route path="dashboard" element={<Dashboard />}>

          <Route path="user/" element={<User />} />

        </Route>

        <Route path="changepassword" element={<Changepassword />} />
        <Route path="/dashboard/admin/:id" element={<Admin />} />
      </Route>


    </>
  ),
  { basename: "/checklistv2" } 
);
export default router;