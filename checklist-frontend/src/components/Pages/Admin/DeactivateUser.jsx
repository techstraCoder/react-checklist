import React, { useEffect, useState } from 'react'
import 'bootstrap/dist/css/bootstrap.min.css';
import { useDispatch, useSelector } from "react-redux";
import { fetchBoards } from "./store/reducers/boardSlice";
import { fetchTeams } from "./store/reducers/teamSlice";
import { fetchUsers } from './store/reducers/userSlice';
import axiosBaseurl from "../../axiosBaseurl";
import { useParams } from "react-router-dom";
import { ToastContainer } from "react-toastify";
import 'react-toastify/dist/ReactToastify.css'
import { toast } from "react-toastify";

const DeactivateUser = () => {
    const { id } = useParams();
    const dispatch = useDispatch();
    const { users } = useSelector((state) => state.users);
    useEffect(() => {
        dispatch(fetchBoards());
        dispatch(fetchTeams());
        dispatch(fetchUsers());

    }, [dispatch]);
    //remove user functionality
    const [user, setUser] = useState(null);

    async function showUserDetail(e) {
        const userdetailsid = e.target.value;
        await axiosBaseurl.post('/Users/deactivateUsers', { 'userid': userdetailsid, 'added_by': id }).then((result) => {
            console.log(result.data); // Check the response structure
            setUser(result.data); // Set the fetched user data
        }).catch((error) => {
            console.log(error)
        });
    }

    async function deactiveUsers(event) {
        event.preventDefault();
        console.log(user.id);  // Access the selected user ID
        await axiosBaseurl.post('activity_track_details', { 'userid': user.id, 'username': event.target.username.value, 'added_by': id }).then((result) => {
            toast.success("User Deactivated Successfully");
            console.log("User deactivated");

            setTimeout(() => {
                window.location.reload();
            }, 4000);
        }).catch((error) => {
            toast.error("Something Went Wrong");
            console.log(error)
        });
    }
    return (
        <>
            <div id="deactivateUsers" className="modal fade" role="dialog">
                <div className="modal-dialog modal-lg">
                    <div className="modal-content">
                        <div className="modal-header p-0 px-4" style={{ border: "none" }}>
                            <div
                                className="modal-title mt-3 p-0"
                                style={{
                                    borderBottom: "0.8px solid rgb(67, 64, 64)",
                                    width: "100%",
                                }}
                            >
                                <h4 style={{ textAlign: "left", fontSize: "18px" }}>Remove Users</h4>
                            </div>
                        </div>
                        <div className="modal-body">
                            <form style={{ margin: "10px" }} onSubmit={deactiveUsers}>
                                <div className="row">
                                    <div className="col-md-6 col-xs-6 col-sm-6">
                                        <select className="form-select" style={{
                                            padding: '10px 6px',
                                            boxShadow: 'inset 0 2px 2px #ccc',
                                            outline: 'none'
                                        }} onChange={showUserDetail}>
                                            <option value="-1">Select User</option>

                                            {
                                                users.map((user) => (
                                                    <option value={user.id} key={user.id}>{user.first_name} {user.last_name}</option>
                                                ))
                                            }


                                        </select>
                                    </div>
                                    <div className="col-md-6 col-sm-6 col-xs-6 text-danger">
                                        <strong>
                                            <small>
                                                <sup>*</sup>Please Select Users for Deactivation
                                            </small>
                                        </strong>
                                    </div>
                                </div>
                                <div className="row mt-3">{
                                    (user) && (
                                        <div className="col-md-12 col-sm-12 col-xs-12">

                                            <table className="table table-bordered table-sm">
                                                <caption>
                                                    Deactivate&nbsp;&nbsp;
                                                    <strong className="text-danger">{user.username}</strong>
                                                </caption>
                                                <thead className="thead-light">
                                                    <tr className="text-center">
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Username</th>
                                                        <th>Batch Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr className="text-center">
                                                        <td>{user.first_name}</td>
                                                        <td>{user.last_name}</td>
                                                        <td>{user.username}</td>
                                                        <td>{user.batchname}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <input type="hidden" name="username" value={user.id} />

                                            {/* Replace with dynamic messages */}
                                            {/* <div className="row mt-3">
                                            <p className="text-success">Deactivation successful!</p>
                                        </div> */}
                                            <div className="row mt-3">
                                                <div className="col-md-6 col-sm-6">
                                                    <button
                                                        type="button"
                                                        className="btn btn-primary btn-block col-sm-4 col-md-4 mx-2 text-justify"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        Cancel
                                                    </button>
                                                </div>
                                                <div className="col-md-6 col-sm-6 text-end">
                                                    <input
                                                        type="submit"
                                                        value="Deactivate"
                                                        // role="button"
                                                        className="button-align btn btn-danger col-md-4 col-sm-4"
                                                        style={{ height: "47px", marginTop: "17px" }}
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <ToastContainer />
        </>
    )
}

export default DeactivateUser;