import { Suspense, lazy, useEffect, useState } from "react";

import axiosBaseurl from "../axiosBaseurl.js";

const wait = (time) => {
  return new Promise((resolve) => {
    setTimeout(() => {
      resolve()
    }, time)
  })
}

const SlidesLoad = lazy(() => import('../Pages/VirtualSlides.jsx'));
// const SlidesLoad = lazy(() => wait(2000).then(() => import('../Pages/VirtualSlides.jsx')));
// const loadingSpinner =lazy(()=>import('../Pages/Laodingspinner.jsx'));
function User(props) {

  /** Added By abanerjee2 */
  const [pendingCount, setpendingCount] = useState('');
  /** Get Pending Lists for Current Users */
  const pendingItems = async () => {
    await axiosBaseurl.post('pendingtasks', { currentuserid: props.loggedinuser }).then((result) => {
      console.log(result.data);
      setpendingCount(result.data);
    }).catch((err) => {
      console.log(err);
    });

  }

  useEffect(() => {
    pendingItems();
  }, [])




  return (

    <div key={props.id}>

      <Suspense key={props.id}>
        <SlidesLoad batchid={props.batchid} checkkey={props.id} onrefresh={props.refresh} key={props.refresh} showcalendar={props.showCalendardata} calendardetails={props.calendarDetails} selecteddate={props.selecteddate} pendingcount={pendingCount} />
      </Suspense>


    </div>

  );

}

export default User;