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

const AddUser = () => {
    const { id } = useParams();
    const dispatch = useDispatch();
    const { teams } = useSelector((state) => state.teams);
    const { boards } = useSelector((state) => state.boards);


    // add user functionality
    const [formData, setFormData] = useState({
        firstname: "",
        lastname: "",
        username: "",
        email: "",
        password: "",
        role: "1", // Default to "User"
        board_id: "", // Changed from board to board_id
        team_id: "", // Changed from team to team_id
    });


    useEffect(() => {
        dispatch(fetchBoards());
        dispatch(fetchTeams());
        dispatch(fetchUsers());

    }, [dispatch]);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    };


    const handleSubmit = async (e) => {
        e.preventDefault();

        // Prepare the activity log data
        const activityData = {
            user_id: id,  // Replace with actual user ID from context or props
            added_by: id, // Replace with actual ID
            activity_type: '1',
            activity_details: 'New User has been Added',
            board_id: formData.board_id, // Use board_id from formData
        };

        try {
            const activityResult = await axiosBaseurl.post('activity_tracker', activityData);
            console.log("Activity logged:", activityResult.data);
        } catch (error) {
            console.error("Error logging activity:", error);
        }

        const newUserDetails = {
            first_name: formData.firstname,
            last_name: formData.lastname,
            user_name: formData.username,
            board_id: formData.board_id,
            team_id: formData.team_id,
            email: formData.email,
            pass_word: formData.password,
            access_role: formData.role,
            added_by: id,
        };

        // Validate if required fields are filled
        if (formData.firstname && formData.email && formData.username && formData.lastname) {
            try {
                const userResult = await axiosBaseurl.post('add_user', newUserDetails);
                console.log("User added:", userResult.data);
                toast.success("User Added Successfully")
                setTimeout(() => {
                    window.location.reload();
                }, 4000);
            } catch (error) {
                console.error("Error adding user:", error);
            }
        } else {
            toast.error("Please fill in all required fields.");
        }

        handleReset();
    };

    const handleReset = () => {
        setFormData({
            firstname: "",
            lastname: "",
            username: "",
            email: "",
            password: "",
            role: "1", // Reset to default value
            board_id: "",
            team_id: "",
        });
    };
    return (
        <>
            <div id="addModal" className="modal fade" role="dialog">
                <div className="modal-dialog modal-md" style={{ maxWidth: '650px' }}>
                    <div className="modal-content">
                        <div className="modal-header p-0 px-4" style={{ border: 'none' }}>
                            <div className="modal-title mt-3 p-0" style={{ borderBottom: '0.8px solid rgb(67, 64, 64)', width: '100%' }}>
                                <h4 style={{ textAlign: 'left', fontSize: '16px', fontWeight: 'normal' }}>Add New User</h4>
                            </div>
                        </div>
                        <div className="modal-body">
                            <form name="add-details" style={{ margin: "10px" }} onSubmit={handleSubmit}>
                                <div className="row mb-2">
                                    <div className="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                                        <div className="form-group">
                                            <label htmlFor="firstname" style={{
                                                color: '#5a5a5a',
                                                display: 'inline-block',
                                                margin: '10px 0',
                                                fontSize: '.6em',
                                                letterSpacing: '1px',
                                                fontWeight: '700 !important'
                                            }}>FIRST NAME</label>
                                            <input
                                                type="text"
                                                className="form-control "
                                                id="firstname"
                                                name="firstname"
                                                value={formData.firstname}
                                                onChange={handleInputChange}
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
                                            <label htmlFor="lastname" style={{
                                                color: '#5a5a5a',
                                                display: 'inline-block',
                                                margin: '10px 0',
                                                fontSize: '.6em',
                                                letterSpacing: '1px',
                                                fontWeight: '700 !important'
                                            }}>LAST NAME</label>
                                            <input
                                                type="text"
                                                className="form-control "
                                                id="lastname"
                                                name="lastname"
                                                value={formData.lastname}
                                                onChange={handleInputChange}
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
                                            <label htmlFor="username" style={{
                                                color: '#5a5a5a',
                                                display: 'inline-block',
                                                margin: '10px 0',
                                                fontSize: '.6em',
                                                letterSpacing: '1px',
                                                fontWeight: '700 !important'
                                            }}>USERNAME</label>
                                            <input
                                                type="text"
                                                className="form-control"
                                                id="username"
                                                name="username"
                                                value={formData.username}
                                                onChange={handleInputChange}
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
                                            <label htmlFor="email" style={{
                                                color: '#5a5a5a',
                                                display: 'inline-block',
                                                margin: '10px 0',
                                                fontSize: '.6em',
                                                letterSpacing: '1px',
                                                fontWeight: '700 !important'
                                            }}>EMAIL</label>
                                            <input
                                                type="text"
                                                className="form-control"
                                                id="email"
                                                name="email"
                                                value={formData.email}
                                                onChange={handleInputChange}
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
                                    <div className="col-sm-6 col-md-6 col-xs-6">
                                        <label htmlFor="password" style={{
                                            color: '#5a5a5a',
                                            display: 'inline-block',
                                            margin: '10px 0',
                                            fontSize: '.6em',
                                            letterSpacing: '1px',
                                            fontWeight: '700 !important'
                                        }}>PASSWORD</label>
                                        <input
                                            type="password"
                                            className="form-control "
                                            id="password"
                                            name="password"
                                            value={formData.password}
                                            onChange={handleInputChange}
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
                                    <div className="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                                        <label htmlFor="role" style={{
                                            color: '#5a5a5a',
                                            display: 'inline-block',
                                            margin: '10px 0',
                                            fontSize: '.6em',
                                            letterSpacing: '1px',
                                            fontWeight: '700 !important'
                                        }}>SELECT ROLE</label>
                                        <select
                                            className="form-select"
                                            id="role"
                                            name="role"
                                            value={formData.role}
                                            onChange={handleInputChange}
                                            style={{
                                                padding: '10px 6px',
                                                boxShadow: 'inset 0 2px 2px #ccc',
                                                outline: 'none',
                                                fontSize: '14px'
                                            }}
                                        >
                                            <option value="1">User</option>
                                            <option value="0">Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div className="row mb-2">
                                    <div className="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                                        <label htmlFor="board" className=' ' style={{
                                            color: '#5a5a5a',
                                            display: 'inline-block',
                                            margin: '10px 0',
                                            fontSize: '.6em',
                                            letterSpacing: '1px',
                                            fontWeight: '700 !important'
                                        }}>SELECT BOARD</label>
                                        <select
                                            className="form-select"
                                            id="board"
                                            name="board_id"
                                            value={formData.board_id}
                                            onChange={handleInputChange}
                                            required
                                            style={{
                                                padding: '10px 6px',
                                                boxShadow: 'inset 0 2px 2px #ccc',
                                                fontSize: '14px'

                                            }}
                                        >
                                            <option value="-1">Select Board Name</option>
                                            {boards.map((board) => (
                                                <option key={board.id} value={board.id}>
                                                    {board.region_name}
                                                </option>
                                            ))}
                                        </select>
                                    </div>
                                </div>
                                <div className="row mb-3">
                                    <div className="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                                        <label htmlFor="team" style={{
                                            color: '#5a5a5a',
                                            display: 'inline-block',
                                            margin: '10px 0',
                                            fontSize: '.6em',
                                            letterSpacing: '1px',
                                            fontWeight: '700 !important'
                                        }}>SELECT TEAM</label>
                                        <select
                                            className="form-select"
                                            id="team"
                                            name="team_id"
                                            value={formData.team_id}
                                            onChange={handleInputChange}
                                            style={{
                                                padding: '10px 6px',
                                                boxShadow: 'inset 0 2px 2px #ccc',
                                                fontSize: '14px'
                                            }}
                                            required
                                        >
                                            <option value="-1">Select Team Name</option>
                                            {teams.map((team) => (
                                                <option key={team.id} value={team.id}>
                                                    {team.team_name}
                                                </option>
                                            ))}
                                        </select>
                                    </div>
                                </div>
                                <div className="row mb-2 text-end">
                                    <div className="col-sm-12 col-lg-12 col-xs-12">
                                        <button
                                            type="button"
                                            className="btn btn-secondary btn-block col-sm-4 col-md-4 mx-2"
                                            onClick={handleReset}
                                        >
                                            Reset
                                        </button>
                                        <button
                                            type="submit"
                                            className="btn btn-success btn-block col-sm-4 col-md-4 mx-2"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div >

            </div >
            <ToastContainer />
        </>
    )
}

export default AddUser