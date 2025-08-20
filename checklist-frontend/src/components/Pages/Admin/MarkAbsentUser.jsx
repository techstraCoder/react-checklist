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

const MarkAbsentUser = () => {
    const { id } = useParams();
    const dispatch = useDispatch();
    const { users } = useSelector((state) => state.users);
    useEffect(() => {
        dispatch(fetchBoards());
        dispatch(fetchTeams());
        dispatch(fetchUsers());

    }, [dispatch]);

    const [startDate, setStartDate] = useState('');
    const [endDate, setEndDate] = useState('');
    const [selectedUser, setSelectedUser] = useState('');
    const [error, setError] = useState('');
    const [btndisabled, setBtnDisabled] = useState(false);

    const handleFromDate = (event) => {
        setStartDate(event.target.value);
        validateDateRange(event.target.value, endDate, selectedUser);
    };

    const handleToDate = (event) => {
        setEndDate(event.target.value);
        validateDateRange(startDate, event.target.value, selectedUser);
    };

    const handleUserSelect = (event) => {
        setSelectedUser(event.target.value);
        validateDateRange(startDate, endDate, event.target.value);
    };

    const validateDateRange = (start, end, user) => {
        // Check if all fields are filled
        if (!start || !end || !user) {
            setError('All fields are required.');
            setBtnDisabled(true);
            return;
        }

        if (start && end && end < start) {
            setError('Enter a valid date range');
            setBtnDisabled(true);
        } else if (start && isWeekend(start)) {
            setError('Weekends are not allowed for start date');
            setBtnDisabled(true);
        } else if (end && isWeekend(end)) {
            setError('Weekends are not allowed for end date');
            setBtnDisabled(true);
        } else {
            setError('');
            setBtnDisabled(false);
        }
    };

    const isWeekend = (date) => {
        const day = new Date(date).getDay();
        return day === 0 || day === 6; // Sunday or Saturday
    };

    const handleAbsentSubmit = async (event) => {
        event.preventDefault();

        if (!error) {
            const userAttendance = {
                user_id: selectedUser,
                team_id: id, // Assuming `id` is the team ID, adjust if necessary
                start_date: startDate,
                end_date: endDate,
                added_by: id, // Assuming `id` is the user adding the attendance
            };

            try {
                const result = await axiosBaseurl.post('add_attendence', userAttendance);
                console.log(result);
                toast.success("Absent Marked Sucessfully"); // Adjust as per response
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            } catch (err) {
                console.error(err);
                toast.error('Error submitting attendance');
            }
        }
    };

    return (
        <>
            {/* Mark Absent Modal */}
            <div id="updateabsentDetails" className="modal fade" role="dialog">
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
                                <h4 style={{ textAlign: "left", fontSize: "18px" }}>
                                    Mark Unavailability for Team Member
                                </h4>
                            </div>
                        </div>
                        <div className="modal-body">
                            <form style={{ margin: "10px" }} onSubmit={handleAbsentSubmit}>
                                <div className="row">
                                    <div className="col-md-6 col-xs-6 col-sm-6">
                                        <select className="form-select" style={{
                                            padding: '10px 6px',
                                            boxShadow: 'inset 0 2px 2px #ccc',
                                            outline: 'none'
                                        }}
                                            name="select_users"
                                            value={selectedUser}
                                            onChange={handleUserSelect}
                                        >
                                            <option value="-1">Select User</option>
                                            {
                                                users.map((user) => (
                                                    <option key={user.id} value={user.id}>
                                                        {user.first_name} {user.last_name}
                                                    </option>
                                                ))
                                            }

                                        </select>
                                    </div>
                                </div>
                                <div className="row mt-3">
                                    <div className="col-sm-6 col-md-6">
                                        <div className="form-group">
                                            <label htmlFor="startDate" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px" }}>START DATE</label>
                                            <input
                                                type="date"
                                                className="input-design form-control"
                                                placeholder="MM/DD/YYYY"
                                                required
                                                style={{
                                                    padding: '10px 6px',
                                                    boxShadow: 'inset 0 2px 2px #ccc',
                                                    outline: 'none'
                                                }}
                                                name="start_date"
                                                value={startDate}
                                                onChange={handleFromDate}
                                            />
                                        </div>
                                    </div>
                                    <div className="col-sm-6 col-md-6">
                                        <label htmlFor="endDate" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px" }}>END DATE</label>
                                        <input
                                            type="date"
                                            className="input-design form-control"
                                            placeholder="MM/DD/YYYY"
                                            required
                                            style={{
                                                padding: '10px 6px',
                                                boxShadow: 'inset 0 2px 2px #ccc',
                                                outline: 'none'
                                            }}
                                            name="end_date"
                                            value={endDate}
                                            onChange={handleToDate}
                                        />
                                    </div>
                                </div>
                                {error && <div className="error_message" style={{ marginTop: "10px", color: "red", fontSize: "14px" }}>**{error}</div>}
                                <div className="row mt-3">
                                    <div className="col-md-12 col-sm-12 text-end">
                                        <input
                                            type="submit"
                                            value="Submit"

                                            style={{
                                                pointerEvents: btndisabled ? "none" : "auto",
                                                backgroundColor: btndisabled ? "#929d98" : undefined,
                                                outlineColor: btndisabled ? "rgb(146, 157, 152)" : undefined,
                                                border: btndisabled ? "1px solid transparent" : undefined,
                                            }}

                                            className="button-align btn btn-success col-md-4 col-sm-4 mt-3"
                                        />
                                    </div>
                                </div>
                                <div className="row">
                                    <p style={{ display: "none" }}>
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            fill="currentColor"
                                            className="bi bi-exclamation-circle"
                                            viewBox="0 0 16 16"
                                        >
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                                        </svg>
                                        Error Message Placeholder
                                    </p>
                                    <p
                                        className="text-success"
                                        style={{ display: "none" }}
                                    >
                                        Success Message Placeholder
                                    </p>
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

export default MarkAbsentUser;