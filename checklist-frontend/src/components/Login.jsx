import React, { useCallback, useEffect, useRef, useState } from "react";
import axiosBaseurl from "../components/axiosBaseurl";
import CryptoJS from "crypto-js";


import { useNavigate } from 'react-router-dom';
import '../App.css'

import { Col, Container, Form, Row, Button, Image } from "react-bootstrap";

function Login() {
    const API_KEY = process.env.REACT_APP_API_KEY;
    const USERNAME = process.env;
    const [formdetails, setformdetails] = useState({ username: "", password: "" });
    const [loggedinstate, setloggedinstate] = useState(false);
    const [userItems, setuseritems] = useState([]);
    const loginform = useRef(null)
    const [islogged, setislogged] = useState(false);
    const history = useNavigate();
    // const history = unstable_HistoryRouteristory();
    const [ssologin, setssologin] = useState(true);

    const [loggedsso, setloggedsso] = useState('');
    let styleCode = `.fs-6 { font-size:0.65rem !important; };.Loginform{font-family: "ABeeZee", sans-serif !important;font-weight: 400;font-style: normal;}`;
    const getloggedinUser = async (e, data) => {
        console.log("The username", data);
        e.preventDefault();
        // let usercredentials = {username:data,password:''};
        await axiosBaseurl.post('login_user_sso', { 'username': data.toString(), 'password': `` }).then((result) => {
        
            if (result.data.loggediname != '') {
             
                localStorage.setItem('batchdetails', JSON.stringify(result.data.users));
                localStorage.setItem('items', JSON.stringify(result.data));
                localStorage.setItem('loggedinuser', JSON.parse(result.data.user_id));
                localStorage.setItem('board_id', JSON.parse(result.data.board_id));
                localStorage.setItem('loggedinuserbatchid', JSON.parse(result.data.team_id));
                //boardDetails.push(JSON.parse(window.localStorage.getItem("items")));
                history("/dashboard/user", { state: { id: `${result.data.user_id}`, board_id: `${result.data.board_id}`, loggedinname: `${result.data.loggediname}`, team_id: `${result.data.team_id}`, group: `${result.data.group}` } });
            } else {
                setloggedinstate(!loggedinstate);
                setTimeout(() => { setloggedinstate((loggedinstate) => !loggedinstate); }, 2000);
                loginform.current.reset();
                setformdetails({ username: "", password: "" });
            }
        }).catch((err) => {
            console.log(err);
        });
    }

    const CheckLoginModel = () => {
        setssologin(!(ssologin));
        // alert(ssologin);
    }
    // const ssologinChecklist = async () => {
    //     await axiosBaseurl.get('currentuser').then((res) => {
    //         setloggedsso(res.data);
    //     });
    // }
    useEffect(() => {

        // ssologinChecklist();
        setformdetails({ username: "", password: "" });
        //loggedinstate;
    }, []);


    const loginformdetails = (e) => {
        e.preventDefault();

        let password = (CryptoJS.MD5(`${formdetails.password}`, API_KEY).toString(CryptoJS.enc.Hex));
        //Login usercredentials
        let usercredentials = { username: formdetails.username, password: password };
        axiosBaseurl.post('login_user', usercredentials).then((result) => {
            if (result.data.loggediname != '') {
                console.log(result.data);
                localStorage.setItem('batchdetails', JSON.stringify(result.data.users));
                localStorage.setItem('items', JSON.stringify(result.data));
                localStorage.setItem('loggedinuser', JSON.parse(result.data.user_id));
                localStorage.setItem('board_id', JSON.parse(result.data.board_id));
                localStorage.setItem('loggedinuserbatchid', JSON.parse(result.data.team_id));
                //boardDetails.push(JSON.parse(window.localStorage.getItem("items")));
                history("/dashboard/user", { state: { id: `${result.data.user_id}`, board_id: `${result.data.board_id}`, loggedinname: `${result.data.loggediname}`, team_id: `${result.data.team_id}`, group: `${result.data.group}` } });
            } else {
                setloggedinstate(!loggedinstate);
                setTimeout(() => { setloggedinstate((loggedinstate) => !loggedinstate); }, 2000);
                loginform.current.reset();
                setformdetails({ username: "", password: "" });
            }

        }).catch((error) => {
            console.log(error);
        });
    }
    return (
        <div className="login-template">
            <style>{styleCode}</style>
            <Container fluid="md" style={{ position: 'absolute', top: '50%', left: '50%', transform: 'translate(-50%,-50%)' }}>
                <Row>
                    <Col md={8} className="shadow-md bg-white align-items-center container-sm justify-content-center p-5" style={{ boxShadow: '0 4px 4px #00000040', borderRadius: '11px 11px' }}>
                        {loggedinstate ? <div className="alert alert-danger">Invalid Login Credentials</div> : ''}
                        <Form className="Loginform" onSubmit={loginformdetails} ref={loginform}>
                            <Row className="fw-bold border-bottom border-black mb-2">
                                <Col md={12}>
                                    <h3><b>Checklist+ Login</b></h3>
                                </Col>
                            </Row>
                            <Row className="d-flex justify-content-center mt-1 mb-2 col-sm-11 col-md-11 col-lg-11">
                                <Col md={5} sm={5} lg={5}>
                                    <div className="mt-1 ms-2"><input type="radio" name="login" value="2" onChange={CheckLoginModel} /><label className="form-check-label" >External Users</label></div>
                                </Col>
                                <Col md={5} sm={5} lg={5}><div className="mt-1 ms-2"><input type="radio" name="login" value="1" onChange={CheckLoginModel} defaultChecked /><label className="form-check-label" >SSO Login</label></div></Col>
                            </Row>
                            <Row className="mb-2">
                                        <Col md={6}>
                                            <Form.Group className="mb-3" controlId="formUsername">
                                                <Form.Label column="md" className="text-muted d-flex justify-content-start fw-bold fs-6 mb-1" sm={5}>USERNAME</Form.Label>
                                                <Form.Control type="text"
                                                    placeholder="Enter Your Username"
                                                    value={formdetails.name}
                                                    required="required"
                                                    autoComplete="off"
                                                    onChange={e => setformdetails({ ...formdetails, username: e.target.value })}
                                                />
                                            </Form.Group>
                                        </Col>
                                        <Col md={6}>
                                            <Form.Group className="mb-3" controlId="formUserpassword">
                                                <Form.Label column="md" className="text-muted d-flex justify-content-start fw-bold fs-6 mb-1" sm={5}>PASSWORD</Form.Label>
                                                <Form.Control type="password"
                                                    placeholder="Enter Your Password"
                                                    value={formdetails.password}
                                                    required="required"
                                                    autoComplete="off"
                                                    onChange={e => setformdetails({ ...formdetails, password: e.target.value })}
                                                />
                                            </Form.Group>
                                        </Col>
                                    </Row>
                                    <Row className="row row-cols-md-12 d-flex justify-content-end">
                                        <Col className="d-grid gap-2" md={4}>
                                            <Button variant="secondary" size="md">Reset</Button>
                                        </Col>
                                        <Col className="d-grid gap-2" md={4}>
                                            <Button type="submit" variant="success" size="md">Login</Button>
                                        </Col>

                                    </Row>

                            <Row>
                                <Col xs={12} className="mt-1"><hr /></Col>
                                <Col xs={8} className="mt-0">
                                    <Image src="data:image/png;base64,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" height="45px" />
                                    <span className="fw-bold fs-6" style={{ display: 'block' }}>Version : 1.0</span>
                                </Col>
                            </Row>
                            <Row>
                                <Col lg={4} className="mt-1 text-credits-small">
                                    <div className="text-sm-start">Arpitha BM (Project Manager)</div>
                                    <div className="text-sm-start">Usharani K. (Lead Developer)</div>
                                    <div className="text-sm-start">Ayon Banerjee (Sr.Developer) </div>
                                </Col>
                                <Col lg={4} className="mt-1 text-credits-small">
                                    <div className="text-sm-start">Nikhil Nath (Developer)</div>
                                    <div className="text-sm-start">Mohammed Sayeem(Developer)</div>
                                    <div className="text-sm-start">Kalim Khan (UI Designer) </div>
                                </Col>
                                <Col lg={4} className="mt-1 text-credits-small">
                                    <div className="text-sm-start">Greeshma SS (Developer)</div>
                                    <div className="text-sm-start">Jothi Malar K (Developer)</div>
                                    <div className="text-sm-start">Tarun Gupta (Disc.Panel) </div>
                                </Col>
                            </Row>
                        </Form>
                    </Col>
                </Row>
            </Container>
        </div>
    );
}

export default Login;