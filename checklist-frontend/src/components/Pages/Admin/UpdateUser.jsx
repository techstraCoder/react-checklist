import React, { useEffect, useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { useDispatch, useSelector } from "react-redux";
import { fetchBoards } from "./store/reducers/boardSlice";
import { fetchTeams } from "./store/reducers/teamSlice";
import { fetchUsers } from './store/reducers/userSlice';
import axiosBaseurl from "../../axiosBaseurl";
import { useParams } from "react-router-dom";
import { ToastContainer, toast } from "react-toastify";
import 'react-toastify/dist/ReactToastify.css';

const UpdateUser = () => {
    const { id } = useParams();
    const dispatch = useDispatch();
    const { teams } = useSelector((state) => state.teams);
    const { boards } = useSelector((state) => state.boards);
    const { users } = useSelector((state) => state.users);

    useEffect(() => {
        dispatch(fetchBoards());
        dispatch(fetchTeams());
        dispatch(fetchUsers());
    }, [dispatch]);

    const [boardName, setBoardName] = useState("-1");
    const [teamName, setTeamName] = useState("");
    const [filteredTeams, setFilteredTeams] = useState([]);
    const [userData, setUserData] = useState([]);

    // Update the team dropdown when board is selected
    useEffect(() => {
        if (boardName !== "-1") {
            setFilteredTeams([...teams]); // Filter teams based on board selection
        } else {
            setFilteredTeams([]);
        }
        setTeamName(""); // Reset team selection when the board changes
    }, [boardName, teams]);

    function showUsers(e) {
        let selectedUsers = users.filter((user) => user.team_id === e.target.value);
        setUserData([...selectedUsers]);
    }

    const [updateDetails, setUpdateDetails] = useState({});
    const [updateStatus, setUpdateStatus] = useState('');

    const getEditUser = async (userId) => {
        try {
            const result = await axiosBaseurl.post('get_team_members', { userid: userId });
            setUpdateDetails(result.data[0] || {});
        } catch (error) {
            console.error(error);
        }
    };

    const updateUserValue = async (event) => {
        event.preventDefault();

        const updateUserDetails = {
            firstname: event.target.firstname.value,
            lastname: event.target.lastname.value,
            userRole: event.target.role.value,
            userid: event.target.updateid.value,
            teamid: event.target.teamname.value,
            email: event.target.email.value,
            username: event.target.username.value,
            boardid: event.target.boardname.value,
            added_by: id,
        };

        console.log(event.target.teamname.value)

        try {
            const result = await axiosBaseurl.post('update_user_roles', { updatedetails: updateUserDetails });
            setUpdateStatus(result.data.msg);
            toast.success("User Updated Successfully");
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <>
            <div id="updateuserDetails" className="modal fade" role="dialog">
                <div className="modal-dialog modal-lg">
                    <div className="modal-content">
                        <div className="modal-header p-0 px-4" style={{ border: "none" }}>
                            <div className="modal-title mt-3 p-0" style={{ borderBottom: "0.8px solid rgb(67, 64, 64)", width: "100%" }}>
                                <h4 style={{ textAlign: "left", fontSize: "18px" }}>Users</h4>
                            </div>
                        </div>

                        <div className="modal-body" style={{ margin: "10px" }}>
                            <form name="userUpdate-details">
                                <div className="row mb-2">
                                    {/* Select Board */}
                                    <div className="col-sm-6">
                                        <label htmlFor="board" style={{ fontSize: "10px", fontWeight: "600", color: "#5a5a5a", letterSpacing: "1px", textTransform: 'uppercase' }}>Select Board</label>
                                        <select
                                            className="form-select"
                                            style={{ padding: '10px 6px', boxShadow: 'inset 0 2px 2px #ccc', outline: 'none' }}
                                            value={boardName}
                                            onChange={(e) => setBoardName(e.target.value)}
                                        >
                                            <option value="-1">Select Board Name</option>
                                            {boards.map((board, index) => (
                                                <option key={index} value={board.id}>{board.region_name}</option>
                                            ))}
                                        </select>
                                    </div>

                                    {/* Select Team */}
                                    <div className="col-sm-6">
                                        <label htmlFor="team" style={{ fontSize: "10px", fontWeight: "600", color: "#5a5a5a", letterSpacing: "1px", textTransform: 'uppercase' }}>Select Team</label>
                                        <select
                                            className="form-select"
                                            style={{ padding: '10px 6px', boxShadow: 'inset 0 2px 2px #ccc', outline: 'none' }}
                                            value={teamName}
                                            onChange={(e) => {
                                                setTeamName(e.target.value);
                                                showUsers(e);
                                            }}
                                        >
                                            <option value="">Select Team Name</option>
                                            {boardName === "-1" || filteredTeams.length === 0 ? (
                                                <option value="">No teams available</option>
                                            ) : (
                                                filteredTeams.map((team, index) => (
                                                    <option key={index} value={team.id}>{team.team_name}</option>
                                                ))
                                            )}
                                        </select>
                                    </div>
                                </div>
                            </form>

                            {/* Users Table */}
                            <table className="table">
                                <thead>
                                    {
                                        boardName === "-1" || filteredTeams.length === 0 ? (
                                            <div style={{ color: 'red' }}>Please select all the fields</div>
                                        ) : (
                                            userData.length > 0 && (
                                                <tr>
                                                    <th>#</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Board</th>
                                                    <th>Team</th>
                                                    <th>Access Role</th>
                                                    <th>Action</th>
                                                </tr>
                                            ))}
                                </thead>
                                <tbody>
                                    {boardName === "-1" || filteredTeams.length === 0 ? (
                                        <div></div>
                                    ) :
                                        (
                                            userData.map((user, index) => (
                                                <tr key={index} style={{ verticalAlign: "middle" }}>
                                                    <td>{index + 1}</td>
                                                    <td>{user.user_name}</td>
                                                    <td>{user.email}</td>
                                                    <td>{boards.find(board => board.id === user.board_id)?.region_name || "Unknown"}</td>
                                                    <td>{teams.find(team => team.id === user.team_id)?.team_name || "Unknown"}</td>
                                                    <td>{user.access_role === "0" ? "Admin" : "User"}</td>
                                                    <td>
                                                        <i
                                                            className="fa fa-pencil mx-auto text-primary"
                                                            data-bs-target="#updatespecificUser"
                                                            data-bs-toggle="modal"
                                                            role="button"
                                                            onClick={() => getEditUser(user.id)}
                                                        ></i>
                                                    </td>
                                                </tr>
                                            )))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="updatespecificUser" className="modal fade" role="dialog">
                <div className="modal-dialog modal-md" style={{ maxWidth: '650px' }}>
                    <div className="modal-content">
                        <div className="modal-header p-0 px-4" style={{ border: 'none !important' }}>
                            <div className="modal-title mt-3 p-0" style={{ borderBottom: '0.8px solid rgb(67, 64, 64)', width: '100%' }}>
                                <h4 style={{ textAlign: 'left', fontSize: '18px' }}>Update User</h4>
                            </div>
                        </div>
                        <div className="modal-body">
                            <form onSubmit={updateUserValue} style={{ margin: '10px' }}>
                                <div className="row mb-2">
                                    <div className="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                                        <div className="form-group">
                                            <label htmlFor="firstname" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px", textTransform: 'uppercase' }}>First Name</label>
                                            <input
                                                type="text"
                                                className="form-control"
                                                name="firstname"
                                                value={updateDetails.first_name || ''}
                                                onChange={(e) => setUpdateDetails({ ...updateDetails, first_name: e.target.value })}
                                                autoComplete="off"
                                                style={{
                                                    padding: '10px 6px',
                                                    boxShadow: 'inset 0 2px 2px #ccc',
                                                    outline: 'none',
                                                    fontSize: '14px'
                                                }}
                                            />
                                        </div>
                                    </div>
                                    <div className="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                                        <div className="form-group">
                                            <label htmlFor="lastname" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px", textTransform: 'uppercase' }}>Last Name</label>
                                            <input
                                                type="text"
                                                className="form-control"
                                                name="lastname"
                                                value={updateDetails.last_name || ''}
                                                onChange={(e) => setUpdateDetails({ ...updateDetails, last_name: e.target.value })}
                                                required
                                                autoComplete="off"
                                                style={{
                                                    padding: '10px 6px',
                                                    boxShadow: 'inset 0 2px 2px #ccc',
                                                    outline: 'none',
                                                    fontSize: '14px'
                                                }}
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div className="row mb-2">
                                    <div className="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                                        <div className="form-group">
                                            <label htmlFor="email" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px", textTransform: 'uppercase' }}>Email</label>
                                            <input
                                                type="email"
                                                className="form-control"
                                                name="email"
                                                value={updateDetails.email || ''}
                                                onChange={(e) => setUpdateDetails({ ...updateDetails, email: e.target.value })}
                                                required
                                                autoComplete="off"
                                                style={{
                                                    padding: '10px 6px',
                                                    boxShadow: 'inset 0 2px 2px #ccc',
                                                    outline: 'none',
                                                    fontSize: '14px'
                                                }}
                                            />
                                        </div>
                                    </div>
                                    <div className="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                                        <div className="form-group">
                                            <label htmlFor="username" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px", textTransform: 'uppercase' }}>Username</label>
                                            <input
                                                type="text"
                                                className="form-control"
                                                name="username"
                                                value={updateDetails.user_name || ''}
                                                onChange={(e) => setUpdateDetails({ ...updateDetails, user_name: e.target.value })}
                                                required
                                                autoComplete="off"
                                                style={{
                                                    padding: '10px 6px',
                                                    boxShadow: 'inset 0 2px 2px #ccc',
                                                    outline: 'none',
                                                    fontSize: '14px'
                                                }}
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div className="row mb-2">
                                    <div className="col-sm-11 col-md-11 col-lg-11 col-xs-11">
                                        <div className="form-group">
                                            <label htmlFor="role" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px", textTransform: 'uppercase' }}>Role</label>
                                            <select
                                                className="form-select"
                                                name="role"
                                                value={updateDetails.access_role || ''}
                                                onChange={(e) => setUpdateDetails({ ...updateDetails, access_role: e.target.value })}
                                                required
                                                style={{
                                                    padding: '10px 6px',
                                                    boxShadow: 'inset 0 2px 2px #ccc',
                                                    outline: 'none',
                                                    fontSize: '14px'
                                                }}
                                            >
                                                <option value="0">Admin</option>
                                                <option value="1">User</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div className='row mb-2'>
                                    <div className="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                                        <div className="form-group">
                                            <label htmlFor="teamname" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px", textTransform: 'uppercase' }}>Select Board</label>
                                            <select
                                                className="form-select"
                                                name="boardname"
                                                value={updateDetails.board_id || ''}
                                                onChange={(e) => setUpdateDetails({ ...updateDetails, board_id: e.target.value })}
                                                required
                                                style={{
                                                    padding: '10px 6px',
                                                    boxShadow: 'inset 0 2px 2px #ccc',
                                                    outline: 'none',
                                                    fontSize: '14px'
                                                }}
                                            >
                                                <option value="">Select Board</option>
                                                {
                                                    boards.map((board) => (
                                                        <option key={board.id} value={board.id}>{board.region_name}</option>
                                                    ))
                                                }
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div className='row mb-3'>
                                    <div className="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                                        <div className="form-group">
                                            <label htmlFor="teamname" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px", textTransform: 'uppercase' }}>Select Team</label>
                                            <select
                                                className="form-select"
                                                name="teamname"
                                                value={updateDetails.team_id || ''}
                                                onChange={(e) => setUpdateDetails({ ...updateDetails, team_id: e.target.value })}
                                                required
                                                style={{
                                                    padding: '10px 6px',
                                                    boxShadow: 'inset 0 2px 2px #ccc',
                                                    outline: 'none',
                                                    fontSize: '14px'
                                                }}
                                            >

                                                {
                                                    teams.map((team) => (
                                                        <option key={team.id} value={team.id} >{team.team_name}</option>
                                                    ))
                                                }
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <input type="hidden" name="updateid" value={updateDetails.id || ''} />

                                {updateStatus && (
                                    <div className="row m-2 text-success">
                                        <div className="col-md-11 col-sm-11">{updateStatus}</div>
                                    </div>
                                )}
                                <div className="row mb-2 text-end">
                                    <div className="col-sm-12 col-lg-12 col-xs-12">
                                        <button type="button" className="btn btn-secondary mx-2" data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" className="btn btn-success mx-2">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <ToastContainer />
        </>
    );
};

export default UpdateUser;
