import React, { useContext, useEffect, useState } from "react";
import { useLocation,Link, NavLink, useNavigate, Route } from "react-router-dom";
import checklistLogo from "../Logos/checklist-plus.svg";
import { Container, Dropdown, Nav, Navbar, NavbarBrand, NavDropdown } from "react-bootstrap";
import { UserdetailsContext } from "../Layouts/DashboardLayout.jsx";

function Header(){
    const { state } = useLocation();
    const history = useNavigate();
    const[istoggle,setistoggle] = useState("false");
    const getuserdetails = useContext(UserdetailsContext);

    const loggedinuser = state && state.loggedinname;
    const loggedinuserid = state && state.id;
   
    const navigate = useNavigate();

   
    const onlogout = (e)=>{
        e.preventDefault();
        localStorage.clear();
        navigate("/");
    }

  
    return (
        <>
            {/* Navigation Bar */}
            <Navbar expand="lg" className="bg-body-tertiary">
             <Container fluid>
                  <Navbar.Brand><Link to={`/dashboard`} className="dropdown-item"><img src={checklistLogo}/></Link></Navbar.Brand>
                  <Nav.Item className="ms-auto text-end" data-bs-toggle="toggle" aria-expanded="false"> 
                  <NavDropdown title={getuserdetails.firstname} id="collapsible-nav-dropdown container-sm text-end" aria-expanded="false">
                     <Link
                       className="dropdown-item"
                        to = {`/changepassword`}
                        state = {{
                        id:getuserdetails.user_id
                        }}
                    >
                Change Password
  </Link>
                       
                        <NavDropdown.Divider />
                        <NavDropdown.Item href="#action/3.2">Mark Absent</NavDropdown.Item>
                        <NavDropdown.Divider />
                        <Link to={`/`} onClick={onlogout} className="dropdown-item">Logout</Link>
                    </NavDropdown>
                  </Nav.Item>
             </Container>
           </Navbar>
            {/*End Navigation Bar */}
        </>
        
    );
}
export default Header;