import { useLocation, Link, BrowserRouter as Router, Route, json, Routes } from "react-router-dom";
import { useState } from "react";
function Usernames(props) {

  let location = useLocation();

  const [userid, setuserid] = useState((props.initiallog == 0) ? props.navlinkid.state.id : props.currentuser);


  location.state.id = userid;
  const ResetLocation = (id) => {
    location.state.id = '';
    setuserid(id);
    props.getclickedlink(id);
  }
  return <nav className="nav nav-pills nav-fill mb-2 mt-4">
    {props.users.map((id) => {
      return <div className="me-2" key={id}><Link to="/dashboard/user/" state={{ id: userid }} className={(props.taskstatusdetails[id].user_id === userid) ? 'me-2 nav-link border nav-link active' : 'me-2 nav-link border nav-link'} onClick={() => { ResetLocation(props.taskstatusdetails[id].user_id) }}>{props.taskstatusdetails[id].first_name}</Link><span className={(props.taskstatusdetails[id].alldates_pending_tasks <= 0) ? "icon1" : "icon2"}>{(props.taskstatusdetails[id].alldates_pending_tasks <= 0) ? <i class="fa fa-check"></i> : props.taskstatusdetails[id].alldates_pending_tasks}</span><span className={(props.taskstatusdetails[id].yesterday_pending_tasks <= 0) ? "icon1" : "icon2"}>{(props.taskstatusdetails[id].yesterday_pending_tasks <= 0) ? <i class="fa fa-check"></i> : props.taskstatusdetails[id].yesterday_pending_tasks}</span></div>
    })}
  </nav>
}

export default Usernames;