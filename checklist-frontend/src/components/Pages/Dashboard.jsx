import { useEffect, useState, useContext } from "react";
import { useLocation, Link, Route, Routes, useNavigate } from "react-router-dom";
import { UserdetailsContext } from "../Layouts/DashboardLayout.jsx";
import axiosBaseurl from "../axiosBaseurl.js";
import User from "../Pages/User.jsx";
import prevCarousel from "../icons/prev.svg";
import nextCarousel from "../icons/next.svg";
import { Col, Row } from "react-bootstrap";
import Usernames from "../Pages/Usernames.jsx";
import Calendar from "../icons/calendar.svg";
import jumpIcon from "../icons/3day-icon.svg";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import moment from "moment";
import { isWeekend } from "date-fns";
import ActivityStream from "./ActivityStream.jsx";



function Dashboard() {

  const navlinkid = useLocation();


  // const [validatelink,setvalidatelink] = useState((navlinkid?.state === null) ? "false" : "true");
  // let userid = (!!validatelink && (navlinkid?.state?.team_id === undefined || navlinkid.state === '') ? '' : navlinkid.state.team_id);
  const getuserdetails = useContext(UserdetailsContext);

  // const teamID = getuserdetails.team_id;
  const boardDetails = [];
  //   const getdefaultusers = [];
  //   const getMembers = [];

  //  const taskDetails = [];

  boardDetails.push(JSON.parse(window.localStorage.getItem("items")));

  const [groupMembers, setgroupMembers] = useState(JSON.parse(localStorage.getItem('batchdetails')));
  const history = useNavigate();



  const [startDate, setStartDate] = useState();
  const [calendarDate, setCalendarDate] = useState(new Date());



  // const [userdetails,setuserdetails] = useState(0);
  // const [taskdetails, settaskdetails] = useState({});

  // const [teamid, setteamid] = useState('');

  const [initallogged, setinitiallogged] = useState(0);

  const [taskstatusdetails, settaskstatusdetails] = useState([]);
  // const [teambubble,setteambubble] = useState([]);
  const [groupdetails, setgroupdetails] = useState([]);
  // const [selectuserid, setuserid] = useState([]);



  // const[useridChange,setUseridChange] = useState();

  //  const [teamchange,setteamchange] = useState(true);

  const [refreshIndex, setrefreshindex] = useState(0);

  //  const[firsttimeloggedin,setloggedin] = useState(true);
  //  const[dd,setdd] = useState(0);
  //  const[showloading,setShowloading] = useState(false);

  const [activity, setActivity] = useState([]);
  const [activityCount, setActivityCount] = useState('');


  const loggedinbatchUserid = (window.localStorage.getItem("teamidbatch") !== 'undefined') ? window.localStorage.getItem("teamidbatch") : window.localStorage.getItem("loggedinuserbatchid");

  const [loggedinuser, setuserloggedin] = useState(window.localStorage.getItem('loggedinuser'));
  const [groupid, setgroupid] = useState((navlinkid?.state != null) ? navlinkid.state.team_id : loggedinbatchUserid);



  const fetchboarddetails = async () => {
    if (navlinkid?.state != null) {
      await axiosBaseurl.post('teamlistdevs', { 'bid': boardDetails[0].board_id }).then((result) => {
        setgroupdetails(result.data);
        // setgroupMembers(groupmem.state.batchdetails);
      }).catch((error) => {
        console.log(error)
      });
    } else {
      return history("/");
    }


  }


  const fetchgroupIdMemebers = async () => {
    /** Fect Team members name */

    setgroupMembers({});
    // setgroupMembers(JSON.parse(localStorage.getItem('batchdetails')));
    if (groupid !== '') {
      // setuseridone(groupid);
      localStorage.setItem('teamidbatch', !!(groupid) ? groupid : loggedinbatchUserid);

      // localStorage.removeItem('batchdetails');
      await axiosBaseurl.post('getbatchdevs', { 'teamid': groupid }).then((result) => {
        localStorage.setItem('batchdetails', JSON.stringify(result.data));
        // setgroupMembers('');

        if (localStorage.getItem('teamidbatch') !== '') {
          setgroupMembers(JSON.parse(localStorage.getItem('batchdetails')));
        }

      }).catch((error) => {
        console.log(error)
      })

    }
  }



  const getTasklistStatus = async () => {
    // console.log("new gour",groupid);

    //  const tt = !!(groupid) ? groupid : navlinkid.state.team_id;
    const tt = !!(groupid) ? groupid : loggedinbatchUserid;

    if (!!tt) {
      changeGroupMembers();

      axiosBaseurl.post('taskstatus', { 'teamid': tt }).then((result) => {
        setuseridone(tt);

        settaskstatusdetails(result.data);


      }).catch((error) => {
        console.log(error)
      });

    }

  }

  //  const[keyid,setkeyid] = useState();
  const getdata = (data) => {

    // setteamchange(data);
    let z = refreshIndex + 1;
    setrefreshindex(z);
    // history("/dashboard/user",{state:{id:data}});

  }


  const getUserid = (id) => {

    settaskstatusdetails('');
  }


  const [refreshindexone, setrefreshindexone] = useState(0);
  const setuseridone = (data) => {
    //changeGroupMembers();

    setShowCalendarDisplay(false);
    setCalendarDetails('');
    return setrefreshindexone(data);
  }
  const changeGroupMembers = () => {

    setShowCalendarDisplay(false);
    setCalendarDetails('');
  }


  const onrefresh = async (data) => {

    // setnewdata(data)
    //  setrefreshindexone(newdata);
    getTasklistStatus();

    // setrefreshindexone()
  }
  const isWeekendDay = (date) => {
    return isWeekend(date);
  }

  const filterWeekends = (date) => {
    return !isWeekendDay(date);
  }

  // const [showCalendar, setShowCalendar] = useState(false);
  const [calendarDisplay, setShowCalendarDisplay] = useState(false);
  const [calendarDetails, setCalendarDetails] = useState([]);
  // const [startDateString, setStartDateString] = useState();
  const showstartDate = async (date) => {

    if (date != null) {
      setShowCalendarDisplay(true);
      //setStartDate(null);
      const startContainer = new Date(date);
      moment(startContainer).utcOffset("+05:30").format()

      //setStartDateString(startDateString);
      let prevDate = new Date(date.setDate(date.getDate() - 2));
      let futureDate = new Date(date.setDate(date.getDate() + 8));
      const previousDate = new Date(prevDate);
      moment(previousDate).utcOffset("+05:30").format();

      const futureDate1 = new Date(futureDate);
      moment(futureDate1).utcOffset("+05:30").format();
      //let startDateString ='';
      let previousDateString = previousDate.toLocaleString("default", { year: "numeric" }) + '-' + previousDate.toLocaleString("default", { month: "2-digit" }) + '-' + previousDate.toLocaleString("default", { day: "2-digit" });
      let futureDateStrng = futureDate1.toLocaleString("default", { year: "numeric" }) + '-' + futureDate1.toLocaleString("default", { month: "2-digit" }) + '-' + futureDate1.toLocaleString("default", { day: "2-digit" });
      //  console.log(`Previous Date ${previousDateString} and Future Date ${futureDateStrng}`);
      let startDateString = startContainer.toLocaleString("default", { year: "numeric" }) + '-' + startContainer.toLocaleString("default", { month: "2-digit" }) + '-' + startContainer.toLocaleString("default", { day: "2-digit" });

      setCalendarDate(startDateString);
      let selectedlistString = ({ 'previousDate': previousDateString, 'currentDate': startDateString, 'next': futureDateStrng, 'uuid': loggedinuser });
      await axiosBaseurl.post("selectedlist", { 'list': selectedlistString }).then((result) => {
        // console.log(result.data);  
        //if(showCalendar){
        setCalendarDetails(result.data);
        //}

      }).catch((err) => {
        console.log(err);
      });



    }

  }

  //Shivani B code
  const loadMessages = async (value) => {
    const teamID = getuserdetails.team_id;
    try {
      const result = await axiosBaseurl.post('activity_log',
        { 'load': value, 'team_id': teamID });

      // console.log('API response:', result.data.activity);

      if (Array.isArray(result.data.activity) && result.data.activity.length) {
        setActivity((prevActivity) => {
          const currentActivity = Array.isArray(prevActivity) ? prevActivity : [];

          const uniqueActivities = result.data.activity.filter(newActivity =>
            !currentActivity.some(existingActivity => existingActivity.activity_message === newActivity.activity_message)
          );

          return [...currentActivity, ...uniqueActivities];
        });
      } else {
        console.log('No activities:', result.data.activity);
      }
    } catch (error) {
      console.error('Error loading messages:', error);
    }
  };



  const totalMessagesCount = async () => {
    const teamID = '6';
    try {
      const result = await axiosBaseurl.post('total_activity_log_messages', { 'team_id': teamID });
      console.log('Activity Count:', result.data);
      setActivityCount(result.data);
    } catch (error) {
      console.log(error);
    }
  };

  const getActivity = async () => {
    const teamID = getuserdetails.team_id;
    try {
      const result = await axiosBaseurl.post('activity_log', { 'team_id': teamID });
      setActivity(result.data.activity);
    } catch (error) {
      console.log(error);
    }
  };



  useEffect(() => {
    if (navlinkid?.state != null) {
      fetchgroupIdMemebers();


      if (localStorage.getItem('teamidbatch') != null) {
        setgroupid(localStorage.getItem('teamidbatch'));
      }

      //  onrefresh();
      getTasklistStatus();
    } else {
      return history("/");
    }

  }, [groupid]);



  useEffect(() => {
    if (navlinkid?.state != null) {
      fetchboarddetails();

      // setgroupMembers(JSON.parse(localStorage.getItem('batchdetails')));
      getTasklistStatus();
      // setuseridone();
      // fetchgroupIdMemebers();
      getActivity();
      totalMessagesCount();
      loadMessages();

    } else {
      return history("/");
    }

  }, [getuserdetails, groupid, groupMembers]);





  return (

    <>

      <div className="mb-3">

        <div className="row">
          <div className="col-md-3">
            {navlinkid?.state != null &&
              <select className="form-select form-select-inline" aria-label="Default select example">
                <option value={boardDetails[0].board_id}>{boardDetails[0].group}</option>
              </select>
            }
          </div>

          <div className="col-md-4">
            {navlinkid?.state != null &&
              <select className="form-select form-select-inline" aria-label="Default select example" value={!groupid ? getuserdetails.team_id : groupid} onChange={(e) => { e.preventDefault(); setgroupid(e.target.value); getUserid(e.target.value); getTasklistStatus(); getdata(1); setinitiallogged(1); }}>
                <>
                  {groupdetails.map((ele, index) => {
                    return <option key={index} value={ele.id} onClick={changeGroupMembers}>{ele.temname}</option>
                  })}
                </>
              </select>
            }
          </div>

        </div>
      </div>


      {navlinkid?.state != null &&
        <Usernames users={Object.keys(taskstatusdetails)} taskstatusdetails={taskstatusdetails} initiallog={initallogged} resetteamid={getUserid} navlinkid={navlinkid} currentuser={Object.keys(taskstatusdetails)[0]} key={Object.keys(taskstatusdetails)} getclickedlink={setuseridone} />
      }


      <div className="nav-design shadow-sm rounded bg-body-tertiary mt-2 p-3 mb-3">
        <div className="outerContainer" style={{ width: '100%', display: 'block', height: '42px', padding: '1px 10px' }}>
          <div className="row align-items-center nav-align">
            <div className="col-md-8" style={{ width: '100%', position: 'relative', top: '13px' }}>
              <Link className="swiper-button-prev">
                <img src={prevCarousel} alt="Previous Icon" style={{ marginTop: '-23px', marginLeft: '14px' }} />
                <span style={{ marginTop: '-20px' }}>Previous</span>
              </Link>

              <div className="calendaricon">
                <img src={jumpIcon} style={{ position: 'relative', top: '-9px', right: '20px', cursor: 'pointer' }} onClick={setuseridone} />
                <img src={Calendar} style={{ position: 'relative', top: '-9px' }} />
                <DatePicker portalId="dashboard-id" className="react-picker" popperPlacement="left"
                  popperModifiers={{ flip: { behavior: ["auto-right"] }, preventOverflow: { enabled: false }, hide: { enabled: false } }} showPopperArrow={false}
                  selected={calendarDate} onChange={(calendarDate) => showstartDate(calendarDate)} dateFormat="yyyy-MM-dd" filterDate={filterWeekends}
                />

                {/* <DatePicker icon={Calendar}/><img src={Calendar}/> */}
              </div>
              <Link className="swiper-button-next">
                <span style={{ marginTop: '-20px' }}>Next</span>
                <img src={nextCarousel} alt="Next Icon" style={{ marginTop: '-23px', marginRight: '-10px' }} />

              </Link>
            </div>
          </div>
        </div>
      </div>
      <Row className="mb-3">
        <Col md={12} xs={12} sm={12} lg={12}>
        </Col>
      </Row>


      <div className="container-fluid p-1">
        <Row>

          <Col md={12} xs={12} lg={12} sm={12}>

            {/* { navlinkid?.state !=null && */}
            {/* <Suspense fallback={<div>Loading ..</div>}> */}
            {navlinkid?.state != null &&
              <Routes>
                <Route path="user" element={<User batchid={groupid} refresh={onrefresh} id={refreshindexone} key={onrefresh} showCalendardata={calendarDisplay} calendarDetails={calendarDetails} selecteddate={calendarDate} loggedinuser={loggedinuser} />} />
              </Routes>
            }
            {/* </Suspense> */}
            {/* }           */}


          </Col>

        </Row>

      </div>
      {/* <Row className="col-md-12 col-xs-12 col-lg-12 d-flex mt-12"></Row> */}
      <ActivityStream activitymessages={activity}
        loadmore={loadMessages}
        activityCount={activityCount} />


    </>

  );

}

export default Dashboard;