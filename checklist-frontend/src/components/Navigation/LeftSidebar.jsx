import React, { useEffect } from "react";
import { Link, NavLink, useLocation } from "react-router-dom";
import checklistlogo from "../icons/checklist-icon.svg";
import activechecklistlogo from "../icons/checklist-icon-white.svg";
import iconsreport from "../icons/reports.svg";
import iconsgrey from "../icons/report-icon-grey.svg";
import settingicon from "../icons/settings-icon.svg";
import settingicongrey from "../icons/setting-icon-grey.svg";


function LeftSidebar({ userdetails }) { //vishnu added
  const location = useLocation();
  //Modified for the user checklist dashboard abanerjee
  const loggedinuser = window.localStorage.getItem("loggedinuser");
  const groupID = window.localStorage.getItem("loggedinuserbatchid");
  const boardID = window.localStorage.getItem("board_id");
  //Modified for the user checklist dashboard abanerjee
  return (
    <div className="sidebar">
      <div className="menu">
        <div className="my-4 me-3 justify-content-end">
          <NavLink
            to={`/dashboard/user`}
            state={{
              id: loggedinuser,
              team_id: groupID,
              board_id: boardID
            }}
            className="link-light d-block p-3"
          >
            <span className="tool-link-label text-center">
              <img src={(location.pathname === '/dashboard') ? checklistlogo : activechecklistlogo} />
            </span>
          </NavLink>
        </div>
        <div className="my-4 me-3 justify-content-end">
          <NavLink
            to={`/dashboard/reportmodel`}
            className="link-light d-block p-3"
          >
            <span className="tool-link-label text-center">
              <img src={(location.pathname !== '/dashboard/reportmodel') ? iconsreport : iconsgrey} />
            </span>
          </NavLink>
        </div>
        <div className="my-4 me-3 justify-content-end">
          <NavLink
            to={`/dashboard/admin/${userdetails.user_id}`}//vishnu added
            className="link-light d-block p-3"
          >
            <span className="tool-link-label text-center">
              <img src={(location.pathname !== '/dashboard') ? settingicon : settingicongrey} />
              {/* <img src={(location.pathname !== '/dashboard/adminmodel') ? settingicon : settingicongrey} /> */}
            </span>
          </NavLink>
        </div>
      </div>
    </div>
  );
}
export default LeftSidebar;