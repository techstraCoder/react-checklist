import React from 'react';

import { Link } from 'react-router-dom';

import AddUser from './AddUser';
import DeactivateUser from './DeactivateUser';
import MarkAbsentUser from './MarkAbsentUser';
import AddNotification from './AddNotification';
import UpdateUser from './UpdateUser';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';


export const Admin = () => {

    return (
        <div style={{ height: '50vw' }}>
            <div className="col-md-12 col-lg-12 p-3 col-sm-12 mx-auto d-flex justify-content-center">
                <div className="card m-3" style={{ width: '20rem' }}>
                    <div className="card-header text-light bg-dark">
                        User Management
                    </div>
                    <ul className="list-group list-group-flush">
                        <li className="list-group-item" role="button" data-bs-toggle="modal" data-bs-target="#addModal">
                            Add New User
                        </li>
                        <li className="list-group-item" role="button" data-bs-toggle="modal" data-bs-target="#updateuserDetails">
                            Update User Profile
                        </li>
                        <li className="list-group-item" role="button" data-bs-toggle="modal" data-bs-target="#deactivateUsers">
                            Remove User
                        </li>
                        <li className="list-group-item" role="button" data-bs-toggle="modal" data-bs-target="#updateabsentDetails">
                            Mark Absent
                        </li>
                        <li className="list-group" role="button">
                            <Link to='/checklist/activitylog' className="list-group-item" data-bs-target="#activityLog">Activity Log</Link>
                        </li>
                    </ul>
                </div>

                {/* Second Card */}
                <div className="card m-3" style={{ width: '20rem', height: '10vw' }}>
                    <div className="card-header text-light bg-dark">
                        Notifications
                    </div>
                    <ul className="list-group list-group-flush">
                        <li className="list-group-item" role="button" data-bs-toggle="modal" data-bs-target="#addNotification">
                            Add New Notification
                        </li>
                        <li className="list-group-item">Edit/Delete Notifications</li>
                    </ul>
                </div>
                {/* End Second Card */}
            </div>
            <AddUser />
            <DeactivateUser />
            <MarkAbsentUser />
            <AddNotification />
            <UpdateUser />
        </div>
    );
};
