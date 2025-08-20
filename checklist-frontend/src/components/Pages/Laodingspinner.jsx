import Skeleton, { SkeletonTheme } from 'react-loading-skeleton';
import { Col, Container, Form, Row, Button, Image, CardText } from "react-bootstrap";

function Laodingspinner() {
  return (
    <>
      <div className="d-flex justify-content-between mb-4" style={{ marginBottom: '20vh', height: '215px' }}>

        <div className="big-div p-1 list text-secondary shadow-sm m-1">

          <Row className="mb-3">
            <Col className="col-sm-5 col-lg-6  list-date" >{<Skeleton />} {<Skeleton />},{<Skeleton />}</Col>
            <Col className="col list-summary text-end">
              <span className="fw-bold"><small><span>{<Skeleton />} </span></small></span>
            </Col>
            <Col className="col list-summary text-end">
              <span className="fw-bold">{<Skeleton />}{<Skeleton />}</span>
            </Col>
            <Col className="col list-summary text-center mt-3 allslidescontainer">
              <div style={{ minHeight: "24px" }}>{<Skeleton />}</div>
            </Col>
          </Row>

        </div>
        <div className="big-div p-1 list text-secondary shadow-sm m-1">

          <Row className="mb-3">
            <Col className="col-sm-5 col-lg-6  list-date" >{<Skeleton />} {<Skeleton />},{<Skeleton />}</Col>
            <Col className="col list-summary text-end">
              <span className="fw-bold"><small><span>{<Skeleton />} </span></small></span>
            </Col>
            <Col className="col list-summary text-end">
              <span className="fw-bold">{<Skeleton />}{<Skeleton />}</span>
            </Col>
            <Col className="col list-summary text-center mt-3 allslidescontainer">
              <div style={{ minHeight: "44px" }}>{<Skeleton />}</div>
            </Col>
          </Row>


        </div>
        <div className="big-div p-1 list text-secondary shadow-sm m-1">

          <Row className="mb-3">
            <Col className="col-sm-5 col-lg-6  list-date" >{<Skeleton />} {<Skeleton />},{<Skeleton />}</Col>
            <Col className="col list-summary text-end">
              <span className="fw-bold"><small><span>{<Skeleton />} </span></small></span>
            </Col>
            <Col className="col list-summary text-end">
              <span className="fw-bold">{<Skeleton />}{<Skeleton />}</span>
            </Col>
            <Col className="col list-summary text-center mt-3 allslidescontainer">
              <div style={{ minHeight: "44px" }}>{<Skeleton />}</div>
            </Col>
          </Row>


        </div>



      </div>
    </>
  )
}
export default Laodingspinner;