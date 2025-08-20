import React from 'react'
import gridicon from '../icons/grip-vertical-icon-grey.svg'
// import { Col, Container, Form, Row, Button, Image, CardText } from "react-bootstrap";
// import Modal from 'react-bootstrap/Modal';
// import { DropArea } from "./DropArea.jsx";
export const TasklistCard = ({ allTasks, dataId, loggedinuser, getEditValue, Cardedittable, edittable, setmessageupdate, messageupdate, slideContent, Copy, edit, cancelbtn, update, trash, CancelCard, handleShow, handleCopy, UpdateCardDetails, savecarddetails, setActiveCard, onDrag, setDraggedIndex, containerID, index, onDrop, reloadSlides, jiraticketStatusUpdate, isjiracardid, isjiracardidloading, editableCard }) => {

  const { id, summary, ticket_no, event_type, status, estimated_time, isprivate, taskname, taskoriginalestimate, taskremainingestimate, ticket_status, colorcode } = allTasks;

  return (

    <li className="mb-2 card-container" data-index={index} style={{ display: (summary == " ") ? "none" : "block" }}>
      <div className="card-style rounded border border-secondary-subtle shadow-sm" style={{ display: (summary == " ") ? "none" : "block" }}>
        <div className="title-div" style={{ display: (summary === '') ? "none" : "block" }}>
          <div className="row m-0 card-text-summary">
            <div className="col-sm-1 p-0" style={{ display: dataId === loggedinuser ? "block" : "none" }}>
              <input type="checkbox" defaultChecked={status == 1} name="task1" id={id} onClick={(e) => getEditValue(e, `${id}`, dataId, `${ticket_no}`)} />
            </div>
            <div className={status == 1 && !edittable ? 'text-strike col-sm-10 px-1' : 'col-sm-10 px-1'}>
              <span contentEditable={Cardedittable === id && edittable ? 'true' : 'false'} id={'summary_' + id} className={Cardedittable === id && edittable ? 'editingcard' : 'ticket-title'} style={Cardedittable === id && edittable ? { display: "block", border: "1px solid rgb(191, 233, 204)", color: "black", padding: "2px 3px", fontSize: "15px", width: "260px", marginTop: "-9px" } : { display: "-webkit-box" }} onBlur={e => setmessageupdate({ ...messageupdate, task_title: e.target.innerText, cardid: id, fieldname: 'task_title' })} suppressContentEditableWarning={true}>{summary}</span>
            </div>
            <div className="col-sm-1 col-md-1 p-0  text-end flex border-none" id={`task_card_${id}`} style={{ display: dataId === loggedinuser ? "block" : "none" }} draggable data-attr={id} onDragStart={() => { setActiveCard(id); onDrag(containerID, id) }} onDragEnd={() => { setActiveCard(null); setDraggedIndex(null) }}>
              <img src={gridicon} width="22" height="22" />
            </div>
          </div>
        </div>
        <div className="rounded-bottom border  card-edit">
          <div className="row m-0 mb-2">
            <div className="col-sm-5 p-0 "><input type="text" name="ticket_no" disabled={Cardedittable === id && edittable ? "" : "disabled"} defaultValue={ticket_no} className="form-control form-control-sm list-time" onBlur={e => setmessageupdate({ ...messageupdate, ticket_no: e.target.value, cardid: id, fieldname: 'ticket_no' })} /></div>
            <div className="col-sm-3 pe-0"><input type="text" name="timelog" disabled={Cardedittable === id && edittable ? "" : "disabled"} defaultValue={estimated_time} id={'div_' + id} class="form-control form-control-sm list-time" placeholder="Time Log" onBlur={e => setmessageupdate({ ...messageupdate, estimated_time: e.target.value, cardid: id, fieldname: 'estimated_time' })} /></div>
            <div className="col-sm-4 pe-0"><input type="checkbox" disabled={Cardedittable === id && edittable ? "" : "disabled"} id={'div_' + id} style={{ marginTop: "8px", marginRight: "7px" }} onChange={e => setmessageupdate({ ...messageupdate, is_private: e.target.checked ? 1 : 0, cardid: id, fieldname: 'is_private' })} defaultChecked={isprivate == 1 ? 1 : 0} /><label className="form-check-label" style={{ position: 'relative', top: '-2px', left: '-6px' }}>Private</label></div>
          </div>
          <div className="row m-0">
            <div className="col-sm-1 mt-1 p-1" style={{ display: dataId === loggedinuser && status != 1 ? 'block' : 'none' }}>
              {status != 1 && <img src={Copy} alt="contentcopy" className="custom-icon-size-edit-1" datamodalid="myCopchecklist" onClick={(e) => { handleCopy(`${id}`, e, `${containerID}`, `${loggedinuser}`) }} />}
            </div>
            <div className="col-sm-3 p-0 mt-1">
              <div className="mt-1 ms-2"><input type="radio" name={id} data-att={event_type} value={event_type == '1' ? event_type : '1'} defaultChecked={event_type == '1'} onChange={e => setmessageupdate({ ...messageupdate, task_type: e.target.value, cardid: id, fieldname: 'task_type' })} className={Cardedittable === id && edittable ? "" : "radio-disabled"} /><label className="form-check-label" >Task</label></div>
            </div>
            <div className="col-sm-4 p-0 mt-1">
              <div className="mt-1 ms-2">
                <input type="radio" name={id} data-att={event_type} value={event_type == '2' ? event_type : '2'} defaultChecked={event_type == '2'} onChange={e => setmessageupdate({ ...messageupdate, task_type: e.target.value, cardid: id, fieldname: 'task_type' })} className={Cardedittable === id && edittable ? "" : "radio-disabled"} />
                <label className="form-check-label" >Meeting</label>
              </div>
            </div>
            <div className="col-sm-3 mt-1 p-1" style={{ display: dataId === loggedinuser ? "block" : "none" }}>
              {(id === Cardedittable && edittable ? <img src={cancelbtn} style={{ cursor: "pointer" }} onClick={() => { CancelCard(`${id}`) }} /> : <img src={status != 1 ? trash : ''} style={{ cursor: "pointer" }} onClick={() => { handleShow(`${id}`) }} />)}
              {status != 1 && <img src={edit} width="20px" height="20px" style={edittable ? { cursor: "pointer", marginLeft: "20px", display: "none" } : { cursor: "pointer", marginLeft: "20px", display: "inline" }} onClick={() => { UpdateCardDetails(`${id}`) }} />}
              {(id === Cardedittable ? <img src={update} width="20px" height="20px" style={edittable ? { cursor: "pointer", marginLeft: "20px", display: "inline" } : { cursor: "pointer", marginLeft: "20px", display: "none" }} onClick={() => { savecarddetails(`${id}`, messageupdate) }} /> : '')}
            </div>
          </div>
        </div>
      </div>
      <div className="row m-0" style={{ display: (taskname != '' ? 'block' : 'none') }}>

        <div className="row task-height pb-2" style={{ margin: "0" }}>
          {id === editableCard.card_id && isjiracardidloading ?
            <>
              <div className="col-sm-10 col-md-10 col-lg-10 mt-0 fw-bold" style={{ color: "black", fontSize: "12.5px" }}>Loading details..</div>
            </>

            :
            <>
              <ul className="col-sm-1 col-md-1 col-lg-1">
                <li style={{ backgroundColor: `${colorcode}`, height: "15px", width: "15px", display: "block", borderRadius: "50%", left: "-10px", top: "2px" }}></li>
              </ul>

              <div className="col-sm-10 col-md-10 col-lg-10 mt-0" style={{ fontSize: "12.5px", fontWeight: "500", color: "black", position: "relative", left: "-12px", top: "-1px" }}><p>{taskname}</p></div>
              <div className="col-sm-1 col-md-1 col-lg-1 mt-0">
                <span style={{ fontSize: "12.5px", fontWeight: "500", color: "black", left: "-42px", position: "relative", top: "-3px" }}>{taskremainingestimate}/{taskoriginalestimate}</span>
              </div>
            </>

          }

        </div>
      </div>

    </li>


  )

}
