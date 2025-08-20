import { useLocation, useNavigate } from "react-router-dom";
import axiosBaseurl from "../axiosBaseurl";
import React, { useContext, useEffect, useRef, useState, useReducer } from "react";
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Virtual } from 'swiper/modules';

import Laodingspinner from "../Pages/Laodingspinner.jsx";
import 'react-loading-skeleton/dist/skeleton.css'

import { Col, Form, Row, Button } from "react-bootstrap";
import Modal from 'react-bootstrap/Modal';
import Copy from "../icons/copy.svg";
import edit from "../icons/edit.svg";
import trash from "../icons/trash-red-small.svg";
import plus from "../icons/plus-circle.svg";
import cancel from "../icons/x-circle.svg";
import cancelbtn from "../icons/cancel-btn.svg";
// import save from "../icons/check-primary.svg";
import update from "../icons/check-bold.svg";
import moment from "moment";
// import { formatInTimeZone } from 'date-fns-tz'
// import { fromZonedTime } from 'date-fns-tz'
// import { getTimezoneOffset } from 'date-fns-tz'
import { Navigate } from "react-router-dom";

import './virtualslides.css';


import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";

import { UserdetailsContext } from "../Layouts/DashboardLayout.jsx";
// import { SortableContext, verticalListSortingStrategy,horizontalListSortingStrategy } from '@dnd-kit/sortable';

import { arrayMove } from '@dnd-kit/sortable';


import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/virtual';


import { DropArea } from "./DropArea.jsx";


// import {useDroppable,DragOverlay} from '@dnd-kit/core';
import { TasklistCard } from "./TasklistCard.jsx";

import { isWeekend } from "date-fns";


import { ToastContainer } from "react-toastify";
import 'react-toastify/dist/ReactToastify.css'
import { toast, Bounce } from "react-toastify";
import e from "cors";




const datelist = () => {
  var MonthCalendar = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'Aug', 'September', 'October', 'November', 'December']
  //  var MonthCalendar_month = ['','01','02','03','04','05','06','07','08','09','10','11','12']


  var currentDate = new Date()
  var daysList = [];
  var actualslidersdate = [];
  var Add5days = new Date(currentDate.setDate(currentDate.getDate() + 40))
  var subtract5days = new Date(currentDate.setDate(currentDate.getDate() - 64))
  var from = new Date(subtract5days.getFullYear(), subtract5days.getMonth(), subtract5days.getDate())
  var to = new Date(Add5days.getFullYear(), Add5days.getMonth(), Add5days.getDate())

  for (var day = from; day <= to; day.setDate(day.getDate() + 1)) {

    if (day.getDay() !== 6 && day.getDay() !== 0) {
      var dd = (day.getDate())
      var mm = (day.getMonth() + 1)
      var yy = day.getFullYear()
      //  var arrmonth = (day.getMonth()+1 < 10 ? '0'+day.getMonth()+1 : day.getMonth()+1 )
      var fulldate = day.getFullYear() + '-' + (day.getMonth() + 1 < 10 ? '0' + (day.getMonth() + 1) : (day.getMonth() + 1)) + '-' + (day.getDate() < 10 ? '0' + day.getDate() : day.getDate())
      daysList.push({ 'date': dd, 'month': MonthCalendar[mm], 'year': yy, 'fulldate': fulldate, 'monthid': mm })
      //daysList[fulldate] = {'date':dd,'month':MonthCalendar[mm],'year':yy,'fulldate':fulldate,'monthid':mm}
    }
  }
  //console.log(daysList);
  daysList.map((ele, index) => {
    return actualslidersdate[ele.fulldate] = { 'date': ele.date, 'month': ele.month, 'year': ele.year };
  })


  var TodayDate = new Date()
  var currentdateToday = TodayDate.getFullYear() + '-' + ((TodayDate.getMonth() + 1) < 10 ? '0' + (TodayDate.getMonth() + 1) : (TodayDate.getMonth() + 1)) + '-' + (TodayDate.getDate() < 10 ? '0' + TodayDate.getDate() : TodayDate.getDate())
  return actualslidersdate;
}

const getdaysListinCurrent = () => {
  var MonthCalendar = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'Aug', 'September', 'October', 'November', 'December']
  //  var MonthCalendar_month = ['','01','02','03','04','05','06','07','08','09','10','11','12']
  var daysList = [];
  // var TodayDate = new Date();
  var currentDate = new Date();
  var Add5days = new Date(currentDate.setDate(currentDate.getDate() + 40))
  var subtract5days = new Date(currentDate.setDate(currentDate.getDate() - 64))
  var from = new Date(subtract5days.getFullYear(), subtract5days.getMonth(), subtract5days.getDate())
  var to = new Date(Add5days.getFullYear(), Add5days.getMonth(), Add5days.getDate())

  for (var day = from; day <= to; day.setDate(day.getDate() + 1)) {

    if (day.getDay() != 6 && day.getDay() != 0) {
      var dd = (day.getDate())
      var mm = (day.getMonth() + 1)
      var yy = day.getFullYear()
      var arrmonth = (day.getMonth() + 1 < 10 ? '0' + day.getMonth() + 1 : day.getMonth() + 1)
      var fulldate = day.getFullYear() + '-' + (day.getMonth() + 1 < 10 ? '0' + (day.getMonth() + 1) : (day.getMonth() + 1)) + '-' + (day.getDate() < 10 ? '0' + day.getDate() : day.getDate())
      daysList.push({ 'date': dd, 'month': MonthCalendar[mm], 'year': yy, 'fulldate': fulldate, 'monthid': mm })
      //daysList[fulldate] = {'date':dd,'month':MonthCalendar[mm],'year':yy,'fulldate':fulldate,'monthid':mm}
    }
  }

  //Get Current Date
  var TodayDate = new Date();

  var isList = '';
  let isYesterday = '';
  let isToday = '';
  let isTomorrow = '';
  let tr = '';
  let notfound = '';
  var currentdateToday = TodayDate.getFullYear() + '-' + ((TodayDate.getMonth() + 1) < 10 ? '0' + (TodayDate.getMonth() + 1) : (TodayDate.getMonth() + 1)) + '-' + (TodayDate.getDate() < 10 ? '0' + TodayDate.getDate() : TodayDate.getDate());
  //Get Yesterday,Today & Tomorrow
  daysList.forEach((key, index) => {
    if (currentdateToday == key.fulldate) {
      tr = index;
      isToday = daysList[tr];
      isYesterday = daysList[tr - 1];
      isTomorrow = daysList[tr + 1];
    } else {
      if (TodayDate.getDay() === 0) {
        notfound = new Date(Date.now() - 172800000).getFullYear() + '-' + (new Date(Date.now() - 172800000).getMonth() + 1 < 10 ? '0' + (new Date(Date.now() - 172800000).getMonth() + 1) : (new Date(Date.now() - 172800000).getMonth() + 1)) + '-' + (new Date(Date.now() - 172800000).getDate() < 10 ? '0' + new Date(Date.now() - 172800000).getDate() : (new Date(Date.now() - 172800000).getDate()))
        if (key.fulldate === notfound) {
          tr = index;
          isToday = daysList[tr]
          isYesterday = daysList[tr - 1]
          isTomorrow = daysList[tr + 1]
        }
      } else if (TodayDate.getDay() === 6) {
        notfound = new Date(Date.now() - 86400000).getFullYear() + '-' + (new Date(Date.now() - 86400000).getMonth() + 1 < 10 ? '0' + (new Date(Date.now() - 86400000).getMonth() + 1) : (new Date(Date.now() - 86400000).getMonth() + 1)) + '-' + (new Date(Date.now() - 86400000).getDate() < 10 ? '0' + new Date(Date.now() - 86400000).getDate() : (new Date(Date.now() - 86400000).getDate()))
        if (key.fulldate === notfound) {
          tr = index;
          isToday = daysList[tr];
          isYesterday = daysList[tr - 1];
          isTomorrow = daysList[tr + 1];
        }
      }
    }

  })


  isList = { 'isTodaylist': JSON.stringify(isToday), 'isYesterdaylist': JSON.stringify(isYesterday), 'isTomorrowlist': JSON.stringify(isTomorrow), 'mainIndex': tr, 'isYesterdaylistdate': isYesterday.fulldate, 'isTodaylistdate': isToday.fulldate, 'isTomorrowlistdate': isTomorrow.fulldate };
  return isList;

}


{/** End Functions */ }
function VirtualSlides(props) {

  // const [orignalslides,setoriginalslides] = useState(calendarString ? false:true);
  const nodeRef = useRef(null);
  const [Cardedittable, setCardedittable] = useState({ cardid: '' });
  const [edittable, setedittable] = useState(false);
  const formsummary = useRef(null);
  const [isprivateCard, setisprivateCard] = useState(false);
  const getuserdetails = useContext(UserdetailsContext);
  //  const [getCurrentformdetails,setCurrentformdetails] = useState();
  const [getTaskdeleteddetails, setTaskdeleteddetails] = useState({ summary: '', ticketno: '', timelog: '', eventtype: '', taskid: '' });
  const teamID = getuserdetails.team_id;
  const [show, setshow] = useState(false);

  let data = useLocation();



  let nav = useNavigate();
  const [daysliders, setdaysliders] = useState([]);
  const [taskdetails, settaskdetails] = useState([]);
  //  const[currentuser,setCurrentuser] = useState();
  //  const[teamuser,setTeamuser] = useState();
  const [tr, settr] = useState([]);
  const [messageupdate, setmessageupdate] = useState();
  const [carddetails, setCarddetails] = useState({ summary: "", ticket: "", timelog: "", is_private: "0", status: "0", task: "1", teamid: "", userid: "", planned_date: "", task_category: "", original_estimate: "", remaining_estimate: "", ticketypeStatus: "", iscolor: "" });
  const [jiracarddetails, setJiraCarddetails] = useState({ task_category: "", originalEstimate: "", remainingEstimate: "", statuscode: "", timespent: "", ticketstatus: "", colorcode: "" });

  const [isShow, setisShow] = useState(false);

  const [loggedinuser, setuserloggedin] = useState(window.localStorage.getItem('loggedinuser'));

  const [ActiveCard, setActiveCard] = useState(null)
  const [draggedIndex, setDraggedIndex] = useState(null);

  const [, forceUpdate] = useReducer(x => x + 1, 0);

  const [slidesdata, setSlidesdata] = useState([]);

  const [swiperRef, setSwiperRef] = useState(null);



  const [startDate, setStartDate] = useState();
  const [endDate, setEndDate] = useState();

  const swiper = useRef(null);

  const swiperinst = useState(null);

  const [copyModal, setcopyModal] = useState(false);

  const [swiperRefcalendar, setSwiperRefcalendar] = useState();
  const slideTo = (index) => {
    // swiperRef.slideTo(17);

    swiperRef.slideTo(index - 1, 0);
    // initialSlide =  swiperRef.slideTo(index - 1,0);
    if (swiperRefcalendar) {

      swiperRefcalendar.slideTo(index - 1, 1);
    }

  }


  const reloadSlides = async (swiper) => {
    if (data.state.id !== '') {
      await axiosBaseurl.post("get_all_dates", { userid: `${data.state.id}`, logged: `${loggedinuser}` }).then((result) => {
        // settaskdetails(result.data);

        settaskdetails(result.data);

        // setrender(render + 1);
        forceUpdate();
        //setindex(index + 1);
      }).catch((err) => {
        console.log(err);
      });
    } else {
      return Navigate.to("/");
      console.log("id is empty");
    }
  }
  const intitSlides = async (Swiper) => {

    if (data.state.id !== '') {
      if (swiperRef) {

        slideTo(tr.mainIndex + 1)

      }

      if (swiperRefcalendar) {

        slideTo(2);

      }



      //setShowCalendarview(false);
      await axiosBaseurl.post("get_all_dates", { userid: `${data.state.id}`, logged: `${loggedinuser}` }).then((result) => {
        // console.log("result",result.data);

        settaskdetails(result.data);

        forceUpdate();
        setisloading(false);






        //  setrender(render + 1);




        //  }
      }).catch((err) => {
        console.log(err);
      });

    } else {

      console.log("id is empty");
      return nav("/");
    }

  }

  const [pendingItems, setPendingitems] = useState('');

  const pendingListItems = async (user_id) => {
    await axiosBaseurl.post('pendingtasks', { currentuserid: user_id }).then((result) => {
      console.log(result.data);
      setPendingitems(result.data);
    }).catch((err) => {
      console.log(err);
    });

  }

  const AdditemsforNotCurrentlist = (div_id) => {

    pendingListItems(loggedinuser);
    // console.log(pendingItems);
    // console.log(pendingItems.pendingitemsdate);

    if (pendingItems.pendingcount > 0 && data.state.id === loggedinuser) {
      toast.error("Please Check Your pending Checklist items to proceed Further", {
        toastId: data.state.id,
        position: "bottom-right",
        autoClose: 5000,
        hideProgressBar: true,
        closeOnClick: false,
        pauseOnHover: true,
        draggable: false,
        progress: undefined,
        theme: "light",
        transition: Bounce,
      });
      // document.getElementById(`${pendingItems.pendingitemsdate}`).setAttribute("disabled","disabled");

    } else {
      // document.getElementById(`${pendingItems.pendingitemsdate}`).setAttribute("disabled"," ");
      var x = document.getElementsByClassName("new_form");
      for (var i = 0; i < x.length; i++) {
        if (div_id == x[i].id) {
          document.getElementById(x[i].id).style.display = 'block'
          document.getElementById(x[i].id).reset();
        } else {
          document.getElementById(x[i].id).style.display = 'none'
        }
      }
    }


    //intitSlides();
    forceUpdate();

  }

  // const pendinglistItems =async(idcount)=>{

  //   if(idcount > 0 && data.state.id === loggedinuser ){
  //     toast.error("Please Check Your Previuos day's items to proceed Further",{
  //      toastId:data.state.id,
  //      position: "bottom-right",
  //      autoClose: 2000,
  //      hideProgressBar: true,
  //      closeOnClick: false,
  //      pauseOnHover: true,
  //      draggable: false,
  //      progress: undefined,
  //      theme: "light",
  //      transition: Bounce,

  //   });

  // }else {

  // }

  // } 
  const handleShow = async (taskid) => {
    setshow(true);
    if (data.state.id == loggedinuser) {

      await axiosBaseurl.post('editdetailsusers', { user_id: `${data.state.id}`, edit_id: `${taskid}` }).then((result) => {

        setTaskdeleteddetails(result.data);
        props.onrefresh(taskid);
        reloadSlides();
        forceUpdate();

      }).catch((err) => {
        console.log("Edit Details Data", err);
      });


    }



  }
  const [activedate, setActiveDate] = useState({ 'startdate': '', 'enddate': '' });
  const [copyModalId, setcopyModalId] = useState('');
  const [dd, setdd] = useState(false);
  const handleCopy = async (taskid, e, dateContainer, loggedinuser) => {
    const dd = new Date(dateContainer);
    dd.setDate((dd.getDate() + 1));
    const Weekend = dd.getDay();
    if (Weekend == 6) {
      dd.setDate(dd.getDate() + 2);
    }
    if (Weekend == 0) {
      dd.setDate(dd.getDate() + 1);
    }
    setStartDate(null)
    setEndDate(null)
    setcopyModalId('');
    setStartDate(dd)

    setcopyModal(true);
    // setActiveDate({'startdate':'','enddate':''}); 
    if (data.state.id != '') {
      await axiosBaseurl.post('editdetailsusers', { user_id: `${data.state.id}`, edit_id: `${taskid}` }).then((result) => {
        setTaskdeleteddetails(result.data);
      }).catch((err) => {
        console.log("Edit Details Data", err);
      });
    }
  }
  const handleClose = () => {
    setshow(false);
  }
  const handleCloseCopy = () => {
    setcopyModal(false);
  }
  const handleTicketDelete = async (taskid) => {
    await axiosBaseurl.post('deletetasks1', { del_id: taskid, userid: data.state.id }).then((result) => {
      forceUpdate();
      reloadSlides();
      handleClose();
      props.onrefresh(taskid);
    }).catch((err) => {
      console.log("Data Delete Error", err);
    })
  }
  const hideitems = (hidediv_id) => {
    document.getElementById(hidediv_id).style.display = "none";

  }

  const getSummaryCardDetails = (e, id, fieldname) => {
    console.log("Main event log", e.target.innerText);
    console.log("otherdetaisl", fieldname);
  }

  const savecarddetails = async (cardid, cardetails) => {

    setCardedittable(cardid);
    setedittable(!edittable);

    if (cardetails.fieldname === "ticket_no" && cardetails[cardetails.fieldname] != " ") {

      setisticketUpdated(true);

      jiraticketStatusUpdate(cardetails[cardetails.fieldname], cardetails.cardid);
    } else {
      setisticketUpdated(false);
    }
    await axiosBaseurl.post('updatetaskcolumn', { fieldname: cardetails.fieldname, value: cardetails[cardetails.fieldname], taskid: cardetails.cardid }).then((res) => {
      forceUpdate();
      reloadSlides();
      handleClose();

    }).catch((err) => {
      console.log("Data Updating Error", err);
    })
  }

  const UpdateCardDetails = async (cardid) => {
    setCardedittable(cardid);
    setedittable(!edittable);
  }
  const [isCancelable, setCancelable] = useState(0);

  const CancelCard = async (cardid) => {
    setCardedittable(cardid);
    setedittable(!edittable);
    setCancelable(!isCancelable);
    forceUpdate();
    reloadSlides();
  }


  const RefreshCard = async (cd) => {
    // props.onrefresh(cd);
    reloadSlides();
    forceUpdate();
  }
  /** Add Cards for the users */
  const AdditemscardOther = async (formdetails, div_id, date_add) => {
    // this.insertlist = { 'summary': this.summary, 'planned_date': currentdate, 'teamid': teamid, 'userid': uuid, 'task': this.tasktype, 'timelog': this.timelog, 'ticket': this.ticket, 'is_private':checkedPrivateValue,'task_category':this.taskCategory,'original_estimate':this.originalestimate,'remaining_estimate':this.remainingestimate,'iscolor':this.colorcode,'ticketypeStatus':this.tickettypeStatus}
    carddetails.planned_date = `${date_add}`;

    if (formdetails.summary !== '') {

      //let addformdetails = {task_category:jiracarddetails.task_category,original_estimate:jiracarddetails.originalEstimate,remaining_estimate:jiracarddetails.remainingEstimate,ticketypeStatus:jiracarddetails.ticketstatus,iscolor:jiracarddetails.colorcode}
      const jirataskdetails = { ...formdetails, task_category: jiracarddetails.task_category, original_estimate: jiracarddetails.originalEstimate, remaining_estimate: jiracarddetails.remainingEstimate, ticketypeStatus: jiracarddetails.ticketstatus, iscolor: jiracarddetails.colorcode };

      await axiosBaseurl.post("add_task_list", jirataskdetails).then((result) => {
        // console.log("Inside Submit");
        // console.log(result.data);

        props.onrefresh(`${props.batchid}`);
        setisjiradata(false);
        setjiraloading(false);
        document.getElementById(`${div_id}`).style.display = 'none'
      }).catch((err) => {
        console.log(err);
      });

      reloadSlides();
      forceUpdate();
    } else {

      document.getElementById(`${div_id}`).style.display = 'block'
      toast.error("Please fill in the fields to save the card.", {
        position: "top-right",
        autoClose: 4000,
        hideProgressBar: true,
        closeOnClick: false,
        pauseOnHover: true,
        draggable: false,
        progress: undefined,
        theme: "light",
        transition: Bounce,

      });
    }


    //  setrender(render + 1);

    // intitSlides();
    //setrender(render + 1);

    // forceUpdate();
    carddetails.task = "1";
    carddetails.is_private = "0";
    carddetails.summary = "";
    carddetails.timelog = "";
    carddetails.ticket = "";
    carddetails.planned_date = "";
    carddetails.status = "0";

    // setTeamuser(`${props.batchid}`);
  }



  const rerender = async () => {
    // return setrender(render + 1);
    intitSlides();
  }
  const [isloading, setisloading] = useState(true);
  const [isjiraloading, setjiraloading] = useState(false);


  const resize = (Swiper) => {
    Swiper.virtual.update(true);
    Swiper.update(true)

    Swiper.updateSize(true)

    return Swiper.realIndex;
    // swiper.virtual.update(force)
  };

  const onSlideChange = async (Swiper) => {

    // console.log(Swiper.realIndex);
    return Swiper.realIndex;

  };

  const onCalendarChange = async (Swiper) => {
    return Swiper.realIndex;
  }

  const getCardDetails = async (event, id) => {
    console.log("Current user", id);
    console.log(event.target.name);
    console.log(event.target.value);
  };

  {/** Update Card Details */ }
  const [pendingCount, setpendingCount] = useState(0);
  // const[pendingitems,setPendingitems] = useState(props.pendingcount); 

  const [isjiracardidloading, setisjiracardidloading] = useState(false);
  const [editableCard, isEditableCard] = useState({ card_id: "" });
  const [isjiracardid, setisjiracardid] = useState(false);
  {/** End Update Crad Details */ }
  const getEditValue = async (event, cardid, userid, ticketNo) => {
    //  alert(cardid+''+userid);

    const target = event.target.control ?? event.target;
    let status = (target.checked == false ? '0' : '1');
    // console.log("getting the status of the card",status);
    if (ticketNo != '') {
      isEditableCard({ card_id: `${cardid}` })
      // if(isEditableCard.card_id !=''){
      setisjiracardidloading(true);

      // }else{
      //   setisjiracardidloading(false);
      // }
      //  jiraticketStatus(event,ticketNo);
      jiraticketStatusUpdate(event, ticketNo, cardid);

    } else {
      isEditableCard({ card_id: "" });
    }



    //  update_checklist_status
    await axiosBaseurl.post('update_checklist_status', { 'task_id': cardid, 'userid': userid, 'status': status }).then((result) => {
      // console.log(result); 
      props.onrefresh(cardid);
      pendingListItems(loggedinuser);
      reloadSlides();
      forceUpdate();

    }).catch((err) => {
      console.log("Date edit access error", err);
    });




  }

  /** DRop functionalities */
  const onDrop = async (columnName, position) => {
    const newArr = [];
    if (position !== undefined) {
      console.log(`${ActiveCard} is in coumn name ${columnName} and at position ${position}`);
      // console.log(taskdetails[`${columnName}`]["content"])
      // console.log(taskdetails[`${draggedIndex}`]["content"]) 
      const filterArray = taskdetails[`${draggedIndex}`]["content"].filter((cards) => { if (cards.id === ActiveCard) { cards.planned_date = `${columnName}`; return cards } });
      const notfilterArray = taskdetails[`${draggedIndex}`]["content"].filter((cards) => { if (cards.id != ActiveCard) { return cards } });

      const newMergedArraya = notfilterArray.concat(filterArray);

      console.log(Object.values(newMergedArraya));
      // const tasklist = taskdetails[`${columnName}`]["content"].concat(filterArray);

      const arr = arrayMove(newMergedArraya, (Object.keys(newMergedArraya).length - 1), position);
      //  const arr = arrayMove(tasklist,(Object.keys(tasklist).length-1),(position-1));
      //  const arr = arrayMove(tasklist,(Object.keys(tasklist).length-1),(position));
      //  console.log(new Set(arr))
      const tt = [...new Set(arr)]
      console.log(tt);
      //  console.log("New Array",jj); 
      await axiosBaseurl.post("updatesortoder", { 'details': tt, 'user_id': `${loggedinuser}` }).then((result) => {
        console.log(result.data)
        //props.onrefresh(cardid); 
        reloadSlides();
        forceUpdate();
      }).catch((error) => {
        console.log(error)
      });
    }
  }
  const onDrag = (columnName, id) => {
    console.log("Dragging Strated", columnName);
    document.getElementById(`task_card_${id}`).classList.add("dragging-ghost");
    setDraggedIndex(columnName);
  }


  const showstartDate = (date) => {
    if (date != null) {
      setStartDate(null);
      const startContainer = new Date(date);
      moment(startContainer).utcOffset("+05:30").format()

      // const isoString = date.toISOString();
      // const formattedDate = isoString.split("T")[0];
      // alert(formattedDate);
      setStartDate(startContainer);
    }

  }

  const isWeekendDay = (date) => {
    return isWeekend(date);
  }

  const filterWeekends = (date) => {
    return !isWeekendDay(date);
  }

  const addoneDay = (date) => {
    if (startDate != null) {
      const dd = new Date(date);
      dd.setDate(dd.getDate() + 1);
      const Weekend = dd.getDay();
      if (Weekend == 6) {
        dd.setDate(dd.getDate() + 2);
      }
      if (Weekend == 0) {
        dd.setDate(dd.getDate() + 1);
      }
      const strdate = dd.toLocaleString("default", { year: "numeric" }) + '-' + dd.toLocaleString("default", { month: "2-digit" }) + '-' + dd.toLocaleString("default", { day: "2-digit" });
      moment(dd).utcOffset("+05:30").format()
      // const isoString = dd.toISOString();
      // const formattedDate = isoString.split("T")[0];
      return strdate;
    }

    // 
    // if(isWeekend(dd)){
    //   dd.ge
    // }


  }
  // const [loadslides,setloadslides] = useState(true);
  // const [copylist,setCopylist] = useState('');
  const handleSubmit = (e, details, start, end, loggedinuser) => {
    e.preventDefault()
    console.log("Sbuniting")
    let endDateString = '';
    if (end != null) {
      endDateString = end.toLocaleString("default", { year: "numeric" }) + '-' + end.toLocaleString("default", { month: "2-digit" }) + '-' + end.toLocaleString("default", { day: "2-digit" });
    } else {
      endDateString = '';
    }


    const startDateString = start.toLocaleString("default", { year: "numeric" }) + '-' + start.toLocaleString("default", { month: "2-digit" }) + '-' + start.toLocaleString("default", { day: "2-digit" });
    console.log(`${details.task_id} is start ${start} and end ${endDateString} loggedinuser ${loggedinuser}`);
    const copylist = { 'startdate': startDateString, 'enddate': endDateString, 'details': details, 'userid': loggedinuser, 'teamid': props.batchid }
    axiosBaseurl.post('copyticket', copylist).then((res) => {
      console.log(res.data);
      console.log("Copy");
      handleCloseCopy();
      props.onrefresh(`${details.task_id}`);
      reloadSlides();
      forceUpdate();

    }).catch((err) => {
      console.log(err);
    })
  }

  const showendDate = (enddate) => {
    // if(enddate !=null){
    setEndDate(null);
    const endcontainer = new Date(enddate);
    //  endcontainer.setDate(endcontainer.getDate() + 1);

    moment(endcontainer).utcOffset("+05:30").format()
    const isoString = endcontainer
    //  const formattedDate = isoString.split("T")[0];
    console.log("Show end date", isoString);
    // const formattedDate = endcontainer;

    setEndDate(isoString);

    // }


  }

  const [isjiradata, setisjiradata] = useState(false);

  {/** get jira cardid details Update */ }

  {/** End Jira cardid details update */ }

  const jiraticketStatus = async (e, ticketNo) => {
    const tickettypes = ['WE', 'FPPS', 'FTP'];
    const ticketstr = ticketNo.split("-")[0];
    if (ticketNo != '' && tickettypes.includes(ticketstr)) {

      setisjiradata(true);
      setjiraloading(false);
      await axiosBaseurl.post('jira_data', { 'ticketno': ticketNo }).then((result) => {
        // console.log(result.data);
        // setjiraloading(false);

        if (result.data.statuscode == "200") {
          setisjiradata(false);
          setjiraloading(true);
          //const jiradetailsone = {task_category:"12"};
          //  const[jiracarddetails,setJiraCarddetails] = useState({task_category:"",originalEstimate:"",remainingEstimate:"",statuscode:"",timespent:"",ticketstatus:"",colorcode:""}); 
          setJiraCarddetails({ task_category: result.data.task_category, originalEstimate: result.data.originalEstimate, remainingEstimate: result.data.remainingEstimate, statuscode: result.data.statuscode, timespent: result.data.timespent, ticketstatus: result.data.ticketstatus, colorcode: result.data.colorcode });
          // console.log(jiracarddetails); 
        }
      }).catch((err) => {
        console.log(err);
      })
    } else {
      setjiraloading(false);
      setisjiradata(false);

    }
    console.log(`Ticket No ${ticketNo}`);
  }

  const [isticketUpdated, setisticketUpdated] = useState(false);

  const jiraticketStatusUpdate = async (ticketNo, cardid) => {
    if (isticketUpdated) {


      let jiraarray = {};
      if (ticketNo != '') {

        setisjiracardidloading(true);
        isEditableCard({ card_id: `${cardid}` });
        await axiosBaseurl.post('jira_data', { 'ticketno': ticketNo }).then((result) => {
          if (result.data.statuscode == "200") {

            setisjiracardidloading(false);
            isEditableCard('');
            jiraarray = {
              'fieldname': ['taskname', 'colorcode', 'original_estimate', 'remaining_estimate'],
              'value': [result.data.task_category, result.data.colorcode, result.data.originalEstimate, result.data.remainingEstimate],
              'taskid': cardid
            }

          }
        }).catch((err) => {
          console.log(err);
        });


        await axiosBaseurl.post('updatetaskcolumnjira', jiraarray).then((result) => {
          props.onrefresh(cardid);
          reloadSlides();
          forceUpdate();
        }).catch((err) => {
          console.log(err);
        })
        console.log(`tikcet no Update ${ticketNo} and the card id is ${cardid}`);
        console.log(jiraarray);
      }
    }
  }


  /** End Add Cards */


  useEffect(() => {
    // props.onrefresh(refreshindex);
    setdaysliders(datelist());
    pendingListItems(loggedinuser);
    // pendinglistItems(props.pendingcount);
    settr(getdaysListinCurrent);
    // setdaysliders(datelist());


    intitSlides();


    //getdaysListinCurrent();
  }, [data.state.id, swiperRef, swiperRefcalendar]);



  if (isloading) {
    return <Laodingspinner />;
  } else {


    return (

      <>

        <>


          {Object.keys(props.calendardetails).length === 0 && <Swiper modules={[Virtual, Navigation]}
            spaceBetween={10}
            slidesPerView={3}
            virtual
            key={props.onrefresh}
            observer={true}
            cssMode={false}
            simulateTouch={false}
            centeredSlides={true}
            pagination={false}
            scrollbar={false}
            navigation={{ prevEl: '.swiper-button-prev', nextEl: '.swiper-button-next' }}
            updateOnWindowResize={true}
            onSwiper={setSwiperRef}
            ref={swiperRef}
            onSlideChange={onSlideChange}
          >
            {/** No Calendar View */}
            {Object.keys(taskdetails).map((slideContent, index) => {

              return <SwiperSlide key={slideContent} virtualIndex={slideContent} className="big-div p-2 list text-secondary shadow-sm" onDrop={onDrop}>{slideContent < tr.isYesterdaylistdate ? <>
                <Row className="mb-3">
                  <Col className="col-sm-5 col-lg-6  list-date" >{daysliders[slideContent].date} {daysliders[slideContent].month},{daysliders[slideContent].year}</Col>
                  <Col className="col list-summary text-end">
                    <span className="fw-bold"><small><span>{taskdetails[slideContent].total_estimated_time > 0 ? taskdetails[slideContent].total_estimated_time : '0.0'} hours <span className="subhead-text">Planned</span></span></small></span>
                  </Col>
                  <Col className="col list-summary text-end">
                    <span className="fw-bold">{taskdetails[slideContent].total_pending_in_board > 0 ? taskdetails[slideContent].total_pending_in_board : '0'}&nbsp;/&nbsp;{taskdetails[slideContent].total_task_in_board > 0 ? taskdetails[slideContent].total_task_in_board : '0'} <span className="subhead-text">Completed</span></span>
                  </Col>
                  <Col className="col list-summary text-center mt-3 allslidescontainer">
                    <div style={{ minHeight: "44px" }}>&nbsp;</div>
                  </Col>
                </Row>
              </> : <>
                <Row className="mb-3 p-2">
                  <Col className="col-sm-5 col-lg-6  list-date" >{daysliders[slideContent].date} {daysliders[slideContent].month},{daysliders[slideContent].year}</Col>
                  <Col className="col list-summary text-end">
                    <span className="fw-bold"><small><span>{taskdetails[slideContent].total_estimated_time > 0 ? taskdetails[slideContent].total_estimated_time : '0.0'} hours <span className="subhead-text">Planned</span></span></small></span>
                  </Col>
                  <Col className="col list-summary text-end">
                    <span className="fw-bold">{taskdetails[slideContent].total_pending_in_board > 0 ? taskdetails[slideContent].total_pending_in_board : '0'}&nbsp;/&nbsp;{taskdetails[slideContent].total_task_in_board > 0 ? taskdetails[slideContent].total_task_in_board : '0'} <span className="subhead-text">Completed</span></span>
                  </Col>

                  <Col className="col-sm-12 col-md-12 col-xs-12 col-lg-12 list-summary text-center mt-3">
                    <span className="yesterday">{tr.isYesterdaylistdate === slideContent ? 'What did you do yesterday?' : ''}</span>
                    <span className="today">{tr.isTodaylistdate === slideContent ? 'What will you do Today?' : ''}</span>
                    <span className="tomorrow">{tr.isTomorrowlistdate === slideContent ? 'Works Planned for Tomorrow' : ''}</span>
                    <span>&nbsp;</span>
                  </Col>
                </Row>
              </>
              }
                {/** Get Task list */}


                <DropArea onDrop={() => { onDrop(slideContent, 0) }} />
                {(taskdetails[slideContent].content).map((tasks, index) =>
                  <React.Fragment key={tasks.id}>
                    <TasklistCard allTasks={tasks} containerID={slideContent} dataId={data.state.id} loggedinuser={loggedinuser} getEditValue={getEditValue} Cardedittable={Cardedittable} edittable={edittable} setmessageupdate={setmessageupdate} messageupdate={messageupdate} slideContent={slideContent} cancelbtn={cancelbtn} edit={edit} Copy={Copy} update={update} trash={trash} CancelCard={CancelCard} handleShow={handleShow} UpdateCardDetails={UpdateCardDetails} savecarddetails={savecarddetails} onDrag={onDrag} setDraggedIndex={setDraggedIndex} setActiveCard={setActiveCard} handleCopy={handleCopy} index={index} onDrop={onDrop} key={isCancelable} jiraticketStatusUpdate={jiraticketStatusUpdate} isjiracardid={isjiracardid} isjiracardidloading={isjiracardidloading} editableCard={editableCard} setisticketUpdated={setisticketUpdated} />
                    {data.state.id === loggedinuser && <DropArea onDrop={() => { onDrop(slideContent, index) }} />}
                  </React.Fragment>
                )}
                <>

                  {
                    slideContent >= tr.isYesterdaylistdate ?
                      <Form className="border border-start-0 rounded-top rounded-bottom border-bottom-0 mt-0 form-list new_form card-error-shake" id={'id_' + slideContent} style={{ display: isShow ? 'block' : 'none' }} ref={formsummary}>
                        <div className="list-group-item form-list-item rounded-top bg-body-light border border border-top-0 border-botto-0 rounded-bottom border-secondary-subtle bg-body-tertiary  m-0">
                          <div className="row p-3">
                            <div className="col-sm-1 col-md-1 px-1 mt-0">
                              <input type="checkbox" name="task1" class="form-check form-check-inline item-head-check" />
                            </div>
                            <div className="col-sm-10 col-md-10 px-0">
                              <input type="text" name="summary" value={carddetails.summary} onChange={e => setCarddetails({ ...carddetails, summary: e.target.value })} className="form-control form-control-sm list-title ms-3" placeholder="Summary" />
                            </div>
                          </div>
                          <div className="rounded-bottom card-edit">
                            <div className="row">
                              <div className="col-sm-5"><input type="text" id="ticket" value={carddetails.ticket} onChange={e => setCarddetails({ ...carddetails, ticket: e.target.value })} onBlur={e => jiraticketStatus(e, e.target.value)} onInput={e => jiraticketStatus(e, e.target.value)} className="form-control form-control-sm list-ticket" autocomplete="off" name="ticket" placeholder="Ticket No/Label" /></div>
                              <div className="col-sm-3"><input type="text" id="timelog" name="timelog" value={carddetails.timelog} onChange={e => setCarddetails({ ...carddetails, timelog: e.target.value })} autocomplete="off" className="form-control form-control-sm list-time " placeholder="Time Log" /></div>
                              <div className="col-sm-4 pe-0" style={{ display: 'flex', justifyContent: 'space-around', alignItems: 'center' }}>
                                {/* <input type="checkbox" name="isprivate" className="pvtcheckbox"/>
                           <label for="pvtbox" className="pvtlabel">private</label> */}
                                {/* <Form.Check inline label="Private" name="is_private" type="checkbox" onChange={(e)=>{setCarddetails({...carddetails,is_private:e.target.checked ? '1':'0'})}} /> */}
                                <input inline label="Private" name="is_private" type="checkbox" onChange={(e) => { setCarddetails({ ...carddetails, is_private: e.target.checked ? 1 : 0 }) }} defaultChecked={isprivateCard} /><label for="pvtbox" className="pvtlabel" style={{ marginLeft: '-19px', marginTop: '-1px' }}>Private</label>
                              </div>
                              <div className="col-sm-2 mt-1">
                                <input type="hidden" name="teamid" value={carddetails.teamid = `${props.batchid}`} />
                                <input type="hidden" name="userid" value={carddetails.userid = `${data.state.id}`} />
                                {/* <input type="hidden" name="planned_date" value={slideContent}/> */}
                              </div>
                            </div>
                            <div className="row mt-1">
                              <div className="col-sm-4 col-md-4 d-flex justify-content-start">
                                <div className="mt-1 ms-2">
                                  {/** <input type="radio" checked="checked" name="task" value="task" onChange={(e)=>{setCarddetails({...carddetails,task:e.target.value})}} defaultChecked/><label className="form-check-label">Task</label>**/}
                                  <input className="mt-1 radio" inline label="Task" name="task" value="1" type="radio" onChange={(e) => { setCarddetails({ ...carddetails, task: "1" }) }} defaultChecked /><label className="form-check-label">Task</label>
                                </div>
                              </div>
                              <div className="col-sm-5 col-md-5 d-flex justify-content-start">
                                <div className="mt-1 ms-2">
                                  {/* <input type="radio" name="task" value="event" onChange={(e)=>{setCarddetails({...carddetails,task:e.target.value})}}/><label className="form-check-label" >Meeeting</label> */}
                                  {/* <Form.Check inline className="mt-1" label="Meeting" name="task"  value="2" type="radio" onChange={(e)=>{setCarddetails({...carddetails,task:"2"})}} /> */}

                                  <input inline className="mt-1" label="Meeting" name="task" value="2" type="radio" onChange={(e) => { setCarddetails({ ...carddetails, task: "2" }) }} /><label className="form-check-label" >Meeeting</label>
                                </div>
                              </div>
                              <div className="col-sm-1 mt-1 mx-1">
                                <img src={plus} style={{ cursor: "pointer", top: "4px", position: "relative" }} width="20px" height="20px" onClick={() => AdditemscardOther(carddetails, `${'id_' + slideContent}`, slideContent)}></img>&nbsp;

                                {/* <i className="fa fa-plus-square" onClick={()=>AdditemscardOther(carddetails,`${'id_'+slideContent}`,slideContent)}></i>&nbsp;&nbsp; */}
                                {/* <i className="fa fa-times text-danger" aria-hidden="true" onClick={()=>hideitems('id_'+slideContent)}></i> */}
                              </div>
                              <div className="col-sm-1 mt-1">
                                <img src={cancel} width="20px" height="20px" style={{ cursor: "pointer", top: "4px", position: "relative" }} onClick={() => hideitems('id_' + slideContent)}></img>&nbsp;
                              </div>
                            </div>
                          </div>
                          {isjiradata &&
                            <div className="col-sm-12 col-md-12 col-lg-12 task-height pb-0" style={{ fontSize: "12.5px", fontWeight: "500", color: "black" }}>
                              <span>Fetching Details</span>
                            </div>
                          }
                          {isjiraloading &&
                            <div className="row mx-auto pb-0 d-flex justify-content-center align-middle">


                              <div className="row task-height pb-2" style={{ margin: "0" }}>
                                <ul className="col-sm-1 col-md-1 col-lg-1">
                                  <li style={{ backgroundColor: `${jiracarddetails.colorcode}`, height: "15px", width: "15px", display: "block", borderRadius: "50%", left: "-10px", top: "2px" }}></li>
                                </ul>

                                <div className="col-sm-10 col-md-10 col-lg-10 mt-0" style={{ fontSize: "12.5px", fontWeight: "500", color: "black", position: "relative", left: "-12px", top: "-1px" }}><p>{jiracarddetails.task_category}</p></div>
                                <div className="col-sm-1 col-md-1 col-lg-1 mt-0">
                                  <span style={{ fontSize: "12.5px", fontWeight: "500", color: "black", left: "-35px", position: "relative", top: "-3px" }}>{jiracarddetails.timespent}/{jiracarddetails.originalEstimate}</span>
                                </div>
                              </div>
                            </div>
                          }

                        </div>
                      </Form>

                      : ''
                  }

                </>

                <>
                  {
                    slideContent >= tr.isYesterdaylistdate ?
                      <div className={slideContent > tr.isTodaylistdate ? 'text-center mt-3' : 'text-end mt-3'} style={{ display: data.state.id === loggedinuser ? "block" : "none" }}>

                        <button type="button" className="btn btn-success btn-sm" id={slideContent} onClick={() => AdditemsforNotCurrentlist('id_' + slideContent)} data-btn={data.state.id} data-logged={loggedinuser}>+ Add New Item</button>

                      </div> : ''
                  }


                </>

                {/** End Ticket Values */}
              </SwiperSlide>

            }


            )}

            {/** End no Calendar View */}

          </Swiper>

          }
          <ToastContainer closeButton={false} transition={Bounce} toastStyle={{ backgroundColor: "#f5f6fa", color: "black", fontWeight: "500", fontSize: "14px" }} />
        </>

        {Object.keys(props.calendardetails).length > 0 && <Swiper
          modules={[Navigation, Virtual]}
          spaceBetween={10}
          slidesPerView={3}
          virtual
          observer={true}
          key={props.selecteddate}
          cssMode={false}
          simulateTouch={false}

          pagination={false}

          scrollbar={false}
          navigation={{ prevEl: '.swiper-button-prev', nextEl: '.swiper-button-next' }}
          updateOnWindowResize={true}
          onSlideChange={onCalendarChange}
          onSwiper={setSwiperRefcalendar}
          ref={swiperRefcalendar}
        >
          {Object.keys(props.calendardetails).map((slideContent, index) => {

            return <SwiperSlide className="big-div p-2 list text-secondary shadow-sm" key={slideContent} data-attr={props.selecteddate}>

              <Row className="mb-3">
                <Col className="col-sm-5 col-lg-6  list-date" >{props.calendardetails[slideContent].date} {props.calendardetails[slideContent].month},{props.calendardetails[slideContent].year}</Col>
                <Col className="col list-summary text-end">
                  <span className="fw-bold"><small><span>{props.calendardetails[slideContent].total_estimated_time > 0 ? props.calendardetails[slideContent].total_estimated_time : '0.0'} hours <span className="subhead-text">Planned</span></span></small></span>
                </Col>
                <Col className="col list-summary text-end">
                  <span className="fw-bold">{props.calendardetails[slideContent].total_pending_in_board > 0 ? props.calendardetails[slideContent].total_pending_in_board : '0'}&nbsp;/&nbsp;{props.calendardetails[slideContent].total_task_in_board > 0 ? props.calendardetails[slideContent].total_task_in_board : '0'} <span className="subhead-text">Completed</span></span>
                </Col>
                <Col className="col list-summary text-center mt-3 allslidescontainer">
                  <div style={{ minHeight: "44px" }}>&nbsp;</div>
                </Col>
              </Row>
              {(props.calendardetails[slideContent].content).map((tasks, index) =>
                <React.Fragment key={tasks.id}>
                  <TasklistCard allTasks={tasks} containerID={slideContent} dataId={data.state.id} loggedinuser={loggedinuser} getEditValue={getEditValue} Cardedittable={Cardedittable} edittable={edittable} setmessageupdate={setmessageupdate} messageupdate={messageupdate} slideContent={slideContent} cancelbtn={cancelbtn} edit={edit} Copy={Copy} update={update} trash={trash} CancelCard={CancelCard} handleShow={handleShow} UpdateCardDetails={UpdateCardDetails} savecarddetails={savecarddetails} onDrag={onDrag} setDraggedIndex={setDraggedIndex} setActiveCard={setActiveCard} handleCopy={handleCopy} index={index} onDrop={onDrop} key={isCancelable} />
                </React.Fragment>
              )}
            </SwiperSlide>

          })
          }
        </Swiper>
        }



        {/** Modal */}

        {/** Delete Modal */}
        <Modal show={show} onHide={handleClose}>
          <Modal.Header>
            <Modal.Title className="text-danger">Confirm Delete</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            <>
              <Row className="mb-2">
                <Col xs={8} sm={8} md={8}><p><b>Title :</b>&nbsp;{getTaskdeleteddetails.summary}</p></Col>
                <Col xs={4} sm={4} md={4}><p><b>Type :</b>&nbsp;{getTaskdeleteddetails.event_type === '2' ? 'Meeting' : 'Task'}</p></Col>
              </Row>
              <Row>
                <Col xs={8} sm={8} md={8}><p><b>Linked To :</b>&nbsp;{getTaskdeleteddetails.ticket_no}</p></Col>
                <Col xs={4} sm={4} md={4}><p><b>Time Log :</b>&nbsp;{getTaskdeleteddetails.timelog}</p></Col>
              </Row>
            </></Modal.Body>
          <Modal.Footer>

            <Row style={{ width: "100%" }}>
              <Col md={6} sm={6}>
                <Button variant="success flex-left" onClick={handleClose}>No,Keep it</Button>
              </Col>
              <Col md={6} sm={6}>
                <Button variant="danger flex-right" onClick={() => handleTicketDelete(`${getTaskdeleteddetails.task_id}`)}>Yes, Delete</Button>
              </Col>
            </Row>
          </Modal.Footer>
        </Modal>
        {/** End Delete Modal*/}
        {/** Copy Modal */}
        <Modal show={copyModal} onHide={handleClose} backdrop="static" dialogClassName="modal-90w" >
          <Modal.Header>
            <Modal.Title className="text-scondary">Copy Checklist item</Modal.Title>
            <div className="text-end col-sm-7 flex-end">
              <img src={cancelbtn} style={{ cursor: "pointer" }} onClick={handleCloseCopy} />
            </div>

          </Modal.Header>
          <Modal.Body>
            <>
              <Row className="mb-2">

                <Col xs={8} sm={8} md={8}><p><b>Title :</b>&nbsp;{getTaskdeleteddetails.summary}</p></Col>
                <Col xs={4} sm={4} md={4}><p><b>Type :</b>&nbsp;{getTaskdeleteddetails.event_type === '2' ? 'Meeting' : 'Task'}</p></Col>
              </Row>
              <Row>
                <Col xs={5} sm={5} md={5}><p><b>Linked To :</b>&nbsp;{getTaskdeleteddetails.ticket_no}</p></Col>
                <Col xs={7} sm={7} md={7}><p style={{ fontSize: '13px' }} className="fw-700 text-secondary">Default Time will be Logged Please add actual time in Working Day</p></Col>
              </Row>
              <Form>
                <Row>
                  <Col className="col-md-6 col-md-offset-1">
                    <Form.Group className="mb-3" controlId="Startdate">
                      <Form.Label className='text-muted text-uppercase text-sm' style={{ fontSize: '13px' }}>From Date</Form.Label>
                      <Row style={{ padding: '0 12px' }}>

                        <DatePicker filterDate={filterWeekends} showIcon icon={<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" aria-hidden="true" class="dp__icon dp__input_icon dp__input_icons"><path d="M29.333 8c0-2.208-1.792-4-4-4h-18.667c-2.208 0-4 1.792-4 4v18.667c0 2.208 1.792 4 4 4h18.667c2.208 0 4-1.792 4-4v-18.667zM26.667 8v18.667c0 0.736-0.597 1.333-1.333 1.333 0 0-18.667 0-18.667 0-0.736 0-1.333-0.597-1.333-1.333 0 0 0-18.667 0-18.667 0-0.736 0.597-1.333 1.333-1.333 0 0 18.667 0 18.667 0 0.736 0 1.333 0.597 1.333 1.333z"></path><path d="M20 2.667v5.333c0 0.736 0.597 1.333 1.333 1.333s1.333-0.597 1.333-1.333v-5.333c0-0.736-0.597-1.333-1.333-1.333s-1.333 0.597-1.333 1.333z"></path><path d="M9.333 2.667v5.333c0 0.736 0.597 1.333 1.333 1.333s1.333-0.597 1.333-1.333v-5.333c0-0.736-0.597-1.333-1.333-1.333s-1.333 0.597-1.333 1.333z"></path><path d="M4 14.667h24c0.736 0 1.333-0.597 1.333-1.333s-0.597-1.333-1.333-1.333h-24c-0.736 0-1.333 0.597-1.333 1.333s0.597 1.333 1.333 1.333z"></path></svg>} minDate={startDate} selected={startDate} onChange={(startDate) => showstartDate(startDate)} placeholderText='YYYY-MM-DD' dateFormat="yyyy-MM-dd" />
                      </Row>
                    </Form.Group>
                  </Col>
                  <Col className="col-md-6 col-md-offset-1">
                    <Form.Group className="mb-3" controlId="enddate">
                      <Form.Label className='text-muted text-uppercase text-sm' style={{ fontSize: '13px' }}>To Date</Form.Label>
                      <Row style={{ padding: '0 12px' }}>
                        <DatePicker filterDate={filterWeekends} showIcon icon={<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" aria-hidden="true" class="dp__icon dp__input_icon dp__input_icons"><path d="M29.333 8c0-2.208-1.792-4-4-4h-18.667c-2.208 0-4 1.792-4 4v18.667c0 2.208 1.792 4 4 4h18.667c2.208 0 4-1.792 4-4v-18.667zM26.667 8v18.667c0 0.736-0.597 1.333-1.333 1.333 0 0-18.667 0-18.667 0-0.736 0-1.333-0.597-1.333-1.333 0 0 0-18.667 0-18.667 0-0.736 0.597-1.333 1.333-1.333 0 0 18.667 0 18.667 0 0.736 0 1.333 0.597 1.333 1.333z"></path><path d="M20 2.667v5.333c0 0.736 0.597 1.333 1.333 1.333s1.333-0.597 1.333-1.333v-5.333c0-0.736-0.597-1.333-1.333-1.333s-1.333 0.597-1.333 1.333z"></path><path d="M9.333 2.667v5.333c0 0.736 0.597 1.333 1.333 1.333s1.333-0.597 1.333-1.333v-5.333c0-0.736-0.597-1.333-1.333-1.333s-1.333 0.597-1.333 1.333z"></path><path d="M4 14.667h24c0.736 0 1.333-0.597 1.333-1.333s-0.597-1.333-1.333-1.333h-24c-0.736 0-1.333 0.597-1.333 1.333s0.597 1.333 1.333 1.333z"></path></svg>} minDate={addoneDay(startDate)} selected={endDate} onChange={(endDate) => showendDate(endDate)} placeholderText='YYYY-MM-DD' dateFormat="yyyy-MM-dd" />
                      </Row>
                    </Form.Group>
                  </Col>
                </Row>
                <Row style={{ width: "100%", display: 'flex', alignItems: 'end', justifyContent: 'end' }}>
                  {/* <Col md={5} sm={5}> */}
                  <Button variant="primary flex-left" onClick={handleCloseCopy} className="col-sm-4 col-md-4 px-2 mx-2">Cancel</Button>
                  {/* </Col> */}
                  {/* <Col md={5} sm={5}>   */}
                  <Button variant="success flex-right" className="col-sm-4 col-md-4" onClick={(e) => handleSubmit(e, getTaskdeleteddetails, startDate, endDate, `${loggedinuser}`)}>Submit</Button>
                  {/* </Col> */}
                </Row>
              </Form>

            </>
          </Modal.Body>
        </Modal>
        {/** End Copy Modal */}

        {/** ENd Modal */}


      </>

    )

  }

}
export default VirtualSlides;