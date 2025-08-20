import { Outlet } from "react-router-dom";
import Header from "../Navigation/Header";
import { useEffect, useState, createContext } from "react";
import LeftSidebar from "../Navigation/LeftSidebar";
import { Col, Container, Row } from "react-bootstrap";
import { useNavigate } from "react-router-dom";


export const UserdetailsContext = createContext();


const DashboardLayout = () => {
  const navigate = useNavigate();
  const [userdetails, setuserdetails] = useState([]);
  const [batchdetails, setbatchdetails] = useState([]);

  useEffect(() => {
    setuserdetails(JSON.parse(window.localStorage.getItem("items")));
  }, []);

  return (
    <>
      {/* <style>{'body { background-color: ;height: auto;background-image: url("https://india.lenovo.com/checklist/assets/background_img-DlnfoQc9.png");background-size: cover;background-attachment: fixed;}'}</style> */}
      <UserdetailsContext.Provider value={userdetails}>
        <Header />
        <Container fluid className="body-container">
          <Row>
            <Col xs={1} md={1} sm={1}>
              {/* Vishnu addinh */}
              <LeftSidebar userdetails={userdetails} />
            </Col>
            <Col xs={11} md={11} sm={11} className="p-3">
              <Outlet />
            </Col>
          </Row>
        </Container>
      </UserdetailsContext.Provider>




    </>
  );
}

export default DashboardLayout;