import React, { useEffect, useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { useDispatch, useSelector } from "react-redux";
import { fetchBoards } from "./store/reducers/boardSlice";
import { fetchTeams } from "./store/reducers/teamSlice";
import { fetchUsers } from './store/reducers/userSlice';
import axiosBaseurl from "../../axiosBaseurl";
import { useParams } from "react-router-dom";
import { ToastContainer } from "react-toastify";
import 'react-toastify/dist/ReactToastify.css';
import { toast } from "react-toastify";

const AddNotification = () => {
    const { id } = useParams();
    const dispatch = useDispatch();
    const { teams } = useSelector((state) => state.teams);
    const { boards } = useSelector((state) => state.boards);

    const [message, setMessage] = useState("");
    const [startNotDate, setStartNotDate] = useState("");
    const [endNotDate, setEndNotDate] = useState("");
    const [boardName, setBoardName] = useState("-1");
    const [teamName, setTeamName] = useState("");
    const [filteredTeams, setFilteredTeams] = useState([]);

    useEffect(() => {
        dispatch(fetchBoards());
        dispatch(fetchTeams());
        dispatch(fetchUsers());
    }, [dispatch]);

    useEffect(() => {
        if (boardName !== "-1") {

            setFilteredTeams([...teams]);
        } else {
            setFilteredTeams([]);
        }
        setTeamName(""); // Reset team selection when the board changes
    }, [boardName, teams]);

    const handleNotification = async (e) => {
        e.preventDefault();

        if (message && startNotDate && endNotDate && boardName !== "-1" && teamName) {
            const notificationMessage = {
                added_by: id,
                board: boardName,
                teamid: teamName,
                message,
                startDate: startNotDate,
                endDate: endNotDate,
            };

            try {
                const result = await axiosBaseurl.post("postnotifications", notificationMessage);
                setMessage("");
                setStartNotDate("");
                setEndNotDate("");
                setBoardName("-1");
                setTeamName("");
                toast.success(result.data.msg);
                setTimeout(() => {
                    window.location.reload();
                }, 4000);
            } catch (error) {
                console.error(error);
            }
        } else {
            toast.error("Please fill out all required fields!");
            setTimeout(() => {
                window.location.reload();
            }, 4000);
        }
    };

    return (
        <>
            <div id="addNotification" className="modal fade" role="dialog">
                <div className="modal-dialog modal-md" style={{ maxWidth: "650px" }}>
                    <div className="modal-content">
                        <div className="modal-header p-0 px-4" style={{ border: "none" }}>
                            <div
                                className="modal-title mt-3 p-0"
                                style={{
                                    borderBottom: "0.8px solid rgb(67, 64, 64)",
                                    width: "100%",
                                }}
                            >
                                <h4 style={{ textAlign: "left", fontSize: "18px" }}>Make An Announcement</h4>
                            </div>
                        </div>
                        <div className="modal-body">
                            <form name="notification-details" style={{ margin: "10px" }} onSubmit={handleNotification}>
                                <div className="row mb-2">
                                    {/* Board Selection */}
                                    <div className="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                                        <label htmlFor="board" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px" }}>SELECT BOARD</label>
                                        <select
                                            className="form-select"
                                            style={{
                                                padding: '10px 6px',
                                                boxShadow: 'inset 0 2px 2px #ccc',
                                                outline: 'none',
                                                fontSize: '14px'
                                            }}
                                            value={boardName}
                                            onChange={(e) => setBoardName(e.target.value)}
                                            required
                                        >
                                            <option value="-1">Select Board Name</option>
                                            {boards.map((board, index) => (
                                                <option key={index} value={board.id}>{board.region_name}</option>
                                            ))}
                                        </select>
                                    </div>

                                    {/* Team Selection */}
                                    <div className="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                                        <label htmlFor="team" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px" }}>SELECT TEAM</label>
                                        <select
                                            className="form-select"
                                            style={{
                                                padding: '10px 6px',
                                                boxShadow: 'inset 0 2px 2px #ccc',
                                                outline: 'none',
                                                fontSize: '14px'
                                            }}
                                            value={teamName}
                                            onChange={(e) => setTeamName(e.target.value)}
                                            required
                                        >
                                            {/* Show options only if filteredTeams is non-empty */}
                                            <option value="">Select Team name</option>
                                            {boardName === "-1" || filteredTeams.length === 0 ? (
                                                <option value="">No teams available</option>
                                            ) : (
                                                filteredTeams.map((team, index) => (
                                                    <option key={index} value={team.team_name}>{team.team_name}</option>
                                                ))
                                            )}
                                        </select>
                                    </div>
                                </div>

                                {/* Date Pickers */}
                                <div className="row mb-2">
                                    <div className="col-md-6 col-sm-6 col-lg-6 col-xs-6">
                                        <div className="form-group">
                                            <label htmlFor="startDate" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px" }}>START DATE</label>
                                            <input
                                                type="date"
                                                className="form-control"
                                                style={{
                                                    padding: '10px 6px', fontSize: '14px'
                                                }}
                                                value={startNotDate}
                                                onChange={(e) => setStartNotDate(e.target.value)}
                                                required
                                            />
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-sm-6 col-lg-6 col-xs-6">
                                        <label htmlFor="endDate" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px" }}>END DATE</label>
                                        <input
                                            type="date"
                                            className="form-control"
                                            style={{
                                                padding: '10px 6px', fontSize: '14px'
                                            }}
                                            value={endNotDate}
                                            onChange={(e) => setEndNotDate(e.target.value)}
                                            required
                                        />
                                    </div>
                                </div>

                                {/* Message */}
                                <div className="row mb-2">
                                    <div className="form-group">
                                        <label htmlFor="message" style={{ fontSize: "10px", fontWeight: "600", color: "rgba(88, 86, 86, 0.68)", letterSpacing: "1px" }}>MESSAGE</label>
                                        <textarea
                                            rows="2"
                                            cols="120"
                                            className="form-control"
                                            style={{
                                                padding: '10px 6px',
                                                boxShadow: 'inset 0 2px 2px #ccc',
                                                outline: 'none',
                                                fontSize: '14px'
                                            }}
                                            value={message}
                                            onChange={(e) => setMessage(e.target.value)}
                                            required
                                        />
                                    </div>
                                </div>

                                {/* Submit Button */}
                                <div className="row mb-2 text-end">
                                    <div className="col-sm-12 col-lg-12 col-xs-12">
                                        <button type="submit" className="btn btn-success btn-block col-sm-4 col-md-4 mx-2">
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

export default AddNotification;
